<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

/**
 * Core provider: registers the Lucide icon set with blade-icons under the
 * `lucide-` prefix. Filament-free and useful in any Laravel app (ADR-0002).
 *
 * blade-icons discovers icons by scanning `resources/svg/`, so the set is
 * registered the moment its Factory resolves — no generated artifact needed.
 */
final class LucideServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory): void {
            $factory->add('lucide', [
                'path' => __DIR__.'/../resources/svg',
                'prefix' => 'lucide',
            ]);
        });
    }
}
