<?php

namespace App\Support;

class ProductImage
{
    public const PLACEHOLDER = 'storage/woocommerce-placeholder-300x300.png';

    public const SIZE_THUMB = 'thumb';

    public const SIZE_CARD = 'card';

    public const SIZE_LARGE = 'large';

    public static function url(?string $storedPath, string $size = self::SIZE_CARD): string
    {
        return asset('images/'.self::resolveStoragePath($storedPath, $size));
    }

    public static function resolveStoragePath(?string $storedPath, string $size = self::SIZE_CARD): string
    {
        if ($storedPath === null || trim($storedPath) === '' || self::isBrandImage($storedPath)) {
            return self::PLACEHOLDER;
        }

        $storedPath = ltrim(str_replace('\\', '/', $storedPath), '/');

        return self::preferCutout(match ($size) {
            self::SIZE_LARGE => self::resolveLargestPath($storedPath),
            self::SIZE_THUMB => self::resolveThumbnailPath($storedPath),
            default => self::resolveCardPath($storedPath),
        });
    }

    public static function largestSourcePath(?string $storedPath): string
    {
        if ($storedPath === null || trim($storedPath) === '') {
            return self::PLACEHOLDER;
        }

        return self::resolveLargestPath(ltrim(str_replace('\\', '/', $storedPath), '/'));
    }

    public static function pixelArea(string $storedPath): int
    {
        if (! self::exists($storedPath)) {
            return 0;
        }

        return self::filePixelArea(public_path('images/'.$storedPath));
    }

    public static function cutoutPathForStored(?string $storedPath): string
    {
        return self::cutoutPathFor(self::largestSourcePath($storedPath));
    }

    public static function hasCutout(string $storedPath): bool
    {
        $storedPath = ltrim(str_replace('\\', '/', $storedPath), '/');

        return self::exists(self::cutoutPathForStored($storedPath));
    }

    public static function pathForSlug(?string $slug, ?string $storedPath): string
    {
        if ($slug !== null && $slug !== '') {
            $override = config('product_images.overrides.'.$slug);

            if (is_string($override) && $override !== '') {
                return ltrim($override, '/');
            }
        }

        return ltrim(str_replace('\\', '/', (string) $storedPath), '/');
    }

    public static function extractFromProductHtml(string $html): ?string
    {
        $candidates = [];

        $galleryStart = stripos($html, 'woocommerce-product-gallery');
        $titleStart = stripos($html, 'product_title');
        $relatedPos = stripos($html, 'related products');
        $start = $galleryStart !== false ? $galleryStart : ($titleStart !== false ? $titleStart : 0);
        $end = $relatedPos !== false ? $relatedPos : strlen($html);
        $chunk = substr($html, $start, max(0, $end - $start));

        if (preg_match_all('/(?:\.\.\/)*storage\/([^"?\s]+\.(?:jpe?g|png|webp|avif|gif))/i', $chunk, $matches)) {
            foreach (array_unique($matches[1]) as $relative) {
                $candidates[] = $relative;
            }
        }

        if (preg_match('/property="og:image"\s+content="(?:\.\.\/)*storage\/([^"]+)"/i', $html, $match)) {
            $candidates[] = $match[1];
        }

        if (preg_match('/"@type"\s*:\s*"Product"[^}]*"image"\s*:\s*"(?:\.\.\/)*storage\/([^"]+)"/s', $html, $match)) {
            $candidates[] = $match[1];
        }

        $bestPath = null;
        $bestArea = 0;

        foreach (array_unique($candidates) as $relative) {
            if (self::isBrandImage($relative)) {
                continue;
            }

            $path = self::largestSourcePath('storage/'.$relative);

            if ($path === self::PLACEHOLDER || self::isBrandImage($path)) {
                continue;
            }

            $area = self::pixelArea($path);

            if ($area > $bestArea) {
                $bestArea = $area;
                $bestPath = $path;
            }
        }

        return $bestPath;
    }

    public static function isBrandImage(string $relative): bool
    {
        $basename = basename($relative);

        foreach (config('product_images.brand_patterns', []) as $pattern) {
            if (preg_match($pattern, $basename)) {
                return true;
            }
        }

        return false;
    }

    public static function isExcludedSource(string $relative): bool
    {
        return self::shouldSkipCutout($relative);
    }

    public static function shouldSkipCutout(string $storedPath): bool
    {
        if (self::isBrandImage($storedPath)) {
            return true;
        }

        $basename = basename($storedPath);

        foreach (config('product_images.no_cutout_patterns', []) as $pattern) {
            if (preg_match($pattern, $basename)) {
                return true;
            }
        }

        return false;
    }

