<?php

namespace Awcodes\FilamentTableRepeater\Components;

use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;

class TableRepeater extends Repeater
{
    protected string $breakPoint = 'md';

    protected array|Closure $columnWidths = [];

    protected null|string|Closure $emptyLabel = null;

    protected Closure|array $headers = [];

    protected bool|Closure $showLabels = true;

    protected string $view = 'filament-table-repeater::components.repeater-table';

    protected bool|Closure $withoutHeader = false;

    public function breakPoint(string $breakPoint = 'md'): static
    {
        $this->breakPoint = $breakPoint;

        return $this;
    }

    public function columnWidths(array|Closure $widths = []): static
    {
        $this->columnWidths = $widths;

        return $this;
    }

    public function emptyLabel(string|Closure $label = null): static
    {
        $this->emptyLabel = $label;

        return $this;
    }

    public function getBreakPoint(): string
    {
        return $this->breakPoint;
    }

    public function getColumnWidths(): array
    {
        return $this->evaluate($this->columnWidths);
    }

    public function getChildComponents(): array
    {
        $components = parent::getChildComponents();

        if ($this->shouldShowLabels()) {
            return $components;
        }

        foreach ($components as $component) {
            if (method_exists($component, 'disableLabel') && ! $component instanceof \Filament\Forms\Components\Checkbox) {
                $component->disableLabel();
            }
        }

        return $components;
    }

    public function getEmptyLabel(): null|string
    {
        return $this->evaluate($this->emptyLabel);
    }

    public function getHeaders(): array
    {
        $mergedHeaders = [];

        $customHeaders = $this->evaluate($this->headers);

        foreach ($this->getChildComponents() as $key => $field) {
            if ($field instanceof Hidden || $field->isHidden()) {
                continue;
            }

            $item = [
                'label' => $customHeaders[$key] ?? $field->getLabel(),
                'width' => $this->getColumnWidths()[$key] ?? null,
                'required' => method_exists($field, 'isRequired') ? $field->isRequired() : false,
            ];

            $mergedHeaders[method_exists($field, 'getName') ? $field->getName() : $field->getId()] = $item;
        }

        $this->headers = $mergedHeaders;

        return $this->evaluate($this->headers);
    }

    public function headers(array|Closure $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function hideLabels(): static
    {
        $this->showLabels = false;

        return $this;
    }

    protected function shouldShowLabels(): bool
    {
        return $this->evaluate($this->showLabels);
    }

    public function shouldHideHeader(): bool
    {
        return $this->evaluate($this->withoutHeader);
    }

    public function showLabels(bool|Closure $show = true): static
    {
        $this->showLabels = $show;

        return $this;
    }

    public function withoutHeader(bool|Closure $condition = true): static
    {
        $this->withoutHeader = $condition;

        return $this;
    }
}
