# The generator is a framework-free CLI, not an Artisan command

**Status:** accepted

The **sync** (the operation that regenerates the **generated artifacts**) is implemented as a
**framework-free PHP CLI** — a `symfony/console` single-command application under `bin/`, the same
shape `blade-ui-kit/blade-icons` ships its own generator in — invoked from CI and aliased via a
`composer` script for ergonomics (`composer sync`, `composer sync -- --check`). It does **not** boot
Laravel. `orchestra/testbench` remains a `require-dev` dependency, but only the test suite boots an
app context; the generator never does.

This supersedes the README's "artisan command `lucide:sync`" framing (the README is an explicit
pre-design idea dump).

## Why

The generator is a **maintainer-only** tool: per the committed-artifacts model, consumers
`composer require` and receive committed files, running nothing and fetching nothing. Composer never
runs a dependency's scripts and never generates anything in the consumer's app, so generation only
ever happens in this repo/CI. That removes any reason for the generator to be a consumer-facing
Artisan command.

Three factors then favour framework-free over Artisan:

- **The Testbench path footgun.** An Artisan command run through Testbench boots inside Testbench's
  *skeleton app*, so `base_path()` / `resource_path()` resolve against the skeleton, not the package
  root. A generator whose whole job is writing to `resources/svg/` and `src/Lucide.php` (reading from
  `node_modules/lucide-static/`) would silently write into the wrong tree. Artisan makes the one task
  most likely to break the host that breaks it.
- **Generation needs nothing from the framework.** It is filesystem reads + string transforms (the
  ADR-0004 case-naming rule) + file writes. No container, `config()`, blade-icons `Factory`, or
  Filament — those are runtime concerns in the service provider that *consume* the generated enum.
- **Precedent.** The closest analogue, `mallardduck/blade-lucide-icons` (same upstream, same
  committed-artifacts goal), uses framework-free standalone scripts; blade-icons itself ships its
  generator as a Symfony Console single-command app. Following that is the low-risk, idiomatic path.

## Consequence

The **sync** glossary term (the operation) is unchanged; only its *invocation* moves from an Artisan
namespace to a `bin/` script + `composer` alias. The `--check` CI mode (a future record) is a flag on
the same CLI. A standalone script needs only PHP + the Composer autoloader to run in CI, with no app
boot to slow down or destabilise the check.
