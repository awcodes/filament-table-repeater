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

        $hasActions = (! $isItemMovementDisabled) || (! $isItemDeletionDisabled) || $isCloneable;
    @endphp

    <div {{ $attributes->merge($getExtraAttributes())->class([
        'filament-table-repeater-component space-y-6',
    ]) }}>

        <div @class([
            'rounded-xl border border-gray-200 overflow-y-hidden overflow-x-auto bg-gray-50',
            'dark:bg-gray-500/10 dark:border-gray-700' => config('forms.dark_mode'),
        ])>
            <table class="min-w-full -mb-px">
                <thead>
                <tr @class([
                            'divide-x divide-gray-200 border-b border-gray-200',
                            'dark:divide-gray-700 dark:border-gray-700' => config('forms.dark_mode'),
                        ])>
                    @foreach ($getHeaders() as $header)
                        <th
                            @class([
                                'py-2 px-2 text-left rtl:text-right bg-gray-100 text-sm min-w-[175px]',
                                'dark:bg-gray-900/60' => config('forms.dark_mode')
                        ])>{{ $header }}</th>
                    @endforeach
                    @if ($hasActions)
                        <th @class([
                                    'py-2 px-2 text-left rtl:text-right bg-gray-100 text-sm',
                                    'dark:bg-gray-900/60' => config('forms.dark_mode')
                            ])>
                            <span class="sr-only">{{ __('filament-table-repeater::components.repeater.row_actions.label') }}</span>
                        </th>
                    @endif
                </tr>
                </thead>
                <tbody
                    wire:sortable
                    wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
                >
                @if (count($containers))
                    @foreach ($containers as $uuid => $row)
                        <tr
                            wire:key="{{ $this->id }}.{{ $row->getStatePath() }}.item"
                            wire:sortable.item="{{ $uuid }}"
                            @class([
                                'divide-x divide-gray-200 border-b border-gray-200',
                                'dark:divide-gray-700 dark:border-gray-700' => config('forms.dark_mode'),
                            ])
                        >
                            @foreach($row->getComponents() as $cell)
                                @if(! $field instanceof \Filament\Forms\Components\Hidden && ! $field->isHidden())
                                    <td class="p-2">
                                        {{ $cell }}
                                    </td>
                                @else
                                    {{ $cell }}
                                @endif
                            @endforeach

                            @if ($hasActions)
                                <td class="p-2 w-px">
                                    <div class="flex items-center">
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
                                </td>
                            @endif

                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
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
