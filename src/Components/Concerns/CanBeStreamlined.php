<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;

trait CanBeStreamlined
{
    protected bool | Closure | null $streamlined = null;

    public function streamlined(bool | Closure $condition = true): static
    {
        $this->streamlined = $condition;

        return $this;
    }

    public function isStreamlined(): bool
    {
        return $this->evaluate($this->streamlined) ?? false;
    }
}
