<?php

use Osmianski\Packages\PackageReflection;

test('example', function () {
    $reflection = new PackageReflection([
        'path' => dirname(__DIR__, 2),
    ]);

    expect($reflection->packages)->toBeArray();
});
