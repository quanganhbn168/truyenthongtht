<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Components\SlugInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                        Tab::make('Nội dung cơ bản')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                ...SlugInput::make(nameField: 'name', label: 'Tên dịch vụ'),
                                Select::make('category_id')->label('Danh mục')
                                    ->relationship('category', 'name')->searchable()->preload()->required(),
                                Textarea::make('summary')->label('Mô tả ngắn')->rows(3)->columnSpanFull(),
                                RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ])->columns(2),
                        Tab::make('Khách hàng & Nỗi đau')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                RichEditor::make('pain_points')->label('Nỗi đau khách hàng (Pain points)')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                                RichEditor::make('benefits')->label('Lợi ích & Giải pháp (Benefits)')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ]),
                        Tab::make('Hậu trường & Quy trình')
                            ->icon('heroicon-o-film')
                            ->schema([
                                FileUpload::make('behind_the_scenes')
                                    ->label('Hậu trường thực tế (Ảnh/Video)')
                                    ->multiple()
                                    ->acceptedFileTypes(['image/*', 'video/*'])
                                    ->directory('upload/behind_the_scenes')
                                    ->maxSize(10240) // 10MB max per file
                                    ->panelLayout('grid')
                                    ->columnSpanFull(),
                                Repeater::make('process')->label('Quy trình thực hiện')
                                    ->schema([
                                        TextInput::make('title')->label('Tiêu đề bước')->required(),
                                        Textarea::make('description')->label('Mô tả chi tiết')->rows(3),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->columnSpanFull(),
                                Repeater::make('faq')->label('Câu hỏi thường gặp (FAQ)')
                                    ->schema([
                                        TextInput::make('question')->label('Câu hỏi')->required(),
                                        Textarea::make('answer')->label('Trả lời')->rows(3)->required(),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Bảng giá & Gói dịch vụ')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Repeater::make('packages')->label('Các gói dịch vụ (Tùy chọn)')
                                    ->schema([
                                        TextInput::make('name')->label('Tên gói (VD: Cơ bản, Chuyên nghiệp)')->required(),
                                        TextInput::make('price_text')->label('Mức giá hiển thị (VD: 5.000.000đ / tháng)')->required(),
                                        Textarea::make('features')->label('Quyền lợi (Mỗi dòng 1 quyền lợi)')->rows(4)->required(),
                                        Toggle::make('is_popular')->label('Đánh dấu là Gói Phổ biến / Khuyên dùng')->default(false),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->columnSpanFull()
                                    ->addActionLabel('Thêm gói dịch vụ mới'),
                            ]),
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
