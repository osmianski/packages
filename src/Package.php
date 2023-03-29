<?php

namespace Osmianski\Packages;

use Osmianski\Exceptions\NotImplemented;
use Osmianski\Packages\Hints\PackageHint;
use Osmianski\Traits\ConstructedFromArray;
use Osmianski\Traits\HasLazyProperties;

class Package
{
    use ConstructedFromArray;
    use HasLazyProperties;

    public PackageReflection $reflection;
    public string $name;
    public string $path;
    public bool $project;
    public bool $dev;

    public static function fromComposerLock(PackageReflection $reflection,
        \stdClass|PackageHint $json, bool $project = false,
        bool $dev = false): static
    {
        return new static([
            'reflection' => $reflection,
            'name' => $json->name,
            'path' => $project ? '' : "vendor/{$json->name}",
            'project' => $project,
            'dev' => $dev,
        ]);
    }
}