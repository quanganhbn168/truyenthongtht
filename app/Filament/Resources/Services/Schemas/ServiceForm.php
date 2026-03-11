<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Components\SlugInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Nội dung')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                ...SlugInput::make(nameField: 'name', label: 'Tên dịch vụ'),
                                Select::make('category_id')->label('Danh mục')
                                    ->relationship('category', 'name')->searchable()->preload()->required(),
                                Textarea::make('summary')->label('Mô tả ngắn')->rows(3)->columnSpanFull(),
                                RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ])->columns(2),
                        Tab::make('Giá & Hình ảnh')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextInput::make('price')->label('Giá dịch vụ')->numeric()->prefix('₫')->default(0),
                                FileUpload::make('image')->label('Ảnh đại diện')->image()->disk('public_uploads')->directory('upload/images')->visibility('public'),
                                TextInput::make('thumbnail')->label('Thumbnail URL'),
                            ]),
                        Tab::make('Cài đặt')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                DatePicker::make('published_at')->label('Ngày đăng')->default(now()),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                                TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                            ])->columns(3),
                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')->label('Meta Title')->maxLength(500),
                                Textarea::make('meta_description')->label('Meta Description')->maxLength(500)->rows(3),
                                TextInput::make('keywords')->label('Keywords')->maxLength(500),
                            ]),
                    ])->persistTabInQueryString('tab')->columnSpanFull(),
            ]);
    }
}
