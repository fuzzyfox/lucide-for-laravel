# Sync pipeline shape: no check command, cron `bump → sync → test → PR`, two-gate guard-rails

**Status:** accepted

The **sync** (regeneration of the **generated artifacts**) is decoupled from *bumping the pin*. There
is **no `--check` command** — the README's proposed `lucide:sync --check` is superseded. Consistency
is enforced by the PHP (Pest) **test suite** over the *committed* artifacts: that every **Lucide enum**
case maps to exactly one **icon set** entry and back (correspondence), and that the ADR-0004 guard-rails
hold (charset, valid identifiers, injectivity, value↔name transform). These tests need no Node and run
in the ordinary suite.

The daily GitHub Action runs **`bump → sync → test → PR`**:

1. **Bump** — age-gated `pnpm update` within `^1.x` (`minimumReleaseAge` in `pnpm-workspace.yaml`, ~3
   days), the only step that moves the **pinned version**.
2. **Sync** — `bin/sync` regenerates artifacts from the new pin.
3. **Test** — the Pest suite runs against the freshly-regenerated tree.
4. **PR** — only if green: `peter-evans/create-pull-request` opens/updates a **single rolling PR** on a
   fixed branch (PR on any change, including a lockfile-only bump; human-merged).

## Why

- **Test-in-job, not a PAT.** Running the suite *before* the PR makes the cron its own CI gate, so a
  bad upstream release (or a generation bug) fails the Action — the maintainer relies on GitHub's
  failed-run notification — and no PR is opened. Because the tested tree is exactly what the action
  commits, the bot PR needs no downstream CI, so the default `GITHUB_TOKEN` suffices (no app/PAT token,
  despite GitHub's loop-guard not triggering workflows on token-authored PRs).
- **No `--check`.** A regenerate-and-byte-compare gate would need Node + `lucide-static` on every PR
  *and* byte-deterministic generation. The cron regenerates wholesale, so any drift is corrected and
  surfaced there; the cheap pure-PHP correspondence + guard-rail tests cover the rest. Determinism is
  kept only for diff hygiene (clean rolling-PR diffs), not as a pass/fail gate.

## Guard-rails (two gates, one implementation)

The ADR-0004 case-naming transform and its guard-rails live in **one shared, framework-free class** (a
`FuzzyFox\Lucide\Generation\…` namespace) enforced at two gates: **sync-time** (the generator asserts on
what it emits; a violation fails the sync — ADR-0004's "fail loudly") and **test-time** (the suite
asserts over the committed enum, catching hand-edits and covering ordinary dev PRs).

## Consequence

The build machinery (`Generation` namespace, `bin/`, `tests/`) is **`export-ignore`d** from the Composer
dist archive, so consumers download only the shipped enum, service providers, and `resources/`. Cutting
a package release from a merged PR (version/changelog/tag automation) is deliberately **out of scope**
here; the cron's job ends at a merged PR with fresh artifacts.
