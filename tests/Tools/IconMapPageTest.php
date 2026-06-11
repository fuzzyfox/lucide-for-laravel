<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Tools\IconMapPage;

it('renders a slot’s Filament default beside the Lucide glyph it maps to', function (): void {
    $html = IconMapPage::render([
        [
            'label' => 'Panels',
            'rows' => [
                [
                    'alias' => 'panels::global-search.field',
                    'case' => 'Search',
                    'svg' => '<svg id="lucide"></svg>',
                    'heroSvg' => '<svg id="heroicon"></svg>',
                ],
            ],
        ],
    ]);

    expect($html)
        ->toStartWith('<!DOCTYPE html>')
        ->toContain('Panels')
        ->toContain('panels::global-search.field')
        ->toContain('Lucide::Search')
        ->toContain('<svg id="heroicon"></svg>') // Filament default (before)
        ->toContain('<svg id="lucide"></svg>');  // Lucide override (after)
});

it('marks an excepted slot as keeping Filament’s default', function (): void {
    $html = IconMapPage::render([
        [
            'label' => 'Panels',
            'rows' => [
                [
                    'alias' => 'panels::widgets.filament-info.open-github-button',
                    'case' => null,
                    'svg' => null,
                    'heroSvg' => null,
                ],
            ],
        ],
    ]);

    expect($html)->toContain('Filament default');
});
