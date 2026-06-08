# lucide-for-laravel — agent guide

A Laravel + Filament package that generates an always-current Lucide blade-icons set and a
`ScalableIcon` `Lucide` enum from the official `lucide-icons/lucide` repository, plus
optional Filament icon-alias overrides. See `README.md` for the concept and `CONTEXT.md`
for the domain glossary.

> **Status:** scaffolding only. The package design is intentionally left un-grilled — that
> happens in a later session. Don't treat `CONTEXT.md`/`docs/` as a spec yet.

## Agent skills

### Issue tracker

GitHub Issues, driven via the `gh` CLI. **No GitHub remote exists yet** — the remote and
the label set still need to be created (see `docs/agents/issue-tracker.md`).

### Triage labels

The default Matt Pocock five-role triage vocabulary, label strings unchanged. See
`docs/agents/triage-labels.md`.

### Domain docs

Single-context: one `CONTEXT.md` + `docs/adr/` at the repo root. See
`docs/agents/domain.md`.
