<?php

namespace App\Filament\Resources\ServiceCategories\Schemas;

use App\Filament\Components\SlugInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // ── Nội dung chính (2/3) ──
                Section::make('Thông tin danh mục')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        ...SlugInput::make(nameField: 'name', label: 'Tên danh mục'),
                        Select::make('parent_id')->label('Danh mục cha')
                            ->relationship('parent', 'name')->searchable()->preload()->placeholder('Danh mục gốc'),
                        Toggle::make('is_active')->label('Hiển thị')->default(true),
                        Textarea::make('description')->label('Mô tả ngắn')->rows(3)->columnSpanFull(),
                        RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull()
                            ->fileAttachmentsDirectory('upload/images'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                // ── Sidebar (1/3) ──
                Section::make('Hình ảnh & SEO')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Ảnh đại diện')
                            ->disk('public_uploads')
                            ->directory('upload/images')
                            ->visibility('public')
                            ->imageEditor()
                            ->openable()
                            ->downloadable(),
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(500),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(500)
                            ->rows(3),
                        TextInput::make('keywords')
                            ->label('Keywords')
                            ->maxLength(500),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
