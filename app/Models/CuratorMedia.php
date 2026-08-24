<?php

namespace App\Models;

use Awcodes\Curator\Models\Media as BaseMedia;
use Awcodes\Curator\Observers\MediaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([MediaObserver::class])]
class CuratorMedia extends BaseMedia
{
    protected $fillable = [
        'disk',
        'directory',
        'visibility',
        'name',
        'path',
        'width',
        'height',
        'size',
        'type',
        'ext',
        'alt',
        'title',
        'description',
        'caption',
        'exif',
        'curations',
        'file',
        'processing_format',
        'watermark_enabled',
        'processing_quality',
        'original_path',
        'original_ext',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
        'curations' => 'array',
        'exif' => 'array',
        'watermark_enabled' => 'boolean',
        'processing_quality' => 'integer',
    ];
}
