<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $ceoContent = <<<'HTML'
<p>Hành trình của THT Media bắt đầu từ một niềm tin mãnh liệt: Rằng mỗi doanh nghiệp đều mang trong mình một câu chuyện phi thường cần được kể lại. Trong kỷ nguyên số, không thiếu những công cụ truyền thông, nhưng lại quá thiếu những thước phim, những khung hình thật sự chạm đến trái tim khán giả.</p>
<p>Chúng tôi không chỉ cung cấp dịch vụ quay phim hay chụp ảnh; chúng tôi nhận trách nhiệm "đánh thức" linh hồn của thương hiệu bạn. Đối với THT, mỗi dự án dù lớn hay nhỏ đều là một tác phẩm nghệ thuật đòi hỏi sự tận tâm tuyệt đối từ khâu kịch bản cho đến cú máy cuối cùng.</p>
<p>Sự thành công và phát triển vượt bậc của chục trăm đối tác gắn bó cùng THT thời gian qua chính là minh chứng rõ ràng nhất cho lời giải của bài toán "Hiệu quả truyền thông đi đôi với Sáng tạo nghệ thuật".</p>
<p><strong>Cảm ơn bạn đã tin tưởng chọn THT Media làm người bạn đồng hành kiến tạo những giá trị đích thực!</strong></p>
HTML;

        $teamContent = <<<'HTML'
<p>Đằng sau sự thành công của mỗi chiến dịch là sức lao động bền bỉ, trí tuệ mài giũa và sự phối hợp nhịp nhàng của các phòng ban chuyên môn.</p>
<p>Chúng tôi tập hợp những chuyên gia trẻ tuổi, nhiệt huyết, dám nghĩ dám làm và không bao giờ hài lòng với những gì đang có.</p>
HTML;

        $this->migrator->add('page.about_ceo_image', '');
        $this->migrator->add('page.about_ceo_name', 'Nguyễn Văn A');
        $this->migrator->add('page.about_ceo_role', 'Founder & CEO');
        $this->migrator->add('page.about_ceo_heading', 'Thư ngỏ từ người sáng lập');
        $this->migrator->add('page.about_ceo_greeting', 'Kính gửi Quý Khách hàng và Đối tác,');
        $this->migrator->add('page.about_ceo_content', $ceoContent);
        $this->migrator->add('page.about_ceo_signature', 'A. Nguyen');

        $this->migrator->add('page.about_values_kicker', 'Nền tảng phát triển');
        $this->migrator->add('page.about_values_title', 'Giá trị cốt lõi');
        $this->migrator->add('page.about_core_values', [
            [
                'icon' => 'fa-solid fa-lightbulb',
                'title' => 'Sáng tạo đột phá',
                'description' => 'Không ngừng cập nhật xu hướng, phá bỏ giới hạn tư duy cũ để tạo ra những sản phẩm độc bản mang đậm dấu ấn thương hiệu.',
            ],
            [
                'icon' => 'fa-solid fa-handshake',
                'title' => 'Tận tâm đồng hành',
                'description' => 'Coi dự án của khách hàng như chính đứa con tinh thần của mình. Sát cánh từ khâu lên ý tưởng đến khi đo lường hiệu quả thực tế.',
            ],
            [
                'icon' => 'fa-solid fa-gem',
                'title' => 'Chất lượng hàng đầu',
                'description' => 'Tiêu chuẩn khắt khe trong mọi quy trình làm việc. Chỉ bàn giao những sản phẩm đạt chất lượng cao nhất theo đúng cam kết.',
            ],
        ]);

        $this->migrator->add('page.about_team_kicker', 'Con người THT');
        $this->migrator->add('page.about_team_title', 'Sức mạnh từ<br><span class="about-brand-text">tập thể vững mạnh</span>');
        $this->migrator->add('page.about_team_content', $teamContent);
        $this->migrator->add('page.about_team_stats', [
            ['value' => '50+', 'label' => 'Nhân sự'],
            ['value' => '98%', 'label' => 'Hài lòng'],
        ]);

        $this->migrator->add('page.about_cta_title', 'Bạn có dự án đột phá cần thực hiện?');
        $this->migrator->add('page.about_cta_description', 'Hãy để chúng tôi lắng nghe và biến những ý tưởng của bạn thành hiện thực với chi phí tối ưu nhất.');
        $this->migrator->add('page.about_cta_button_label', 'Liên hệ ngay hôm nay');
    }
};
