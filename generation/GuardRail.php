<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Generation;

/**
 * Fails loudly on any glyph set / derived case names that would yield a broken
 * Lucide enum (ADR-0004). One shared implementation enforced at two gates —
 * sync-time and test-time (ADR-0009). Pure and framework-free — no I/O.
 */
final class GuardRail
{
    /** @param array<string, string> $caseNamesByGlyph glyph => derived case name */
    public static function assert(array $caseNamesByGlyph): void
    {
        foreach ($caseNamesByGlyph as $glyph => $caseName) {
            if (preg_match('/^[a-z0-9-]+$/', $glyph) !== 1) {
                throw new \InvalidArgumentException(
                    "Glyph '{$glyph}' breaks the charset ^[a-z0-9-]+\$.",
                );
            }

            if (preg_match('/^[A-Za-z][A-Za-z0-9]*$/', $caseName) !== 1) {
                throw new \InvalidArgumentException(
                    "Case name '{$caseName}' (from glyph '{$glyph}') is not a valid "
                    .'PHP identifier starting with a letter.',
                );
            }
        }

        $seen = [];
        foreach ($caseNamesByGlyph as $glyph => $caseName) {
            if (isset($seen[$caseName])) {
                throw new \InvalidArgumentException(
                    "Case name '{$caseName}' collides: glyphs '{$seen[$caseName]}' and "
                    ."'{$glyph}' both map to it (case names must be injective).",
                );
            }

            $seen[$caseName] = $glyph;
        }
    }
}
