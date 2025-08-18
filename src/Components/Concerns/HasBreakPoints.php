<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;
use Filament\Support\Enums\Width;

trait HasBreakPoints
{
    protected string | Width | Closure | null $stackAt = null;

    public function stackAt(string | Width | Closure $stackAt): static
    {
        $this->stackAt = $stackAt;

        return $this;
    }

    public function getStackAt(): string | Width
    {
        return $this->evaluate($this->stackAt)
            ?? Width::Medium;
    }
}
