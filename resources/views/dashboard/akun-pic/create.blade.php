@extends('dashboard.layout.app', [
    'title' => 'Create Akun PIC',
])

@section('style')
@endsection

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
                        <h1 class="text-3xl font-bold text-gray-900">Tambah Akun PIC</h1>
                        <p class="mt-1 text-base text-gray-500">Kelola data PIC (Person In Charge)</p>
                    </div>
                </div>
                <div class="bg-white py-6 px-8 rounded-lg shadow-sm">
                    <form id="formPIC" action="{{ route('dashboard.data-kurir.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Masukkan nama lengkap PIC">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="username" name="username" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Masukkan username">
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base pr-12"
                                        placeholder="Masukkan password">
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
                                <input type="tel" id="no_hp" name="no_hp" required
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent text-base"
                                    placeholder="Cari dan pilih daerah...">
                                <input type="hidden" id="id_daerah" name="id_daerah" required>

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
                                        <input type="radio" name="status" value="Aktif" checked
                                            class="form-radio h-5 w-5 text-[#879FFF] focus:ring-[#879FFF] border-gray-300">
                                        <span class="ml-2 text-base text-gray-700">Aktif</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Nonaktif"
                                            class="form-radio h-5 w-5 text-[#879FFF] focus:ring-[#879FFF] border-gray-300">
                                        <span class="ml-2 text-base text-gray-700">Nonaktif</span>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden field untuk role -->
                        <input type="hidden" name="role" value="pic">

                        <!-- Tombol Action -->
                        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                            <a href=""
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 text-base font-medium">
                                <i class="bx bx-x mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-[#879FFF] text-white rounded-lg hover:bg-[#6B7EF7] focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2 transition-colors duration-200 text-base font-medium">
                                <i class="bx bx-check mr-2"></i>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const daftarDaerah = @json($daerah);

        const daerahSearch = document.getElementById('daerah_search');
        const daerahDropdown = document.getElementById('daerah_dropdown');
        const daerahList = document.getElementById('daerah_list');
        const idDaerahHidden = document.getElementById('id_daerah');

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
                if (keyword) {
                    const regex = new RegExp(`(${keyword})`, 'gi');
                    li.innerHTML = daerah.nama.replace(regex, '<mark class="bg-yellow-200 font-medium">$1</mark>');
                } else {
                    li.textContent = daerah.nama;
                }
                li.onmousedown = function() {
                    daerahSearch.value = daerah.nama;
                    idDaerahHidden.value = daerah.id_daerah;
                    daerahDropdown.classList.add('hidden');
                    daerahSearch.classList.remove('border-red-500');
                };
                daerahList.appendChild(li);
            });
        }

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

        daerahSearch.addEventListener('input', function() {
            const keyword = this.value.trim();
            idDaerahHidden.value = '';
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

        // Render initial list
        renderDaerahList();
    </script>
@endsection
