<?php

declare(strict_types=1);

use FuzzyFox\Lucide\Generation\IconSource;
use FuzzyFox\Lucide\Generation\Sync;

/** A fresh, empty target tree for one sync run. */
function syncTarget(): object
{
    $root = sys_get_temp_dir().'/lucide-sync-'.bin2hex(random_bytes(6));
    mkdir($root, 0777, true);

    return (object) [
        'svgDir'   => $root.'/svg',
        'enumPath' => $root.'/Lucide.php',
    ];
}

function runSync(string $svgDir, string $enumPath, ?string $source = null): void
{
    $source ??= __DIR__.'/fixtures/source';

    (new Sync(new IconSource($source), $svgDir, $enumPath))->run();
}

it('writes a normalised icon-set SVG for each source glyph', function () {
    $target = syncTarget();

    runSync($target->svgDir, $target->enumPath);

    expect(file_get_contents($target->svgDir.'/camera.svg'))
        ->toBe(file_get_contents(__DIR__.'/fixtures/camera.normalised.svg'));
});

it('copies the source LICENSE verbatim into the icon set', function () {
    $target = syncTarget();

    runSync($target->svgDir, $target->enumPath);

    expect(file_get_contents($target->svgDir.'/LICENSE'))
        ->toBe(file_get_contents(__DIR__.'/fixtures/source/LICENSE'));
});

it('emits the Lucide enum for the source glyphs', function () {
    $target = syncTarget();

    runSync($target->svgDir, $target->enumPath);

    expect(file_get_contents($target->enumPath))
        ->toBe(file_get_contents(__DIR__.'/fixtures/Lucide.expected.php'));
});

it('regenerates the icon set wholesale, dropping stale glyphs', function () {
    $target = syncTarget();

    // A glyph from a previous sync that no longer exists upstream.
    mkdir($target->svgDir, 0777, true);
    file_put_contents($target->svgDir.'/obsolete.svg', '<svg/>');

    runSync($target->svgDir, $target->enumPath);

    $svgs = array_map('basename', glob($target->svgDir.'/*.svg'));
    sort($svgs);

    expect($svgs)->toBe(['alarm-clock-plus.svg', 'camera.svg', 'dice-6.svg']);
});

it('fails the sync at the guard-rail gate on a charset-breaking glyph', function () {
    $target = syncTarget();
    $invalidSource = __DIR__.'/fixtures/source-invalid';

    expect(fn () => runSync($target->svgDir, $target->enumPath, $invalidSource))
        ->toThrow(InvalidArgumentException::class, 'arrow_left');

    // The gate runs before the enum is emitted, so no broken enum is written.
    expect(file_exists($target->enumPath))->toBeFalse();
});
