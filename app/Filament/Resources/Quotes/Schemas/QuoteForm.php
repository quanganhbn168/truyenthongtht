<?php

namespace App\Filament\Resources\Quotes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin khách hàng')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Họ và tên')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('company_name')
                            ->label('Tên công ty')
                            ->maxLength(255),
                    ]),
                Section::make('Chi tiết yêu cầu')
                    ->columns(2)
                    ->schema([
                        Select::make('service_id')
                            ->label('Dịch vụ quan tâm')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('budget_range')
                            ->label('Ngân sách dự kiến')
                            ->options([
                                'Dưới 10 triệu' => 'Dưới 10 triệu',
                                '10 - 50 triệu' => '10 - 50 triệu',
                                '50 - 100 triệu' => '50 - 100 triệu',
                                'Trên 100 triệu' => 'Trên 100 triệu',
                                'Chưa xác định' => 'Chưa xác định',
                            ]),
                        Textarea::make('note')
                            ->label('Ghi chú / Yêu cầu chi tiết')
                            ->columnSpanFull()
                            ->rows(4),
                        Select::make('status')
                            ->label('Trạng thái xử lý')
                            ->options([
                                'new' => 'Mới',
                                'contacting' => 'Đang liên hệ',
                                'quoted' => 'Đã báo giá',
                                'closed' => 'Hoàn tất/Hủy',
                            ])
                            ->default('new')
                            ->required(),
                    ]),
            ]);
    }
}
