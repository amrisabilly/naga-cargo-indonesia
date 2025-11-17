{{-- filepath: c:\laragon\www\project-dropshiper\dropshiper\resources\views\dashboard\kurir\edit.blade.php --}}
@extends('dashboard.layout.app', [
    'title' => 'Edit Akun Kurir',
])

@section('style')
@endsection
{{-- @dd($kurir); --}}

@section('content')
    <section class="flex w-full pt-10">
        <div class="flex flex-col w-full">
            <div class="w-full">
                <div class="flex items-start gap-7 mb-8">
                    {{-- Tombol kembali --}}
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg bg-[#4A90E2] hover:bg-[#357ABD] text-white text-base font-semibold shadow transition-colors"
                        title="Kembali">
                        <i class="bx bx-arrow-back text-xl mr-1"></i>
                    </a>
                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-gray-900">Edit Akun Kurir</h1>
                        <p class="mt-1 text-base text-gray-500">Kelola data kurir</p>
                    </div>
                </div>
                <div class="bg-white py-6 px-8 rounded-lg shadow-sm">
                    <form id="formKurir" action="{{ route('dashboard.data-kurir.update', $kurir->id_user) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" required value="{{ $kurir->nama }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Masukkan nama lengkap">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="username" name="username" required value="{{ $kurir->username }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Masukkan username">
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-gray-400">(kosongkan jika tidak ingin mengubah)</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base pr-12"
                                        placeholder="Masukkan password baru">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i id="passwordIcon" class="bx bx-hide text-gray-400 text-xl"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No. Telepon -->
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="no_hp" name="no_hp" required value="{{ $kurir->no_hp }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Masukkan nomor telepon">
                                @error('no_hp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Daerah dengan Search -->
                            <div class="relative">
                                <label for="daerah_search" class="block text-sm font-medium text-gray-700 mb-2">
                                    Daerah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="daerah_search" autocomplete="off" required
                                    value="{{ $kurir->daerah->nama ?? '' }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Cari dan pilih daerah...">
                                <input type="hidden" id="id_daerah" name="id_daerah" required
                                    value="{{ $kurir->id_daerah }}">

                                <!-- Dropdown daerah -->
                                <div id="daerah_dropdown"
                                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                    <ul id="daerah_list" class="divide-y divide-gray-100">
                                        <!-- Options akan diisi via JavaScript -->
                                    </ul>
                                </div>
                                @error('id_daerah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Aktif"
                                            {{ $kurir->status == 'Aktif' ? 'checked' : '' }}
                                            class="form-radio h-5 w-5 text-[#4A90E2] focus:ring-[#4A90E2] border-gray-300">
                                        <span class="ml-2 text-base text-gray-700">Aktif</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Nonaktif"
                                            {{ $kurir->status == 'Nonaktif' ? 'checked' : '' }}
                                            class="form-radio h-5 w-5 text-[#4A90E2] focus:ring-[#4A90E2] border-gray-300">
                                        <span class="ml-2 text-base text-gray-700">Nonaktif</span>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden field untuk role -->
                        <input type="hidden" name="role" value="kurir">

                        <!-- Tombol Action -->
                        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard.data-kurir.index') }}"
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 text-base font-medium">
                                <i class="bx bx-x mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-[#4A90E2] text-white rounded-lg hover:bg-[#5667d4] focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2 transition-colors duration-200 text-base font-medium">
                                <i class="bx bx-save mr-2"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tampilkan error validasi backend (Laravel) dalam bentuk Swal toast
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @if (strpos($error, 'username') !== false)
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Username sudah digunakan, silakan pilih username lain!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                @else
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: @json($error),
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                @endif
            @endforeach
        @endif

        // Data daerah dari controller (ganti array hardcode dengan data dinamis jika sudah siap)
        const daftarDaerah = @json($daerah);

        const daerahSearch = document.getElementById('daerah_search');
        const daerahDropdown = document.getElementById('daerah_dropdown');
        const daerahList = document.getElementById('daerah_list');
        const idDaerahHidden = document.getElementById('id_daerah');

        // Render daftar daerah
        function renderDaerahList(daftarFilter = daftarDaerah, keyword = '') {
            daerahList.innerHTML = '';

            if (daftarFilter.length === 0) {
                daerahList.innerHTML = '<li class="px-4 py-3 text-gray-500 text-sm">Tidak ada daerah yang ditemukan</li>';
                return;
            }

            daftarFilter.forEach(daerah => {
                const li = document.createElement('li');
                li.className =
                    'px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 transition-colors duration-150';

                // Highlight kata yang cocok
                if (keyword) {
                    const regex = new RegExp(`(${keyword})`, 'gi');
                    li.innerHTML = daerah.nama.replace(regex, '<mark class="bg-yellow-200 font-medium">$1</mark>');
                } else {
                    li.textContent = daerah.nama;
                }

                // Gunakan onmousedown agar tidak bentrok dengan blur
                li.onmousedown = function() {
                    daerahSearch.value = daerah.nama;
                    idDaerahHidden.value = daerah.id_daerah;
                    daerahDropdown.classList.add('hidden');
                    daerahSearch.classList.remove('border-red-500');
                };

                daerahList.appendChild(li);
            });
        }

        // Filter daerah berdasarkan input
        function filterDaerah(keyword) {
            if (!keyword.trim()) {
                renderDaerahList();
                return;
            }

            const hasil = daftarDaerah.filter(daerah =>
                daerah.nama.toLowerCase().includes(keyword.toLowerCase())
            );

            renderDaerahList(hasil, keyword);
        }

        // Event listeners untuk daerah search
        daerahSearch.addEventListener('input', function() {
            const keyword = this.value.trim();
            idDaerahHidden.value = ''; // Reset hidden value saat mengetik
            filterDaerah(keyword);
            daerahDropdown.classList.remove('hidden');
        });

        daerahSearch.addEventListener('focus', function() {
            filterDaerah(this.value);
            daerahDropdown.classList.remove('hidden');
        });

        daerahSearch.addEventListener('blur', function() {
            setTimeout(() => {
                daerahDropdown.classList.add('hidden');
            }, 150);
        });

        // Keyboard navigation
        let currentIndex = -1;
        daerahSearch.addEventListener('keydown', function(e) {
            const items = daerahList.querySelectorAll('li');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentIndex = Math.min(currentIndex + 1, items.length - 1);
                updateActiveItem(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentIndex = Math.max(currentIndex - 1, -1);
                updateActiveItem(items);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentIndex >= 0 && items[currentIndex]) {
                    items[currentIndex].dispatchEvent(new Event('mousedown'));
                    currentIndex = -1;
                }
            } else if (e.key === 'Escape') {
                daerahDropdown.classList.add('hidden');
                currentIndex = -1;
            }
        });

        function updateActiveItem(items) {
            items.forEach((item, idx) => {
                if (idx === currentIndex) {
                    item.classList.add('bg-blue-100');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('bg-blue-100');
                }
            });
        }

        // Render initial list
        renderDaerahList();

        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.className = 'bx bx-show text-gray-400 text-xl';
            } else {
                passwordField.type = 'password';
                passwordIcon.className = 'bx bx-hide text-gray-400 text-xl';
            }
        }

        // Form validation untuk edit
        document.getElementById('formKurir').addEventListener('submit', function(e) {
            const requiredFields = ['nama', 'username', 'no_hp'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                    input.focus();
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            // Validasi khusus untuk daerah
            const idDaerahHidden = document.getElementById('id_daerah');
            const daerahSearch = document.getElementById('daerah_search');
            if (!idDaerahHidden.value) {
                isValid = false;
                daerahSearch.classList.add('border-red-500');
                daerahSearch.focus();
            }

            // Validasi nomor HP harus diawali 08 dan hanya angka (10-13 digit)
            const noHp = document.getElementById('no_hp').value.trim();
            const hpRegex = /^08[0-9]{8,11}$/;
            if (!hpRegex.test(noHp)) {
                isValid = false;
                document.getElementById('no_hp').classList.add('border-red-500');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Nomor HP harus diawali 08 dan 10-13 digit angka!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
                document.getElementById('no_hp').focus();
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Mohon lengkapi semua field yang wajib diisi!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            }
        });

        // Remove error styling when user types
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    </script>
@endsection
