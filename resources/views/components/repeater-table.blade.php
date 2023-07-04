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

        $hasActions = $reorderAction || $moveUpAction || $moveDownAction || $cloneAction || $deleteAction;
    @endphp

    <div
        x-data="{}"
        x-load-css="['{{ asset('css/awcodes/filament-table-repeater/filament-table-repeater.css') }}']"
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

        <div @class([
            'filament-table-repeater-container rounded-xl bg-gray-50 relative dark:bg-gray-500/10',
            'border border-gray-300 dark:border-gray-700' => $hasContainers,
            'sm:border sm:border-gray-300 dark:sm:border-gray-700' => ! $hasContainers && $breakPoint === 'sm',
            'md:border md:border-gray-300 dark:md:border-gray-700' => ! $hasContainers && $breakPoint === 'md',
            'lg:border lg:border-gray-300 dark:lg:border-gray-700' => ! $hasContainers && $breakPoint === 'lg',
            'xl:border xl:border-gray-300 dark:xl:border-gray-700' => ! $hasContainers && $breakPoint === 'xl',
            '2xl:border 2xl:border-gray-300 dark:2xl:border-gray-700' => ! $hasContainers && $breakPoint === '2xl',
        ])>
            <table class="w-full">
                <thead @class([
                    'sr-only' => $hasHiddenHeader,
                    'filament-table-repeater-header rounded-t-xl overflow-hidden' => ! $hasHiddenHeader,
                    'border-b border-gray-300 dark:border-gray-700' => ! $hasHiddenHeader,
                ])>
                    <tr class="md:divide-x md:rtl:divide-x-reverse md:divide-gray-300 dark:md:divide-gray-700 text-sm">
                        @foreach ($headers as $key => $header)
                            <th
                                @class([
                                    'filament-table-repeater-header-column px-3 py-2 font-medium text-left text-gray-600 dark:text-gray-300 bg-gray-200/50 dark:bg-gray-900/60',
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
                            <th class="filament-table-repeater-header-column p-2 bg-gray-200/50 dark:bg-gray-900/60 w-px ltr:rounded-tr-xl rtl:rounded-tl-xl">
                                <div class="flex items-center md:justify-center">
                                    @if ($reorderAction)
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

                                    @if ($cloneAction)
                                        <div class="w-8"></div>
                                    @endif

                                    @if ($deleteAction)
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
                    class="filament-table-repeater-rows-wrapper divide-y divide-gray-300 dark:divide-gray-700"
                >
                    @if (count($containers))
                        @foreach ($containers as $uuid => $row)
                            <tr
                                wire:key="{{ $this->id }}.{{ $row->getStatePath() }}.{{ $field::class }}.item"
                                x-sortable-item="{{ $uuid }}"
                                class="filament-table-repeater-row md:divide-x md:rtl:divide-x-reverse md:divide-gray-300 dark:md:divide-gray-700"
                            >
                                @foreach($row->getComponents() as $cell)
                                    @if(! $cell instanceof \Filament\Forms\Components\Hidden && ! $cell->isHidden())
                                        <td
                                            @class([
                                                'filament-table-repeater-column p-2',
                                                'has-hidden-label' => $cell->isLabelHidden(),
                                            ])
                                            @if ($columnWidths && isset($columnWidths[$cell->getName()]))
                                                style="width: {{ $columnWidths[$cell->getName()] }}"
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
                                            @if ($reorderAction)
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

                                            @if ($cloneAction)
                                                {{ $cloneAction(['item' => $uuid]) }}
                                            @endif

                                            @if ($deleteAction)
                                                {{ $deleteAction(['item' => $uuid]) }}
                                            @endif
                                        </div>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    @else
                        <tr class="filament-table-repeater-row md:divide-x md:rtl:divide-x-reverse md:divide-gray-300 dark:md:divide-gray-700">
                            <td colspan="{{ count($headers) + intval($hasActions) }}" class="filament-table-repeater-column p-4 w-px text-center italic">
                                {{ $getEmptyLabel() ?? __('filament-table-repeater::components.repeater.empty.label') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($addAction)
            <div class="relative flex justify-center">
                {{ $addAction }}
            </div>
        @endif
    </div>
</x-dynamic-component>
