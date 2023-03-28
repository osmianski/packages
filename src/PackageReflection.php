<?php

namespace Osmianski\Packages;

use Osmianski\Traits\ConstructedFromArray;
use Osmianski\Traits\HasLazyProperties;

/**
 * @property array $packages
 */
class PackageReflection
{
    use ConstructedFromArray;
    use HasLazyProperties;

}