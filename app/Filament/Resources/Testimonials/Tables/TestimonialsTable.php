<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('STT')->numeric()->sortable()->width(60),
                ImageColumn::make('avatar')->label('Ảnh')->disk('public_uploads')->circular(),
                TextColumn::make('name')->label('Khách hàng')->searchable()->sortable(),
                TextColumn::make('position')->label('Chức vụ')->limit(40)->toggleable(),
                TextColumn::make('rating')->label('Sao')->sortable(),
                TextColumn::make('content')->label('Nội dung')->limit(60)->wrap(),
                IconColumn::make('is_active')->label('Hiển thị')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
