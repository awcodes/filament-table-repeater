<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;
use Filament\Support\Enums\MaxWidth;

trait HasBreakPoints
{
    protected string | MaxWidth | Closure | null $stackAt = null;

    public function stackAt(string | MaxWidth | Closure $stackAt): static
    {
        $this->stackAt = $stackAt;

        return $this;
    }

    public function getStackAt(): string | MaxWidth
    {
        return $this->evaluate($this->stackAt)
            ?? MaxWidth::Medium;
    }
}
