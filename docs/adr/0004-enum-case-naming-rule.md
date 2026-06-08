# Enum case-naming rule: PascalCase with whole-number digit-to-words

**Status:** accepted

A glyph's kebab-case name is transformed into its `Lucide` enum case name as follows:

1. Split the name on `-`.
2. Convert each **maximal run of digits** to its English cardinal as a **whole number**,
   PascalCased (`12 → Twelve`, `10 → Ten`, `0 → Zero`; leading zeros collapse, so `01 → One`).
3. PascalCase the letter portions (upper-case the first character of each segment; letters
   interior to a segment keep their case).
4. Concatenate. The case **value** is `lucide-<original-name>`, unchanged (per ADR-0001).

Examples: `alarm-clock-plus → AlarmClockPlus`, `dice-6 → DiceSix`, `clock-12 → ClockTwelve`,
`grid-2x2 → GridTwoxTwo`, `axis-3-d → AxisThreeD`.

## Why whole-number, not per-digit

Per-digit conversion (`12 → OneTwo`) is **not injective** on the real dataset: it erases the
dash between digit segments, so the numeric sort-arrow duplicates collapse —
`arrow-down-0-1` and `arrow-down-01` both become `ArrowDownZeroOne`. Lucide ships these as two
physical SVG files (a canonical dashed form and a legacy non-dashed duplicate), and since we
generate from filenames and read no alias metadata (ADR-0003), both are real glyphs needing
distinct, legal cases.

Whole-number parsing separates them for free: `01 → One` vs `0-1 → ZeroOne`, and `10 → Ten`
vs `1-0 → OneZero`. Verified against `lucide-static@1.17.0`: all 1962 names map to 1962
distinct, valid PHP identifiers — **zero collisions**. As a bonus, `clock-10/11/12` read as
`ClockTen/Eleven/Twelve` rather than `ClockOneZero/…`.

Trade-off accepted: `arrow-down-01 → ArrowDownOne` is semantically lossy (the icon is a "0→1"
sort glyph, not "one"), but it is a duplicate file of `arrow-down-0-1` anyway, so the loss is
cosmetic on a redundant case.

## Guard-rail

The generator **asserts at sync time** that (a) every glyph name matches `^[a-z0-9-]+$`,
(b) every emitted case name is a valid PHP identifier starting with a letter, and (c) the case
names are collision-free (injective). If a future Lucide release ever violates any of these —
a new collision, a leading-digit name, an unexpected character — **the sync fails loudly**
rather than emitting a broken enum, and we decide the fix against the concrete offending name.
This is correct today and self-defending tomorrow.
