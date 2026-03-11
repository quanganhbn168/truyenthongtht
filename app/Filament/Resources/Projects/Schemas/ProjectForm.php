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
                                TextInput::make('client_name')->label('Tên khách hàng / Đối tác')->maxLength(200),
                                DatePicker::make('project_date')->label('Ngày/Tháng/Năm thực hiện'),
                                Textarea::make('summary')->label('Mô tả ngắn (Hiển thị ngoài card)')->rows(3)->columnSpanFull(),
                            ])->columns(2),
                        Tab::make('Bài toán & Giải pháp')
                            ->icon('heroicon-o-light-bulb')
                            ->schema([
                                RichEditor::make('challenge')->label('Bài toán / Yêu cầu từ khách hàng (Challenge)')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                                RichEditor::make('solution')->label('Giải pháp & Thi công (Solution)')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                                RichEditor::make('content')->label('Nội dung báo chí/Bổ sung (Nội dung cũ)')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ]),
                        Tab::make('Media & Thư viện')
                            ->icon('heroicon-o-film')
                            ->schema([
                                TextInput::make('tvc_url')->label('Video TVC / Youtube URL (Tùy chọn)')->url()->columnSpanFull(),
                                FileUpload::make('image')->label('Ảnh Bìa / Hero Banner (Kích thước lớn)')->image()->disk('public_uploads')->directory('upload/images')->visibility('public')->columnSpanFull(),
                                FileUpload::make('gallery')
                                    ->label('Thư viện Hình ảnh / Video Hậu trường (Gallery)')
                                    ->multiple()
                                    ->acceptedFileTypes(['image/*', 'video/*'])
                                    ->disk('public_uploads')
                                    ->directory('upload/project_gallery')
                                    ->visibility('public')
                                    ->maxSize(10240) // 10MB per file
                                    ->panelLayout('grid')
                                    ->columnSpanFull(),
                                TextInput::make('thumbnail')->label('Thumbnail URL (Tùy chọn)'),
                            ]),
                        Tab::make('Cài đặt')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Toggle::make('is_featured')->label('Dự án Nổi bật'),
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
