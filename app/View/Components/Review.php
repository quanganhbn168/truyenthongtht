<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Review extends Component
{
    /**
     * Model polymorphic: 'post', 'service', 'product', v.v.
     */
    public string $model;
    public int    $modelId;
    public string $title;

    public function __construct(
        string $model,
        int    $modelId,
        string $title = 'Đánh giá & Bình luận'
    ) {
        $this->model   = $model;
        $this->modelId = $modelId;
        $this->title   = $title;
    }

    public function render()
    {
        return view('components.review');
    }
}
