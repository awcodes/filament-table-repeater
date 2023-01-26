<?php

namespace Awcodes\FilamentTableRepeater\Components;

use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;

class TableRepeater extends Repeater
{
    protected string $view = 'filament-table-repeater::components.repeater-table';

    protected Closure|array $headers = [];

    protected array|Closure $columnWidths = [];

    protected bool|Closure $showLabels = true;

    public function getChildComponents(): array
    {
        $components = parent::getChildComponents();

        if ($this->shouldShowLabels()) {
            return $components;
        }

        foreach ($components as $component) {
            if (method_exists($component, 'disableLabel')) {
                $component->disableLabel();
            }
        }

        return $components;
    }

    public function headers(array|Closure $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function columnWidths(array|Closure $widths = []): static
    {
        $this->columnWidths = $widths;

        return $this;
    }

    public function getHeaders(): array
    {
        $mergedHeaders = [];

        foreach ($this->getChildComponents() as $key => $field) {
            if ($field instanceof Hidden || $field->isHidden()) {
                continue;
            }

            $customHeaders = $this->evaluate($this->headers);

            $mergedHeaders[$field->getId()] = $customHeaders[$key] ?? $field->getLabel();
        }

        $this->headers = $mergedHeaders;

        return $this->evaluate($this->headers);
    }

    public function showLabels(bool|Closure $show = true): static
    {
        $this->showLabels = $show;

        return $this;
    }

    public function getColumnWidths(): array
    {
        return $this->evaluate($this->columnWidths);
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
}
