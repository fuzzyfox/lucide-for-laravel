<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\IconSource;

function fixtureSource(): IconSource
{
    return new IconSource(__DIR__.'/fixtures/source');
}

it('lists the glyph names from the source icons, ordered', function () {
    expect(fixtureSource()->glyphs())
        ->toBe(['alarm-clock-plus', 'camera', 'dice-6']);
});

it('returns a glyph raw SVG untouched, ready for the normaliser', function () {
    expect(fixtureSource()->rawSvg('camera'))
        ->toBe(file_get_contents(__DIR__.'/fixtures/source/icons/camera.svg'));
});

it('returns the source LICENSE verbatim', function () {
    expect(fixtureSource()->license())
        ->toBe(file_get_contents(__DIR__.'/fixtures/source/LICENSE'));
});
