<?php

declare(strict_types=1);

if (! function_exists('subdirAsset')) {
    function subdirAsset($path)
    {
        return asset((App::environment('production') ? env('APP_DIR') : '') . '/' . $path);
    }
}

if (! function_exists('subdirMix')) {
    function subdirMix($path)
    {
        return mix((App::environment('production') ? env('APP_DIR') : '') . '/' . $path);
    }
}
