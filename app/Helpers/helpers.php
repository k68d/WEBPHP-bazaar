<?php

if (!function_exists('asset_or_default')) {
    function asset_or_default($path, $default = '/storage/images/img_DEFAULT.png')
    {
        return file_exists(public_path($path)) ? asset($path) : asset($default);
    }
}
