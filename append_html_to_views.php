<?php

$paths = [
    __DIR__ . '/resources/views/services/*.blade.php',
    __DIR__ . '/resources/views/posts/*.blade.php',
    __DIR__ . '/resources/views/pages/*.blade.php',
    __DIR__ . '/resources/views/home.blade.php',
];

foreach ($paths as $pathGlob) {
    foreach (glob($pathGlob) as $file) {
        $content = file_get_contents($file);
        
        // Match url($service->slug) -> url($service->slug . '.html')
        $content = preg_replace('/url\(\\$([a-zA-Z0-9_\-]+)->slug\)/', "url(\$$1->slug . '.html')", $content);

        // Match url($service->slug ?? '#') -> url(isset($service->slug) ? $service->slug . '.html' : '#')
        $content = preg_replace('/url\(\\$([a-zA-Z0-9_\-]+)->slug \?\? \'#\'\)/', "url(isset(\$$1->slug) ? \$$1->slug . '.html' : '#')", $content);
        
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}

echo "All view files updated with .html suffix!\n";
