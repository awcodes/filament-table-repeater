<?php

namespace Awcodes\FilamentTableRepeater;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTableRepeaterServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->bootLoaders();
        $this->bootPublishing();
    }
    
    public function configurePackage(Package $package): void
    {
        $package->name('filament-table-repeater')
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }

    protected function bootLoaders()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-table-repeater');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'filament-table-repeater');
    }

    protected function bootPublishing()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-table-repeater'),
        ], 'filament-table-repeater');
    }
}
