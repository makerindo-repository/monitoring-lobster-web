<?php
use App\Models\Setting;

if (! function_exists('avatar_profile_slug')) {
    function avatar_profile_slug($name) {
        $slug = '';
        $split = explode(' ', $name);

        if (count($split) > 1) $slug = $split[0][0] . $split[1][0];
        else                   $slug = $split[0][0];

        return strtoupper($slug);
    }
}

if (! function_exists('get_app_info')) {
    function get_app_info($column) {
        $data = Setting::first();
        return $data[$column] ?? 'undefined'; 
    }
}