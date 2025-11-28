<?php
namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FakerImageProvider extends Base
{
    public function imageMy(string $dir='', int $width = 640, int $heidth = 480): string
    {
        $name = $dir . '/'. Str::random(6) .'.png';

        Storage::disk('public')->put(
            $name,
            file_get_contents("https://placehold.jp/".$width."x".$heidth.".png")
        );

        // return '/storage/' . $name;
        return $name;
    }
}
