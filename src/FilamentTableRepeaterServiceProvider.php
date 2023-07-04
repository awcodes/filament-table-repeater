<?php

namespace Awcodes\FilamentTableRepeater;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
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

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        if (app()->runningInConsole()) {
            FilamentAsset::register([
                Css::make('filament-table-repeater', __DIR__ . '/../resources/dist/filament-table-repeater.css')
            ], 'awcodes/filament-table-repeater');
        }
    }
}
