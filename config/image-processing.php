<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Processing — THT Media
    |--------------------------------------------------------------------------
    */

    // Chiều rộng tối đa (px). Ảnh lớn hơn sẽ được scale down giữ tỷ lệ.
    'max_width' => env('IMAGE_MAX_WIDTH', 1920),

    // Chất lượng nén JPEG/WebP (0-100). 85 là mức cân bằng tốt.
    'quality' => env('IMAGE_QUALITY', 85),

    'watermark' => [
        // Bật/tắt watermark
        'enabled' => env('IMAGE_WATERMARK_ENABLED', false),

        // Đường dẫn tuyệt đối đến file watermark PNG (nên dùng PNG có nền trong)
        'path' => env('IMAGE_WATERMARK_PATH', public_path('images/watermark.png')),

        // Vị trí: bottom-right | bottom-left | bottom-center | top-right | top-left | center
        'position' => env('IMAGE_WATERMARK_POSITION', 'bottom-right'),

        // Độ mờ watermark (0 = trong suốt, 100 = đục hoàn toàn)
        'opacity' => env('IMAGE_WATERMARK_OPACITY', 60),
    ],
];
