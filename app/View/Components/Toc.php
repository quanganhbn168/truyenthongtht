<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toc extends Component
{
    public array $headings;

    /**
     * @param string $content HTML content để parse headings từ đó
     * @param array  $tags    Các tag muốn include, mặc định h2 và h3
     */
    public function __construct(
        public string $content   = '',
        public array  $tags      = ['h2', 'h3'],
        public string $title     = 'Mục lục',
        public string $placement = 'desktop', // 'mobile' | 'desktop'
    ) {
        $this->headings = $this->parseHeadings($content, $tags);
    }

    private function parseHeadings(string $html, array $tags): array
    {
        if (blank($html)) return [];

        $pattern = '<(' . implode('|', $tags) . ')([^>]*)>(.*?)<\/\1>';
        preg_match_all('/' . $pattern . '/si', $html, $matches, PREG_SET_ORDER);

        $headings = [];
        foreach ($matches as $match) {
            $tag  = strtolower($match[1]);
            $text = trim(html_entity_decode(strip_tags($match[3]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

            // Tự sinh anchor id nếu không có
            $attrs = $match[2];
            if (preg_match('/id=["\']([^"\']+)["\']/', $attrs, $idMatch)) {
                $id = $idMatch[1];
            } else {
                $id = 'toc-' . \Illuminate\Support\Str::slug($text);
            }

            $headings[] = [
                'tag'   => $tag,
                'id'    => $id,
                'text'  => $text,
                'level' => (int) substr($tag, 1),  // h2 → 2, h3 → 3
            ];
        }

        return $headings;
    }

    public function render(): View|Closure|string
    {
        return view('components.toc');
    }
}
