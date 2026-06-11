<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Tools;

/**
 * Renders a self-contained HTML page of the Filament alias-override map for
 * human verification: every Filament chrome icon slot, grouped by the Filament
 * package that defines it, shown next to the Lucide glyph it re-skins to (or
 * flagged where Filament's default is deliberately kept).
 *
 * Pure and framework-free — it templates pre-resolved rows (alias, Lucide case
 * name, and inlined SVG markup for both Filament's default Heroicon and the
 * Lucide override); the `bin/icon-map` CLI does the filesystem reads. A
 * dev/maintainer tool, never shipped or registered.
 */
final class IconMapPage
{
    private const STYLE = <<<'CSS'
        :root { color-scheme: light dark; }
        body { font-family: system-ui, sans-serif; margin: 2rem; line-height: 1.4; }
        h1 { font-size: 1.4rem; }
        h2 { margin-top: 2.5rem; border-bottom: 1px solid currentColor; padding-bottom: .25rem; }
        .legend { opacity: .7; font-size: .85rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(17rem, 1fr)); gap: .75rem; }
        .card { border: 1px solid #8884; border-radius: .5rem; padding: .75rem; display: flex; gap: .6rem; align-items: center; }
        .pair { display: flex; align-items: center; gap: .35rem; flex: none; }
        .glyph svg { width: 1.75rem; height: 1.75rem; display: block; }
        .arrow { opacity: .5; }
        .none { opacity: .35; font-size: 1.25rem; line-height: 1.75rem; }
        .meta { min-width: 0; }
        .alias { font-family: ui-monospace, monospace; font-size: .8rem; word-break: break-all; }
        .case { font-weight: 600; font-size: .85rem; }
        .default { font-style: italic; opacity: .7; font-size: .85rem; }
        CSS;

    /**
     * @param  list<array{label: string, rows: list<array{alias: string, case: string|null, svg: string|null, heroSvg: string|null}>}>  $groups
     */
    public static function render(array $groups): string
    {
        $sections = '';

        foreach ($groups as $group) {
            $cards = '';

            foreach ($group['rows'] as $row) {
                $alias = htmlspecialchars($row['alias'], ENT_QUOTES);

                // "Before": Filament's default Heroicon, where it has one.
                $before = $row['heroSvg'] ?? '<span class="none" title="no Heroicon default">—</span>';

                if ($row['case'] === null || $row['svg'] === null) {
                    // "After": slot kept as Filament's default (an explicit exception).
                    $after = '<span class="none">—</span>';
                    $label = '<span class="default">Filament default — not overridden</span>';
                } else {
                    $after = $row['svg'];
                    $label = '<span class="case">Lucide::'.htmlspecialchars($row['case'], ENT_QUOTES).'</span>';
                }

                $cards .= <<<HTML
                            <div class="card">
                                <div class="pair">
                                    <span class="glyph">{$before}</span>
                                    <span class="arrow">&rarr;</span>
                                    <span class="glyph">{$after}</span>
                                </div>
                                <div class="meta">
                                    {$label}
                                    <div class="alias">{$alias}</div>
                                </div>
                            </div>

                HTML;
            }

            $count = count($group['rows']);
            $heading = htmlspecialchars($group['label'], ENT_QUOTES);

            $sections .= <<<HTML
                    <h2>{$heading} <small>({$count})</small></h2>
                    <div class="grid">
                {$cards}    </div>

                HTML;
        }

        $style = self::STYLE;

        return <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Lucide for Laravel — Filament icon map</title>
                <style>{$style}</style>
            </head>
            <body>
                <h1>Filament icon-alias overrides</h1>
                <p class="legend">Each Filament chrome icon slot, grouped by the Filament package that defines it.
                Left to right: <strong>Filament's default Heroicon &rarr; the Lucide glyph it re-skins to</strong>.
                A &mdash; means no Heroicon default (or a slot kept as Filament's default).</p>
            {$sections}</body>
            </html>

            HTML;
    }
}
