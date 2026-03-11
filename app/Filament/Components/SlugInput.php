<?php

namespace App\Filament\Components;

use Filament\Forms\Components\TextInput;

/**
 * SlugInput — tạo cặp field (nameField + slugField) cho mọi Filament Form.
 *
 * Tính năng:
 *  - Auto-generate slug từ title khi blur (tiếng Việt → không dấu → kebab-case)
 *  - Hiển thị URL prefix làm hint để admin thấy full URL
 *  - Validation unique server-side (ignoreRecord)
 *  - Collision tự động xử lý bên SlugObserver (-1, -2, -3...)
 *
 * Cách dùng:
 *   [...SlugInput::make(nameField: 'name', label: 'Tên dịch vụ')]
 *   [...SlugInput::make(nameField: 'title', label: 'Tiêu đề bài viết')]
 */
class SlugInput
{
    /**
     * Trả về mảng [nameField, slugField] — dùng spread operator trong schema().
     *
     * @param  string  $nameField  Tên field nguồn (thường 'name' hoặc 'title')
     * @param  string  $label      Label hiển thị cho nameField
     * @param  bool    $required   nameField có required không
     */
    public static function make(
        string $nameField = 'name',
        string $label = 'Tên',
        bool $required = true,
    ): array {
        $baseUrl = rtrim(config('app.url'), '/') . '/';

        return [
            TextInput::make($nameField)
                ->label($label)
                ->required($required)
                ->maxLength(500)
                ->columnSpanFull()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($get, $set, ?string $state, $record) {
                    // Chỉ auto-generate khi slug chưa có (create) hoặc vẫn là slug mặc định
                    $currentSlug = $get('slug');
                    if ($currentSlug && $record) {
                        return; // Edit mode: giữ slug cũ nếu đã có record
                    }
                    if ($state) {
                        $set('slug', static::toSlug($state));
                    }
                }),

            TextInput::make('slug')
                ->label('Slug (URL)')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(500)
                ->prefix($baseUrl)
                ->helperText('Tự động tạo từ tên.')
                ->columnSpanFull()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($set, ?string $state) {
                    // Sanitize khi người dùng tự gõ slug
                    if ($state) {
                        $set('slug', static::sanitizeSlug($state));
                    }
                }),
        ];
    }

    /**
     * Convert tiếng Việt → kebab-case slug.
     * Ví dụ: "Dịch vụ TikTok" → "dich-vu-tiktok"
     */
    public static function toSlug(string $value): string
    {
        // Bảng chuyển đổi tiếng Việt có dấu → không dấu
        $unicode = [
            'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ',
            'è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ',
            'ì','í','ị','ỉ','ĩ',
            'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ',
            'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
            'ỳ','ý','ỵ','ỷ','ỹ',
            'đ',
            'À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă','Ằ','Ắ','Ặ','Ẳ','Ẵ',
            'È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ',
            'Ì','Í','Ị','Ỉ','Ĩ',
            'Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ','Ờ','Ớ','Ợ','Ở','Ỡ',
            'Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ',
            'Ỳ','Ý','Ỵ','Ỷ','Ỹ',
            'Đ',
        ];
        $ascii = [
            'a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a',
            'e','e','e','e','e','e','e','e','e','e','e',
            'i','i','i','i','i',
            'o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o',
            'u','u','u','u','u','u','u','u','u','u','u',
            'y','y','y','y','y',
            'd',
            'A','A','A','A','A','A','A','A','A','A','A','A','A','A','A','A','A',
            'E','E','E','E','E','E','E','E','E','E','E',
            'I','I','I','I','I',
            'O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O',
            'U','U','U','U','U','U','U','U','U','U','U',
            'Y','Y','Y','Y','Y',
            'D',
        ];

        $value = str_replace($unicode, $ascii, $value);
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9\s-]/', '', $value);
        $value = preg_replace('/[\s]+/', '-', trim($value));
        $value = preg_replace('/-+/', '-', $value);
        $value = trim($value, '-');

        return $value;
    }

    /**
     * Sanitize khi người dùng tự gõ slug:
     * - Chỉ cho phép a-z, 0-9, dấu gạch ngang
     */
    public static function sanitizeSlug(string $value): string
    {
        $base = strtolower($value);
        $base = preg_replace('/[^a-z0-9-]/', '-', $base);
        $base = preg_replace('/-+/', '-', $base);
        $base = trim($base, '-');

        return $base;
    }
}
