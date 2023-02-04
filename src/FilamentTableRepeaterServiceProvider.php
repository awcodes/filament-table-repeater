<?php

namespace Awcodes\FilamentTableRepeater;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentTableRepeaterServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-table-repeater';

    protected array $styles = [
        'filament-table-repeater' => __DIR__ . '/../resources/dist/filament-table-repeater.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }
}
