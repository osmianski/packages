<?php

use Osmianski\Packages\PackageReflection;

it('returns array of packages', function () {
    $reflection = new PackageReflection([
        'path' => dirname(__DIR__, 2),
    ]);

    expect($reflection->packages)->toBeArray();
});

it('returns project package', function () {
    $reflection = new PackageReflection([
        'path' => dirname(__DIR__, 2),
    ]);

    expect($reflection->project_package->name)->toBe('osmianski/packages');
});