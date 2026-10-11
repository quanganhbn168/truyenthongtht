<?php

namespace App\Support;

/**
 * Gỡ khối thông tin liên hệ (địa chỉ, hotline, website...) được dán cứng trong
 * nội dung bài viết, để trang bài viết hiển thị khối liên hệ lấy từ Settings.
 *
 * Nội dung được tách thành từng "dòng" theo thẻ khối, <br> và ký tự xuống dòng,
 * không dựng lại DOM nên markup còn lại giữ nguyên.
 *
 * Gỡ hai trường hợp:
 *  1. Cụm dòng liên hệ liên tiếp có từ 2 nhãn liên hệ trở lên (ở bất kỳ vị trí nào).
 *  2. Phần đuôi bài: đi ngược từ dòng cuối, gỡ các dòng liên hệ, bỏ qua khối link tham khảo.
 */
class PostContactBlockCleaner
{
    private const SPLIT = '~(</?(?:p|div|li|ul|ol|h[1-6]|table|thead|tbody|tr|td|th|blockquote|section|figure|figcaption)\b[^>]*>|<br\b[^>]*>|\r?\n)~iu';

    private const KEYS = '(?:cs\s?\d+|trụ sở(?:\s+chính)?|địa chỉ|dia chi|address|add|văn phòng|cơ sở(?:\s+\d+|\s+chính)?|chi nhánh|hotline(?:\s*\/\s*zalo)?|điện thoại|sđt|sdt|tel|phone|zalo|website|web|email|e-mail|mail|facebook|fanpage|fb)';

    /** Dòng địa chỉ trần, không có nhãn. */
    private const BARE_ADDRESS = '~^(số\s*)?\d+[a-z]?,?\s+(đường\s+)?(bình than|lý anh tông|bính hạ)\b~u';

    /** Dòng dẫn/tên công ty đi kèm khối liên hệ. */
    private const SOFT_LINE = '~^((thông tin\s+)?(hãy\s+)?liên hệ[^.!?]{0,100}[:：!]?|(công ty\s+)?(tnhh\s+)?(truyền thông\s+)?tht\s*media\b[^.!?:：]{0,90}[:：]?)$~u';

    /** Dòng giới thiệu khối link tham khảo, giữ lại và đi xuyên qua. */
    private const REFERENCE_HEADER = '~^[^\p{L}\p{N}]*((một số\s+)?(bài viết|tin|dịch vụ)\s+(liên quan|tham khảo)|tham khảo(\s+thêm)?|xem thêm|đọc thêm)\b[^.!?]{0,120}$~u';

    /** Số dòng nội dung ngắn (câu kết, lời kêu gọi) được bỏ qua trước khi gặp dòng liên hệ đầu tiên của phần đuôi. */
    private const TAIL_SKIP = 3;

