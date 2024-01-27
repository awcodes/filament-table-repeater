<?php

namespace Awcodes\FilamentTableRepeater\Tests\Resources;

use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Awcodes\FilamentTableRepeater\Tests\Models\Page;
use Awcodes\FilamentTableRepeater\Tests\Resources\PageResource\Pages;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TableRepeater::make('seo')
                    ->schema([
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\TextInput::make('description'),
                        Forms\Components\TextInput::make('keywords'),
                    ]),
            ])->columns(1);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
