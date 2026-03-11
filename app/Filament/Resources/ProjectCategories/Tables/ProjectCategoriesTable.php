<?php

namespace App\Filament\Resources\ProjectCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectCategoriesTable
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
                ToggleColumn::make('is_active')->label('Hiển thị'),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
