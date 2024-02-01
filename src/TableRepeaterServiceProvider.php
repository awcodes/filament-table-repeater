<?php

namespace Awcodes\TableRepeater;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TableRepeaterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('table-repeater')
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }
}
