<?php

namespace App\Filament\Resources\ProjectCategories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Thông tin')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('name')->label('Tên danh mục')->required()->maxLength(200)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')->label('Slug (URL)')->required()->unique(ignoreRecord: true)
                                    ->helperText('Chỉ lưu nội dung sạch, không chứa .html'),
                                Select::make('parent_id')->label('Danh mục cha')
                                    ->relationship('parent', 'name')->searchable()->preload()->placeholder('-- Không có --'),
                                Textarea::make('description')->label('Mô tả ngắn')->rows(3)->columnSpanFull(),
                                TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                            ])->columns(2),
                        Tab::make('Hình ảnh')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')->label('Ảnh đại diện')->image()->disk('public_uploads')->directory('upload/images')->visibility('public'),
                                TextInput::make('thumbnail')->label('Thumbnail URL'),
                            ]),
                        Tab::make('Nội dung')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull()->fileAttachmentsDirectory('upload/images'),
                            ]),
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
