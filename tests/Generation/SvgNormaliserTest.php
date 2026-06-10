<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\SvgNormaliser;

function svgFixture(string $name): string
{
    return file_get_contents(__DIR__."/fixtures/{$name}");
}

it('normalises a raw lucide-static SVG into the committed icon-set form', function () {
    expect(SvgNormaliser::normalise(svgFixture('camera.raw.svg')))
        ->toBe(svgFixture('camera.normalised.svg'));
});

it('strips the attributes that would break blade-icons or churn diffs', function () {
    $normalised = SvgNormaliser::normalise(svgFixture('camera.raw.svg'));

    // `class` is mandatory to drop: blade-icons prepends consumer attributes
    // without merging, so a retained class renders a duplicate (ADR-0008).
    // Space-prefixed so `stroke-width` (kept) doesn't masquerade as `width`.
    expect($normalised)
        ->not->toContain(' class=')
        ->not->toContain(' width=')
        ->not->toContain(' height=');
});

it('keeps the attributes that drive colour and sizing', function () {
    $normalised = SvgNormaliser::normalise(svgFixture('camera.raw.svg'));

    expect($normalised)
        ->toContain('xmlns="http://www.w3.org/2000/svg"')
        ->toContain('viewBox="0 0 24 24"')
        ->toContain('fill="none"')
        ->toContain('stroke="currentColor"')
        ->toContain('stroke-width="2"')
        ->toContain('stroke-linecap="round"')
        ->toContain('stroke-linejoin="round"');
});

it('drops the licence comment and the XML declaration', function () {
    $normalised = SvgNormaliser::normalise(svgFixture('camera.raw.svg'));

    expect($normalised)
        ->not->toContain('@license')
        ->not->toContain('<?xml');
});

it('is byte-stable across repeated runs on the same input', function () {
    $raw = svgFixture('camera.raw.svg');

    expect(SvgNormaliser::normalise($raw))
        ->toBe(SvgNormaliser::normalise($raw));
});
