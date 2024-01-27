<?php

namespace Awcodes\Looper;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LooperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('looper')
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }
}
