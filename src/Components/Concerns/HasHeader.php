<?php

namespace Awcodes\Looper\Components\Concerns;

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

    public function header(bool | Closure $condition = true): static
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
        return $this->evaluate($this->renderHeader);
    }
}
