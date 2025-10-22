{{-- filepath: c:\laragon\www\project-dropshiper\dropshiper\resources\views\dashboard\partials\sidebar.blade.php --}}
<nav class="flex w-56 flex-col items-center bg-white pt-5 pl-10 pr-6 border-r-2 border-[#E6EFF5]">
    {{-- LOGO PERUSAHAAN --}}
    <img src="{{ asset('assets/images/dashboard/logo-cargo.png') }}" alt="">

    {{-- LIST MENU --}}
    <ul class="mt-10 overflow-y-auto overflow-x-hidden text-gray-700 dark:text-gray-400 space-y-8">
        <!-- Dashboard -->
        <li
            class="{{ Request::is('/') || Request::is('dashboard') ? 'bg-[#879FFF] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('index') }}"
                class="flex flex-row items-center duration-700 {{ Request::is('/') || Request::is('dashboard') ? 'text-white' : 'text-gray-700 hover:text-[#879FFF]' }}">
                <i
                    class="bx bx-home-alt {{ Request::is('/') || Request::is('dashboard') ? 'text-white' : 'text-gray-700' }} mr-2 text-xl"></i>
                <span class="ml-4 text-lg font-bold leading-5">Dashboard</span>
            </a>
        </li>
        <!-- Data Pengiriman -->
        <li class="{{ Request::is('dashboard/data-pengiriman*') ? 'bg-[#879FFF] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('dashboard.data-pengiriman.index') }}"
                class="flex flex-row items-center duration-700 {{ Request::is('dashboard/data-pengiriman*') ? 'text-white' : 'text-gray-700 hover:text-[#879FFF]' }}">
                <i
                    class="bx bx-package {{ Request::is('dashboard/data-pengiriman*') ? 'text-white' : 'text-gray-700' }} mr-2 text-xl "></i>
                <span class="ml-4 text-lg font-bold leading-5">Data Pengiriman</span>
            </a>
        </li>
        <!-- Data Pengguna -->
        <li class="{{ Request::is('dashboard/data-pengguna*') ? 'bg-[#879FFF] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('dashboard.data-pengguna.index') }}"
                class="flex flex-row items-center duration-700 {{ Request::is('dashboard/data-pengguna*') ? 'text-white' : 'text-gray-700 hover:text-[#879FFF]' }}">
                <i
                    class="bx bx-user {{ Request::is('dashboard/data-pengguna*') ? 'text-white' : 'text-gray-700' }} mr-2 text-xl"></i>
                <span class="ml-4 text-lg font-bold leading-5">Data Kurir</span>
            </a>
        </li>
        <!-- Logout -->
        <li class="dark-hover:text-blue-300 mt-20 rounded-lg p-2">
            <form action="" method="POST">
                @csrf
                <button type="submit"
                    class="fixed bottom-5 left-14 flex items-center gap-2 rounded-full bg-slate-100 px-6 py-2 hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-red-300 text-black">
                    <i class="bx bx-log-out text-lg"></i>
                    <span class="text-center text-base">Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</nav>
