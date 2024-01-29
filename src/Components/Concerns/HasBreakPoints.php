<?php

namespace Awcodes\Looper\Components\Concerns;

use Closure;
use Filament\Support\Enums\MaxWidth;

trait HasBreakPoints
{
    protected string | MaxWidth | Closure | null $breakPoint = null;

    public function breakPoint(string | MaxWidth | Closure $breakPoint): static
    {
        $this->breakPoint = $breakPoint;

        return $this;
    }

    public function getBreakPoint(): string | MaxWidth
    {
        return $this->evaluate($this->breakPoint)
            ?? MaxWidth::Medium;
    }
}
