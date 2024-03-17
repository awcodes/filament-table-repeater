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
        $fields = $this->childComponents;

        if (count($headers) < count($fields)) {
            foreach($fields as $field) {
                $headers[] = Header::make($field->getLabel());
            }
        }

        return array_map(
            fn ($header) => $header instanceof Header ? $header : Header::make($header),
            $headers,
        );
    }

    public function shouldRenderHeader(): bool
    {
        return $this->evaluate($this->renderHeader) ?? true;
    }
}
