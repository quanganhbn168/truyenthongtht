<?php

namespace App\Filament\Resources\ProductCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->searchable()->limit(30),
                TextColumn::make('parent.name')->label('DM cha')->searchable(),
                ImageColumn::make('image')->label('Ảnh'),
                TextColumn::make('sort_order')->label('Thứ tự')->numeric()->sortable(),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y')
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
