<?php

namespace App\Services\Cms;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsBlock;

class CmsBuilderService
{
    public function renderPage(string $slug): array
    {
        $page = CmsPage::with(['sections.blocks'])->where('slug', $slug)->firstOrFail();
        return [
            'page' => $page,
            'layout_html' => $this->compileLayout($page),
        ];
    }

    private function compileLayout(CmsPage $page): string
    {
        $html = "";
        foreach ($page->sections as $section) {
            $html .= "<section class='page-section' data-id='{$section->id}' style='margin-bottom:20px;'>";
            foreach ($section->blocks as $block) {
                $html .= $this->compileBlock($block);
            }
            $html .= "</section>";
        }
        return $html;
    }

    private function compileBlock(CmsBlock $block): string
    {
        $content = $block->content_json ?? [];
        switch ($block->block_type) {
            case 'hero_banner':
                $title = $content['title'] ?? 'Welcome';
                $btn = $content['button_text'] ?? 'Learn More';
                return "<div class='hero-block' style='padding:60px; background:#0b2454; color:#fff;'><h1>{$title}</h1><button class='btn btn-primary'>{$btn}</button></div>";
            case 'testimonials':
                return "<div class='testimonials-block'><h3>What Patients Say</h3><p>Excellent clinical support.</p></div>";
            default:
                return "<div class='custom-block'><p>Custom content block</p></div>";
        }
    }
}
