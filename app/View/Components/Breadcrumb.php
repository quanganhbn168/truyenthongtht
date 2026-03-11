<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $items;

    /**
     * @param array $items Mảng breadcrumb items: [['label' => '...', 'url' => '...'], ...]
     *                     Item cuối cùng không cần url (đang active)
     */
    public function __construct(
        array $items = [],
        public string $homeLabel = 'Trang chủ',
        public string $homeUrl = '/',
        public bool $showHome = true,
        public string $theme = 'light',
    ) {
        // Tự động prepend Home nếu showHome = true
        if ($showHome) {
            array_unshift($items, ['label' => $homeLabel, 'url' => $homeUrl]);
        }
        $this->items = $items;
    }

    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
