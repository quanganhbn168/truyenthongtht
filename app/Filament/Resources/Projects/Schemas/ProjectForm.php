<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Components\SlugInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProjectForm
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
                                ...SlugInput::make(nameField: 'name', label: 'Tên dự án'),
                                Select::make('category_id')->label('Danh mục')
                                    ->relationship('category', 'name')->searchable()->preload()->required(),
                                Select::make('services')->label('Dịch vụ áp dụng')
                                    ->relationship('services', 'name')->multiple()->searchable()->preload(),
                                TextInput::make('client_name')->label('Tên khách hàng')->maxLength(200),
                                Textarea::make('summary')->label('Mô tả ngắn')->rows(3)->columnSpanFull(),
                                RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ])->columns(2),
                        Tab::make('Hình ảnh')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')->label('Ảnh đại diện')->image()->disk('public_uploads')->directory('upload/images')->visibility('public'),
                                TextInput::make('thumbnail')->label('Thumbnail URL'),
                            ]),
                        Tab::make('Cài đặt')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                DatePicker::make('project_date')->label('Ngày thực hiện'),
                                Toggle::make('is_featured')->label('Nổi bật'),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                                TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                            ])->columns(2),
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
