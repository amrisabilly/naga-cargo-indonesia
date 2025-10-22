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
            <nav class="flex items-center justify-end  px-10 py-4 bg-white border-b-2 border-[#E6EFF5]">
                
                    {{-- Setting --}}
                    <div class="flex items-center justify-center bg-[#F5F7FA] mr-6 rounded-full h-12 w-12">
                        <a href="" class="flex items-center justify-center h-8 w-8">
                            <i class="bx bx-cog text-2xl text-gray-600"></i>
                        </a>
                    </div>
                    {{-- Notifikasi --}}
                    <div class="flex items-center justify-center bg-[#F5F7FA] mr-6 rounded-full h-12 w-12">
                        <button class="relative flex items-center justify-center h-8 w-8">
                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1 right-1 inline-block h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                    {{-- Foto Profil Admin --}}
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/dashboard/profile.png') }}" alt="Admin"
                            class="h-10 w-10 rounded-full object-cover border border-gray-300">
                        <div>
                            <span class="block text-sm font-semibold text-gray-800">Admin</span>
                            <span class="block text-xs text-gray-500">Super Admin</span>
                        </div>
                    </div>
                
            </nav>
            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto bg-[#F5F7FA] px-10 transition duration-500 ease-in-out">
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
