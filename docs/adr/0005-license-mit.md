# License: MIT for our code; vendored Lucide SVGs keep ISC + Feather-MIT

**Status:** accepted

The package's own code is **MIT**. The vendored Lucide SVGs are redistributed under their
upstream licenses — **ISC** for most icons, **MIT** (© Cole Bemis) for the ~120 Feather-derived
icons — with those notices carried alongside the SVGs. `composer.json` declares
`"license": "MIT AND ISC"`.

## Why MIT over MPL-2.0

MPL-2.0 and MIT are both compatible with bundling the permissive ISC/MIT Lucide art, so the
choice came down to fit and benefit:

- The Laravel ecosystem is overwhelmingly MIT (Laravel, Filament, blade-icons, and the incumbent
  `*-lucide-icons` packages this aims to displace). A non-MIT license is an adoption-friction
  outlier — some teams' license scanners flag it — which works against the package's whole point.
- MPL-2.0's only real advantage is weak, file-level copyleft ("modifications to our files flow
  back"). This package ships **generated artifacts** (the enum, the SVG set); consumers regenerate
  or PR upstream rather than fork-and-modify our files, so that protection has virtually no bite
  here. We'd pay MPL's ecosystem cost for a benefit that doesn't apply.

## Obligations (for the generator / sync session to implement)

- Ship Lucide's **verbatim ISC notice + the Feather MIT notice** colocated with the vendored
  SVGs, e.g. `resources/svg/LICENSE`. ISC requires the copyright + permission notice to travel
  with every copy; the Feather subset requires the MIT notice.
- Root `LICENSE` is MIT (already added). No per-file headers required (MIT/ISC don't mandate them).
- Credit Lucide in the README as courtesy. The generated enum (bare icon names) carries no
  copyright obligation — names/short strings aren't copyrightable — so the obligation lives with
  the SVG art, not the name list.
- Before first publish, re-check upstream Lucide's `LICENSE` still splits ISC + Feather-MIT and
  copy both notices verbatim at the pinned version.
