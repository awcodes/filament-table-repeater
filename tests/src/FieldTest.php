<?php

use Awcodes\Looper\Components\Looper;
use Awcodes\Looper\Tests\Fixtures\Livewire;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;

beforeEach(function () {
    $this->field = (new Looper('table_repeater'))
        ->container(ComponentContainer::make(Livewire::make()));
});

it('has headers by default', function () {
    $this->field
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toEqual([
            'name' => [
                'label' => 'Name',
                'width' => null,
                'required' => false,
            ],
        ]);
});

it('has headers with default items 0', function () {
    $this->field
        ->defaultItems(0)
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toEqual([
            'name' => [
                'label' => 'Name',
                'width' => null,
                'required' => false,
            ],
        ]);
});

it('has headers with required', function () {
    $this->field
        ->schema([
            TextInput::make('name')->required(),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toEqual([
            'name' => [
                'label' => 'Name',
                'width' => null,
                'required' => true,
            ],
        ]);
});

it('respects header widths', function () {
    $this->field
        ->columnWidths([
            'name' => '100px',
        ])
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->getHeaders())
        ->toBeArray()
        ->toEqual([
            'name' => [
                'label' => 'Name',
                'width' => '100px',
                'required' => false,
            ],
        ]);
});

it('can hide header', function () {
    $this->field
        ->withoutHeader()
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->shouldHideHeader())->toBeTrue();
});

it('hides field labels', function () {
    $this->field
        ->hideLabels()
        ->schema([
            TextInput::make('name'),
        ]);

    expect($this->field->shouldShowLabels())->toBeFalse();
});
