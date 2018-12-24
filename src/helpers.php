<?php
use TeeLaravel\Menu\Facades\Menu;

if (!function_exists('menu_get')) {
    function menu_get($slug = null)
    {
        return Menu::use ($slug);
    }
}
