{{-- filepath: c:\laragon\www\project-dropshiper\dropshiper\resources\views\dashboard\partials\sidebar.blade.php --}}
<nav id="sidebar"
    class="flex-shrink-0 w-56 flex flex-col items-center bg-white pt-5 pl-10 pr-6 border-r-2 border-[#E6EFF5]">
    {{-- LOGO PERUSAHAAN --}}
    <div class="flex justify-between items-center gap-5">
        <h1 id="logoText" class="text-3xl font-extrabold"><span class="bg-[#4A90E2] text-white px-2">CAR</span><span
                class="italic text-[#122F50]">GO</span></h1>
        {{-- Hamburger Menu --}}
        <i id="hamburgerMenu"
            class="bx bx-menu text-[28px] text-[#122F50] cursor-pointer hover:bg-gray-100 p-1 rounded"></i>
    </div>

    {{-- LIST MENU --}}
    <ul class="mt-10 overflow-y-auto overflow-x-hidden text-gray-700 dark:text-gray-400 space-y-8">
        <!-- Dashboard -->
        <li
            class="{{ Request::is('/') || Request::is('dashboard') ? 'bg-[#4A90E2] rounded-xl' : '' }} mt-1 rounded-lg px-3 py-2">
            <a href="{{ route('index') }}"
                class="group flex flex-row items-center duration-700 {{ Request::is('/') || Request::is('dashboard') ? 'text-white' : 'text-gray-700 hover:text-[#4A90E2]' }}">
                <i
                    class="bx bx-home-alt {{ Request::is('/') || Request::is('dashboard') ? 'text-white' : 'text-gray-700 group-hover:text-[#4A90E2]' }} text-xl transition-colors duration-300"></i>
                <span class="ml-2 text-base font-bold leading-5 menu-text">Dashboard</span>
            </a>
        </li>
        <!-- Data Pengiriman -->
        <li
            class="{{ Request::is('dashboard/daerah*') || Request::is('dashboard/data-pengiriman*') ? 'bg-[#4A90E2] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('dashboard.daerah') }}"
                class="group flex flex-row items-center duration-700 {{ Request::is('dashboard/daerah*') || Request::is('dashboard/data-pengiriman*') ? 'text-white' : 'text-gray-700 hover:text-[#4A90E2]' }}">
                <i
                    class="bx bx-package {{ Request::is('dashboard/daerah*') || Request::is('dashboard/data-pengiriman*') ? 'text-white' : 'text-gray-700 group-hover:text-[#4A90E2]' }} text-xl transition-colors duration-300"></i>
                <span class="ml-2 text-base font-bold leading-5 menu-text">Pengiriman</span>
            </a>
        </li>
        <!-- Data Kurir -->
        <li class="{{ Request::is('dashboard/data-kurir*') ? 'bg-[#4A90E2] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('dashboard.data-kurir.index') }}"
                class="group flex flex-row items-center duration-700 {{ Request::is('dashboard/data-kurir*') ? 'text-white' : 'text-gray-700 hover:text-[#4A90E2]' }}">
                <i
                    class="bx bx-user {{ Request::is('dashboard/data-kurir*') ? 'text-white' : 'text-gray-700 group-hover:text-[#4A90E2]' }} text-xl transition-colors duration-300"></i>
                <span class="ml-2 text-base font-bold leading-5 menu-text">Data Kurir</span>
            </a>
        </li>
        <!-- Data PIC -->
        <li class="{{ Request::is('dashboard/data-pic*') ? 'bg-[#4A90E2] rounded-xl' : '' }} mt-1 rounded-lg p-2">
            <a href="{{ route('dashboard.data-pic.index') }}"
                class="group flex flex-row items-center duration-700 {{ Request::is('dashboard/data-pic*') ? 'text-white' : 'text-gray-700 hover:text-[#4A90E2]' }}">
                <i
                    class="bx bx-user-check {{ Request::is('dashboard/data-pic*') ? 'text-white' : 'text-gray-700 group-hover:text-[#4A90E2]' }} text-xl transition-colors duration-300"></i>
                <span class="ml-2 text-base font-bold leading-5 menu-text">Data <span class="italic">PIC</span></span>
            </a>
        </li>
        {{-- Daerah --}}
        <!-- Logout -->
        <li class="dark-hover:text-blue-300 mt-20 rounded-lg p-2">
            <form action="" method="POST">
                @csrf
                <button type="submit" id="logoutBtn"
                    class="group fixed bottom-5 left-14 flex items-center gap-2 rounded-full bg-slate-100 px-6 py-2 hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4A90E2] text-black">
                    <i class="bx bx-log-out text-lg group-hover:text-[#4A90E2] transition-colors duration-300"></i>
                    <span
                        class="text-center text-base menu-text group-hover:text-[#4A90E2] transition-colors duration-300">Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</nav>

<style>
    /* Sidebar collapsed state */
    #sidebar.collapsed {
        width: 80px;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    /* Hide text when collapsed */
    #sidebar.collapsed .menu-text,
    #sidebar.collapsed #logoText {
        display: none;
    }

    /* Center items when collapsed */
    #sidebar.collapsed li {
        display: flex;
        justify-content: center;
    }

    #sidebar.collapsed a {
        justify-content: center;
    }

    /* Adjust logout button when collapsed */
    #sidebar.collapsed #logoutBtn {
        left: 1.5rem;
        width: 48px;
        height: 48px;
        padding: 0;
        justify-content: center;
    }

    /* Adjust hamburger position when collapsed */
    #sidebar.collapsed #hamburgerMenu {
        margin: 0 auto;
    }

    #sidebar.collapsed .flex.justify-between {
        justify-content: center;
    }



    /* Hide text in collapsed logout button */
    #sidebar.collapsed #logoutBtn span {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const mainContent = document.querySelector('.main-content') || document.querySelector('main') ||
            document.body;

        // Fungsi untuk mengetahui state sidebar
        window.isSidebarOpen = function() {
            return !sidebar.classList.contains('collapsed');
        };

        // Baca state dari localStorage
        const sidebarState = localStorage.getItem('sidebarCollapsed');
        const isCollapsed = sidebarState === 'true';

        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            if (mainContent) {
                mainContent.classList.remove('sidebar-collapsed');
            }
        } else {
            sidebar.classList.remove('collapsed');
            if (mainContent) {
                mainContent.classList.add('sidebar-collapsed');
            }
        }

        // Toggle hanya lewat hamburger menu
        hamburgerMenu.addEventListener('click', function() {
            const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');

            if (isCurrentlyCollapsed) {
                // Buka sidebar
                sidebar.classList.remove('collapsed');
                if (mainContent) {
                    mainContent.classList.add('sidebar-collapsed');
                }
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                // Tutup sidebar
                sidebar.classList.add('collapsed');
                if (mainContent) {
                    mainContent.classList.remove('sidebar-collapsed');
                }
                localStorage.setItem('sidebarCollapsed', 'true');
            }

            // Contoh penggunaan:
            // console.log('Sidebar terbuka?', isSidebarOpen());
        });

        // Anda bisa gunakan window.isSidebarOpen() di mana saja untuk cek state sidebar
    });
</script>
