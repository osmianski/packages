<?php

namespace Osmianski\Packages;

use Osmianski\Packages\Exceptions\NotFound;
use Osmianski\Packages\Hints\ComposerLockHint;
use Osmianski\Packages\Hints\PackageHint;
use Osmianski\Traits\ConstructedFromArray;
use Osmianski\Traits\HasLazyProperties;
use stdClass;

/**
 * @property stdClass|ComposerLockHint $lock
 * @property stdClass|PackageHint $json
 * @property array|Package[] $packages
 * @property Package $project_package
 */
class PackageReflection
{
    use ConstructedFromArray;
    use HasLazyProperties;

    public string $path;
    public bool $dev = false;

    protected function get_lock(): stdClass
    {
        $filename = $this->path
            ? "{$this->path}/composer.lock"
            : 'composer.lock';

        if (($contents = file_get_contents($filename)) === false) {
            throw new NotFound("'$filename' not found");
        }

        return json_decode($contents, flags: JSON_THROW_ON_ERROR);
    }

    protected function get_json(): stdClass
    {
        $filename = $this->path
            ? "{$this->path}/composer.json"
            : 'composer.json';

        if (($contents = file_get_contents($filename)) === false) {
            throw new NotFound("'$filename' not found");
        }

        return json_decode($contents, flags: JSON_THROW_ON_ERROR);
    }

    protected function get_packages(): array
    {
        $packages = [
            $this->json->name => Package::fromComposerLock($this, $this->json,
                project: true),
        ];

        foreach ($this->lock->packages as $json) {
            $packages[$json->name] = Package::fromComposerLock($this, $json);
        }

        if ($this->dev) {
            foreach ($this->lock->{'packages-dev'} as $json) {
                $packages[$json->name] = Package::fromComposerLock($this, $json,
                    dev: true);
            }
        }

        return $packages;
    }

    protected function get_project_package(): Package
    {
        return $this->packages[$this->json->name];
    }
}