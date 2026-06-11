# Lucide for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fuzzyfox/lucide-for-laravel.svg?style=flat-square)](https://packagist.org/packages/fuzzyfox/lucide-for-laravel)
[![Tests](https://img.shields.io/github/actions/workflow/status/fuzzyfox/lucide-for-laravel/tests.yml?branch=main&style=flat-square&label=tests)](https://github.com/fuzzyfox/lucide-for-laravel/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/fuzzyfox/lucide-for-laravel.svg?style=flat-square)](https://packagist.org/packages/fuzzyfox/lucide-for-laravel)
[![PHP Version](https://img.shields.io/packagist/php-v/fuzzyfox/lucide-for-laravel?style=flat-square)](https://packagist.org/packages/fuzzyfox/lucide-for-laravel)
[![License](https://img.shields.io/packagist/l/fuzzyfox/lucide-for-laravel.svg?style=flat-square)](LICENSE)

An always-current [Lucide](https://lucide.dev) icon set and PHP enum for Laravel and
[Filament](https://filamentphp.com) — generated straight from the official Lucide release, so
new and renamed glyphs reach you on **your** schedule instead of a third-party mirror's.

- 🎨 Every Lucide glyph as a [blade-icons](https://github.com/blade-ui-kit/blade-icons) set
  under the `lucide-` prefix — `@svg('lucide-camera')` / `<x-lucide-camera />`.
- 🧩 A generated `Lucide` enum — one autocompletable, rename-safe case per glyph, droppable
  into `->icon(Lucide::Camera)`.
- 🪄 An optional, auto-discovered Filament overlay that re-skins Filament's built-in chrome
  icons to Lucide — inert when Filament isn't installed.
- ⚡ Zero runtime cost — SVGs are served from disk and the enum is autoloaded; nothing is
  fetched or generated in your app.

## Why this exists

Most Laravel apps reach Lucide through community packages
(`blade-ui-kit/blade-lucide-icons`, `mallardduck/blade-lucide-icons`) that, in practice,
lag upstream — new and renamed glyphs land in Lucide proper long before they reach those
packages. This package owns generation from the upstream source of truth
([`lucide-static`](https://www.npmjs.com/package/lucide-static)), so freshness is a decision,
not a wait: a pinned Lucide release in, regenerated artifacts out. A daily age-gated
`bump → sync → test → PR` cron keeps the set ahead of the abandoned alternatives.

## Requirements

- PHP `^8.2` (8.2 – 8.5)
- Laravel 11.28+, 12, or 13
- Filament `^5.0` — optional, only needed for the chrome overlay

## Installation

```bash
composer require fuzzyfox/lucide-for-laravel
```

Both service providers are auto-discovered — there's nothing to register. The Filament
overlay self-guards on `class_exists`, so it stays completely inert in a non-Filament app.

## Usage

### In Blade

Every glyph is available under the `lucide-` prefix:

```blade
@svg('lucide-camera')
<x-lucide-camera />
```

Icons inherit colour via `currentColor` and are sized with CSS — pass your own classes and
they're applied without any duplicate or conflicting attributes on the rendered SVG:

```blade
@svg('lucide-camera', 'w-6 h-6 text-primary-500')
<x-lucide-camera class="w-6 h-6 text-primary-500" />
```

### The `Lucide` enum

A plain `string`-backed enum with one case per glyph. Each case's value **is** its
icon-set name, so the enum and the icon set can never disagree:

```php
use FuzzyFox\Lucide\Lucide;

Lucide::Camera->value;          // 'lucide-camera'
Lucide::AlarmClockPlus->value;  // 'lucide-alarm-clock-plus'
```

Case names are derived deterministically from the glyph name, with digit-runs spelled as
whole-number English words so they stay valid, predictable, and collision-free across syncs:

```php
Lucide::ClockTwelve->value;  // 'lucide-clock-12'
Lucide::DiceSix->value;      // 'lucide-dice-6'
```

### With Filament

Pass enum cases anywhere Filament accepts an icon — Filament resolves them via `->value`:

```php
use FuzzyFox\Lucide\Lucide;

TextColumn::make('name')->icon(Lucide::Camera);

Action::make('delete')->icon(Lucide::Trash);
```

When Filament is installed, the auto-discovered overlay also re-skins Filament's built-in
chrome — the global search field, sidebar toggles, theme switcher, notification bell,
pagination, table sort handles, and more — to their Lucide equivalents, app-wide, with no
per-panel registration. No configuration required.

## How it stays current

Single source of truth, generated outward, so the parts can't drift:

```
pinned lucide-static version               ← the only input (npm, pnpm-pinned)
        │
   [ sync (framework-free CLI) ]           ← build-time only; boots no Laravel app
        ├── resources/svg/*.svg  ──────────┐
        ├── resources/svg/LICENSE          ├─ generated artifacts (committed & shipped)
        └── src/Lucide.php (enum)  ─────────┘
```

- **The enum and the SVG set are regenerated from the same snapshot in one command**
  (`composer sync`), so they cannot disagree. A correspondence test asserts every enum case
  maps to exactly one icon file and vice versa.
- **Nothing is fetched at runtime.** Generated artifacts are committed and shipped in the
  Composer dist archive; consumers run nothing and fetch nothing.
- **Freshness is a human decision.** A daily GitHub Action age-gates `pnpm update` within
  `^1.x` (refusing releases younger than ~3 days), regenerates, runs the full test suite, and
  only on green opens or updates a single rolling PR whose diff shows exactly which glyphs
  changed.

The design rationale is captured in [`CONTEXT.md`](CONTEXT.md) (glossary) and the ADRs under
[`docs/adr/`](docs/adr).

## Testing

```bash
composer test
```

The suite covers the generator modules in isolation (case naming, guard-rails, SVG
normalisation, enum emission), an end-to-end sync, the correspondence between the committed
enum and icon set, and both service providers under Testbench.

## Contributing

Issues and pull requests are welcome on
[GitHub](https://github.com/fuzzyfox/lucide-for-laravel). Note that the icon set and enum are
**generated artifacts** — to change them, run `composer sync` against an updated
`lucide-static` pin rather than editing `resources/svg/` or `src/Lucide.php` by hand.

## Credits

- [Lucide](https://lucide.dev) — the icon set this package vendors and tracks.
- [blade-icons](https://github.com/blade-ui-kit/blade-icons) — the rendering layer.
- [William Duyck](https://github.com/fuzzyfox)

## License

This package's own code is licensed under the **MIT License**. The vendored Lucide SVGs
retain their upstream **ISC** (and Feather **MIT**) notices, shipped verbatim in
[`resources/svg/LICENSE`](resources/svg/LICENSE). The overall distribution is therefore
`MIT AND ISC`. See [LICENSE](LICENSE) for details.
