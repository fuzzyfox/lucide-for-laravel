# Issue tracker: GitHub

Issues and PRDs for this repo live as GitHub issues. Use the `gh` CLI for all operations.

Repo: `fuzzyfox/lucide-for-laravel` (private). Issues enabled; default Pocock triage labels
applied.

## Conventions

- **Create an issue**: `gh issue create --title "..." --body "..."`. Use a heredoc for multi-line bodies.
- **Read an issue**: `gh issue view <number> --comments`, filtering comments by `jq` and also fetching labels.
- **List issues**: `gh issue list --state open --json number,title,body,labels,comments --jq '[.[] | {number, title, body, labels: [.labels[].name], comments: [.comments[].body]}]'` with appropriate `--label` and `--state` filters.
- **Comment on an issue**: `gh issue comment <number> --body "..."`
- **Apply / remove labels**: `gh issue edit <number> --add-label "..."` / `--remove-label "..."`
- **Close**: `gh issue close <number> --comment "..."`

Infer the repo from `git remote -v` — `gh` does this automatically when run inside a clone.

## When a skill says "publish to the issue tracker"

Create a GitHub issue.

## When a skill says "fetch the relevant ticket"

Run `gh issue view <number> --comments`.

## History

The remote was created with `gh repo create fuzzyfox/lucide-for-laravel --source=. --push
--private` and the default Matt Pocock triage labels (see `triage-labels.md`) were applied
with `gh label create`. To recreate the label set elsewhere:

```sh
gh label create needs-triage    --color FBCA04 --description "Maintainer needs to evaluate this issue"
gh label create needs-info      --color D4C5F9 --description "Waiting on reporter for more information"
gh label create ready-for-agent --color 0E8A16 --description "Fully specified, ready for an AFK agent"
gh label create ready-for-human --color 1D76DB --description "Requires human implementation"
gh label create wontfix         --color FFFFFF --description "Will not be actioned"
```
