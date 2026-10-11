<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên DV')->searchable()->sortable()->limit(50),
                ImageColumn::make('image')->label('Ảnh')->disk('public_uploads'),
                TextColumn::make('category.name')->label('Danh mục')->sortable(),
                TextColumn::make('price')->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state) . '₫')->sortable(),
                TextColumn::make('view_count')->label('Lượt xem')->numeric()->sortable(),
                ToggleColumn::make('is_active')->label('Hiển thị'),
                ToggleColumn::make('is_home')->label('Trang chủ'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y')
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category_id')->label('Danh mục')->relationship('category', 'name'),
                TernaryFilter::make('is_home')->label('Trang chủ'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
