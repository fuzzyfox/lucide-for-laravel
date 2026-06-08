# Package naming and namespace

**Status:** accepted

| Thing | Name |
| --- | --- |
| Composer package | `fuzzyfox/lucide-for-laravel` |
| PHP namespace | `FuzzyFox\Lucide` |
| Enum | `FuzzyFox\Lucide\Lucide` (used as `Lucide::Camera`) |
| Core provider | `FuzzyFox\Lucide\LucideServiceProvider` |
| Filament provider | `FuzzyFox\Lucide\LucideFilamentServiceProvider` |
| blade-icons set prefix | `lucide-` |

## Why "for-laravel", not "for-filament"

The README flagged the name as an open question: it must not imply the package is *only* the
Filament overrides. It isn't — per ADR-0001/0002 the icon set and enum are Filament-free and
useful in any Laravel app, with the Filament overlay an optional, self-guarding add-on. So the
name is scoped to **Laravel** (the broad capability) with Filament as the opt-in layer, not the
headline. This also distinguishes it from the incumbent Filament-flavoured packages.

## Notes

- The enum sits at `…\Lucide\Lucide` (namespace + class same word, à la `Carbon\Carbon`) so the
  import reads `use FuzzyFox\Lucide\Lucide;` and the call site is the bare `Lucide::Camera`.
- The `lucide-` blade-icons prefix is the public addressing of the icon set and is also each enum
  case's backing value (ADR-0001); it is effectively part of the public API.
