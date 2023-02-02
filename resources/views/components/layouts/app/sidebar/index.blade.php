@props([
    'navigation' => [],
])

<aside
    x-data="{}"
    @if (config('filament.layout.sidebar.is_collapsible_on_desktop')) x-cloak
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0 max-w-[20em] lg:max-w-[var(--sidebar-width)]' : '-translate-x-full lg:translate-x-0 lg:max-w-[var(--collapsed-sidebar-width)] rtl:lg:-translate-x-0 rtl:translate-x-full'"
    @else
        x-cloak="-lg"
        x-bind:class="$store.sidebar.isOpen ? 'filament-sidebar-open translate-x-0' : '-translate-x-full lg:translate-x-0 rtl:lg:-translate-x-0 rtl:translate-x-full'" @endif
    @class([
        'filament-sidebar relative inset-y-0 left-0 rtl:left-auto rtl:right-0 z-20 flex flex-col h-full overflow-hidden shadow-2xl transition-all bg-white lg:border-r rtl:lg:border-r-0 rtl:lg:border-l w-[var(--sidebar-width)] lg:z-0',
        'lg:translate-x-0' => !config(
            'filament.layout.sidebar.is_collapsible_on_desktop'),
        'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
    ])
>
    <nav class="flex-1 py-6 overflow-x-hidden overflow-y-auto filament-sidebar-nav">
        <x-layouts.app.sidebar.start />
        {{ \Filament\Facades\Filament::renderHook('sidebar.start') }}

        <ul class="px-6 space-y-6">
            @foreach ($navigation as $group)
                <x-layouts.app.sidebar.group
                    :label="$group->getLabel()"
                    :icon="$group->getIcon()"
                    :collapsible="$group->isCollapsible()"
                    :items="$group->getItems()"
                />

                @if (!$loop->last)
                    <li>
                        <div @class([
                            'border-t -mr-6 rtl:-mr-auto rtl:-ml-6',
                            'dark:border-gray-700' => config('filament.dark_mode'),
                        ])></div>
                    </li>
                @endif
            @endforeach
        </ul>

        <x-layouts.app.sidebar.end />
        {{ \Filament\Facades\Filament::renderHook('sidebar.end') }}
    </nav>

    <x-layouts.app.sidebar.footer />
</aside>