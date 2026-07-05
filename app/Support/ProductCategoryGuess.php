<?php

namespace App\Support;

class ProductCategoryGuess
{
    public static function fromSlug(string $slug): string
    {
        $slug = strtolower(trim($slug));

        $rules = [
            'projectors' => '/projector|epson|benq|optoma/',
            'canon-cameras' => '/^canon-(?:r[0-9]|eos|5d|6d|80d|xa|c[0-9]{2,3}|xf)/',
            'sony-cameras' => '/^sony-(?:a7|fx|pxw|alpha|zve|a6)/',
            'canon-lenses' => '/^canon-(?:ef|rf|.*mm)/',
            'sony-lenses' => '/^sony-.*mm/',
            'sigma-lenses' => '/^sigma-.*mm/',
            'lens' => '/(?:mm|lens|prime|telephoto|wide-angle|f-[0-9])/',
            'continuous-light' => '/(?:light|softbox|aputure|amaran|tolifo|godox|nanlite|led|strobe|flash|c-stand|stand|reflector|diffuser|octabox|soft-box)/',
            'gimbals' => '/(?:gimbal|ronin|zhiyun|rs-[0-9]|crane|steadicam|slider|vaxis|weebill)/',
            'drone' => '/(?:drone|mavic|phantom|mini-[0-9]|air-[0-9]|fpv|inspire)/',
            'audio-gears' => '/(?:mic|microphone|recorder|audio|boom|wireless|rode|sennheiser|zoom-h|lavalier|xdr)/',
            'cameras' => '/(?:blackmagic|panasonic|nikon|fuji|red-komodo|bmpcc|camcorder|xa11|ux90|16605|pxw)/',
        ];

        foreach ($rules as $categorySlug => $pattern) {
            if (preg_match($pattern, $slug)) {
                return $categorySlug;
            }
        }

        return 'accessories';
    }
}
