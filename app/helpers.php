<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('is_active_menu')) {
    function is_active_menu($route)
    {
        return Route::is($route) || Route::is($route . '.*') ? 'active' : '';
    }
}

if (!function_exists('is_open_menu')) {
    function is_open_menu(array $submenu): string
    {
        foreach ($submenu as $item) {
            // Kiểm tra submenu lồng nhau
            if (!empty($item['submenu']) && is_open_menu($item['submenu'])) {
                return 'menu-open';
            }

            // Kiểm tra route con khớp
            if (!empty($item['route']) && Route::is($item['route'] . '*')) {
                return 'menu-open';
            }
        }

        return '';
    }
}
