<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide;

use Illuminate\Support\ServiceProvider;

/**
 * Core provider: registers the Lucide icon set with blade-icons under the
 * `lucide-` prefix. Filament-free and useful in any Laravel app (ADR-0002).
 *
 * Scaffolding slice: the blade-icons set registration is added in a later
 * slice once the generated `resources/svg/` artifacts exist.
 */
final class LucideServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
