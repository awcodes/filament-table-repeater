<?php

namespace Awcodes\Looper\Tests\Database\Factories;

use Awcodes\Looper\Tests\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'seo' => null,
        ];
    }
}
