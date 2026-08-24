<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestPosts extends TableWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Bài viết mới cập nhật';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query()->with('category')->latest('updated_at')->limit(6))
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->limit(70)
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->placeholder('Chưa phân loại'),
                TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->date('d/m/Y')
                    ->placeholder('Chưa đăng'),
                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->since(),
            ])
            ->recordUrl(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record]))
            ->paginated(false)
            ->emptyStateHeading('Chưa có bài viết');
    }
}
