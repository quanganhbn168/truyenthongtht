<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên SP')->searchable()->sortable()->limit(50),
                ImageColumn::make('image')->label('Ảnh'),
                TextColumn::make('category.name')->label('Danh mục')->sortable(),
                TextColumn::make('price')->label('Giá bán')
                    ->formatStateUsing(fn ($state) => number_format($state) . '₫')->sortable(),
                TextColumn::make('original_price')->label('Giá gốc')
                    ->formatStateUsing(fn ($state) => number_format($state) . '₫')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_bestseller')->label('Bán chạy')->boolean(),
                TextColumn::make('view_count')->label('Lượt xem')->numeric()->sortable(),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
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
