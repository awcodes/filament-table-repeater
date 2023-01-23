<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $containers = $getChildComponentContainers();

        $isCloneable = $isCloneable();
        $isItemCreationDisabled = $isItemCreationDisabled();
        $isItemDeletionDisabled = $isItemDeletionDisabled();
        $isItemMovementDisabled = $isItemMovementDisabled();
        $columnWidths = $getColumnWidths();

        $hasActions = (! $isItemMovementDisabled) || (! $isItemDeletionDisabled) || $isCloneable;
    @endphp

    <div {{ $attributes->merge($getExtraAttributes())->class([
        'filament-table-repeater-component space-y-6 relative',
    ]) }}>

        <div @class([
            'filament-table-repeater-container rounded-xl bg-gray-50 md:border md:border-gray-300 relative',
            'dark:bg-gray-500/10 dark:border-gray-700' => config('forms.dark_mode'),
            'border border-gray-300' => count($containers) > 0,
        ]) style="--table-repeater-col-count: {{count($getHeaders())}}">
            <div @class([
                    'filament-table-repeater-row filament-table-repeater-header-row md:divide-x md:divide-gray-300 overflow-hidden',
                    'dark:md:divide-gray-700' => config('forms.dark_mode'),
                    'border-b border-gray-300 rounded-t-xl' => count($containers) > 0,
                    'rounded-xl' => count($containers) === 0,
                    'dark:border-gray-700' => config('forms.dark_mode') && count($containers) > 0,
                ])>
                @foreach ($getHeaders() as $header)
                    <div
                        @class([
                            'filament-table-repeater-header-column p-2 bg-gray-200/50 text-sm flex-1',
                            'dark:bg-gray-900/60' => config('forms.dark_mode')
                        ])
                        @if (filled($columnWidths[$loop->index]) && $columnWidths[$loop->index] !== 'auto')
                            style="max-width: {{ $columnWidths[$loop->index] }}"
                        @endif
                    >
                        {{ $header }}
                    </div>
                @endforeach
                @if ($hasActions)
                    <div @class([
                        'filament-table-repeater-header-column p-2 bg-gray-200/50 text-sm',
                        'dark:bg-gray-900/60' => config('forms.dark_mode')
                    ])>
                        <div class="flex items-center">
                            @unless ($isItemMovementDisabled)
                                <div class="w-8"></div>
                            @endunless

                            @if ($isCloneable)
                                <div class="w-8"></div>
                            @endunless

                            @unless ($isItemDeletionDisabled)
                                <div class="w-8"></div>
                            @endunless
                        </div>
                        <span class="sr-only">
                            {{ __('filament-table-repeater::components.repeater.row_actions.label') }}
                        </span>
                    </div>
                @endif
            </div>
            <ul wire:sortable
                wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
                @class([
                    'filament-table-repeater-rows-wrapper divide-y divide-gray-300',
                    'dark:divide-gray-700' => config('forms.dark_mode')
                ])
            >
                @if (count($containers))
                    @foreach ($containers as $uuid => $row)
                        <li
                            wire:key="{{ $this->id }}.{{ $row->getStatePath() }}.item"
                            wire:sortable.item="{{ $uuid }}"
                            @class([
                                'filament-table-repeater-row md:divide-x md:divide-gray-300',
                                'dark:md:divide-gray-700' => config('forms.dark_mode')
                            ])
                        >
                            @foreach($row->getComponents() as $cell)
                                @if(! $cell instanceof \Filament\Forms\Components\Hidden && ! $cell->isHidden())
                                    <div
                                        @class([
                                            'filament-table-repeater-column flex-1',
                                            'has-hidden-label' => $cell->isLabelHidden(),
                                        ])
                                        @if (filled($columnWidths[$loop->index]) && $columnWidths[$loop->index] !== 'auto')
                                            style="max-width: {{ $columnWidths[$loop->index] }}"
                                        @endif
                                    >
                                        {{ $cell }}
                                    </div>
                                @else
                                    {{ $cell }}
                                @endif
                            @endforeach

                            @if ($hasActions)
                                <div class="filament-table-repeater-column">
                                    <div class="flex items-center md:h-full">
                                        @unless ($isItemMovementDisabled)
                                            <button
                                                title="{{ __('forms::components.repeater.buttons.move_item.label') }}"
                                                x-on:click.stop
                                                wire:sortable.handle
                                                wire:keydown.prevent.arrow-up="dispatchFormEvent('repeater::moveItemUp', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                                wire:keydown.prevent.arrow-down="dispatchFormEvent('repeater::moveItemDown', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                                type="button"
                                                @class([
                                                    'flex items-center justify-center flex-none w-8 h-8 text-gray-400 transition hover:text-gray-500',
                                                    'dark:border-gray-700' => config('forms.dark_mode'),
                                                ])
                                            >
                                                    <span class="sr-only">
                                                        {{ __('forms::components.repeater.buttons.move_item.label') }}
                                                    </span>

                                                <x-heroicon-s-switch-vertical class="w-4 h-4"/>
                                            </button>
                                        @endunless

                                        @if ($isCloneable)
                                            <button
                                                title="{{ __('forms::components.repeater.buttons.clone_item.label') }}"
                                                wire:click="dispatchFormEvent('repeater::cloneItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                                type="button"
                                                @class([
                                                    'flex items-center justify-center flex-none w-8 h-8 text-gray-400 transition hover:text-gray-500',
                                                    'dark:border-gray-700' => config('forms.dark_mode'),
                                                ])
                                            >
                                                        <span class="sr-only">
                                                            {{ __('forms::components.repeater.buttons.clone_item.label') }}
                                                        </span>

                                                <x-heroicon-s-duplicate class="w-4 h-4"/>
                                            </button>
                                        @endunless

                                        @unless ($isItemDeletionDisabled)
                                            <button
                                                title="{{ __('forms::components.repeater.buttons.delete_item.label') }}"
                                                wire:click.stop="dispatchFormEvent('repeater::deleteItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                                type="button"
                                                @class([
                                                    'flex items-center justify-center flex-none w-8 h-8 text-danger-600 transition hover:text-danger-500',
                                                    'dark:text-danger-500 dark:hover:text-danger-400' => config('forms.dark_mode'),
                                                ])
                                            >
                                                        <span class="sr-only">
                                                            {{ __('forms::components.repeater.buttons.delete_item.label') }}
                                                        </span>

                                                <x-heroicon-s-trash class="w-4 h-4"/>
                                            </button>
                                        @endunless
                                    </div>
                                </div>
                            @endif

                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        @if (! $isItemCreationDisabled)
            <div class="relative flex justify-center">
                <x-forms::button
                    :wire:click="'dispatchFormEvent(\'repeater::createItem\', \'' . $getStatePath() . '\')'"
                    size="sm"
                    type="button"
                >
                    {{ $getCreateItemButtonLabel() }}
                </x-forms::button>
            </div>
        @endif
    </div>
</x-dynamic-component>
