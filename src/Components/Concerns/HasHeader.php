<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;

trait HasHeader
{
    protected array | Closure | null $headers = null;

    protected bool | Closure | null $renderHeader = null;

    public function headers(array | Closure $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function renderHeader(bool | Closure $condition = true): static
    {
        $this->renderHeader = $condition;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->evaluate($this->headers) ?? [];
    }

    public function shouldRenderHeader(): bool
    {
        return $this->evaluate($this->renderHeader) ?? true;
    }
}
