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
        @include('dashboard.partials.sidebar')
        <main class="main-content flex-1 overflow-y-auto bg-[#F5F7FA] px-10 py-2">
            @yield('content')
        </main>
    </div>

    {{-- Script --}}
    @include('dashboard.partials.script')

    {{-- Additional Script --}}
    @yield('script')

    {{-- Alert Component --}}
    {{-- @include("components.alert") --}}
</body>

</html>
