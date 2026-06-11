<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Generation;

/**
 * The sync orchestrator: regenerates the committed artifacts from an icon source
 * by wiring the pure generation modules end-to-end (ADR-0009). Reads the source,
 * normalises each glyph's SVG into the icon set, copies the LICENSE verbatim,
 * runs the guard-rails (the sync-time gate), then emits the Lucide enum.
 *
 * Framework-free and source-agnostic: it takes an {@see IconSource} and the two
 * target paths, so the maintainer CLI runs it against `node_modules/lucide-static`
 * while tests run it against a fixture source (ADR-0007).
 */
final class Sync
{
    public function __construct(
        private readonly IconSource $source,
        private readonly string $svgDir,
        private readonly string $enumPath,
    ) {}

    public function run(): void
    {
        $glyphs = $this->source->glyphs();

        $this->freshDir($this->svgDir);

        foreach ($glyphs as $glyph) {
            file_put_contents(
                $this->svgDir.'/'.$glyph.'.svg',
                SvgNormaliser::normalise($this->source->rawSvg($glyph)),
            );
        }

        file_put_contents($this->svgDir.'/LICENSE', $this->source->license());

        $caseNamesByGlyph = [];
        foreach ($glyphs as $glyph) {
            $caseNamesByGlyph[$glyph] = CaseName::fromGlyph($glyph);
        }

        GuardRail::assert($caseNamesByGlyph);

        file_put_contents($this->enumPath, EnumEmitter::emit($glyphs));
    }

    /** Recreate $dir empty, so each sync regenerates the icon set wholesale. */
    private function freshDir(string $dir): void
    {
        if (is_dir($dir)) {
            foreach (glob($dir.'/*') ?: [] as $path) {
                unlink($path);
            }
        } else {
            mkdir($dir, 0777, true);
        }
    }
}
