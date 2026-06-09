# lucide-for-laravel

> **Status: pre-implementation.** This README began as a raw idea dump; the design has since
> been grilled and captured in `CONTEXT.md` (glossary) and `docs/adr/` (decisions), which are
> the spec. The notes below have been reconciled with those decisions, but are not yet usage
> docs — no installable package exists yet.

A Laravel + Filament package that provides [Lucide](https://lucide.dev) icons as a
first-class, **always-current** icon set — generated directly from the official
`lucide-icons/lucide` repository rather than depending on a third-party mirror that lags
upstream.

## Why this exists

We standardise our Filament panels on Lucide icons. Today that means leaning on community
packages (`blade-ui-kit/blade-lucide-icons`, `mallardduck/blade-lucide-icons`) that, in
practice, **aren't updated often enough** — new and renamed icons land in lucide proper
long before they reach those packages.

If we own the generation from the upstream source, we control freshness: a pinned lucide
release in, regenerated artifacts out, on our cadence.

## What it does (three responsibilities)

1. **Generates a blade-icons icon set from the official lucide repo.** Pulls the canonical
   `icons/*.svg` for a pinned lucide release and registers them as a blade-icons set under
   the `lucide-` prefix.
2. **Provides a `Lucide` enum** — one case per glyph. A plain `string`-backed enum whose
   value is the icon-set name (`Lucide::Camera->value === 'lucide-camera'`); it does *not*
   implement Filament's `ScalableIcon` — Filament resolves it via `->value`, so it still drops
   straight into `->icon(Lucide::Camera)`. A *generated artifact*, not hand-maintained.
   (See ADR-0001.)
3. **Registers our Filament icon-alias overrides** — the `PanelsIconAlias::*` → `Lucide`
   map that re-skins Filament's built-in chrome (search box, sidebar toggles, theme
   switcher, notification bell, …) to match the Lucide icons we use on resources.

## Design model (the important bit)

Single source of truth, generated outward, so the parts can't drift:

```
pinned lucide-static version               <- the only input (npm, pnpm-pinned)
        │
   [ generator ]                           <- framework-free CLI, build-time only
        ├── SVG icon set on disk  ─────────┐
        ├── resources/svg/LICENSE          ├─ generated artifacts (committed)
        └── PHP `Lucide` enum  ────────────┘

   service providers (static, hand-authored):
        ├── LucideServiceProvider          <- registers the icon set with blade-icons
        └── LucideFilamentServiceProvider  <- the Filament overlay (alias overrides)
```

- **The enum and the SVG set are both regenerated from the same upstream snapshot in one
  command**, so they cannot disagree.
- **Nothing is fetched at runtime.** blade-icons serves SVGs from disk; the enum is
  autoloaded. All work happens at sync time. Runtime cost is zero.

### The sync (ADR-0007 / 0009)

The generator is a framework-free CLI (`composer sync`), not an Artisan command. It reads the
`icons/*.svg` from the pnpm-pinned `lucide-static` and regenerates the committed artifacts.
*Bumping* the pin is separate from regenerating: a daily age-gated `bump → sync → test → PR`
cron keeps us ahead of the laggy community packages. There is no `--check` command — a PHP
test suite asserts the committed artifacts are internally consistent (enum ↔ icon set, plus the
ADR-0004 guard-rails).

## Design decisions (resolved — see `docs/adr/`)

The gotchas this idea-dump flagged were resolved during grilling:

- **Enum case naming** — kebab → PascalCase with digit-runs as whole-number words
  (`clock-12 → ClockTwelve`), guarded by a sync-time injectivity assertion. Generating from
  SVG filenames (not alias metadata) sidesteps the duplicate-value problem entirely (ADR-0004,
  ADR-0003).
- **No `ScalableIcon`** — a plain backed enum, sized via CSS (uniform stroke), not per-size
  variants (ADR-0001).
- **License** — MIT for our code; vendored SVGs keep their ISC + Feather-MIT notices in
  `resources/svg/LICENSE` (ADR-0005).
- **Optional Filament layer** — the overlay is an auto-discovered, self-guarding service
  provider, inert when Filament is absent (ADR-0002).

## Naming

Package `fuzzyfox/lucide-for-laravel`, namespace `FuzzyFox\Lucide`, enum
`FuzzyFox\Lucide\Lucide`, blade-icons prefix `lucide-` (ADR-0006).

## Relationship to the Filament bootstrap playbook

This is a **sibling** to our internal Filament bootstrap playbook, not part of it. The
playbook documents the `Lucide` enum and `IconProvider` as conventions and expects them to
come from *this* package; this package is where they actually live and stay current.

## Project conventions (to be established)

- Issue tracker: **GitHub Issues**, using the default Matt Pocock recommended label set.
- Skills/workflow: Matt Pocock's skill set (initialised separately).
- Domain language, decisions, and doc-set: see `CONTEXT.md` and `docs/` once bootstrapped.
