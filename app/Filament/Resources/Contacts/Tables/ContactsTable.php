<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('SĐT')->searchable(),
                TextColumn::make('subject')->label('Tiêu đề')->limit(40),
                ToggleColumn::make('is_read')->label('Đã đọc'),
                TextColumn::make('created_at')->label('Ngày gửi')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Trạng thái')
                    ->trueLabel('Đã đọc')
                    ->falseLabel('Chưa đọc')
                    ->queries(
                        true: fn ($query) => $query->where('is_read', true),
                        false: fn ($query) => $query->where('is_read', false),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
