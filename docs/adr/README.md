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

Still open for future records: the upstream sourcing strategy (git tag vs. npm tarball) and
the enum case-naming rule.
