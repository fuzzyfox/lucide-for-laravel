<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Generation;

/**
 * Reads a Lucide icon source from a directory laid out like the `lucide-static`
 * npm package: `icons/*.svg` (one file per glyph, the filename stem its name)
 * and a sibling `LICENSE`. Returns the ordered glyph list and the raw, untouched
 * file contents — normalisation and naming happen downstream.
 *
 * The directory is the whole interface, so the sync points it at
 * `node_modules/lucide-static` while tests point it at a fixture tree (ADR-0003,
 * ADR-0009): the source is swapped simply by passing a different directory.
 */
final class IconSource
{
    public function __construct(private readonly string $packageDir) {}

    /** @return list<string> glyph names, ordered. */
    public function glyphs(): array
    {
        $paths = glob($this->packageDir.'/icons/*.svg') ?: [];

        return array_map(
            static fn (string $path): string => basename($path, '.svg'),
            $paths,
        );
    }

    /** The raw, unmodified `icons/{glyph}.svg` contents. */
    public function rawSvg(string $glyph): string
    {
        return file_get_contents($this->packageDir.'/icons/'.$glyph.'.svg');
    }

    /** The source `LICENSE`, copied verbatim into the icon set by the sync. */
    public function license(): string
    {
        return file_get_contents($this->packageDir.'/LICENSE');
    }
}
