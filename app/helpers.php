<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('is_active_menu')) {
    function is_active_menu($route)
    {
        return Route::currentRouteNamed($route) ? 'active' : '';
    }
}

if (!function_exists('is_open_menu')) {
    function is_open_menu(array $submenu)
    {
        foreach ($submenu as $item) {
            if (Route::currentRouteNamed($item['route'])) {
                return 'menu-open';
            }
        }
        return '';
    }
}
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings = null;
        if (is_null($settings)) {
            $settings = \Illuminate\Support\Facades\Cache::remember('settings', 3600, function () {
                return \App\Models\Setting::where('autoload', 1)->pluck('value', 'key')->toArray();
            });
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('setting_update')) {
    function setting_update($key, $value, $autoload = true, $group = null, $type = null)
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'autoload' => $autoload,
                'group' => $group,
                'type' => $type,
            ]
        );

        \Illuminate\Support\Facades\Cache::forget('settings');
    }
}
