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
