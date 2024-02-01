<?php

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Tests\Fixtures\Livewire as LivewireForm;
use function Pest\Livewire\livewire;

it('renders editor field', function () {
    livewire(LivewireForm::class)
        ->assertFormFieldExists('table_repeater')
        ->assertDontSee('table-repeater-header-hidden')
        ->assertDontSee('table-repeater-empty-row');
});

it('can disable header row', function () {
    livewire(DisabledHeaderRow::class)
        ->assertSee('table-repeater-header-hidden');
});

it('can have 0 items by default', function () {
    livewire(DefaultItemsForm::class)
        ->assertSee('table-repeater-empty-row');
});

it('can show labels', function () {
    livewire(VisibleLabelsForm::class)
        ->assertDontSee('has-hidden-label');
});

//it('creates record', function() {
//
//    $title = fake()->sentence;
//    $description = fake()->sentence;
//    $keywords = fake()->sentence;
//
//    livewire(CreatePage::class)
//        ->set('data.seo', null)
//        ->fillForm([
//            'seo' => [
//                [
//                    'title' => $title,
//                    'description' => $description,
//                    'keywords' => $keywords,
//                ],
//            ],
//        ])
//        ->call('create')
//        ->assertHasNoFormErrors();
//
//    $storedPage = Page::query()->first();
//
//    expect($storedPage)
//        ->seo->toBe([
//            [
//                'title' => $title,
//                'description' => $description,
//                'keywords' => $keywords,
//            ],
//        ]);
//});
//
//it('updates record', function() {
//    $page = Page::factory()->create([
//        'seo' => [
//            [
//                'title' => fake()->sentence,
//                'description' => fake()->sentence,
//                'keywords' => fake()->sentence,
//            ],
//        ],
//    ]);
//
//    $title = fake()->sentence;
//    $description = fake()->sentence;
//    $keywords = fake()->sentence;
//
//    livewire(EditPage::class, [
//        'record' => $page->getRouteKey(),
//    ])
//        ->set('data.seo', null)
//        ->fillForm([
//            'seo' => [
//                [
//                    'title' => $title,
//                    'description' => $description,
//                    'keywords' => $keywords,
//                ],
//            ],
//        ])
//        ->call('save')
//        ->assertHasNoFormErrors();
//
//    $storedPage = Page::query()->where('id', $page->id)->first();
//
//    expect($storedPage)
//        ->seo->toBe([
//            [
//                'title' => $title,
//                'description' => $description,
//                'keywords' => $keywords,
//            ],
//        ]);
//});

class DisabledHeaderRow extends LivewireForm
{
    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->renderHeader(false)
                ->headers(static::getRepeaterHeaders())
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
                ->headers(static::getRepeaterHeaders())
                ->schema(static::getRepeaterFormSchema()),
        ];
    }
}

class VisibleLabelsForm extends LivewireForm
{
    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->showLabels()
                ->headers(static::getRepeaterHeaders())
                ->schema(static::getRepeaterFormSchema()),
        ];
    }
}
