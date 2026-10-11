<?php

namespace App\Console\Commands;

use App\Support\PostContactBlockCleaner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StripPostContactBlock extends Command
{
    protected $signature = 'posts:strip-contact-block
        {--apply : Ghi vào DB (mặc định chỉ chạy thử)}
        {--id=* : Chỉ xử lý các ID bài viết này}';

    protected $description = 'Gỡ khối địa chỉ/hotline dán cứng ở cuối bài viết (khối liên hệ hiển thị từ Settings)';

    private const TABLE = 'posts';

    private const COLUMN = 'content';

    private const STALE = '/lý anh tông|kđt tây hồ|đường 36|võ cường|bình than|bính hạ|hotline\s*:/iu';

    public function handle(PostContactBlockCleaner $cleaner): int
    {
        $apply = (bool) $this->option('apply');
        $ids = array_filter((array) $this->option('id'));

        $query = DB::table(self::TABLE)->select('id', 'title', self::COLUMN.' as html')->orderBy('id');
        if ($ids) {
            $query->whereIn('id', $ids);
        }

        $changes = [];
        $untouched = 0;
        $residual = [];
        $lineCounts = [];

        $query->chunkById(100, function ($rows) use ($cleaner, &$changes, &$untouched, &$residual, &$lineCounts) {
            foreach ($rows as $row) {
                $html = (string) $row->html;
                $result = $cleaner->clean($html);

                if ($result['removed'] === []) {
                    $untouched++;
                    $this->collectResidual($residual, $row->id, $row->title, $html);

                    continue;
                }

                foreach ($result['removed'] as $line) {
                    $lineCounts[$line] = ($lineCounts[$line] ?? 0) + 1;
                }

                $changes[$row->id] = ['title' => $row->title, 'original' => $html, 'html' => $result['html'], 'removed' => $result['removed']];
                $this->collectResidual($residual, $row->id, $row->title, $result['html']);
            }
        });

        $this->info(sprintf('Bài sẽ được sửa: %d | Không đổi: %d', count($changes), $untouched));

        arsort($lineCounts);
        $this->line('Các dòng bị gỡ nhiều nhất:');
        foreach (array_slice($lineCounts, 0, 25, true) as $line => $count) {
            $this->line(sprintf('  %4d× %s', $count, mb_strimwidth($line, 0, 140, '…')));
        }

        $this->newLine();
        $this->warn(sprintf('Bài còn chuỗi địa chỉ cũ sau khi gỡ (cần xem tay): %d', count($residual)));
        foreach (array_slice($residual, 0, 40, true) as $id => $info) {
            $this->line("  #{$id} {$info}");
        }

        $reportPath = storage_path('app/backups/posts-contact-report-'.now()->format('Ymd-His').'.json');
        File::ensureDirectoryExists(dirname($reportPath));
        File::put($reportPath, json_encode(
            array_map(fn ($c) => ['title' => $c['title'], 'removed' => $c['removed']], $changes),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        ));
        $this->line("Báo cáo chi tiết: {$reportPath}");

        if (! $apply) {
            $this->comment('Chạy thử, chưa ghi gì. Thêm --apply để ghi (tự backup trước).');

            return self::SUCCESS;
        }

        $backupPath = storage_path('app/backups/posts-contact-backup-'.now()->format('Ymd-His').'.json');
        File::put($backupPath, json_encode(
            array_map(fn ($c) => $c['original'], $changes),
            JSON_UNESCAPED_UNICODE
        ));
        $this->line("Đã backup nội dung gốc: {$backupPath}");

        foreach ($changes as $id => $change) {
            DB::table(self::TABLE)->where('id', $id)->update([self::COLUMN => $change['html']]);
        }

        $this->info('Đã cập nhật '.count($changes).' bài.');

        return self::SUCCESS;
    }

    private function collectResidual(array &$residual, int|string $id, string $title, string $html): void
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (preg_match(self::STALE, $text, $m, PREG_OFFSET_CAPTURE)) {
            $residual[$id] = $title.' → …'.trim(preg_replace('/\s+/u', ' ', mb_substr($text, max(0, (int) mb_strlen(substr($text, 0, $m[0][1])) - 40), 110))).'…';
        }
    }
}
