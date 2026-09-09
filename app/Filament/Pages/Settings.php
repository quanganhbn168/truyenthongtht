<?php

namespace App\Filament\Pages;

use App\Filament\Forms\TrackingSchema;
use App\Support\Tracking\TrackingScripts;

use App\Settings\BusinessSettings;
use App\Settings\PageSettings;
use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog8Tooth;

    protected static ?string $navigationLabel = 'Cài đặt';

    protected static ?string $title = 'Cài đặt hệ thống';

    protected static string|UnitEnum|null $navigationGroup = 'Quản lý';

    protected static ?int $navigationSort = 90;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $biz  = app(BusinessSettings::class);
        $web  = app(WebsiteSettings::class);
        $page = app(PageSettings::class);

        $this->form->fill([
            ...app(TrackingScripts::class)->formData(),
            // --- Business ---
            'company_name'          => $biz->company_name,
            'company_short_name'    => $biz->company_short_name,
            'tax_code'              => $biz->tax_code,
            'legal_representative'  => $biz->legal_representative,
            'founded_year'          => $biz->founded_year,
            'business_license'      => $biz->business_license,
            'main_phone'            => $biz->main_phone,
            'main_phone_2'          => $biz->main_phone_2,
            'main_email'            => $biz->main_email,
            'main_address'          => $biz->main_address,
            'working_hours'         => $biz->working_hours,

            // --- Website ---
            'site_name'             => $web->site_name,
            'site_tagline'          => $web->site_tagline,
            'site_description'      => $web->site_description,
            'site_logo'             => $web->site_logo ? [$web->site_logo] : [],
            'site_logo_white'       => $web->site_logo_white ? [$web->site_logo_white] : [],
            'site_favicon'          => $web->site_favicon ? [$web->site_favicon] : [],
            'og_image'              => $web->og_image ? [$web->og_image] : [],
            'hero_video_url'        => $web->hero_video_url ?? '',

            // --- SEO ---
            'meta_title'            => $web->meta_title,
            'meta_description'      => $web->meta_description,
            'meta_keywords'         => $web->meta_keywords,

            // --- Social ---
            'facebook_url'          => $web->facebook_url,
            'youtube_url'           => $web->youtube_url,
            'tiktok_url'            => $web->tiktok_url,
            'zalo_number'           => $web->zalo_number,
            'linkedin_url'          => $web->linkedin_url,
            'instagram_url'         => $web->instagram_url,

            // --- Tracking ---
            'google_map_embed'      => $web->google_map_embed,

            // --- About & Stats ---
            'about_video_url'       => $web->about_video_url,
            'about_image'           => $web->about_image ? [$web->about_image] : [],
            'stats'                 => $web->stats ?? [],
            'partners_title'        => $web->partners_title,
            'partners'              => collect($web->partners ?? [])->map(fn (array $partner): array => [
                'logo' => ! empty($partner['logo']) ? [$partner['logo']] : [],
                'name' => $partner['name'] ?? '',
            ])->values()->all(),
            'stats_background'      => $web->stats_background ? [$web->stats_background] : [],
            'testimonials_background'=> $web->testimonials_background ? [$web->testimonials_background] : [],
            'cta_background'        => $web->cta_background ? [$web->cta_background] : [],

            // --- Page Settings ---
            'about_banner'          => $page->about_banner ? [$page->about_banner] : [],
            'about_title'           => $page->about_title,
            'about_description'     => $page->about_description,
            'about_ceo_image'       => $page->about_ceo_image ? [$page->about_ceo_image] : [],
            'about_ceo_name'        => $page->about_ceo_name,
            'about_ceo_role'        => $page->about_ceo_role,
            'about_ceo_heading'     => $page->about_ceo_heading,
            'about_ceo_greeting'    => $page->about_ceo_greeting,
            'about_ceo_content'     => $page->about_ceo_content,
            'about_ceo_signature'   => $page->about_ceo_signature,
            'about_values_kicker'   => $page->about_values_kicker,
            'about_values_title'    => $page->about_values_title,
            'about_core_values'     => $page->about_core_values ?? [],
            'about_team_kicker'     => $page->about_team_kicker,
            'about_team_title'      => $page->about_team_title,
            'about_team_content'    => $page->about_team_content,
            'about_team_stats'      => $page->about_team_stats ?? [],
            'about_cta_title'       => $page->about_cta_title,
            'about_cta_description' => $page->about_cta_description,
            'about_cta_button_label'=> $page->about_cta_button_label,
            'news_banner'           => $page->news_banner ? [$page->news_banner] : [],
            'news_title'            => $page->news_title,
            'news_description'      => $page->news_description,
            'services_banner'       => $page->services_banner ? [$page->services_banner] : [],
            'services_title'        => $page->services_title,
            'services_description'  => $page->services_description,
            'products_banner'       => $page->products_banner ? [$page->products_banner] : [],
            'products_title'        => $page->products_title,
            'products_description'  => $page->products_description,
            'projects_banner'       => $page->projects_banner ? [$page->projects_banner] : [],
            'projects_title'        => $page->projects_title,
            'projects_description'  => $page->projects_description,
            'quote_title'           => $page->quote_title,
            'quote_description'     => $page->quote_description,
            'quote_content'         => $page->quote_content,
            'quote_meta_title'      => $page->quote_meta_title,
            'quote_meta_description'=> $page->quote_meta_description,
            'quote_keywords'        => $page->quote_keywords,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
            Tabs::make('settings_tabs')
                ->tabs([

                    // ─── Tab 1: Doanh nghiệp ─────────────────────────────
                    Tab::make('Doanh nghiệp')
                        ->icon('heroicon-o-building-office-2')
                        ->schema([
                            Section::make('Tên công ty')
                                ->icon('heroicon-o-identification')
                                ->description('Thông tin pháp lý và thương hiệu')
                                ->schema([
                                    TextInput::make('company_name')
                                        ->label('Tên công ty đầy đủ')
                                        ->placeholder('VD: Công ty TNHH Truyền Thông THT')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    TextInput::make('company_short_name')
                                        ->label('Tên ngắn / Thương hiệu')
                                        ->placeholder('VD: THT Media')
                                        ->maxLength(100),
                                    TextInput::make('founded_year')
                                        ->label('Năm thành lập')
                                        ->placeholder('VD: 2015')
                                        ->maxLength(4),
                                    TextInput::make('tax_code')
                                        ->label('Mã số thuế')
                                        ->placeholder('VD: 0123456789')
                                        ->maxLength(20),
                                    TextInput::make('business_license')
                                        ->label('Số giấy phép ĐKKD')
                                        ->maxLength(100),
                                    TextInput::make('legal_representative')
                                        ->label('Người đại diện pháp luật')
                                        ->placeholder('VD: Nguyễn Văn A')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),

                            Section::make('Thông tin liên hệ')
                                ->icon('heroicon-o-phone')
                                ->description('Thông tin liên hệ hiển thị trên website')
                                ->schema([
                                    TextInput::make('main_phone')
                                        ->label('Hotline chính')
                                        ->tel()
                                        ->placeholder('VD: 0982 123 456')
                                        ->maxLength(20),
                                    TextInput::make('main_phone_2')
                                        ->label('Số điện thoại phụ')
                                        ->tel()
                                        ->placeholder('VD: 0909 456 789')
                                        ->maxLength(20),
                                    TextInput::make('main_email')
                                        ->label('Email liên hệ chính')
                                        ->email()
                                        ->placeholder('VD: info@thtmedia.vn')
                                        ->maxLength(255),
                                    TextInput::make('working_hours')
                                        ->label('Giờ làm việc')
                                        ->placeholder('VD: T2 - T7: 8:00 - 17:30')
                                        ->maxLength(100),
                                    Textarea::make('main_address')
                                        ->label('Địa chỉ trụ sở chính')
                                        ->placeholder('VD: 123 Đường ABC, Quận 1, TP. HCM')
                                        ->rows(2)
                                        ->maxLength(500)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),
                        ]),

                    // ─── Tab 2: Website ──────────────────────────────────
                    Tab::make('Website')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            Section::make('Danh tính website')
                                ->icon('heroicon-o-computer-desktop')
                                ->schema([
                                    TextInput::make('site_name')
                                        ->label('Tên website')
                                        ->placeholder('VD: THT Media')
                                        ->maxLength(100)
                                        ->columnSpanFull(),
                                    TextInput::make('site_tagline')
                                        ->label('Slogan / Tagline')
                                        ->placeholder('VD: Giải pháp truyền thông chuyên nghiệp')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    TextInput::make('hero_video_url')
                                        ->label('Background Video URL (Trang chủ)')
                                        ->placeholder('VD: /upload/videos/hero.mp4 hoặc YouTube link')
                                        ->maxLength(500)
                                        ->helperText('Đường dẫn video làm nền cho hero banner trên trang chủ')
                                        ->columnSpanFull(),
                                    Textarea::make('site_description')
                                        ->label('Mô tả ngắn website')
                                        ->rows(3)
                                        ->maxLength(1000)
                                        ->columnSpanFull(),
                                ])
                                ->columns(1),

                            Section::make('Logo & Hình ảnh thương hiệu')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    FileUpload::make('site_logo')
                                        ->label('Logo chính')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('80')
                                        ->helperText('Logo nền sáng (header)'),
                                    FileUpload::make('site_logo_white')
                                        ->label('Logo nền tối')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('80')
                                        ->helperText('Logo footer / nền tối'),
                                    FileUpload::make('site_favicon')
                                        ->label('Favicon')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('60')
                                        ->helperText('Favicon website (32x32)'),
                                    FileUpload::make('og_image')
                                        ->label('Ảnh OG (Social Share)')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('80')
                                        ->helperText('Nhập đường dẫn logo share Facebook/Zalo'),
                                ])
                                ->columns(2),
                        ]),

                    // ─── Tab 3: SEO mặc định ─────────────────────────────
                    Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Section::make('Thẻ meta mặc định')
                                ->icon('heroicon-o-tag')
                                ->description('Được sử dụng khi trang không có meta riêng')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('Meta Title mặc định')
                                        ->maxLength(255)
                                        ->helperText('Tiêu đề xuất hiện trên tab trình duyệt và kết quả Google')
                                        ->columnSpanFull(),
                                    Textarea::make('meta_description')
                                        ->label('Meta Description mặc định')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->helperText('Mô tả xuất hiện trong kết quả tìm kiếm (~155 ký tự)')
                                        ->columnSpanFull(),
                                    TextInput::make('meta_keywords')
                                        ->label('Keywords mặc định')
                                        ->maxLength(500)
                                        ->helperText('Phân cách bằng dấu phẩy')
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // ─── Tab 4: Mạng xã hội ──────────────────────────────
                    Tab::make('Mạng xã hội')
                        ->icon('heroicon-o-share')
                        ->schema([
                            Section::make('Liên kết mạng xã hội')
                                ->icon('heroicon-o-link')
                                ->schema([
                                    TextInput::make('facebook_url')
                                        ->label('Facebook')
                                        ->url()
                                        ->placeholder('https://facebook.com/...')
                                        ->maxLength(500),
                                    TextInput::make('youtube_url')
                                        ->label('YouTube')
                                        ->url()
                                        ->placeholder('https://youtube.com/@...')
                                        ->maxLength(500),
                                    TextInput::make('tiktok_url')
                                        ->label('TikTok')
                                        ->url()
                                        ->placeholder('https://tiktok.com/@...')
                                        ->maxLength(500),
                                    TextInput::make('instagram_url')
                                        ->label('Instagram')
                                        ->url()
                                        ->placeholder('https://instagram.com/...')
                                        ->maxLength(500),
                                    TextInput::make('linkedin_url')
                                        ->label('LinkedIn')
                                        ->url()
                                        ->placeholder('https://linkedin.com/company/...')
                                        ->maxLength(500),
                                    TextInput::make('zalo_number')
                                        ->label('Zalo (số điện thoại)')
                                        ->tel()
                                        ->placeholder('VD: 0982123456')
                                        ->maxLength(20)
                                        ->helperText('Nhập số điện thoại Zalo Official Account'),
                                ])
                                ->columns(2),
                        ]),

                    // ─── Tab 5: Tracking & Script ─────────────────────────
                    Tab::make('Tracking')
                        ->icon('heroicon-o-chart-bar-square')
                        ->schema([
                            ...TrackingSchema::make(),

                            Section::make('Google Maps')
                                ->icon('heroicon-o-map-pin')
                                ->schema([
                                    Textarea::make('google_map_embed')
                                        ->label('Google Maps Embed URL / Iframe src')
                                        ->rows(3)
                                        ->maxLength(2000)
                                        ->helperText('Lấy từ Google Maps → Chia sẻ → Nhúng bản đồ → copy phần src="..."')
                                        ->columnSpanFull(),
                                ]),

                        ]),

                    // ─── Tab 6: Giới thiệu ──────────────────────────────────────────────
                    Tab::make('Giới thiệu')
                        ->icon('heroicon-o-play-circle')
                        ->schema([
                            Section::make('Ảnh & Video giới thiệu')
                                ->icon('heroicon-o-film')
                                ->description('Hiển thị trong section Giới thiệu công ty trang chủ')
                                ->schema([
                                    FileUpload::make('about_image')
                                        ->label('Ảnh công ty')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('200')
                                        ->helperText('Tỷ lệ khuyến nghị: 4:3 (800x600px)')
                                        ->columnSpanFull(),
                                    TextInput::make('about_video_url')
                                        ->label('URL Video giới thiệu')
                                        ->url()
                                        ->placeholder('https://youtube.com/watch?v=... hoặc /storage/video.mp4')
                                        ->helperText('Hỗ trợ YouTube, Vimeo, file video trực tiếp. Để trống nếu không có.')
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Con số ấn tượng')
                                ->icon('heroicon-o-chart-bar')
                                ->description('Thêm/xóa/kéo để sắp xếp tự do')
                                ->schema([
                                    Repeater::make('stats')
                                        ->label('')
                                        ->schema([
                                            TextInput::make('value')
                                                ->label('Con số')
                                                ->placeholder('500+')
                                                ->required()
                                                ->maxLength(20),
                                            TextInput::make('label')
                                                ->label('Mô tả')
                                                ->placeholder('Dự án thực hiện')
                                                ->required()
                                                ->maxLength(100),
                                            TextInput::make('icon')
                                                ->label('Icon (Font Awesome)')
                                                ->placeholder('fa-solid fa-briefcase')
                                                ->maxLength(100),
                                        ])
                                        ->columns(3)
                                        ->reorderable()
                                        ->addActionLabel('+ Thêm con số')
                                        ->columnSpanFull(),
                                    FileUpload::make('stats_background')
                                        ->label('Ảnh nền khu vực Con số ấn tượng (Parallax)')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('200')
                                        ->helperText('Ảnh sẽ được hiển thị với hiệu ứng Parallax (chuẩn 1920x1080)')
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Đối tác khách hàng')
                                ->icon('heroicon-o-building-office-2')
                                ->description('Logo chạy ngang ở khu vực “Hơn 500+ doanh nghiệp đã đồng hành cùng THT Media” trên trang chủ')
                                ->schema([
                                    TextInput::make('partners_title')
                                        ->label('Tiêu đề khu vực')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    Repeater::make('partners')
                                        ->label('Danh sách logo đối tác')
                                        ->schema([
                                            FileUpload::make('logo')
                                                ->label('Logo')
                                                ->image()
                                                ->disk('public_uploads')
                                                ->directory('upload/partners')
                                                ->imagePreviewHeight('90')
                                                ->required()
                                                ->columnSpanFull(),
                                            TextInput::make('name')
                                                ->label('Tên đối tác (alt ảnh)')
                                                ->maxLength(255),
                                        ])
                                        ->columns(2)
                                        ->reorderable()
                                        ->collapsible()
                                        ->addActionLabel('+ Thêm logo đối tác')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),
                                
                            Section::make('Ảnh nền các khu vực khác')
                                ->icon('heroicon-o-photo')
                                ->description('Cài đặt ảnh nền cho các khối Giao diện trang chủ')
                                ->schema([
                                    FileUpload::make('testimonials_background')
                                        ->label('Ảnh nền khu vực Đánh giá khách hàng')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('200')
                                        ->helperText('Hiển thị lớp phủ mờ phía sau các nhận xét (chuẩn 1920x1080)')
                                        ->columnSpanFull(),
                                    FileUpload::make('cta_background')
                                        ->label('Ảnh nền khu vực Liên hệ Call-to-Action')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('200')
                                        ->helperText('Hiển thị lớp phủ mờ phía sau khối liên hệ cuối trang (chuẩn 1920x1080)')
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // ─── Tab 7: Trang tổng hợp ──────────────────────────────────────────
                    Tab::make('Trang tổng hợp')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Section::make('Trang Giới thiệu (/gioi-thieu.html)')
                                ->icon('heroicon-o-building-office')
                                ->description('Sứ mệnh và Tầm nhìn chỉnh tại Giao diện > Giới thiệu / USP')
                                ->schema([
                                    TextInput::make('about_title')->label('Tiêu đề trang')->maxLength(255),
                                    TextInput::make('about_description')->label('Mô tả ngắn')->maxLength(500),
                                    FileUpload::make('about_banner')->label('Banner hero')->image()->disk('public_uploads')->directory('banners')->columnSpanFull(),
                                ])->columns(2),

                            Section::make('Thư ngỏ từ người sáng lập')
                                ->icon('heroicon-o-user-circle')
                                ->description('Nội dung khối đầu tiên của trang Giới thiệu')
                                ->schema([
                                    FileUpload::make('about_ceo_image')
                                        ->label('Ảnh người sáng lập')
                                        ->image()
                                        ->disk('public_uploads')
                                        ->directory('upload/settings')
                                        ->imagePreviewHeight('220')
                                        ->columnSpanFull(),
                                    TextInput::make('about_ceo_name')
                                        ->label('Tên người sáng lập')
                                        ->maxLength(255),
                                    TextInput::make('about_ceo_role')
                                        ->label('Chức danh')
                                        ->maxLength(255),
                                    TextInput::make('about_ceo_heading')
                                        ->label('Tiêu đề thư ngỏ')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    TextInput::make('about_ceo_greeting')
                                        ->label('Lời chào')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    RichEditor::make('about_ceo_content')
                                        ->label('Nội dung thư ngỏ')
                                        ->columnSpanFull(),
                                    TextInput::make('about_ceo_signature')
                                        ->label('Chữ ký hiển thị')
                                        ->maxLength(255),
                                ])
                                ->columns(2),

                            Section::make('Giá trị cốt lõi')
                                ->icon('heroicon-o-sparkles')
                                ->description('Các thẻ giá trị hiển thị ở giữa trang')
                                ->schema([
                                    TextInput::make('about_values_kicker')
                                        ->label('Nhãn nhỏ')
                                        ->maxLength(255),
                                    TextInput::make('about_values_title')
                                        ->label('Tiêu đề khu vực')
                                        ->maxLength(255),
                                    Repeater::make('about_core_values')
                                        ->label('Các giá trị')
                                        ->schema([
                                            TextInput::make('icon')
                                                ->label('Icon Font Awesome')
                                                ->placeholder('fa-solid fa-lightbulb')
                                                ->maxLength(100),
                                            TextInput::make('title')
                                                ->label('Tiêu đề')
                                                ->required()
                                                ->maxLength(255),
                                            Textarea::make('description')
                                                ->label('Mô tả')
                                                ->rows(3)
                                                ->required()
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2)
                                        ->reorderable()
                                        ->collapsible()
                                        ->addActionLabel('+ Thêm giá trị')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),

                            Section::make('Đội ngũ')
                                ->icon('heroicon-o-users')
                                ->description('Nội dung và các con số ở khối Đội ngũ')
                                ->schema([
                                    TextInput::make('about_team_kicker')
                                        ->label('Nhãn nhỏ')
                                        ->maxLength(255),
                                    TextInput::make('about_team_title')
                                        ->label('Tiêu đề')
                                        ->helperText('Có thể dùng thẻ <br> và <span> để giữ bố cục nhấn mạnh.')
                                        ->maxLength(500),
                                    RichEditor::make('about_team_content')
                                        ->label('Nội dung')
                                        ->columnSpanFull(),
                                    Repeater::make('about_team_stats')
                                        ->label('Các con số')
                                        ->schema([
                                            TextInput::make('value')
                                                ->label('Con số')
                                                ->required()
                                                ->maxLength(30),
                                            TextInput::make('label')
                                                ->label('Nhãn')
                                                ->required()
                                                ->maxLength(100),
                                        ])
                                        ->columns(2)
                                        ->reorderable()
                                        ->collapsible()
                                        ->addActionLabel('+ Thêm con số')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),

                            Section::make('Kêu gọi hành động cuối trang')
                                ->icon('heroicon-o-megaphone')
                                ->schema([
                                    TextInput::make('about_cta_title')
                                        ->label('Tiêu đề')
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    Textarea::make('about_cta_description')
                                        ->label('Mô tả')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->columnSpanFull(),
                                    TextInput::make('about_cta_button_label')
                                        ->label('Nhãn nút')
                                        ->maxLength(100),
                                ])
                                ->columns(2),

                            Section::make('Trang Tin tức (/tin-tuc)')
                                ->icon('heroicon-o-newspaper')
                                ->schema([
                                    TextInput::make('news_title')->label('Tiêu đề trang')->maxLength(255),
                                    TextInput::make('news_description')->label('Mô tả ngắn')->maxLength(500),
                                    FileUpload::make('news_banner')->label('Banner hero')->image()->disk('public_uploads')->directory('banners')->columnSpanFull(),
                                ])->columns(2),

                            Section::make('Trang Dịch vụ (/dich-vu)')
                                ->icon('heroicon-o-wrench-screwdriver')
                                ->schema([
                                    TextInput::make('services_title')->label('Tiêu đề trang')->maxLength(255),
                                    TextInput::make('services_description')->label('Mô tả ngắn')->maxLength(500),
                                    FileUpload::make('services_banner')->label('Banner hero')->image()->disk('public_uploads')->directory('banners')->columnSpanFull(),
                                ])->columns(2),

                            Section::make('Trang Dự án (/du-an)')
                                ->icon('heroicon-o-folder-open')
                                ->schema([
                                    TextInput::make('projects_title')->label('Tiêu đề trang')->maxLength(255),
                                    TextInput::make('projects_description')->label('Mô tả ngắn')->maxLength(500),
                                    FileUpload::make('projects_banner')->label('Banner hero')->image()->disk('public_uploads')->directory('banners')->columnSpanFull(),
                                ])->columns(2),

                            Section::make('Trang Báo giá (/bao-gia.html)')
                                ->icon('heroicon-o-document-currency-dollar')
                                ->schema([
                                    TextInput::make('quote_title')->label('Tiêu đề trang')->maxLength(255)->columnSpanFull(),
                                    Textarea::make('quote_description')->label('Mô tả mở đầu')->rows(3)->columnSpanFull(),
                                    RichEditor::make('quote_content')->label('Nội dung chi tiết')->columnSpanFull(),
                                    TextInput::make('quote_meta_title')->label('Meta title')->maxLength(255)->columnSpanFull(),
                                    Textarea::make('quote_meta_description')->label('Meta description')->rows(3)->columnSpanFull(),
                                    Textarea::make('quote_keywords')->label('Từ khóa SEO')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                        ]),

                ])
                ->persistTabInQueryString('tab')
                ->columnSpanFull(),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make($this->getFormActions())
                        ->alignment(Alignment::Start)
                        ->fullWidth(false),
                ]),
        ]);
    }

    /** @return array<Action> */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu tất cả cài đặt')
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->keyBindings(['command+s', 'ctrl+s'])
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        app(TrackingScripts::class)->save($data);

        // --- Business ---
        $biz = app(BusinessSettings::class);
        $biz->company_name         = $data['company_name'] ?? '';
        $biz->company_short_name   = $data['company_short_name'] ?? '';
        $biz->tax_code             = $data['tax_code'] ?? '';
        $biz->legal_representative = $data['legal_representative'] ?? '';
        $biz->founded_year         = $data['founded_year'] ?? '';
        $biz->business_license     = $data['business_license'] ?? '';
        $biz->main_phone           = $data['main_phone'] ?? '';
        $biz->main_phone_2         = $data['main_phone_2'] ?? '';
        $biz->main_email           = $data['main_email'] ?? '';
        $biz->main_address         = $data['main_address'] ?? '';
        $biz->working_hours        = $data['working_hours'] ?? '';
        $biz->save();

        // --- Website ---
        $web = app(WebsiteSettings::class);
        $web->site_name              = $data['site_name'] ?? '';
        $web->site_tagline           = $data['site_tagline'] ?? '';
        $web->site_description       = $data['site_description'] ?? '';
        $web->site_logo              = is_array($data['site_logo'] ?? null) ? (reset($data['site_logo']) ?: '') : ($data['site_logo'] ?? '');
        $web->site_logo_white        = is_array($data['site_logo_white'] ?? null) ? (reset($data['site_logo_white']) ?: '') : ($data['site_logo_white'] ?? '');
        $web->site_favicon           = is_array($data['site_favicon'] ?? null) ? (reset($data['site_favicon']) ?: '') : ($data['site_favicon'] ?? '');
        $web->og_image               = is_array($data['og_image'] ?? null) ? (reset($data['og_image']) ?: '') : ($data['og_image'] ?? '');
        $web->hero_video_url         = $data['hero_video_url'] ?? '';
        
        // Cần truyền ImageService
        $imgService = app(\App\Services\ImageService::class);
        if ($web->site_logo) $imgService->process('public_uploads', $web->site_logo);
        if ($web->site_logo_white) $imgService->process('public_uploads', $web->site_logo_white);
        if ($web->og_image) $imgService->process('public_uploads', $web->og_image);
        if ($web->site_favicon) $imgService->process('public_uploads', $web->site_favicon);

        $web->meta_title             = $data['meta_title'] ?? '';
        $web->meta_description       = $data['meta_description'] ?? '';
        $web->meta_keywords          = $data['meta_keywords'] ?? '';
        $web->facebook_url           = $data['facebook_url'] ?? '';
        $web->youtube_url            = $data['youtube_url'] ?? '';
        $web->tiktok_url             = $data['tiktok_url'] ?? '';
        $web->zalo_number            = $data['zalo_number'] ?? '';
        $web->linkedin_url           = $data['linkedin_url'] ?? '';
        $web->instagram_url          = $data['instagram_url'] ?? '';
        $web->google_map_embed       = $data['google_map_embed'] ?? '';
        $web->about_video_url        = $data['about_video_url'] ?? '';
        $web->about_image            = is_array($data['about_image'] ?? null) ? (reset($data['about_image']) ?: '') : ($data['about_image'] ?? '');
        $web->stats                  = $data['stats'] ?? [];
        $web->partners_title         = $data['partners_title'] ?? '';
        $web->partners               = array_values(array_filter(array_map(
            static function (array $partner): array {
                $logo = is_array($partner['logo'] ?? null)
                    ? (reset($partner['logo']) ?: '')
                    : ($partner['logo'] ?? '');

                return [
                    'logo' => $logo,
                    'name' => $partner['name'] ?? '',
                ];
            },
            $data['partners'] ?? [],
        ), static fn (array $partner): bool => $partner['logo'] !== ''));
        $web->stats_background       = is_array($data['stats_background'] ?? null) ? (reset($data['stats_background']) ?: '') : ($data['stats_background'] ?? '');
        $web->testimonials_background = is_array($data['testimonials_background'] ?? null) ? (reset($data['testimonials_background']) ?: '') : ($data['testimonials_background'] ?? '');
        $web->cta_background          = is_array($data['cta_background'] ?? null) ? (reset($data['cta_background']) ?: '') : ($data['cta_background'] ?? '');
        $web->save();
        app(FaviconService::class)->sync($web->site_favicon);

        // --- Page Settings ---
        $page = app(PageSettings::class);
        $page->about_banner         = is_array($data['about_banner'] ?? null) ? (reset($data['about_banner']) ?: '') : ($data['about_banner'] ?? '');
        $page->about_title          = $data['about_title'] ?? '';
        $page->about_description    = $data['about_description'] ?? '';
        $page->about_ceo_image      = is_array($data['about_ceo_image'] ?? null) ? (reset($data['about_ceo_image']) ?: '') : ($data['about_ceo_image'] ?? '');
        $page->about_ceo_name       = $data['about_ceo_name'] ?? '';
        $page->about_ceo_role       = $data['about_ceo_role'] ?? '';
        $page->about_ceo_heading    = $data['about_ceo_heading'] ?? '';
        $page->about_ceo_greeting   = $data['about_ceo_greeting'] ?? '';
        $page->about_ceo_content    = $data['about_ceo_content'] ?? '';
        $page->about_ceo_signature  = $data['about_ceo_signature'] ?? '';
        $page->about_values_kicker  = $data['about_values_kicker'] ?? '';
        $page->about_values_title   = $data['about_values_title'] ?? '';
        $page->about_core_values    = $data['about_core_values'] ?? [];
        $page->about_team_kicker    = $data['about_team_kicker'] ?? '';
        $page->about_team_title     = $data['about_team_title'] ?? '';
        $page->about_team_content   = $data['about_team_content'] ?? '';
        $page->about_team_stats     = $data['about_team_stats'] ?? [];
        $page->about_cta_title      = $data['about_cta_title'] ?? '';
        $page->about_cta_description = $data['about_cta_description'] ?? '';
        $page->about_cta_button_label = $data['about_cta_button_label'] ?? '';
        $page->news_banner          = is_array($data['news_banner'] ?? null) ? (reset($data['news_banner']) ?: '') : ($data['news_banner'] ?? '');
        $page->news_title           = $data['news_title'] ?? '';
        $page->news_description     = $data['news_description'] ?? '';
        $page->services_banner      = is_array($data['services_banner'] ?? null) ? (reset($data['services_banner']) ?: '') : ($data['services_banner'] ?? '');
        $page->services_title       = $data['services_title'] ?? '';
        $page->services_description = $data['services_description'] ?? '';
        $page->products_banner      = is_array($data['products_banner'] ?? null) ? (reset($data['products_banner']) ?: '') : ($data['products_banner'] ?? '');
        $page->products_title       = $data['products_title'] ?? '';
        $page->products_description = $data['products_description'] ?? '';
        $page->projects_banner      = is_array($data['projects_banner'] ?? null) ? (reset($data['projects_banner']) ?: '') : ($data['projects_banner'] ?? '');
        $page->projects_title       = $data['projects_title'] ?? '';
        $page->projects_description = $data['projects_description'] ?? '';
        $page->quote_title          = $data['quote_title'] ?? '';
        $page->quote_description    = $data['quote_description'] ?? '';
        $page->quote_content        = $data['quote_content'] ?? '';
        $page->quote_meta_title     = $data['quote_meta_title'] ?? '';
        $page->quote_meta_description = $data['quote_meta_description'] ?? '';
        $page->quote_keywords       = $data['quote_keywords'] ?? '';
        $page->save();

        // Xử lý nén ảnh cho các trang
        if ($page->about_banner) $imgService->process('public_uploads', $page->about_banner);
        if ($page->news_banner) $imgService->process('public_uploads', $page->news_banner);
        if ($page->services_banner) $imgService->process('public_uploads', $page->services_banner);
        if ($page->products_banner) $imgService->process('public_uploads', $page->products_banner);
        if ($page->projects_banner) $imgService->process('public_uploads', $page->projects_banner);
        if ($page->about_ceo_image) $imgService->process('public_uploads', $page->about_ceo_image);
        if ($web->about_image) $imgService->process('public_uploads', $web->about_image);
        foreach ($web->partners as $partner) {
            if (! empty($partner['logo']) && ! str_starts_with($partner['logo'], 'images/')) {
                $imgService->process('public_uploads', $partner['logo']);
            }
        }
        if ($web->stats_background) $imgService->process('public_uploads', $web->stats_background);
        if ($web->testimonials_background) $imgService->process('public_uploads', $web->testimonials_background);
        if ($web->cta_background) $imgService->process('public_uploads', $web->cta_background);

        Notification::make()
            ->title('Đã lưu cài đặt thành công!')
            ->success()
            ->send();
    }
}
