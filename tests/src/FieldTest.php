<?php

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Awcodes\TableRepeater\Tests\Fixtures\Livewire;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\Alignment;

beforeEach(function () {
    $this->field = (new TableRepeater('table_repeater'))
        ->container(ComponentContainer::make(Livewire::make()));
});

it('has headers by default', function () {
    $header = Header::make('Name');

    $this->field
        ->headers([
            $header,
        ])
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toContain($header);
});

it('has headers with default items 0', function () {
    $header = Header::make('Name');

    $this->field
        ->defaultItems(0)
        ->headers([
            $header,
        ])
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toContain($header);
});

it('respects header widths', function () {
    $header = Header::make('Name')->width('150px');

    $this->field
        ->headers([
            $header,
        ])
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toContain($header)
        ->and($header->getWidth())->toEqual('150px');
});

it('respects header alignment', function () {
    $header = Header::make('Name')->align(Alignment::Center);

    $this->field
        ->headers([
            $header,
        ])
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toContain($header)
        ->and($header->getAlignment())->toEqual(Alignment::Center);
});

it('can hide header', function () {
    $header = Header::make('Name');

    $this->field
        ->headers([
            $header,
        ])
        ->renderHeader(false)
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toContain($header)
        ->and($this->field->shouldRenderHeader())->toBeFalse();
});

it('shows field labels', function () {
    $this->field
        ->showLabels()
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->shouldShowLabels())->toBeTrue();
});
