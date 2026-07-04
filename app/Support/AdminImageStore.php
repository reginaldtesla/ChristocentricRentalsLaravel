<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

class AdminImageStore
{
    public const MAX_KILOBYTES = 5120;

    /** @var list<string> */
    public const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'];

    public static function rules(string $field = 'image_file'): array
    {
        return [
            $field => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif,avif', 'max:'.self::MAX_KILOBYTES],
        ];
    }

    public static function store(UploadedFile $file, string $directory = 'uploads/site'): string
    {
        self::guardFile($file);

        $extension = strtolower($file->extension() ?: 'jpg');
        $filename = Str::uuid()->toString().'.'.$extension;
        $relativeDirectory = trim(str_replace('\\', '/', $directory), '/');
        $targetDirectory = public_path('images/'.$relativeDirectory);

        if (! is_dir($targetDirectory) && ! mkdir($targetDirectory, 0755, true) && ! is_dir($targetDirectory)) {
            throw new RuntimeException('Could not create upload directory.');
        }

        $file->move($targetDirectory, $filename);

        return $relativeDirectory.'/'.$filename;
    }

    public static function storeForProduct(UploadedFile $file, string $slug): string
    {
        self::guardFile($file);

        $slug = Str::slug($slug) ?: 'product';
        $extension = strtolower($file->extension() ?: 'jpg');
        $relativeDirectory = 'storage/products';
        $targetDirectory = public_path('images/'.$relativeDirectory);

        if (! is_dir($targetDirectory) && ! mkdir($targetDirectory, 0755, true) && ! is_dir($targetDirectory)) {
            throw new RuntimeException('Could not create product image directory.');
        }

        $filename = $slug.'.'.$extension;
        $file->move($targetDirectory, $filename);

        return $relativeDirectory.'/'.$filename;
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    public static function applyImageUploads(
        \Illuminate\Http\Request $request,
        array $items,
        string $requestKey,
        string $directory,
    ): array {
        foreach ($items as $index => $item) {
            $file = $request->file("{$requestKey}.{$index}.image_file");

            if ($file instanceof UploadedFile) {
                $items[$index]['image'] = self::store($file, $directory);
            }
        }

        return $items;
    }

    private static function guardFile(UploadedFile $file): void
    {
        $extension = strtolower($file->extension() ?: '');

        if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('Unsupported image type.');
        }
    }
}
