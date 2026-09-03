<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoEndpointsTest extends TestCase
{
    public function test_robots_uses_app_url_and_allows_public_crawling(): void
    {
        config(['app.url' => 'https://truyenthongtht.example']);

        $this->withServerVariables([
            'HTTP_HOST' => 'request-host.example',
            'HTTPS' => 'off',
        ])->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertContent(implode(PHP_EOL, [
                'User-agent: *',
                'Allow: /',
                '',
                'Sitemap: https://truyenthongtht.example/sitemap.xml',
                '',
            ]));
    }

    public function test_frontend_master_always_allows_indexing(): void
    {
        $master = file_get_contents(resource_path('views/layouts/master.blade.php'));

        $this->assertIsString($master);
        $this->assertStringContainsString(
            '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">',
            $master,
        );
    }

    public function test_products_are_not_exposed_as_public_routes_or_sitemap_entries(): void
    {
        $this->get('/san-pham.html')->assertNotFound();
        $this->get('/san-pham')->assertNotFound();

        $routes = file_get_contents(base_path('routes/web.php'));
        $sitemap = file_get_contents(app_path('Http/Controllers/SitemapController.php'));

        $this->assertIsString($routes);
        $this->assertStringNotContainsString("name('products.index')", $routes);
        $this->assertIsString($sitemap);
        $this->assertStringNotContainsString('Product::', $sitemap);
        $this->assertStringNotContainsString('ProductCategory::', $sitemap);
        $this->assertStringNotContainsString("routeUrl('products.index')", $sitemap);
    }
}
