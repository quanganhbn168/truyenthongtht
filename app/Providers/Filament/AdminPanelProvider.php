<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Menus\MenuResource;
use App\Filament\Widgets\ContentStatsOverview;
use App\Filament\Widgets\LatestContacts;
use App\Filament\Widgets\LatestPosts;
use App\Filament\Widgets\LatestQuotes;
use App\Models\ManagedMenu;
use App\Models\ManagedMenuItem;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Service;
use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Datlechin\FilamentMenuBuilder\MenuPanel\ModelMenuPanel;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('THT Media')

            ->favicon(fn (): ?string => app(FaviconService::class)->primaryUrl(app(WebsiteSettings::class)->site_favicon))
            ->renderHook(PanelsRenderHook::HEAD_END, function (): string {
                return view('filament.partials.favicon', [
                    'faviconLinks' => app(FaviconService::class)->links(app(WebsiteSettings::class)->site_favicon),
                ])->render();
            })
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->navigationGroups([
                NavigationGroup::make('Nội dung'),
                NavigationGroup::make('Sản phẩm'),
                NavigationGroup::make('Dịch vụ'),
                NavigationGroup::make('Dự án'),
                NavigationGroup::make('Giao diện'),
                NavigationGroup::make('Quản lý'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                ContentStatsOverview::class,
                LatestPosts::class,
                LatestQuotes::class,
                LatestContacts::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->navigationGroup('Quản lý')
                    ->navigationSort(80),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Thư viện Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Giao diện')
                    ->navigationSort(10)
                    ->showBadge(false)
                    ->registerNavigation(true),
                FilamentMenuBuilderPlugin::make()
                    ->usingResource(MenuResource::class)
                    ->usingMenuModel(ManagedMenu::class)
                    ->usingMenuItemModel(ManagedMenuItem::class)
                    ->navigationLabel('Menu Builder')
                    ->navigationGroup('Giao diện')
                    ->navigationIcon('heroicon-o-bars-3')
                    ->navigationSort(21)
                    ->navigationCountBadge(true)
                    ->enableIndentActions(true)
                    ->addLocations([
                        'header' => 'Menu chính (Header)',
                        'footer' => 'Menu footer',
                        'mobile' => 'Mobile',
                        'sidebar' => 'Sidebar',
                    ])
                    ->addMenuPanels([
                        ModelMenuPanel::make()->model(PostCategory::class),
                        ModelMenuPanel::make()->model(Service::class),
                        ModelMenuPanel::make()->model(Post::class),
                    ]),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
