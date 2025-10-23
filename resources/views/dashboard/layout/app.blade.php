<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Header --}}
    @include('dashboard.partials.header')

    {{-- Additional Style --}}
    @yield('style')
</head>

<body class="font-plusJakartaSans">
    <div class="flex h-screen w-full select-none">
        {{-- Sidebar --}}
        @include('dashboard.partials.sidebar')

        {{-- Navbar Atas Section Kanan --}}
        <div class="flex-1 flex flex-col">
            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto bg-[#F5F7FA] px-10 py-2 transition duration-500 ease-in-out">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Script --}}
    @include('dashboard.partials.script')

    {{-- Additional Script --}}
    @yield('script')

    {{-- Alert Component --}}
    {{-- @include("components.alert") --}}
</body>

</html>
