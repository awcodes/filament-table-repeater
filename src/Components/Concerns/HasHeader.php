<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Awcodes\TableRepeater\Header;
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
        $headers = $this->evaluate($this->headers) ?? [];

        foreach ($this->getChildComponents() as $index => $field) {
            if (!isset($headers[$index])) {
                $headers[$index] = Header::make($field->getLabel());
            } elseif (!($headers[$index] instanceof Header)) {
                $headers[$index] = Header::make($headers[$index] ?? $field->getLabel());
            };
        }

        return $headers;
    }

    public function shouldRenderHeader(): bool
    {
        return $this->evaluate($this->renderHeader) ?? true;
    }
}
