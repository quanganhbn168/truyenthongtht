<?php

namespace App\Filament\Resources\Intros\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IntroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ── Nội dung chính ────────────────────────────────────────
                Section::make('Nội dung')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Tiêu đề')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('subtitle')
                            ->label('Tiêu đề phụ')
                            ->maxLength(255),

                        TextInput::make('icon')
                            ->label('Icon (Font Awesome)')
                            ->placeholder('fa-solid fa-star')
                            ->maxLength(100)
                            ->helperText('Bỏ trống nếu dùng ảnh'),

                        FileUpload::make('image')
                            ->label('Ảnh minh họa')
                            ->image()
                            ->disk('public_uploads')
                            ->directory('upload/intros')
                            ->visibility('public')
                            ->imagePreviewHeight('180')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Nội dung')
                            ->columnSpanFull(),    // full toolbar mặc định — không cần chỉ định
                    ])
                    ->columns(2),

                // ── Liên kết ──────────────────────────────────────────────
                Section::make('Liên kết')
                    ->icon('heroicon-o-link')
                    ->schema([
                        TextInput::make('link')
                            ->label('URL')
                            ->url()
                            ->maxLength(500),

                        TextInput::make('link_text')
                            ->label('Nhãn nút')
                            ->placeholder('Xem thêm')
                            ->maxLength(100),

                        Toggle::make('is_active')
                            ->label('Hiển thị')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

            ]);
    }
}
