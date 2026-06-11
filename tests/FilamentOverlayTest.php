<?php

declare(strict_types=1);

use Filament\Support\Facades\FilamentIcon;
use Filament\View\PanelsIconAlias;
use FuzzyFox\Lucide\Lucide;
use FuzzyFox\Lucide\LucideFilamentServiceProvider;

/**
 * Every Filament icon slot, discovered from the source of truth — the
 * `*IconAlias` classes each Filament package ships — rather than restated
 * here, so a slot Filament adds upstream shows up as newly unmapped.
 *
 * @return array<int, string>
 */
function filamentIconAliases(): array
{
    $aliasClasses = [
        \Filament\Actions\View\ActionsIconAlias::class,
        \Filament\View\PanelsIconAlias::class,
        \Filament\Forms\View\FormsIconAlias::class,
        \Filament\Infolists\View\InfolistsIconAlias::class,
        \Filament\Notifications\View\NotificationsIconAlias::class,
        \Filament\QueryBuilder\View\QueryBuilderIconAlias::class,
        \Filament\Schemas\View\SchemaIconAlias::class,
        \Filament\Support\View\SupportIconAlias::class,
        \Filament\Tables\View\TablesIconAlias::class,
        \Filament\Widgets\View\WidgetsIconAlias::class,
    ];

    $aliases = [];

    foreach ($aliasClasses as $class) {
        foreach ((new ReflectionClass($class))->getConstants() as $value) {
            $aliases[] = $value;
        }
    }

    return $aliases;
}

it('registers an alias override that Filament resolves to a Lucide glyph', function (): void {
    // The overlay's whole job: a Filament chrome slot now resolves to a
    // Lucide glyph instead of its Heroicon default (ADR-0002).
    expect(FilamentIcon::resolve(PanelsIconAlias::GLOBAL_SEARCH_FIELD))
        ->toBe(Lucide::Search);
});

it('leaves the GitHub brand button to Filament’s default as an explicit exception', function (): void {
    // Filament's GitHub button is a hardcoded brand-logo SVG, and neither
    // Lucide nor Heroicons ships a GitHub glyph, so there is no faithful
    // replacement — we deliberately leave Filament's default in place.
    $github = PanelsIconAlias::WIDGETS_FILAMENT_INFO_OPEN_GITHUB_BUTTON;

    expect(LucideFilamentServiceProvider::aliasOverrides())->not->toHaveKey($github)
        ->and(LucideFilamentServiceProvider::unmappedAliases())->toContain($github);
});

it('accounts for every Filament icon alias, mapping or excepting each one', function (): void {
    $accountedFor = array_merge(
        array_keys(LucideFilamentServiceProvider::aliasOverrides()),
        LucideFilamentServiceProvider::unmappedAliases(),
    );

    $unaccounted = array_values(array_diff(filamentIconAliases(), $accountedFor));

    expect($unaccounted)->toBe([]);
});

it('excepts only real Filament aliases, and never one it also maps', function (): void {
    $exceptions = LucideFilamentServiceProvider::unmappedAliases();

    // An exception must be a real slot Filament defines...
    expect(array_diff($exceptions, filamentIconAliases()))->toBe([]);
    // ...and must not contradict the override map.
    expect(array_intersect($exceptions, array_keys(LucideFilamentServiceProvider::aliasOverrides())))->toBe([]);
});

it('maps no key Filament does not define as an alias', function (): void {
    $mapped = array_keys(LucideFilamentServiceProvider::aliasOverrides());

    $stray = array_values(array_diff($mapped, filamentIconAliases()));

    expect($stray)->toBe([]);
});

it('maps every alias to a Lucide glyph the icon set can render', function (): void {
    foreach (LucideFilamentServiceProvider::aliasOverrides() as $alias => $glyph) {
        expect($glyph)->toBeInstanceOf(Lucide::class);

        // A mapping is only meaningful if blade-icons can actually serve the
        // glyph from the registered Lucide set.
        expect(svg($glyph->value)->toHtml())->toContain('<svg');
    }
});
