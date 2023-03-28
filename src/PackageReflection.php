<?php

namespace Osmianski\Packages;

use Osmianski\Packages\Exceptions\NotFound;
use Osmianski\Traits\ConstructedFromArray;
use Osmianski\Traits\HasLazyProperties;
use stdClass;

/**
 * @property stdClass|Lock $lock
 * @property array|Package[] $packages
 */
class PackageReflection
{
    use ConstructedFromArray;
    use HasLazyProperties;

    public string $path;

    protected function get_lock(): stdClass
    {
        $filename = "{$this->path}/composer.lock";

        if (($contents = file_get_contents($filename)) === false) {
            throw new NotFound("'$filename' not found");
        }

        return json_decode($contents, flags: JSON_THROW_ON_ERROR);
    }

    protected function get_packages(): array
    {
        return $this->lock->packages;
    }
}