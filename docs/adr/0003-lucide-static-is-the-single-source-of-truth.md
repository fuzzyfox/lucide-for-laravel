# `lucide-static` is the single source of truth; alias/deprecation metadata is out of scope

**Status:** accepted

The `lucide-static` npm package, at a pinned version, is the sole upstream input. Its
`icons/*.svg` filenames define which glyphs exist; the icon set and the `Lucide` enum are
generated from those filenames alone. Lucide's per-icon `aliases`/`deprecated` metadata is
explicitly **not** consumed.

## Why

`lucide-static` ships the raw `icons/<name>.svg` (plus a sprite, font, `icon-nodes.json`,
`tags.json`) at every release. It does **not** ship the per-icon `aliases`/`deprecated` fields —
those exist only in the `lucide-icons/lucide` git repo's `icons/<name>.json`. Reading them would
require a *second* pinned input (the matching git tag), breaking the single-input model.

We don't need them:

- **Aliases can't be enum cases anyway.** An alias (e.g. `alarm-plus` for `alarm-clock-plus`) has
  no SVG of its own, so it has no icon-set entry to back to. Per ADR-0001 a case's value *is* an
  icon-set name, and PHP forbids duplicate backing values — so two cases can't share
  `lucide-alarm-clock-plus`. Alias cases are impossible by construction. (This also dissolves the
  README's "aliases produce duplicate values" gotcha: generating from filenames sidesteps it.)
- **Deprecation hints are near-worthless today.** As of the 1.0 release, Lucide carries zero
  root-level deprecated icons; deprecation now lives almost entirely on deprecated *aliases*,
  which we don't surface. The only thing the metadata would buy is `@deprecated` docblocks for an
  empty set.

## Non-goals

- **Human icon discovery is out of scope.** People choose icons by browsing lucide.dev, not by
  scanning a PHP enum. The enum exists to *reference* a glyph in code with IDE autocompletion, not
  to browse the catalogue — so alias/keyword discovery aids belong upstream, not here.

## Consequence

One pinned `lucide-static` version fully determines the generated artifacts — the "generated from
one source, can't drift" thesis holds literally. If `@deprecated` hints are ever wanted, the
escape hatch is to add the git repo pinned to the *same* version as an optional enrichment input;
until then there is no git dependency at all.
