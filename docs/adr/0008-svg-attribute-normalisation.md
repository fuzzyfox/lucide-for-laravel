# SVG attribute normalisation at sync time

**Status:** accepted

The **sync** normalises each upstream `lucide-static` SVG before committing it: **strip** `class`,
`width`, `height`, the `<!-- @license … -->` comment, and the XML declaration; **keep** `xmlns`,
`viewBox`, `fill="none"`, and all `stroke*` attributes (so `currentColor` + CSS/Filament sizing
work). This matches what `mallardduck/blade-lucide-icons` and `blade-ui-kit/blade-heroicons` ship.

The only non-obvious one: **`class` must be stripped.** blade-icons does not merge classes — `Svg::toHtml()`
*prepends* consumer attributes verbatim (`str_replace('<svg', '<svg '.$attrs)`), so a committed
`class="lucide lucide-camera"` plus a consumer `@svg('lucide-camera', 'w-6 h-6')` emits **two** `class`
attributes on one element — invalid markup where the browser silently drops one. Keeping `class` is a
latent bug, not a styling hook. (`width`/`height` are stripped for drop-in parity with the packages we
displace, which size via CSS; the version-stamped license comment is stripped so unchanged glyphs don't
re-diff on every version bump — the notice lives in `resources/svg/LICENSE`.)
