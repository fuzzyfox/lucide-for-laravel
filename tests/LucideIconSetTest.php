<?php

declare(strict_types=1);

use BladeUI\Icons\Factory;

it('registers the lucide set on the core provider, independent of Filament', function (): void {
    // The core provider owns icon-set registration; the Filament overlay
    // contributes no icon set (ADR-0002), so the set must be present without
    // any Filament involvement.
    $sets = app(Factory::class)->all();

    expect($sets)->toHaveKey('lucide')
        ->and($sets['lucide']['prefix'])->toBe('lucide');
});

it('resolves and renders a lucide-prefixed icon', function (): void {
    $html = svg('lucide-camera')->toHtml();

    expect($html)->toContain('<svg');
});

it('applies consumer-supplied classes without duplicating the class attribute', function (): void {
    $html = svg('lucide-camera', 'w-6 h-6 text-primary-500')->toHtml();

    expect($html)
        ->toContain('class="w-6 h-6 text-primary-500"')
        ->and(substr_count($html, 'class='))->toBe(1);
});
