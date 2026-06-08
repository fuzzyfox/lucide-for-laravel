# Lucide enum is a plain backed enum, not a ScalableIcon

**Status:** accepted

The `Lucide` enum is a plain `string`-backed enum whose case values are icon-set names
(`Lucide::Camera = 'lucide-camera'`). It deliberately does **not** implement Filament's
`Filament\Support\Contracts\ScalableIcon`, and the core has no `filament/*` dependency.

## Why

Filament never requires the contract. Every icon-resolution path (`generate_icon_html()` and
the `toArray()` of `Action`, `ActionGroup`, `Notification`) branches `instanceof ScalableIcon`
**else** `instanceof BackedEnum → $icon->value`; there is no `ScalableIcon` type-hint anywhere
in Filament's source. So a plain backed enum resolves to `svg('lucide-camera')` and renders
identically.

`ScalableIcon::getIconForSize(IconSize $size): string` only earns its keep when an icon family
ships different glyphs per size (Heroicons return `heroicon-c-*`/`-m-*`/`-s-*`). Lucide is a
single uniform-stroke family sized by CSS, so our `getIconForSize()` would return the same
`lucide-*` name for all six `IconSize` cases — a method that changes nothing observable (the
`fi-size-*` class is applied independently of the branch). Implementing it would add a
`filament/support` dependency to the core for zero behavioural gain.

## Consequence

The core (icon set + enum) is Filament-free and usable in any Laravel app. This is surprising
at first glance because Filament's own `Heroicon` enum *does* implement `ScalableIcon` — hence
this record, so the absence reads as deliberate, not an oversight.
