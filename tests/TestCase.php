<?php

declare(strict_types=1);

namespace FuzzyFox\Lucide\Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use FuzzyFox\Lucide\LucideFilamentServiceProvider;
use FuzzyFox\Lucide\LucideServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Register the package's auto-discovered providers, mirroring what
     * Laravel package discovery does in a consumer app. filament/support
     * is installed (require-dev), so the self-guarding overlay engages and
     * Filament's IconManager — a dependency-free singleton the facade
     * auto-resolves — is what the overrides resolve through (ADR-0002).
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            LucideServiceProvider::class,
            LucideFilamentServiceProvider::class,
        ];
    }
}
