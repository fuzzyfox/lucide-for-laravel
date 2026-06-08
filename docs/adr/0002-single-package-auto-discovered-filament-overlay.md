# Single package; Filament overlay is an auto-discovered, self-guarding provider

**Status:** accepted

The package ships as **one** composer package with **two** auto-discovered service providers
listed in `extra.laravel.providers`: a core `LucideServiceProvider` (registers the icon set +
enum, zero Filament references) and a `LucideFilamentServiceProvider` that applies the alias
overrides. The Filament provider self-guards — `if (! class_exists(\Filament\Support\Facades\
FilamentIcon::class)) return;` — so it no-ops when Filament is absent. `filament/filament` is
`require-dev` + `suggest`, never `require`.

## Why

The overlay registers **global** icon aliases via `FilamentIcon::register()` in a service
provider `boot()`, which is plain-Laravel territory. Laravel package auto-discovery registers
it with zero consumer wiring.

## Considered options

- **Filament plugin** (rejected): Filament plugins are per-panel and must be hand-registered in
  every `PanelProvider` — there is no global plugin auto-discovery. That forces consumer wiring
  for what is an app-wide concern, and `FilamentIcon::register()` isn't panel-scoped anyway.
- **Two separate composer packages** (rejected): a clean dependency graph on paper, but it puts
  two release cycles around a single pinned Lucide release, fighting the "generated from one
  source, can't drift" thesis. Since the core is already Filament-free (see ADR-0001), the split
  buys nothing.
- **One provider with an inner guard** (viable alternative): functionally identical safety;
  rejected only for clarity — keeping core and Filament wiring in separate providers makes the
  optional layer obvious.

## Consequence

Auto-discovery is all-or-nothing per the JSON list — there is no hook to skip a listed provider
based on another package's presence — so the runtime presence check *must* live inside the
always-registered Filament provider. `class_exists()` is autoload-safe and `::class` literals
never trigger autoload, so a Filament-less consumer sees no class-not-found error.
