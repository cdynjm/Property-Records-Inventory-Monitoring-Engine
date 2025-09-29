<?php

namespace App\Http\Middleware;

use Closure;

class MinifyHtmlMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();

            if ($request->is('settings/*') || $request->is('settings')) {
                return $response;
            }

            // Extract no-minify blocks first
            [$content, $placeholders] = $this->excludeNoMinifyBlocks($content);

            // Minify HTML + JS
            $minified = $this->minifyHtmlAndJs($content);

            // Restore skipped blocks
            $minified = $this->restoreNoMinifyBlocks($minified, $placeholders);

            $response->setContent($minified);
        }

        return $response;
    }

    protected function minifyHtmlAndJs($html)
    {
        $parts = preg_split(
            '/(<\/?(?:textarea|flux:textarea|pre)\b[^>]*>.*?<\/(?:textarea|flux:textarea|pre)>)/is',
            $html,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $result = '';

        foreach ($parts as $part) {
            if (preg_match('/^<(textarea|flux:textarea|pre)\b/i', $part)) {
                $result .= $part;
                continue;
            }

            // Minify inline JS
            $part = preg_replace_callback(
                '/<script\b[^>]*>(.*?)<\/script>/is',
                function ($matches) {
                    if (trim($matches[1])) {
                        return '<script>' . $this->minifyJs($matches[1]) . '</script>';
                    }
                    return $matches[0];
                },
                $part
            );

            $part = preg_replace('/<!--(?!\[if).*?-->/s', '', $part);
            $part = preg_replace('/>\s+</', '><', $part);
            $part = preg_replace('/\s+/', ' ', $part);

            $result .= $part;
        }

        return $result;
    }

    protected function minifyJs($js)
    {
        $js = preg_replace('/\/\*.*?\*\/|\/\/.*(?=[\n\r])/', '', $js);
        $js = preg_replace('/\s+/', ' ', $js);
        $js = preg_replace('/\s*([{};,:])\s*/', '$1', $js);
        $js = preg_replace('/;}/', '}', $js);
        return trim($js);
    }

    /**
     * Exclude no-minify blocks.
     */
    protected function excludeNoMinifyBlocks(string $html): array
    {
        preg_match_all('/<!-- no-minify:start -->(.*?)<!-- no-minify:end -->/is', $html, $matches);
        $placeholders = [];

        foreach ($matches[0] as $i => $block) {
            $key = "###NO_MINIFY_BLOCK_$i###";
            $html = str_replace($block, $key, $html);
            $placeholders[$key] = $block;
        }

        return [$html, $placeholders];
    }

    /**
     * Restore excluded blocks.
     */
    protected function restoreNoMinifyBlocks(string $html, array $placeholders): string
    {
        foreach ($placeholders as $key => $block) {
            $html = str_replace($key, $block, $html);
        }
        return $html;
    }
}
