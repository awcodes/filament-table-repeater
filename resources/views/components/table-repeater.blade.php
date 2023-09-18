<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $containers = $getChildComponentContainers();

        $addAction = $getAction($getAddActionName());
        $cloneAction = $getAction($getCloneActionName());
        $deleteAction = $getAction($getDeleteActionName());
        $moveDownAction = $getAction($getMoveDownActionName());
        $moveUpAction = $getAction($getMoveUpActionName());
        $reorderAction = $getAction($getReorderActionName());
        $isReorderableWithButtons = $isReorderableWithButtons();

        $headers = $getHeaders();
        $columnWidths = $getColumnWidths();
        $breakPoint = $getBreakPoint();
        $hasContainers = count($containers) > 0;
        $hasHiddenHeader = $shouldHideHeader();
        $statePath = $getStatePath();

        $emptyLabel = $getEmptyLabel();

        $hasActions = $reorderAction->isVisible() || $cloneAction->isVisible() || $deleteAction->isVisible() || $moveUpAction->isVisible() || $moveDownAction->isVisible();
    @endphp

    <div
        x-data="{}"
        {{ $attributes->merge($getExtraAttributes())->class([
            'filament-table-repeater-component space-y-6 relative',
            match ($breakPoint) {
                'sm' => 'break-point-sm',
                'lg' => 'break-point-lg',
                'xl' => 'break-point-xl',
                '2xl' => 'break-point-2xl',
                default => 'break-point-md',
            }
        ]) }}
    >
        @if (count($containers) || $emptyLabel !== false)
            <div @class([
                'filament-table-repeater-container rounded-xl relative ring-1 ring-gray-950/5 dark:ring-white/20',
                'sm:ring-gray-950/5 dark:sm:ring-white/20' => ! $hasContainers && $breakPoint === 'sm',
                'md:ring-gray-950/5 dark:md:ring-white/20' => ! $hasContainers && $breakPoint === 'md',
                'lg:ring-gray-950/5 dark:lg:ring-white/20' => ! $hasContainers && $breakPoint === 'lg',
                'xl:ring-gray-950/5 dark:xl:ring-white/20' => ! $hasContainers && $breakPoint === 'xl',
                '2xl:ring-gray-950/5 dark:2xl:ring-white/20' => ! $hasContainers && $breakPoint === '2xl',
            ])>
                <table class="w-full">
                    <thead @class([
                        'sr-only' => $hasHiddenHeader,
                        'filament-table-repeater-header rounded-t-xl overflow-hidden border-b border-gray-950/5 dark:border-white/20' => ! $hasHiddenHeader,
                    ])>
                        <tr class="text-xs md:divide-x md:divide-gray-950/5 dark:md:divide-white/20">
                            @foreach ($headers as $key => $header)
                                <th
                                    @class([
                                        'filament-table-repeater-header-column px-3 py-2 font-medium text-left bg-gray-100 dark:text-gray-300 dark:bg-gray-900/60',
                                        'ltr:rounded-tl-xl rtl:rounded-tr-xl' => $loop->first,
                                        'ltr:rounded-tr-xl rtl:rounded-tl-xl' => $loop->last && ! $hasActions,
                                    ])
                                    @if ($header['width'])
                                        style="width: {{ $header['width'] }}"
                                    @endif
                                >
                                    {{ $header['label'] }}
                                    @if ($header['required'])
                                        <span class="whitespace-nowrap">
                                            <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                                        </span>
                                    @endif
                                </th>
                            @endforeach
                            @if ($hasActions)
                                <th class="filament-table-repeater-header-column w-px ltr:rounded-tr-xl rtl:rounded-tl-xl p-2 bg-gray-100 dark:bg-gray-900/60">
                                    <div class="flex items-center md:justify-center">
                                        @if ($reorderAction->isVisible())
                                            <div class="w-8"></div>
                                        @endif

                                        @if ($isReorderableWithButtons)
                                            @if ($moveUpAction && count($containers) > 2)
                                                <div class="w-8"></div>
                                            @endif

                                            @if ($moveDownAction && count($containers) > 2)
                                                <div class="w-8"></div>
                                            @endif
                                        @endif

                                        @if ($cloneAction->isVisible())
                                            <div class="w-8"></div>
                                        @endif

                                        @if ($deleteAction->isVisible())
                                            <div class="w-8"></div>
                                        @endif

                                        <span class="sr-only">
                                            {{ __('filament-table-repeater::components.repeater.row_actions.label') }}
                                        </span>
                                    </div>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody
                        x-sortable
                        wire:end.stop="{{ 'mountFormComponentAction(\'' . $statePath . '\', \'reorder\', { items: $event.target.sortable.toArray() })' }}"
                        class="filament-table-repeater-rows-wrapper divide-y divide-gray-950/5 dark:divide-white/20"
                    >
                        @if (count($containers))
                            @foreach ($containers as $uuid => $row)
                                <tr
                                    wire:key="{{ $this->getId() }}.{{ $row->getStatePath() }}.{{ $field::class }}.item"
                                    x-sortable-item="{{ $uuid }}"
                                    class="filament-table-repeater-row md:divide-x md:divide-gray-950/5 dark:md:divide-white/20"
                                >
                                    @foreach($row->getComponents() as $cell)
                                        @if(! $cell instanceof \Filament\Forms\Components\Hidden && ! $cell->isHidden())
                                            <td
                                                @class([
                                                    'filament-table-repeater-column p-2',
                                                    'has-hidden-label' => $cell->isLabelHidden(),
                                                ])
                                                @php
                                                    $cellKey = method_exists($cell, 'getName') ? $cell->getName() : $cell->getId();
                                                @endphp
                                                @if (
                                                    $columnWidths &&
                                                    isset($columnWidths[$cellKey])
                                                )
                                                    style="width: {{ $columnWidths[$cellKey] }}"
                                                @endif
                                            >
                                                {{ $cell }}
                                            </td>
                                        @else
                                            {{ $cell }}
                                        @endif
                                    @endforeach

                                    @if ($hasActions)
                                        <td class="filament-table-repeater-column p-2 w-px">
                                            <div class="flex items-center md:justify-center">
                                                @if ($reorderAction->isVisible())
                                                    <div x-sortable-handle>
                                                        {{ $reorderAction }}
                                                    </div>
                                                @endif

                                                @if ($isReorderableWithButtons)
                                                    @if (! $loop->first)
                                                        {{ $moveUpAction(['item' => $uuid]) }}
                                                    @endif

                                                    @if (! $loop->last)
                                                        {{ $moveDownAction(['item' => $uuid]) }}
                                                    @endif
                                                @endif

                                                @if ($cloneAction->isVisible())
                                                    {{ $cloneAction(['item' => $uuid]) }}
                                                @endif

                                                @if ($deleteAction->isVisible())
                                                    {{ $deleteAction(['item' => $uuid]) }}
                                                @endif
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        @else
                            <tr class="filament-table-repeater-row filament-table-repeater-empty-row md:divide-x md:divide-gray-950/5 dark:md:divide-divide-white/20">
                                <td colspan="{{ count($headers) + intval($hasActions) }}" class="filament-table-repeater-column filament-table-repeater-empty-column p-4 w-px text-center italic">
                                    {{ $emptyLabel ?: __('filament-table-repeater::components.repeater.empty.label') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endif

        @if ($addAction->isVisible())
            <div class="relative flex justify-center">
                {{ $addAction }}
            </div>
        @endif
    </div>
</x-dynamic-component>