    public static function shouldUseCutout(string $storedPath): bool
    {
        if (self::shouldSkipCutout($storedPath)) {
            return false;
        }

        $absolute = public_path('images/'.$storedPath);

        if (! is_file($absolute)) {
            return false;
        }

        $size = @getimagesize($absolute);

        if ($size === false) {
            return false;
        }

        [$width, $height] = $size;
        $minRatio = (float) config('product_images.no_cutout_min_aspect_ratio', 2.1);

        if ($height > 0 && ($width / $height) >= $minRatio) {
            return false;
        }

        return true;
    }

    public static function cutoutPathFor(string $resolvedPath): string
    {
        $relativeDir = dirname($resolvedPath);

        return $relativeDir.'/'.self::baseStem(basename($resolvedPath)).'-cutout.png';
    }

    private static function preferCutout(string $path): string
    {
        if ($path === self::PLACEHOLDER || ! self::shouldUseCutout($path)) {
            return $path;
        }

        $cutout = self::cutoutPathFor($path);

        return self::exists($cutout) ? $cutout : $path;
    }

    public static function intrinsicDimensions(string $storedPath): ?array
    {
        $resolved = self::resolveStoragePath($storedPath, self::SIZE_LARGE);
        $absolute = public_path('images/'.$resolved);
        $size = @getimagesize($absolute);

        if ($size === false) {
            return null;
        }

        return ['width' => $size[0], 'height' => $size[1]];
    }

    /**
     * @return list<array{path: string, width: int}>
     */
    public static function srcset(?string $storedPath): array
    {
        if ($storedPath === null || trim($storedPath) === '') {
            return [];
        }

        $storedPath = ltrim(str_replace('\\', '/', $storedPath), '/');
        $variants = self::variantsInDirectory($storedPath);
        $srcset = [];

        $cutout = self::cutoutPathFor(self::largestSourcePath($storedPath));

        if (self::exists($cutout)) {
            $size = @getimagesize(public_path('images/'.$cutout));

            if ($size !== false) {
                return [['path' => $cutout, 'width' => $size[0]]];
            }
        }

        foreach ($variants as $variant) {
            $width = self::widthFromFilename($variant['basename']);

            if ($width <= 0) {
                $size = @getimagesize(public_path('images/'.$variant['path']));
                $width = $size ? $size[0] : 0;
            }

            if ($width > 0) {
                $srcset[] = ['path' => $variant['path'], 'width' => $width];
            }
        }

        usort($srcset, fn (array $a, array $b) => $a['width'] <=> $b['width']);

        return $srcset;
    }

    public static function resolveThumbnailPath(string $storedPath): string
    {
        if (self::exists($storedPath) && self::isThumbnailSized($storedPath)) {
            return $storedPath;
        }

        foreach (self::thumbnailCandidates($storedPath) as $candidate) {
            if (self::exists($candidate)) {
                return $candidate;
            }
        }

        if (self::exists($storedPath)) {
            return $storedPath;
        }

        foreach (self::fallbackCandidates($storedPath) as $candidate) {
            if (self::exists($candidate)) {
                return $candidate;
            }
        }

        $match = self::findByBasename(basename($storedPath), self::SIZE_THUMB);

        if ($match !== null) {
            return $match;
        }

        return self::PLACEHOLDER;
    }

    public static function resolveCardPath(string $storedPath): string
    {
        $variants = self::variantsInDirectory($storedPath);

        if ($variants !== []) {
            $scored = [];

            foreach ($variants as $variant) {
                $width = self::widthFromFilename($variant['basename']);

                if ($width <= 0) {
                    $size = @getimagesize(public_path('images/'.$variant['path']));
                    $width = $size ? $size[0] : 0;
                }

                if ($width > 0) {
                    $scored[] = ['path' => $variant['path'], 'width' => $width];
                }
            }

            if ($scored !== []) {
                usort($scored, fn (array $a, array $b) => $a['width'] <=> $b['width']);

                // Cards display ~220px wide; 2x retina ≈ 440px — pick the smallest file still sharp enough.
                foreach ($scored as $variant) {
                    if ($variant['width'] >= 440) {
                        return $variant['path'];
                    }
                }

                return $scored[array_key_last($scored)]['path'];
            }
        }

        return self::resolveThumbnailPath($storedPath);
    }

