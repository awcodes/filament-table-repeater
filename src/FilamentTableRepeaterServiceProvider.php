<?php

namespace Awcodes\FilamentTableRepeater;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentTableRepeaterServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-table-repeater';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    protected array $styles = [
        'plugin-filament-table-repeater' => __DIR__ . '/../resources/dist/filament-table-repeater.css',
    ];

    protected array $scripts = [
        'plugin-filament-table-repeater' => __DIR__ . '/../resources/dist/filament-table-repeater.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-filament-table-repeater' => __DIR__ . '/../resources/dist/filament-table-repeater.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
