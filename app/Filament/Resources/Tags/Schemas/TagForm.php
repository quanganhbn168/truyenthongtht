<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin tag')
                    ->schema([
                        TextInput::make('name')->label('Tên tag')->required()->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->label('Slug')->required()->maxLength(200),
                        TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                        Toggle::make('is_active')->label('Hiển thị')->default(true),
                    ])->columns(2),
            ]);
    }
}
