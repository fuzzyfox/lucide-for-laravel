<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Generation;

/**
 * Transforms a glyph's kebab-case name into its Lucide enum case name per
 * ADR-0004: PascalCase each `-`-segment, rendering each maximal digit run as a
 * whole-number English cardinal word. Pure and framework-free — no I/O.
 */
final class CaseName
{
    public static function fromGlyph(string $glyph): string
    {
        $segments = explode('-', $glyph);

        return implode('', array_map(self::segment(...), $segments));
    }

    private static function segment(string $segment): string
    {
        $rendered = preg_replace_callback(
            '/\d+/',
            static fn (array $m): string => self::digitsToWord($m[0]),
            $segment,
        );

        return ucfirst($rendered);
    }

    private static function digitsToWord(string $digits): string
    {
        return self::numberToWord((int) $digits);
    }

    /** Cardinals 0–19, PascalCased. */
    private const ONES = [
        'Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight',
        'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
        'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen',
    ];

    /** Tens 20–90, PascalCased; indexed by the tens digit. */
    private const TENS = [
        2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty', 6 => 'Sixty',
        7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety',
    ];

    /**
     * Render a non-negative whole number as a PascalCase English cardinal.
     * Supports 0–99 — the real dataset only reaches 12, and anything larger
     * fails loudly (ADR-0004 guard-rail) rather than emitting a broken case.
     */
    private static function numberToWord(int $n): string
    {
        if ($n < 0 || $n > 99) {
            throw new \InvalidArgumentException(
                "Cannot render number {$n} as a case-name word: out of supported range 0-99.",
            );
        }

        if ($n < 20) {
            return self::ONES[$n];
        }

        $ones = $n % 10;

        return self::TENS[intdiv($n, 10)].($ones === 0 ? '' : self::ONES[$ones]);
    }
}
