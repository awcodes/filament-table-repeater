<?php

namespace Awcodes\FilamentTableRepeater\Components;

use Closure;
use Filament\Forms\Components\Repeater;

class TableRepeater extends Repeater
{
    private Closure|array $headers = [];

    protected string $view = 'filament-table-repeater::components.repeater-table';

    public function headers(array | Closure $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->evaluate($this->headers);
    }
}
