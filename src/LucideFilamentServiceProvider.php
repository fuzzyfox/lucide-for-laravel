<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide;

use Illuminate\Support\ServiceProvider;

/**
 * The Filament overlay: applies the alias overrides that re-skin Filament's
 * built-in chrome icons to Lucide. Auto-discovered but self-guarding, so it
 * no-ops when Filament is absent and never burdens a non-Filament app
 * (ADR-0002).
 *
 * Scaffolding slice: the `FilamentIcon::register()` alias-override map is
 * added in a later slice; for now the provider only proves the self-guard.
 */
final class LucideFilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // `::class` never autoloads, so this is safe with Filament absent.
        if (! class_exists(\Filament\Support\Facades\FilamentIcon::class)) {
            return;
        }

        // Alias-override map lands in a later slice (PRD: overlay mechanism
        // ships now, concrete map deferred).
    }
}
