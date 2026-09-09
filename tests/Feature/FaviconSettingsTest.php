<?php

namespace Tests\Feature;

use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Tests\TestCase;
use App\Filament\Pages\Settings;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;
class FaviconSettingsTest extends TestCase
{
    use DatabaseTransactions;

    private string $originalPublicPath;
    private string $testPublicPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalPublicPath = public_path();
        $this->testPublicPath = storage_path('framework/testing/favicon-'.Str::uuid());
        File::ensureDirectoryExists($this->testPublicPath.'/favicon-assets/.source');
        app()->usePublicPath($this->testPublicPath);
    }

    protected function tearDown(): void
    {
        app()->usePublicPath($this->originalPublicPath);
        $root = realpath(storage_path('framework/testing')).DIRECTORY_SEPARATOR;
        $target = realpath($this->testPublicPath);
        if ($target && str_starts_with($target, $root)) {
            File::deleteDirectory($target);
        }
        parent::tearDown();
    }

    public function test_all_destinations_are_checked_before_writing(): void
    {
        File::put(public_path('favicon-assets/favicon-16x16.png'), 'original');
        try {
            app(FaviconService::class)->assertWritable();
            $this->fail('Expected the invalid .source destination to stop synchronization.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('.source', $exception->getMessage());
            $this->assertSame('original', File::get(public_path('favicon-assets/favicon-16x16.png')));
        }
    }
    private function settingsPage()
    {
        $panel = Filament::getPanel('admin');
        Filament::setCurrentPanel($panel);
        $panel->boot();
        Storage::fake('public_uploads');
        return Livewire::actingAs(User::query()->firstOrFail(), $panel->getAuthGuard())->test(Settings::class);
    }

    public function test_unchanged_favicon_does_not_require_write_permission(): void
    {
        $settings = app(WebsiteSettings::class);
        $settings->site_favicon = 'missing-old-favicon.png';
        $settings->save();
        $this->settingsPage()->set('data.site_tagline', 'QA unchanged favicon')->call('save')->assertHasNoFormErrors();
        $this->assertSame('QA unchanged favicon', json_decode(DB::table('settings')->where('group', 'website')->where('name', 'site_tagline')->value('payload'), true));
    }

    public function test_permission_error_does_not_save_settings(): void
    {
        $component = $this->settingsPage();
        Storage::disk('public_uploads')->put('new-favicon.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='));
        $before = DB::table('settings')->orderBy('id')->get()->toJson();
        $component->set('data.site_favicon', ['new-favicon.png'])->set('data.site_tagline', 'Must not save')->call('save')->assertHasFormErrors(['site_favicon']);
        $this->assertSame($before, DB::table('settings')->orderBy('id')->get()->toJson());
    }

}
