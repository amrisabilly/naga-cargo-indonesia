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
                            Preview Daerah Terdaftar:
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
        const daftarDaerah = @json($daerah);

        const inputDaerah = document.getElementById('input-daerah');
        const daftarTerdaftar = document.getElementById('daftar-terdaftar');
        const jumlahHasil = document.getElementById('jumlah-hasil');
        const tidakDitemukan = document.getElementById('tidak-ditemukan');

        function renderDaerahList(daftarFilter = daftarDaerah, keyword = '') {
            daftarTerdaftar.innerHTML = '';
            if (daftarFilter.length === 0) {
                tidakDitemukan.classList.remove('hidden');
                jumlahHasil.textContent = '';
                return;
            }
            tidakDitemukan.classList.add('hidden');
            jumlahHasil.textContent = `(${daftarFilter.length} daerah)`;

            daftarFilter.forEach(daerah => {
                const li = document.createElement('li');
                li.className = 'px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer transition-colors duration-150';

                // Buat link ke route detail pengiriman daerah
                li.onclick = function() {
                    window.location.href = `/dashboard/data-pengiriman/daerah/${daerah.id_daerah}`;
                };

                if (keyword) {
                    const regex = new RegExp(`(${keyword})`, 'gi');
                    li.innerHTML = daerah.nama.replace(regex, '<mark class="bg-yellow-200 font-medium">$1</mark>');
                } else {
                    li.textContent = daerah.nama;
                }
                daftarTerdaftar.appendChild(li);
            });
        }

        function filterDaerah(keyword) {
            if (!keyword.trim()) {
                // Tampilkan hanya 5 daerah teratas jika tidak ada pencarian
                renderDaerahList(daftarDaerah.slice(0, 5));
                return;
            }
            // Tampilkan hasil pencarian saja
            const hasil = daftarDaerah.filter(daerah =>
                daerah.nama.toLowerCase().includes(keyword.toLowerCase())
            );
            renderDaerahList(hasil, keyword);
        }

        inputDaerah.addEventListener('input', function() {
            const keyword = this.value.trim();
            filterDaerah(keyword);
        });

        // Tampilkan 5 daerah teratas saat pertama kali load
        renderDaerahList(daftarDaerah.slice(0, 5));
    </script>
@endsection
