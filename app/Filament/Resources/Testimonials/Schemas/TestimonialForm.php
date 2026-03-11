<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin đánh giá')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên khách hàng')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('position')
                            ->label('Chức vụ / Công ty')
                            ->maxLength(200),
                        FileUpload::make('avatar')
                            ->label('Ảnh đại diện')
                            ->image()
                            ->disk('public_uploads')
                            ->directory('upload/testimonials')
                            ->visibility('public')
                            ->avatar()
                            ->columnSpanFull(),
                        Textarea::make('content')
                            ->label('Nội dung đánh giá')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Select::make('rating')
                            ->label('Số sao')
                            ->options([
                                1 => '⭐ 1 sao',
                                2 => '⭐⭐ 2 sao',
                                3 => '⭐⭐⭐ 3 sao',
                                4 => '⭐⭐⭐⭐ 4 sao',
                                5 => '⭐⭐⭐⭐⭐ 5 sao',
                            ])
                            ->default(5)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Thứ tự')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Hiển thị')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
