<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'Dịch vụ liên quan';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên dịch vụ')->searchable()->limit(60),
                TextColumn::make('category.name')->label('Danh mục'),
                TextColumn::make('price')->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state) . '₫'),
                ToggleColumn::make('is_active')->label('Hiển thị'),
            ])
            ->recordActions([DetachAction::make()])
            ->toolbarActions([
                AttachAction::make()
                    ->label('Gắn dịch vụ')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name']),
                DetachBulkAction::make(),
            ]);
    }
}
