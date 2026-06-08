# Lucide for Laravel

The domain language for a Laravel + Filament package that generates an always-current Lucide
icon set (blade-icons + a plain PHP enum) from the official Lucide release, with optional
Filament icon-alias overrides.

> Keep this file a **glossary and nothing else**: define what each term _is_ in one or two
> sentences, pick one canonical word per concept and list the aliases to avoid, and keep all
> implementation detail out. See the producer skill's `CONTEXT-FORMAT.md` for the format.
> Decisions and rationale live in `docs/adr/`, not here.

## Language

### Icons & consumption

**Glyph**:
A single Lucide icon, identified by its canonical kebab-case name (`camera`, `alarm-clock-plus`),
which is also its SVG filename stem upstream. The atomic unit the package deals in — each glyph
yields exactly one entry in the **icon set** and one case in the **Lucide enum**.
_Avoid_: icon (overloaded — see Flagged ambiguities), symbol.

**Icon set**:
The collection of Lucide SVGs registered with blade-icons under the `lucide-` prefix (so the
`camera` glyph is addressable as `lucide-camera`). The runtime-facing artifact: blade-icons
serves it from disk.
_Avoid_: icon pack, icon library, glyph set.

**Lucide enum**:
The generated PHP `string`-backed enum, one case per glyph, whose backing value is the glyph's
name in the **icon set** (`Lucide::Camera->value === 'lucide-camera'`). A plain backed enum — it
does **not** implement Filament's `ScalableIcon` — passed directly anywhere Filament accepts an
icon, which resolves it via `->value`.
_Avoid_: icon enum, icon constants, ScalableIcon enum.

**Alias override**:
A mapping from one of Filament's built-in chrome icon slots (`PanelsIconAlias::*` — the global
search field, sidebar toggles, notification bell, …) to a Lucide **icon set** name. The only
hand-authored, Filament-coupled part of the package; shipped as the optional **Filament overlay**.
_Avoid_: icon swap, icon replacement, re-skin, theme.

**Filament overlay**:
The optional layer of the package that applies the **alias overrides**. Auto-discovered but
self-guarding, so it activates only when Filament is installed and is otherwise inert. Distinct
from the **icon set** and **Lucide enum**, which are useful in any Laravel app.
_Avoid_: Filament plugin (it is not a per-panel Filament plugin), Filament package.

### Generation & sourcing

**Source of truth**:
The `lucide-static` npm package at the **pinned version**. Its `icons/*.svg` filenames define
exactly which **glyphs** exist; everything else is generated from them. Upstream alias and
deprecation metadata (which lives only in the Lucide git repo, not in npm) is deliberately not a
source — see ADR-0003.
_Avoid_: upstream (vague), lucide repo (the git repo is not the source we read).

**Pinned version**:
The exact `lucide-static` version the committed **generated artifacts** correspond to — resolved
by the pnpm lockfile within the `package.json` semver range. "Lucide 1.17.0" the package speaks
of always means this number.
_Avoid_: pinned release (ambiguous with a GitHub release/tag), snapshot.

**Sync**:
The operation that reads the **source of truth** at the **pinned version** and regenerates the
**generated artifacts** to match. The only way artifacts change; never hand-edited.
_Avoid_: build, fetch, import, update.

**Generated artifact**:
A file emitted by a **sync** and committed to the repo: the SVG **icon set**, the **Lucide enum**,
and the blade-icons registration. Treated as read-only output, regenerated wholesale, never patched
by hand.
_Avoid_: build output, vendored file, asset.

## Flagged ambiguities

**"Icon"** is overloaded — it can mean the abstract **glyph** (`camera`), its SVG in the **icon
set** (`lucide-camera`), or its case in the **Lucide enum** (`Lucide::Camera`). Use **glyph** for
the abstract unit and name the artifact (**icon set** entry vs. enum case) wherever the distinction
matters; reserve bare "icon" for casual prose only.
