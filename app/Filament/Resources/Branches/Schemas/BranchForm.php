<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Thông tin chi nhánh')
                ->icon('heroicon-o-building-storefront')
                ->schema([
                    TextInput::make('name')
                        ->label('Tên chi nhánh')
                        ->required()
                        ->maxLength(200)
                        ->placeholder('VD: Chi nhánh Hà Nội')
                        ->columnSpanFull(),

                    Textarea::make('address')
                        ->label('Địa chỉ')
                        ->rows(2)
                        ->maxLength(500)
                        ->placeholder('VD: 123 Đường Lê Lợi, Hoàn Kiếm, Hà Nội')
                        ->columnSpanFull(),

                    TextInput::make('phone')
                        ->label('Số điện thoại')
                        ->tel()
                        ->maxLength(20)
                        ->placeholder('VD: 024 1234 5678'),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(100)
                        ->placeholder('VD: hanoi@thtmedia.vn'),
                ])
                ->columns(2),

            Section::make('Bản đồ & Giờ làm việc')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    TextInput::make('working_hours')
                        ->label('Giờ làm việc')
                        ->maxLength(200)
                        ->placeholder('VD: T2 - T7: 8:00 - 17:30')
                        ->columnSpanFull(),

                    Textarea::make('map_url')
                        ->label('Google Maps Embed URL / src')
                        ->rows(3)
                        ->maxLength(2000)
                        ->helperText('Lấy từ Google Maps → Chia sẻ → Nhúng bản đồ → copy phần src="..."')
                        ->columnSpanFull(),

                    Textarea::make('note')
                        ->label('Ghi chú nội bộ')
                        ->rows(2)
                        ->maxLength(1000)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
