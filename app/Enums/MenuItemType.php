<?php

namespace App\Enums;

enum MenuItemType: string
{
    case Custom          = 'custom';
    case Page            = 'page';
    case Post            = 'post';
    case PostCategory    = 'post_category';
    case Product         = 'product';
    case ProductCategory = 'product_category';
    case Service         = 'service';

    public function label(): string
    {
        return match($this) {
            self::Custom          => 'URL tùy chỉnh',
            self::Page            => 'Trang tĩnh',
            self::Post            => 'Bài viết',
            self::PostCategory    => 'Danh mục bài viết',
            self::Product         => 'Sản phẩm',
            self::ProductCategory => 'Danh mục sản phẩm',
            self::Service         => 'Dịch vụ',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Custom          => 'heroicon-o-link',
            self::Page            => 'heroicon-o-document',
            self::Post            => 'heroicon-o-document-text',
            self::PostCategory    => 'heroicon-o-folder',
            self::Product         => 'heroicon-o-shopping-bag',
            self::ProductCategory => 'heroicon-o-tag',
            self::Service         => 'heroicon-o-briefcase',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Custom          => 'gray',
            self::Page            => 'violet',
            self::Post            => 'blue',
            self::PostCategory    => 'indigo',
            self::Product         => 'amber',
            self::ProductCategory => 'orange',
            self::Service         => 'green',
        };
    }
}