    public static function resolveLargestPath(string $storedPath): string
    {
        $variants = self::variantsInDirectory($storedPath);

        if ($variants !== []) {
            usort($variants, fn (array $a, array $b) => $b['area'] <=> $a['area']);

            return $variants[0]['path'];
        }

        if (self::exists($storedPath)) {
            return $storedPath;
        }

        foreach (self::fallbackCandidates($storedPath) as $candidate) {
            if (self::exists($candidate)) {
                return $candidate;
            }
        }

        $match = self::findByBasename(basename($storedPath), self::SIZE_LARGE);

        if ($match !== null) {
            return $match;
        }

        return self::resolveThumbnailPath($storedPath);
    }

    /**
     * Best path to keep in the database (largest local file for this product image).
     */
    public static function canonicalStoragePath(?string $storedPath): string
    {
        if ($storedPath === null || trim($storedPath) === '' || self::isBrandImage($storedPath)) {
            return self::PLACEHOLDER;
        }

        $largest = self::resolveLargestPath(ltrim(str_replace('\\', '/', $storedPath), '/'));

        if (self::isBrandImage($largest)) {
            return self::PLACEHOLDER;
        }

        return $largest === self::PLACEHOLDER
            ? self::resolveThumbnailPath(ltrim(str_replace('\\', '/', $storedPath), '/'))
            : $largest;
    }

    /**
     * @return list<string>
     */
    private static function thumbnailCandidates(string $storedPath): array
    {
        $candidates = [];
        $stem = self::baseStem(basename($storedPath));
        $relativeDir = dirname($storedPath);

        if (preg_match('/\.(jpe?g|png|webp|avif|gif)$/i', $storedPath, $match)) {
            $ext = $match[1];
            $candidates[] = $relativeDir.'/'.$stem.'-300x300.'.$ext;
        }

        return array_values(array_unique($candidates));
    }

    /**
     * @return list<string>
     */
    private static function fallbackCandidates(string $storedPath): array
    {
        $candidates = [];

        if (preg_match('/-scaled\.(jpe?g|png|webp|avif|gif)$/i', $storedPath, $match)) {
            $candidates[] = preg_replace('/-scaled\.(jpe?g|png|webp|avif|gif)$/i', '-300x300.$1', $storedPath);
            $candidates[] = preg_replace('/-scaled\.(jpe?g|png|webp|avif|gif)$/i', '.$1', $storedPath);
        }

        if (preg_match('/\.(jpe?g|png|webp|avif|gif)$/i', $storedPath, $match)) {
            $ext = $match[1];
            $withoutSize = preg_replace('/-\d+x\d+\.'.$ext.'$/i', '.'.$ext, $storedPath);
            $candidates[] = preg_replace('/\.'.$ext.'$/i', '-300x300.'.$ext, $withoutSize);
            $candidates[] = $withoutSize;
        }

        return array_values(array_unique(array_filter($candidates, fn (string $path) => $path !== $storedPath)));
    }

    /**
     * @return list<array{basename: string, path: string, area: int}>
     */
    private static function variantsInDirectory(string $storedPath): array
    {
        $relativeDir = dirname($storedPath);
        $directory = public_path('images/'.$relativeDir);

        if (! is_dir($directory)) {
            return [];
        }

        $stem = self::baseStem(basename($storedPath));
        $variants = [];

        foreach (scandir($directory) ?: [] as $filename) {
            if ($filename === '.' || $filename === '..') {
                continue;
            }

            if (! preg_match('/\.(jpe?g|png|webp|avif|gif)$/i', $filename)) {
                continue;
            }

            if (str_contains($filename, '-cutout.')) {
                continue;
            }

            if (self::baseStem($filename) !== $stem) {
                continue;
            }

            $path = $relativeDir.'/'.$filename;
            $width = self::widthFromFilename($filename);
            $height = self::heightFromFilename($filename);
            $area = $width > 0 && $height > 0
                ? $width * $height
                : self::filePixelArea(public_path('images/'.$path));

            $variants[] = [
                'basename' => $filename,
                'path' => $path,
                'area' => $area,
            ];
        }

        return $variants;
    }

