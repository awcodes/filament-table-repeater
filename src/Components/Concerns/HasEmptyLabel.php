<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;

trait HasEmptyLabel
{
    protected string | bool | Closure | null $emptyLabel = null;

    public function emptyLabel(bool | string | Closure | null $label = null): static
    {
        $this->emptyLabel = $label;

        return $this;
    }

    public function getEmptyLabel(): string | bool | null
    {
        return $this->evaluate($this->emptyLabel);
    }
}
