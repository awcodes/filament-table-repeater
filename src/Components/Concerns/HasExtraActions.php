<?php

namespace Awcodes\TableRepeater\Components\Concerns;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Arr;

trait HasExtraActions
{
    /**
     * @var array<Action | Closure>
     */
    protected array $extraActions = [];

    /**
     * @var array<Action> | null
     */
    protected ?array $cachedExtraActions = null;

    /**
     * @param  array<Action | Closure>  $actions
     */
    public function extraActions(array $actions): static
    {
        $this->extraActions = [
            ...$this->extraActions,
            ...$actions,
        ];

        return $this;
    }

    /**
     * @return array<Action>
     */
    public function getExtraActions(): array
    {
        return $this->cachedExtraActions ?? $this->cacheExtraActions();
    }

    /**
     * @return array<Action>
     */
    public function cacheExtraActions(): array
    {
        $this->cachedExtraActions = [];

        foreach ($this->extraActions as $extraAction) {
            foreach (Arr::wrap($this->evaluate($extraAction)) as $action) {
                $this->cachedExtraActions[$action->getName()] = $this->prepareAction(
                    $action
                        ->defaultColor('gray')
                        ->defaultSize(ActionSize::Small)
                        ->defaultView(Action::BUTTON_VIEW),
                );
            }
        }

        return $this->cachedExtraActions;
    }
}
