<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin liên hệ')
                    ->schema([
                        TextInput::make('name')->label('Tên')->required(),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('phone')->label('Số điện thoại'),
                        TextInput::make('subject')->label('Tiêu đề'),
                        Textarea::make('message')->label('Nội dung')->rows(5)->columnSpanFull(),
                        Toggle::make('is_read')->label('Đã đọc'),
                    ])->columns(2),
            ]);
    }
}
