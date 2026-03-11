<?php

namespace App\Filament\Resources\Intros\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IntrosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('STT')->numeric()->sortable()->width(60),
                ImageColumn::make('image')->label('Ảnh')->defaultImageUrl(null)->circular(),
                TextColumn::make('icon')->label('Icon class')->limit(30),
                TextColumn::make('title')->label('Tiêu đề')->searchable()->sortable()->limit(50),
                TextColumn::make('subtitle')->label('Tiêu đề phụ')->limit(40)->toggleable(),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
