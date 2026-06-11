<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\CaseName;
use FuzzyFox\Lucide\Generation\GuardRail;

it('passes silently on a clean glyph-to-case-name map', function () {
    GuardRail::assert([
        'camera'           => 'Camera',
        'alarm-clock-plus' => 'AlarmClockPlus',
        'dice-6'           => 'DiceSix',
    ]);

    expect(true)->toBeTrue();
});

it('throws on a glyph that breaks the charset', function () {
    expect(fn () => GuardRail::assert(['arrow_left' => 'ArrowLeft']))
        ->toThrow(InvalidArgumentException::class, 'arrow_left');
});

it('throws on a case name that is not a valid PHP identifier', function () {
    // A leading digit: legal glyph charset, illegal as an enum case name.
    expect(fn () => GuardRail::assert(['3-d' => '3D']))
        ->toThrow(InvalidArgumentException::class, '3D');
});

it('throws on an injected case-name collision', function () {
    // Two distinct, charset-legal glyphs colliding on one case name (non-injective).
    expect(fn () => GuardRail::assert([
        'foo' => 'Same',
        'bar' => 'Same',
    ]))->toThrow(InvalidArgumentException::class, 'Same');
});

it('accepts the real pinned dataset without throwing', function () {
    $iconsDir = dirname(__DIR__, 2).'/node_modules/lucide-static/icons';

    if (! is_dir($iconsDir)) {
        test()->markTestSkipped('lucide-static icons not installed.');
    }

    $glyphs = array_map(
        static fn (string $path): string => basename($path, '.svg'),
        glob($iconsDir.'/*.svg') ?: [],
    );

    expect($glyphs)->not->toBeEmpty();

    $map = [];
    foreach ($glyphs as $glyph) {
        $map[$glyph] = CaseName::fromGlyph($glyph);
    }

    GuardRail::assert($map);

    expect($map)->toHaveCount(count($glyphs));
});
