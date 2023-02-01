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
        $headers = $getHeaders();
        $columnWidths = $getColumnWidths();
        $breakPoint = $getBreakPoint();

        $hasActions = (! $isItemMovementDisabled) || (! $isItemDeletionDisabled) || $isCloneable;
    @endphp

    <div {{ $attributes->merge($getExtraAttributes())->class([
        'filament-table-repeater-component space-y-6 relative',
        match ($breakPoint) {
            'sm' => 'break-point-sm',
            'lg' => 'break-point-lg',
            'xl' => 'break-point-xl',
            '2xl' => 'break-point-2xl',
            default => 'break-point-md',
        }
    ]) }}>

        <div @class([
            'filament-table-repeater-container rounded-xl overflow-hidden bg-gray-50 relative dark:bg-gray-500/10',
            'border border-gray-300 dark:border-gray-700' => count($containers) > 0,
            'sm:border sm:border-gray-300 dark:sm:border-gray-700' => count($containers) === 0 && $breakPoint === 'sm',
            'md:border md:border-gray-300 dark:md:border-gray-700' => count($containers) === 0 && $breakPoint === 'md',
            'lg:border lg:border-gray-300 dark:lg:border-gray-700' => count($containers) === 0 && $breakPoint === 'lg',
            'xl:border xl:border-gray-300 dark:xl:border-gray-700' => count($containers) === 0 && $breakPoint === 'xl',
            '2xl:border 2xl:border-gray-300 dark:2xl:border-gray-700' => count($containers) === 0 && $breakPoint === '2xl',
        ])>
            <table class="w-full">
                <thead @class([
                    'filament-table-repeater-header bg-gray-200/50 dark:bg-gray-900/60',
                    'border-b border-gray-300 dark:border-gray-700' => count($containers) > 0,
                ])>
                    <tr class="md:divide-x md:rtl:divide-x-reverse md:divide-gray-300 dark:md:divide-gray-700 text-sm">
                        @foreach ($headers as $key => $header)
                            <th
                                class="filament-table-repeater-header-column p-2 text-left"
                                @if ($columnWidths && isset($columnWidths[$key]))
                                    style="width: {{ $columnWidths[$key] }}"
                                @endif
                            >
                                {{ $header }}
                            </th>
                        @endforeach
                        @if ($hasActions)
                            <th class="filament-table-repeater-header-column p-2 w-px">
                                <span class="sr-only">
                                    {{ __('filament-table-repeater::components.repeater.row_actions.label') }}
                                </span>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody
                    wire:sortable
                    wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
                    class="filament-table-repeater-rows-wrapper divide-y divide-gray-300 dark:divide-gray-700"
                >
                    @if (count($containers))
                        @foreach ($containers as $uuid => $row)
                            <tr
                                wire:key="{{ $this->id }}.{{ $row->getStatePath() }}.item"
                                wire:sortable.item="{{ $uuid }}"
                                @class([
                                    'filament-table-repeater-row md:divide-x md:rtl:divide-x-reverse md:divide-gray-300',
                                    'dark:md:divide-gray-700' => config('forms.dark_mode')
                                ])
                            >
                                @foreach($row->getComponents() as $cell)
                                    @if(! $cell instanceof \Filament\Forms\Components\Hidden && ! $cell->isHidden())
                                        <td
                                            @class([
                                                'filament-table-repeater-column p-2',
                                                'has-hidden-label' => $cell->isLabelHidden(),
                                            ])
                                        >
                                            {{ $cell }}
                                        </td>
                                    @else
                                        {{ $cell }}
                                    @endif
                                @endforeach

                                @if ($hasActions)
                                    <td class="filament-table-repeater-column p-2">
                                        <div class="flex items-center md:justify-center">
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

                                                    <x-heroicon-s-switch-vertical class="w-5 h-5 md:!w-4 md:!h-4"/>
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

                                                    <x-heroicon-s-duplicate class="w-5 h-5 md:!w-4 md:!h-4"/>
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

                                                    <x-heroicon-s-trash class="w-5 h-5 md:!w-4 md:!h-4"/>
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
