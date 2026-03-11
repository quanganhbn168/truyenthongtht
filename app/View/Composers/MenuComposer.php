<?php

namespace App\View\Composers;

use Datlechin\FilamentMenuBuilder\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view): void
    {
        $view->with('headerMenu', Menu::location('header'));
        $view->with('footerMenu', Menu::location('footer'));
    }
}
