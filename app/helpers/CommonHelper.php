<?php


use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_frontend_settings')) {
    function get_frontend_settings($key = '') {
        if (empty($key)) {
            return null;
        }

        // Query the database to fetch settings
        $setting = \DB::table('frontend_settings')
                       ->where('key', $key)
                       ->select('value')
                       ->first();

        if ($setting) {
            return $setting->value;
        }

        // If setting not found, return null or handle as needed
        return null;
    }
}
