# lucide-for-laravel — agent guide

A Laravel + Filament package that generates an always-current Lucide blade-icons set and a
plain `string`-backed `Lucide` enum from the official `lucide-icons/lucide` repository, plus
optional Filament icon-alias overrides. See `README.md` for usage and `CONTEXT.md` for the
domain glossary.

> **Status:** implemented and released. The design is fixed in `CONTEXT.md` (glossary) and
> `docs/adr/` (decisions 0001–0009) — treat both as the spec. The icon set and enum are
> **generated artifacts**: change them via `composer sync` against an updated `lucide-static`
> pin, never by hand.

## Agent skills

### Issue tracker

GitHub Issues at `fuzzyfox/lucide-for-laravel`, driven via the `gh` CLI. The
default Pocock triage labels are applied. See `docs/agents/issue-tracker.md`.

### Triage labels

The default Matt Pocock five-role triage vocabulary, label strings unchanged. See
`docs/agents/triage-labels.md`.

### Domain docs

Single-context: one `CONTEXT.md` + `docs/adr/` at the repo root. See
`docs/agents/domain.md`.
