# Issue tracker: GitHub

Issues and PRDs for this repo live as GitHub issues. Use the `gh` CLI for all operations.

> **Not yet wired up.** This repo has no GitHub remote and no issue-tracker repo yet. Until
> the remote exists, skills that "publish to the issue tracker" have nowhere to write — see
> [Bootstrapping](#bootstrapping) below before relying on this file.

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

## Bootstrapping

When you're ready to create the remote and enable Issues with the default triage labels:

```sh
# 1. Create the repo (pick visibility) and push. Run from the repo root.
gh repo create fuzzyfox/lucide-for-laravel --source=. --remote=origin --push --public  # or --private

# 2. Apply the default Matt Pocock triage label set (see docs/agents/triage-labels.md)
gh label create needs-triage    --color FBCA04 --description "Maintainer needs to evaluate this issue"
gh label create needs-info      --color D4C5F9 --description "Waiting on reporter for more information"
gh label create ready-for-agent --color 0E8A16 --description "Fully specified, ready for an AFK agent"
gh label create ready-for-human --color 1D76DB --description "Requires human implementation"
gh label create wontfix         --color FFFFFF --description "Will not be actioned"
```

GitHub Issues is enabled by default on new repos; confirm with `gh repo view --json hasIssuesEnabled`.
