<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Quotes\QuoteResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Bài viết', Post::count())
                ->description(Post::where('is_active', true)->count() . ' đang hiển thị')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->extraAttributes($this->redirectAttributes(PostResource::getUrl('index'))),

            Stat::make('Dịch vụ', Service::count())
                ->description(Service::where('is_active', true)->count() . ' đang hiển thị')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('primary')
                ->extraAttributes($this->redirectAttributes(ServiceResource::getUrl('index'))),

            Stat::make('Dự án', Project::count())
                ->description(Project::where('is_featured', true)->where('is_active', true)->count() . ' dự án nổi bật')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success')
                ->extraAttributes($this->redirectAttributes(ProjectResource::getUrl('index'))),

            Stat::make('Sản phẩm', Product::count())
                ->description(Product::where('is_active', true)->count() . ' đang hiển thị')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color(Product::exists() ? 'warning' : 'gray')
                ->extraAttributes($this->redirectAttributes(ProductResource::getUrl('index'))),

            Stat::make('Liên hệ chưa đọc', Contact::where('is_read', false)->count())
                ->description(Contact::count() . ' liên hệ trong hệ thống')
                ->descriptionIcon('heroicon-m-envelope')
                ->color(Contact::where('is_read', false)->exists() ? 'danger' : 'success')
                ->extraAttributes($this->redirectAttributes(ContactResource::getUrl('index'))),

            Stat::make('Báo giá mới', Quote::where('status', 'new')->count())
                ->description(Quote::count() . ' yêu cầu báo giá')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color(Quote::where('status', 'new')->exists() ? 'danger' : 'success')
                ->extraAttributes($this->redirectAttributes(QuoteResource::getUrl('index'))),
        ];
    }

    /** @return array<string, string> */
    private function redirectAttributes(string $url): array
    {
        return [
            'class' => 'cursor-pointer',
            'wire:click' => "redirect('{$url}')",
        ];
    }
}
