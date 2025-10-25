@extends('dashboard.layout.app', [
    'title' => 'Data Daerah',
])

@section('style')
@endsection

@section('content')
    <section class="flex w-full pt-10 h-full items-center">
        <div class="flex flex-col w-full items-center">
            <div class="w-full max-w-md">
                <div class="bg-white py-6 px-6 rounded-md shadow relative">
                    <label for="input-daerah" class="block text-base font-semibold mb-2">Nama Daerah</label>
                    <input type="text" id="input-daerah" autocomplete="off"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#879FFF] text-base"
                        placeholder="Masukkan nama daerah...">

                    <!-- Daerah Terdaftar -->
                    <div class="mt-6">
                        <div class="font-semibold text-gray-700 mb-3">
                            Daerah Terdaftar:
                            <span id="jumlah-hasil" class="text-sm font-normal text-gray-500"></span>
                        </div>
                        <div class="border border-gray-200 rounded-lg max-h-60 overflow-y-auto">
                            <ul id="daftar-terdaftar" class="divide-y divide-gray-100">
                                <!-- Daftar daerah akan diisi via JS -->
                            </ul>
                            <div id="tidak-ditemukan" class="px-4 py-8 text-center text-gray-500 text-sm hidden">
                                Tidak ada daerah yang ditemukan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Daftar daerah terdaftar (bisa diganti dari backend)
        const daftarDaerah = [
            'Jakarta Pusat',
            'Jakarta Selatan',
            'Jakarta Utara',
            'Jakarta Barat',
            'Jakarta Timur',
            'Bandung',
        ];

        const inputDaerah = document.getElementById('input-daerah');
        const daftarTerdaftar = document.getElementById('daftar-terdaftar');
        const jumlahHasil = document.getElementById('jumlah-hasil');
        const tidakDitemukan = document.getElementById('tidak-ditemukan');

        // Tampilkan daftar daerah terdaftar dalam bentuk list
        function renderDaerahTerdaftar(daftarFilter = daftarDaerah, keyword = '') {
            daftarTerdaftar.innerHTML = '';

            if (daftarFilter.length === 0) {
                daftarTerdaftar.classList.add('hidden');
                tidakDitemukan.classList.remove('hidden');
                jumlahHasil.textContent = '(0 daerah)';
                return;
            }

            daftarTerdaftar.classList.remove('hidden');
            tidakDitemukan.classList.add('hidden');
            jumlahHasil.textContent = `(${daftarFilter.length} daerah)`;

            daftarFilter.forEach((nama, index) => {
                const li = document.createElement('li');
                li.className =
                    'px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 transition-colors duration-150';

                // Highlight kata yang cocok jika ada keyword
                if (keyword) {
                    const regex = new RegExp(`(${keyword})`, 'gi');
                    li.innerHTML = nama.replace(regex, '<mark class="bg-yellow-200 font-medium">$1</mark>');
                } else {
                    li.textContent = nama;
                }

                li.onclick = function() {
                    inputDaerah.value = nama;
                    inputDaerah.focus();
                };
                daftarTerdaftar.appendChild(li);
            });
        }

        // Filter daerah berdasarkan input
        function filterDaerah(keyword) {
            if (!keyword.trim()) {
                renderDaerahTerdaftar();
                return;
            }

            const hasil = daftarDaerah.filter(nama =>
                nama.toLowerCase().includes(keyword.toLowerCase())
            );

            renderDaerahTerdaftar(hasil, keyword);
        }

        // Event listener untuk input
        inputDaerah.addEventListener('input', function() {
            const keyword = this.value.trim();
            filterDaerah(keyword);
        });

        // Clear filter saat input kosong
        inputDaerah.addEventListener('keyup', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                filterDaerah('');
                this.focus();
            }
        });

        // Render awal
        renderDaerahTerdaftar();
    </script>
@endsection
