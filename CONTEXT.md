# Lucide for Laravel

The domain language for a Laravel + Filament package that generates an always-current Lucide
icon set (blade-icons + a plain PHP enum) from the official `lucide-icons/lucide` repository,
with optional Filament icon-alias overrides.

> Keep this file a **glossary and nothing else**: define what each term _is_ in one or two
> sentences, pick one canonical word per concept and list the aliases to avoid, and keep all
> implementation detail out. See the producer skill's `CONTEXT-FORMAT.md` for the format.
> Decisions and rationale live in `docs/adr/`, not here.

## Language

**Icon set**:
The collection of Lucide SVGs registered with blade-icons under the `lucide-` prefix (so
`camera` is addressable as `lucide-camera`). The runtime-facing artifact: blade-icons serves
it from disk.
_Avoid_: icon pack, icon library, glyph set.

**Lucide enum**:
The generated PHP `string`-backed enum, one case per Lucide glyph, whose backing value is the
glyph's name in the **icon set** (`Lucide::Camera->value === 'lucide-camera'`). It is a plain
backed enum — it does **not** implement Filament's `ScalableIcon` — and is passed directly
anywhere Filament accepts an icon, which resolves it via `->value`.
_Avoid_: icon enum, icon constants, ScalableIcon enum.

**Alias override**:
A mapping from one of Filament's built-in chrome icon slots (`PanelsIconAlias::*` — the global
search field, sidebar toggles, notification bell, …) to a Lucide **icon set** name. The only
hand-authored, Filament-coupled part of the package; registered globally and shipped as the
optional **Filament overlay**.
_Avoid_: icon swap, icon replacement, re-skin, theme.

**Filament overlay**:
The optional layer of the package that applies the **alias overrides**. Auto-discovered but
self-guarding, so it activates only when Filament is installed and is otherwise inert. Distinct
from the **icon set** and **Lucide enum**, which are useful in any Laravel app with no Filament
present.
_Avoid_: Filament plugin (it is not a per-panel Filament plugin), Filament package.

## Flagged ambiguities

**"Icon"** is overloaded — it can mean the abstract named glyph (`camera`), its SVG in the
**icon set** (`lucide-camera`), or its case in the **Lucide enum** (`Lucide::Camera`). Prefer
the precise term (**icon set** name vs. enum case) over bare "icon" wherever the distinction
matters. A canonical term for the abstract unit (likely **glyph**) will be settled when enum
case-naming is resolved.
