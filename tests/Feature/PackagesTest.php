<?php

use Osmianski\Packages\PackageReflection;

test('example', function () {
    $reflection = new PackageReflection();

    expect($reflection->packages)->toBeArray();
});
