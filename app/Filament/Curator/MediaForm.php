<?php

namespace App\Filament\Curator;

use Awcodes\Curator\Resources\Media\Schemas\MediaForm as BaseMediaForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class MediaForm extends BaseMediaForm
{
    public static function getAdditionalInformationFormSchema(): array
    {
        return [
            ...parent::getAdditionalInformationFormSchema(),
            Select::make('processing_format')
                ->label('Định dạng lưu')
                ->options([
                    'original' => 'Giữ nguyên định dạng gốc',
                    'webp' => 'Chuyển sang WebP',
                ])
                ->default('original')
                ->required()
                ->helperText('Chỉ áp dụng cho ảnh; video, audio và tài liệu được giữ nguyên.'),
            Toggle::make('watermark_enabled')
                ->label('Đóng watermark')
                ->default(false)
                ->helperText('Dùng watermark chung đang cấu hình trong hệ thống.'),
            Select::make('processing_quality')
                ->label('Chất lượng WebP')
                ->options([
                    80 => '80 - nhẹ hơn',
                    85 => '85 - cân bằng',
                    90 => '90 - khuyến nghị',
                    95 => '95 - ưu tiên chi tiết',
                    100 => '100 - lớn nhất',
                ])
                ->default(90)
                ->required()
                ->native(false)
                ->helperText('Chủ yếu ảnh hưởng khi chọn chuyển sang WebP.'),
        ];
    }
}
