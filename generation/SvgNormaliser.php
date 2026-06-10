<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Generation;

use DOMDocument;

/**
 * Maps a raw `lucide-static` SVG to the normalised form committed to the icon
 * set (ADR-0008): strips `class`, `width`, `height`, the `<!-- @license … -->`
 * comment, and the XML declaration; keeps `xmlns`, `viewBox`, `fill`, and all
 * `stroke*` attributes. Pure and framework-free — no I/O.
 *
 * Serialisation goes through `DOMDocument`, whose output for a given DOM is
 * deterministic, so repeated syncs of an unchanged glyph produce byte-identical
 * SVGs and the rolling PR shows only real glyph changes (ADR-0009 diff hygiene).
 */
final class SvgNormaliser
{
    /** Attributes stripped from the `<svg>` element; everything else is kept. */
    private const STRIP = ['class', 'width', 'height'];

    public static function normalise(string $rawSvg): string
    {
        $document = new DOMDocument();
        $document->loadXML($rawSvg);

        $svg = $document->documentElement;

        foreach (self::STRIP as $attribute) {
            $svg->removeAttribute($attribute);
        }

        // Serialising the document element alone drops the leading licence
        // comment and the XML declaration without us touching them.
        return $document->saveXML($svg);
    }
}