    /**
     * @return array{html: string, removed: list<string>}
     */
    public function clean(string $html): array
    {
        if (trim($html) === '') {
            return ['html' => $html, 'removed' => []];
        }

        $tokens = preg_split(self::SPLIT, $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if ($tokens === false || count($tokens) < 3) {
            return ['html' => $html, 'removed' => []];
        }

        // Chỉ số chẵn là nội dung dòng, chỉ số lẻ là dấu ngắt.
        $lines = [];
        for ($i = 0, $n = count($tokens); $i < $n; $i += 2) {
            $text = $this->text($tokens[$i]);
            $lines[$i] = [
                'text' => $text,
                'media' => $this->hasMedia($tokens[$i]),
                'link' => $this->isLinkOnly($tokens[$i], $text),
                'kind' => $text === '' ? null : $this->classify($text),
                'weight' => $text === '' ? 0 : $this->labelCount($text),
            ];
        }

        $remove = [];

        // 1. Cụm liên tiếp có từ 2 nhãn liên hệ rõ ràng trở lên.
        $run = [];
        $flush = function () use (&$run, &$remove, $lines) {
            $weight = 0;
            foreach ($run as $i) {
                $weight += $lines[$i]['kind'] === 'hard' ? max(1, $lines[$i]['weight']) : 0;
            }
            if ($weight >= 2) {
                foreach ($run as $i) {
                    $remove[$i] = true;
                }
            }
            $run = [];
        };

        foreach ($lines as $i => $line) {
            if ($line['text'] === '') {
                if ($line['media']) {
                    $flush();
                }

                continue;
            }

            if ($line['kind'] === null || $this->isReference($line)) {
                $flush();

                continue;
            }

            $run[] = $i;
        }
        $flush();

        // 2. Phần đuôi bài, kể cả khi chỉ còn 1 dòng liên hệ.
        $tail = [];
        $hasHard = false;
        $skipped = 0;

        for ($i = array_key_last($lines); $i >= 0; $i -= 2) {
            $line = $lines[$i];

            if ($line['text'] === '') {
                if ($line['media']) {
                    break;
                }

                continue;
            }

            if ($this->isReference($line)) {
                continue;
            }

            if ($line['kind'] === null) {
                if (! $hasHard && $skipped < self::TAIL_SKIP && mb_strlen($line['text']) <= 300) {
                    $skipped++;

                    continue;
                }

                break;
            }

            $hasHard = $hasHard || $line['kind'] === 'hard';
            $tail[] = $i;
        }

        if ($hasHard) {
            foreach ($tail as $i) {
                $remove[$i] = true;
            }
        }

        if ($remove === []) {
            return ['html' => $html, 'removed' => []];
        }

        ksort($remove);
        $removed = [];

        foreach (array_keys($remove) as $i) {
            $removed[] = $lines[$i]['text'];
            $tokens[$i] = '';

            // Bỏ dấu xuống dòng ngay trước dòng bị gỡ để không để lại dòng trống.
            if ($i >= 1 && preg_match('~^(<br\b[^>]*>|\r?\n)$~i', $tokens[$i - 1])) {
                $tokens[$i - 1] = '';
            }
        }

        foreach (array_keys($remove) as $i) {
            $this->collapseEmptyWrappers($tokens, $i);
        }

        return ['html' => trim(implode('', $tokens)), 'removed' => $removed];
    }

    /** Bỏ cặp thẻ mở/đóng khối còn trống sau khi dòng bên trong bị gỡ, kể cả khi lồng nhau. */
    private function collapseEmptyWrappers(array &$tokens, int $i): void
    {
        $a = $i - 1;
        $b = $i + 1;

        while ($a >= 1 && $b < count($tokens)) {
            if (! preg_match('~^<(\w+)\b[^>]*>$~', $tokens[$a], $open)
                || ! preg_match('~^</(\w+)\s*>$~', $tokens[$b], $close)
                || strtolower($open[1]) !== strtolower($close[1])
                || strtolower($open[1]) === 'br') {
                return;
            }

            $tokens[$a] = '';
            $tokens[$b] = '';

            $beforeIsBlank = $a - 1 >= 0 && trim(strip_tags($tokens[$a - 1])) === '' && ! $this->hasMedia($tokens[$a - 1]);
            $afterIsBlank = $b + 1 < count($tokens) && trim(strip_tags($tokens[$b + 1])) === '' && ! $this->hasMedia($tokens[$b + 1]);

            if (! $beforeIsBlank || ! $afterIsBlank) {
                return;
            }

            $a -= 2;
            $b += 2;
        }
    }

    private function classify(string $text): ?string
    {
        if (mb_strlen($text) > 400) {
            return null;
        }

        $lower = mb_strtolower($text);
        $lower = trim(preg_replace('/^[^\p{L}\p{N}]+/u', '', $lower) ?? $lower);

        if (preg_match('~^'.self::KEYS.'\s*\d*\s*[:：]~u', $lower) || preg_match(self::BARE_ADDRESS, $lower)) {
            return 'hard';
        }

        if (mb_strlen($lower) <= 140 && ! str_contains($lower, '#') && preg_match(self::SOFT_LINE, $lower)) {
            return 'soft';
        }

        return null;
    }

    /** Số nhãn liên hệ xuất hiện trong dòng (dòng gộp "Địa chỉ ... Hotline ... Email ..."). */
    private function labelCount(string $text): int
    {
        return (int) preg_match_all('~(?:^|[\s\p{P}\p{S}])'.self::KEYS.'\s*[:：]~u', mb_strtolower($text));
    }

    /** Dòng chỉ chứa link hoặc dòng dẫn tới danh sách link tham khảo. */
    private function isReference(array $line): bool
    {
        if ($line['kind'] !== null) {
            return false;
        }

        return $line['link'] || preg_match(self::REFERENCE_HEADER, mb_strtolower($line['text']));
    }

    private function isLinkOnly(string $fragment, string $text): bool
    {
        if ($text === '' || ! preg_match_all('~<a\b[^>]*>(.*?)</a>~isu', $fragment, $matches)) {
            return false;
        }

        $linkText = $this->text(implode('', $matches[1]));
        $strip = fn (string $value) => preg_replace('/[^\p{L}\p{N}]+/u', '', $value);

        return $linkText !== '' && $strip($linkText) === $strip($text);
    }

    private function text(string $fragment): string
    {
        $text = html_entity_decode(strip_tags($fragment), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\u{00A0}", ' ', $text);

        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    /** Có ảnh/video/iframe thật (bỏ qua emoji của Facebook). */
    private function hasMedia(string $fragment): bool
    {
        $fragment = preg_replace('~<img\b[^>]*emoji\.php[^>]*>~i', '', $fragment) ?? $fragment;

        return (bool) preg_match('~<(img|iframe|video|picture|embed|object)\b~i', $fragment);
    }
}
