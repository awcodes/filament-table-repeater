<?php

namespace Awcodes\FilamentTableRepeater;

use Filament\Support\Assets\AssetManager;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTableRepeaterServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-table-repeater';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered()
    {
        $this->app->resolving(AssetManager::class, function () {
            FilamentAsset::register([
                Css::make('table-repeater', __DIR__ . '/../resources/dist/filament-table-repeater.css'),
            ], 'awcodes/filament-table-repeater');
        });
    }
}
