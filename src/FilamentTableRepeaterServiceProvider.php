<?php

namespace Awcodes\FilamentTableRepeater;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTableRepeaterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-table-repeater')
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }
}
