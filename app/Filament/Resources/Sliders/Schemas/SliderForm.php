<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin slider')
                    ->schema([
                        TextInput::make('name')->label('Tên')->maxLength(200),
                        TextInput::make('link')->label('Liên kết')->maxLength(500),
                        FileUpload::make('image')->label('Ảnh banner')->image()
                            ->disk('public_uploads')->directory('upload/images')->visibility('public')->columnSpanFull(),
                        TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                        Toggle::make('is_active')->label('Hiển thị')->default(true),
                    ])->columns(2),
            ]);
    }
}
