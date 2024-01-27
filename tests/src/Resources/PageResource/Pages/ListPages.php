<?php

namespace Awcodes\FilamentTableRepeater\Tests\Resources\PageResource\Pages;

use Awcodes\FilamentTableRepeater\Tests\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
