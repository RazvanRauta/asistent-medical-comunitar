@props([
    'maxContentWidth' => null,
])

<x-filament::layouts.base :title="$title">
    <div class="flex w-full min-h-screen filament-app-layout overflow-x-clip">
        <div
            x-data="{}"
            class="flex flex-col flex-1 w-screen h-screen filament-main rtl:lg:pl-0"
        >
            <x-filament::topbar />

            <div class="relative flex flex-1 w-full">
                <div
                    x-data="{}"
                    x-cloak
                    x-show="$store.sidebar.isOpen"
                    x-transition.opacity.500ms
                    x-on:click="$store.sidebar.close()"
                    class="fixed inset-0 z-20 w-full h-full filament-sidebar-close-overlay bg-gray-900/50 lg:hidden"
                ></div>

                <x-layouts.app.sidebar :navigation="$navigation" />

                <div class="flex flex-col flex-1">
                    <div @class([
                        'filament-main-content mt-6 flex-1 w-full px-4 mx-auto md:px-6 lg:px-8',
                        match (
                        ($maxContentWidth ??= config('filament.layout.sidebar_max_content_width'))
                        ) {
                            null, '7xl', '' => 'max-w-7xl',
                            'xl' => 'max-w-xl',
                            '2xl' => 'max-w-2xl',
                            '3xl' => 'max-w-3xl',
                            '4xl' => 'max-w-4xl',
                            '5xl' => 'max-w-5xl',
                            '6xl' => 'max-w-6xl',
                            'full' => 'max-w-full',
                            default => $maxContentWidth,
                        },
                    ])>

                        <x-filament::layouts.app.topbar.breadcrumbs :breadcrumbs="$breadcrumbs" />

                        {{ \Filament\Facades\Filament::renderHook('content.start') }}

                        {{ $slot }}

                        {{ \Filament\Facades\Filament::renderHook('content.end') }}
                    </div>

                    <div class="py-4 filament-main-footer shrink-0">
                        <x-filament::footer />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::layouts.base>