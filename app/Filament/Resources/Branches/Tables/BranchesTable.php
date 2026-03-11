<?php

namespace App\Filament\Resources\Branches\Tables;

use App\Models\Branch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Tên chi nhánh')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Branch $r) => $r->address ? Str::limit($r->address, 60) : null)
                    ->weight('semibold'),

                TextColumn::make('phone')
                    ->label('Điện thoại')
                    ->placeholder('—')
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->placeholder('—')
                    ->copyable(),

                ToggleColumn::make('is_active')
                    ->label('Hiện'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Chưa có chi nhánh')
            ->emptyStateDescription('Nhấn "Tạo mới" để thêm chi nhánh đầu tiên.')
            ->emptyStateIcon('heroicon-o-building-storefront');
    }
}