    public static function findByBasename(string $basename, string $size = self::SIZE_THUMB): ?string
    {
        if ($basename === '') {
            return null;
        }

        $storageRoot = public_path('images/storage');

        if (! is_dir($storageRoot)) {
            return null;
        }

        $stem = self::baseStem($basename);
        $ext = pathinfo($basename, PATHINFO_EXTENSION);
        $best = null;
        $bestArea = 0;

        foreach (['2025', '2024', '2023', '2022'] as $year) {
            $yearPath = $storageRoot.DIRECTORY_SEPARATOR.$year;

            if (! is_dir($yearPath)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($yearPath, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (self::baseStem($file->getFilename()) !== $stem) {
                    continue;
                }

                $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($storageRoot) + 1));
                $path = 'storage/'.$relative;
                $area = self::filePixelArea($file->getPathname());

                if ($size === self::SIZE_THUMB && str_contains($file->getFilename(), '-300x300.')) {
                    return $path;
                }

                if ($area > $bestArea) {
                    $bestArea = $area;
                    $best = $path;
                }
            }
        }

        return $best;
    }

    private static function baseStem(string $filename): string
    {
        $stem = pathinfo($filename, PATHINFO_FILENAME);

        return preg_replace('/(-scaled|-cutout|-\d+x\d+)$/i', '', $stem) ?? $stem;
    }

    private static function widthFromFilename(string $filename): int
    {
        if (preg_match('/-(\d+)x\d+\./i', $filename, $match)) {
            return (int) $match[1];
        }

        return 0;
    }

    private static function heightFromFilename(string $filename): int
    {
        if (preg_match('/-\d+x(\d+)\./i', $filename, $match)) {
            return (int) $match[1];
        }

        return 0;
    }

    private static function filePixelArea(string $absolutePath): int
    {
        if (! is_file($absolutePath)) {
            return 0;
        }

        $size = @getimagesize($absolutePath);

        if ($size === false) {
            return 0;
        }

        return $size[0] * $size[1];
    }

    private static function isThumbnailSized(string $path): bool
    {
        return (bool) preg_match('/-(?:100|150|300)x(?:100|150|300)\./i', basename($path));
    }

    private static function exists(string $path): bool
    {
        return is_file(public_path('images/'.$path));
    }

    public static function productsDir(): string
    {
        return trim((string) config('product_images.products_dir', 'storage/products'), '/');
    }

    public static function descriptiveImagePath(string $fileSlug, string $extension): string
    {
        return self::productsDir().'/'.$fileSlug.'.'.strtolower($extension);
    }

    public static function usesDescriptiveFilename(string $fileSlug, ?string $storedPath): bool
    {
        if ($storedPath === null || trim($storedPath) === '') {
            return false;
        }

        $storedPath = ltrim(str_replace('\\', '/', $storedPath), '/');
        $prefix = self::productsDir().'/'.$fileSlug.'.';

        return str_starts_with($storedPath, $prefix);
    }

    /**
     * Copy the resolved catalog image (and cutout, if present) to storage/products/{slug}.{ext}.
     */
    public static function materializeDescriptivePath(string $fileSlug, ?string $storedPath, bool $force = false): ?string
    {
        if ($storedPath === null || trim($storedPath) === '' || self::isBrandImage($storedPath)) {
            return null;
        }

        $sourceRelative = self::largestSourcePath(ltrim(str_replace('\\', '/', $storedPath), '/'));

        if ($sourceRelative === self::PLACEHOLDER || ! self::exists($sourceRelative)) {
            return null;
        }

        if (self::usesDescriptiveFilename($fileSlug, $sourceRelative) && ! $force) {
            return $sourceRelative;
        }

        $extension = pathinfo($sourceRelative, PATHINFO_EXTENSION);

        if ($extension === '') {
            return null;
        }

        $destRelative = self::descriptiveImagePath($fileSlug, $extension);
        $destAbsolute = public_path('images/'.$destRelative);
        $sourceAbsolute = public_path('images/'.$sourceRelative);

        self::ensureDirectory(dirname($destAbsolute));

        if ($force || ! is_file($destAbsolute) || filesize($destAbsolute) !== filesize($sourceAbsolute)) {
            if (! copy($sourceAbsolute, $destAbsolute)) {
                return null;
            }
        }

        $sourceCutout = self::cutoutPathFor($sourceRelative);

        if (self::exists($sourceCutout)) {
            $destCutout = self::cutoutPathFor($destRelative);
            $destCutoutAbsolute = public_path('images/'.$destCutout);

            if ($force || ! is_file($destCutoutAbsolute) || filesize($destCutoutAbsolute) !== filesize(public_path('images/'.$sourceCutout))) {
                copy(public_path('images/'.$sourceCutout), $destCutoutAbsolute);
            }
        }

        return $destRelative;
    }

    private static function ensureDirectory(string $absoluteDir): void
    {
        if (! is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }
    }
}
