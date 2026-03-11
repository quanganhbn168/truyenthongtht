<?php

namespace App\Filament\Resources\ServiceCategories\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'Dịch vụ thuộc danh mục';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Tên dịch vụ')->required()->maxLength(500)->columnSpanFull(),
            TextInput::make('price')->label('Giá')->numeric()->prefix('₫')->default(0),
            TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
            Toggle::make('is_active')->label('Hiển thị')->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên dịch vụ')->searchable()->limit(50),
                TextColumn::make('price')->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state) . '₫'),
                TextColumn::make('view_count')->label('Lượt xem')->numeric(),
                ToggleColumn::make('is_active')->label('Hiển thị'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([CreateAction::make()->label('Thêm dịch vụ')]);
    }
}
