# Architecture Decision Records

Architecturally significant decisions for this package, recorded as short, numbered Markdown
files: `0001-slug.md`, `0002-slug.md`, … Scan for the highest existing number and increment.

## Format

An ADR can be a single paragraph — 1–3 sentences capturing **what** the context was, **what**
was decided, and **why**. The value is in recording _that_ a decision was made and its
rationale, not in filling out sections. Add optional `Status` frontmatter, `Considered
Options`, or `Consequences` only when they earn their place.

## When to write one

All three must be true:

1. **Hard to reverse** — changing your mind later carries real cost.
2. **Surprising without context** — a future reader would otherwise wonder "why this way?".
3. **The result of a real trade-off** — there were genuine alternatives and you picked one.

If any is missing, skip it.

## Records

- [0001](./0001-lucide-enum-is-a-plain-backed-enum.md) — Lucide enum is a plain backed enum, not a `ScalableIcon`
- [0002](./0002-single-package-auto-discovered-filament-overlay.md) — single package; Filament overlay is an auto-discovered, self-guarding provider
- [0003](./0003-lucide-static-is-the-single-source-of-truth.md) — `lucide-static` is the single source of truth; alias/deprecation metadata out of scope
- [0004](./0004-enum-case-naming-rule.md) — enum case-naming rule: PascalCase + whole-number digit-to-words, with a sync-time injectivity assertion
- [0005](./0005-license-mit.md) — license: MIT for our code; vendored Lucide SVGs keep ISC + Feather-MIT
- [0006](./0006-package-naming.md) — package naming and namespace (`fuzzyfox/lucide-for-laravel`, `FuzzyFox\Lucide`)
- [0007](./0007-generator-is-a-framework-free-cli.md) — the generator is a framework-free `symfony/console` CLI, not an Artisan command
- [0008](./0008-svg-attribute-normalisation.md) — SVG attribute normalisation: strip `class`/`width`/`height`/comment, keep `viewBox`/`stroke*`

Still open for future records: the rest of the sync/CI pipeline shape (generated-artifact layout,
SVG attribute handling, the `--check` gate, the daily age-gated `pnpm update` → single rolling PR
Action) — being worked through in the dedicated grilling session.
