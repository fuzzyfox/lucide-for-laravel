<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\CaseName;
use FuzzyFox\Lucide\Generation\GuardRail;
use FuzzyFox\Lucide\Lucide;

/*
 * Correspondence over the *committed* artifacts (issue #8): the icon set under
 * resources/svg/ and the generated FuzzyFox\Lucide\Lucide enum in src/Lucide.php.
 * These two files are produced by one sync run but live and ship independently,
 * so this is the gate that proves they can never drift — every enum case maps to
 * exactly one icon-set file and vice versa, with no orphan in either direction.
 */

/** Glyph name for each committed icon-set SVG (filename stem, LICENSE excluded). */
function iconSetGlyphs(): array
{
    $svgDir = dirname(__DIR__, 2).'/resources/svg';

    $glyphs = array_map(
        static fn (string $path): string => basename($path, '.svg'),
        glob($svgDir.'/*.svg') ?: [],
    );

    sort($glyphs, SORT_STRING);

    return $glyphs;
}

/** Glyph name backing each committed enum case (the `lucide-` prefix stripped). */
function enumGlyphs(): array
{
    $glyphs = array_map(
        static fn (Lucide $case): string => substr($case->value, strlen('lucide-')),
        Lucide::cases(),
    );

    sort($glyphs, SORT_STRING);

    return $glyphs;
}

it('has a committed icon set and enum to check', function () {
    // Guards against a vacuous pass if the artifacts were never synced.
    expect(iconSetGlyphs())->not->toBeEmpty()
        ->and(enumGlyphs())->not->toBeEmpty();
});

it('maps every enum case to exactly one icon-set file, and vice versa', function () {
    // Set equality covers both directions at once: no enum case without its SVG,
    // no SVG without its enum case. Filenames are unique by the filesystem and
    // enum values are unique by the guard-rail, so equal sets mean a bijection.
    expect(enumGlyphs())->toBe(iconSetGlyphs());
});

it('backs every enum case value with the lucide- prefixed glyph', function () {
    foreach (Lucide::cases() as $case) {
        expect($case->value)->toStartWith('lucide-');
    }
});

it('re-asserts the guard-rails over the committed enum', function () {
    // The same gate the sync runs, replayed over what actually shipped: each
    // case name must be the canonical transform of its glyph, and the whole map
    // must clear the charset / identifier / injectivity rules.
    $map = [];
    foreach (Lucide::cases() as $case) {
        $glyph = substr($case->value, strlen('lucide-'));

        expect($case->name)->toBe(CaseName::fromGlyph($glyph));

        $map[$glyph] = $case->name;
    }

    GuardRail::assert($map);

    expect($map)->toHaveCount(count(Lucide::cases()));
});
