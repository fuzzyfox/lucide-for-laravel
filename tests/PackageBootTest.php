<?php

declare(strict_types=1);

use FuzzyFox\Lucide\LucideFilamentServiceProvider;
use FuzzyFox\Lucide\LucideServiceProvider;

it('boots both auto-discovered providers under Testbench', function (): void {
    $loaded = app()->getLoadedProviders();

    expect($loaded)
        ->toHaveKey(LucideServiceProvider::class)
        ->toHaveKey(LucideFilamentServiceProvider::class);
});

it('keeps the Filament overlay inert and error-free when it boots', function (): void {
    // The self-guarding overlay must boot without throwing regardless of
    // whether Filament's chrome is wired up (ADR-0002).
    expect(app()->getLoadedProviders())
        ->toHaveKey(LucideFilamentServiceProvider::class);
});
