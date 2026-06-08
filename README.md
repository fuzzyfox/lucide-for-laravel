# lucide-for-laravel

> **Status: initial idea dump.** This README is a raw capture of the concept, written
> before any design grilling or implementation. Treat it as the seed, not the spec.
> CONTEXT.md and the doc-set will supersede the relevant parts as they land.

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
2. **Provides a `Lucide` enum** — one case per glyph, implementing Filament's
   `ScalableIcon` contract so it drops straight into `->icon(Lucide::Foo)` anywhere
   Filament accepts an icon. This enum is a *generated artifact*, not hand-maintained.
3. **Registers our Filament icon-alias overrides** — the `PanelsIconAlias::*` → `Lucide`
   map that re-skins Filament's built-in chrome (search box, sidebar toggles, theme
   switcher, notification bell, …) to match the Lucide icons we use on resources.

## Design model (the important bit)

Single source of truth, generated outward, so the parts can't drift:

```
pinned lucide release (e.g. vX.Y.Z)        <- the only input
        │
   [ generator ]                           <- artisan command, build-time only
        ├── SVG set on disk  ──────────────┐
        ├── blade-icons set registration   ├─ emitted artifacts (committed)
        └── PHP `Lucide` enum  ────────────┘
        
   Filament alias-override plugin           <- the only hand-authored, Filament-coupled part
        └── consumes the enum
```

- **The enum and the SVG set are both regenerated from the same upstream snapshot in one
  command**, so they cannot disagree.
- **Nothing is fetched at runtime.** blade-icons serves SVGs from disk; the enum is
  autoloaded. All work happens at sync time. Runtime cost is zero.

### Proposed commands

- `lucide:sync vX.Y.Z` — fetch the pinned release, regenerate the SVG set + enum +
  registration, all committed to the repo.
- `lucide:sync --check` — CI mode: fail if committed artifacts are stale relative to the
  pinned version. This check is what actually keeps us ahead of the abandoned packages.

Sourcing the raw `icons/*.svg` from `lucide-icons/lucide` (or the versioned npm tarball —
same SVGs, easier to fetch one versioned artifact than to clone). Avoid the per-framework
npm packages; the raw SVGs are the canonical, least-laggy source.

## Known gotchas to resolve during design

- **Enum case naming is not trivial.** kebab → PascalCase is fine until leading-digit
  names and deprecated aliases, which PHP enum cases can't represent (`case 2Foo` is
  illegal; aliases produce duplicate values). The generator needs a deterministic
  sanitisation rule and must handle lucide's alias/deprecation map. **Most likely to bite
  — decide the rule up front.**
- **`ScalableIcon` semantics.** `getIconForScale()` should resolve to the registered
  `lucide-{value}` name. Lucide's appeal is uniform stroke width, so we probably want CSS
  sizing, not per-size SVG variants — confirm.
- **License.** lucide is ISC. Vendoring the SVGs is fine; carry the notice.
- **Keep the Filament layer optional.** Responsibilities (1) and (2) are useful in any
  Laravel app; (3) is Filament-specific. Let consumers pull the icons without the Filament
  opinions, even if internally we always use both.

## Naming

Working name / repo slug: `lucide-for-laravel`. Open question: the name should not imply
this is *only* the Filament overrides — it's "fresh Lucide for Laravel, with our Filament
defaults on top". Revisit before publishing.

## Relationship to the Filament bootstrap playbook

This is a **sibling** to our internal Filament bootstrap playbook, not part of it. The
playbook documents the `Lucide` enum and `IconProvider` as conventions and expects them to
come from *this* package; this package is where they actually live and stay current.

## Project conventions (to be established)

- Issue tracker: **GitHub Issues**, using the default Matt Pocock recommended label set.
- Skills/workflow: Matt Pocock's skill set (initialised separately).
- Domain language, decisions, and doc-set: see `CONTEXT.md` and `docs/` once bootstrapped.
