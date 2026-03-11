<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Tiêu đề')->searchable()->sortable()->limit(50)
                    ->description(fn ($record) => $record->slug),
                ImageColumn::make('image')->label('Ảnh')
                    ->getStateUsing(fn ($record) => $record->image ? asset($record->image) : null)
                    ->height(48)
                    ->width(72),
                TextColumn::make('category.name')->label('Danh mục')->sortable(),
                TextColumn::make('published_at')->label('Ngày đăng')->date('d/m/Y')->sortable(),
                TextColumn::make('view_count')->label('Lượt xem')->numeric()->sortable(),
                ToggleColumn::make('is_active')->label('Hiển thị'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y')
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
