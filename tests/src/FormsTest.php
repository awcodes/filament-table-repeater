<?php

use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Awcodes\FilamentTableRepeater\Tests\Fixtures\Livewire as LivewireForm;
use Awcodes\FilamentTableRepeater\Tests\Models\Page;
use Awcodes\FilamentTableRepeater\Tests\Resources\PageResource\Pages\CreatePage;
use Awcodes\FilamentTableRepeater\Tests\Resources\PageResource\Pages\EditPage;
use function Pest\Livewire\livewire;
use function Pest\Faker\fake;

it('renders editor field', function () {
    livewire(LivewireForm::class)
        ->assertFormFieldExists('table_repeater')
        ->assertDontSee('filament-table-repeater-header-hidden')
        ->assertDontSee('filament-table-repeater-empty-row');
});

it('can disable header row', function () {
    livewire(DisabledHeaderRow::class)
        ->assertSee('filament-table-repeater-header-hidden');
});

it('can have 0 items by default', function () {
    livewire(DefaultItemsForm::class)
        ->assertSee('filament-table-repeater-empty-row');
});

it('can hide labels', function () {
    livewire(HiddenLabelsForm::class)
        ->assertSee('has-hidden-label');
});

it('creates record', function() {

    $title = fake()->sentence;
    $description = fake()->sentence;
    $keywords = fake()->sentence;

    livewire(CreatePage::class)
        ->set('data.seo', null)
        ->fillForm([
            'seo' => [
                [
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                ],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $storedPage = Page::query()->first();

    expect($storedPage)
        ->seo->toBe([
            [
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
            ],
        ]);
});

it('updates record', function() {
    $page = Page::factory()->create([
        'seo' => [
            [
                'title' => fake()->sentence,
                'description' => fake()->sentence,
                'keywords' => fake()->sentence,
            ],
        ],
    ]);

    $title = fake()->sentence;
    $description = fake()->sentence;
    $keywords = fake()->sentence;

    livewire(EditPage::class, [
        'record' => $page->getRouteKey(),
    ])
        ->set('data.seo', null)
        ->fillForm([
            'seo' => [
                [
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                ],
            ],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $storedPage = Page::query()->where('id', $page->id)->first();

    expect($storedPage)
        ->seo->toBe([
            [
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
            ],
        ]);
});

class DisabledHeaderRow extends LivewireForm
{
    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->withoutHeader()
                ->schema(static::getRepeaterFormSchema()),
        ];
    }
}

class DefaultItemsForm extends LivewireForm
{
    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->defaultItems(0)
                ->schema(static::getRepeaterFormSchema()),
        ];
    }
}

class HiddenLabelsForm extends LivewireForm
{
    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->hideLabels()
                ->schema(static::getRepeaterFormSchema()),
        ];
    }
}
