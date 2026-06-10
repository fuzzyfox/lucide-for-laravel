<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\CaseName;

it('maps a glyph to its case name', function (string $glyph, string $expected) {
    expect(CaseName::fromGlyph($glyph))->toBe($expected);
})->with([
    // The five ADR-0004 examples.
    'single trailing digit'              => ['dice-6', 'DiceSix'],
    'multi-digit whole number'           => ['clock-12', 'ClockTwelve'],
    'digit run interior to a segment'    => ['grid-2x2', 'GridTwoxTwo'],
    'separate digit segments'            => ['arrow-down-0-1', 'ArrowDownZeroOne'],
    'leading zeros collapse'             => ['arrow-down-01', 'ArrowDownOne'],

    // Representative glyphs.
    'plain letter segments'              => ['alarm-clock-plus', 'AlarmClockPlus'],
    'digit between letter segments'      => ['axis-3-d', 'AxisThreeD'],
    'zero'                               => ['arrow-down-1-0', 'ArrowDownOneZero'],

    // Adversarial: compound numbers beyond the real dataset's 0-12 range.
    'compound tens-and-ones'             => ['x-21', 'XTwentyOne'],
    'round ten'                          => ['x-30', 'XThirty'],
    'teen'                               => ['x-17', 'XSeventeen'],
]);

it('keeps dashed and non-dashed digit pairs distinct (injectivity)', function () {
    // The pair the whole-number rule exists to preserve (ADR-0004).
    expect(CaseName::fromGlyph('arrow-down-0-1'))
        ->not->toBe(CaseName::fromGlyph('arrow-down-01'));
});

it('fails loudly on a number it cannot render', function () {
    expect(fn () => CaseName::fromGlyph('x-100'))
        ->toThrow(InvalidArgumentException::class);
});

it('maps every real glyph to a distinct, valid PHP identifier', function () {
    $iconsDir = dirname(__DIR__, 2).'/node_modules/lucide-static/icons';

    if (! is_dir($iconsDir)) {
        test()->markTestSkipped('lucide-static icons not installed.');
    }

    $glyphs = array_map(
        static fn (string $path): string => basename($path, '.svg'),
        glob($iconsDir.'/*.svg') ?: [],
    );

    expect($glyphs)->not->toBeEmpty();

    $caseNames = array_map(CaseName::fromGlyph(...), $glyphs);

    foreach ($caseNames as $name) {
        expect($name)->toMatch('/^[A-Za-z][A-Za-z0-9]*$/');
    }

    // Injectivity across the full dataset: no two glyphs collide (ADR-0004).
    expect(array_unique($caseNames))->toHaveCount(count($glyphs));
});
