<?php

namespace App\Http\Controllers;

use App\Models\Intro;
use App\Settings\PageSettings;
use App\Settings\WebsiteSettings;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        // Lấy tất cả intros active, sắp xếp theo sort_order
        $intros = Intro::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Tách từng loại intro theo subtitle để render đúng vị trí
        $mission   = $intros->firstWhere('subtitle', 'Vì sao chúng tôi tồn tại');
        $vision    = $intros->firstWhere('subtitle', 'Chúng tôi hướng đến điều gì');
        $values    = $intros->firstWhere('subtitle', 'Những gì chúng tôi cam kết');
        $whyUs     = $intros->whereIn('subtitle', ['Chúng tôi là ai', 'Tại sao chọn chúng tôi']);

        return view('pages.about', compact(
            'intros',
            'mission',
            'vision',
            'values',
            'whyUs',
        ));
    }
}
