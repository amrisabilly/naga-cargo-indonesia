@extends('dashboard.layout.app', [
    'title' => 'Data Pengiriman',
])

@section('style')
    <style>
        /* Bungkus container length dan search */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        /* Styling dropdown "Show entries" */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 6px;
            background-color: #f9fafb;
            color: #374151;
        }

        /* Styling input "Search" */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 10px;
            background-color: #f9fafb;
            color: #374151;
            transition: 0.2s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
        }

        /* Posisi kiri-kanan */
        .dataTables_wrapper .dataTables_length {
            float: left;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
        }

        /* Responsive rapi di layar kecil */
        @media (max-width: 640px) {

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <section class="flex w-full pt-10">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="flex items-start gap-7 mb-8">
                    {{-- tombol kembali --}}
                    <a href="{{ route('dashboard.data-daerah.index') }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg bg-[#4A90E2] hover:bg-[#357ABD] text-white text-base font-semibold shadow transition-colors mb-4"
                        title="Kembali">
                        <i class="bx bx-arrow-back text-xl mr-1"></i>
                    </a>
                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-gray-900">Data Pengiriman <span
                                class="font-bold">{{ $daerah->nama }}</span></h1>
                        <p class="mt-1 text-base text-gray-500">Kelola data pengiriman</p>
                    </div>
                </div>
                <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10 rounded-md">
                    <div class="mt-4 overflow-x-auto">
                        <table id="example" class="display" style="overflow-x: scroll;">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Kode Pengiriman</th>
                                    <th style="text-align: center">Nama Pengirim</th>
                                    <th style="text-align: center">Nama Penerima</th>
                                    <th style="text-align: center">Tujuan</th>
                                    <th style="text-align: center">Tanggal Kirim</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengiriman ?? [] as $i => $order)
                                    <tr>
                                        <td style="text-align: center">{{ $i + 1 }}</td>
                                        <td class="font-mono text-blue-600" style="text-align: center">
                                            {{ $order->AWB ?? '-' }}</td>
                                        <td style="text-align: center">{{ $order->user->nama ?? '-' }}</td>
                                        <!-- Nama Kurir -->
                                        <td style="text-align: center">{{ $order->penerima ?? '-' }}</td>
                                        <!-- Nama Penerima -->
                                        <td style="text-align: center">{{ $order->tujuan ?? '-' }}</td>
                                        <td style="text-align: center">{{ $order->tanggal ?? '-' }}</td>
                                        <td style="text-align: center">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $order->status == 'Terkirim' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                <div
                                                    class="w-1.5 h-1.5 {{ $order->status == 'Terkirim' ? 'bg-green-500' : 'bg-yellow-500' }} rounded-full mr-1">
                                                </div>
                                                {{ $order->status ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center gap-2">
                                                @if (!empty($order->AWB))
                                                    <a href="{{ route('dashboard.data-pengiriman.show', $order->AWB) }}"
                                                        class="inline-flex items-center justify-center rounded bg-blue-400 hover:bg-blue-400 p-2 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                                                        title="Lihat Detail">
                                                        <i class="bx bx-show text-white text-lg"></i>
                                                    </a>
                                                    <button type="button" onclick="openDeleteModal('{{ $order->AWB }}')"
                                                        class="focus:ring-2 focus:ring-offset-2 inline-flex items-center justify-center p-2 bg-red-500 hover:bg-red-600 focus:outline-none rounded transition-colors"
                                                        title="Hapus">
                                                        <i class="bx bx-trash-alt text-white text-lg"></i>
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-gray-500">Tidak ada data pengiriman untuk
                                            daerah ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Main Image --}}
                        <div class="main-image">
                            <img id="mainPhoto" src="{{ asset('storage/' . $order->orderFoto->first()->path_foto) }}"
                                alt="Main Photo">
                        </div>

                        {{-- Thumbnail Grid --}}
                        <div class="thumbnail-grid">
                            @foreach ($order->orderFoto as $foto)
                                <div class="thumbnail {{ $loop->first ? 'active' : '' }}"
                                    onclick="changeMainImage({{ $loop->index }}, this)">
                                    <img src="{{ asset('storage/' . $foto->path_foto) }}"
                                        alt="Photo {{ $loop->iteration }}" loading="lazy">
                                </div>
                            @endforeach
                        </div>

                        <script>
                            // Data gambar
                            const images = @json(
                                $order->orderFoto->map(function ($foto) {
                                    return [
                                        'url' => asset('storage/' . $foto->path_foto),
                                        'keterangan' => $foto->keterangan,
                                    ];
                                }));

                            function changeMainImage(index, element) {
                                // Update main image
                                document.getElementById('mainPhoto').src = images[index].url;

                                // Update active thumbnail
                                document.querySelectorAll('.thumbnail').forEach(thumb => {
                                    thumb.classList.remove('active');
                                });
                                element.classList.add('active');
                            }
                        </script>

                        <!-- Modal Konfirmasi Hapus -->
                        <div id="deleteModal"
                            class="fixed inset-0 z-10 hidden items-center justify-center bg-black bg-opacity-50 flex">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 text-center">
                                <div class="mb-4 flex justify-center">
                                    <img src="{{ asset('assets/images/dashboard/svg-icon/warning.svg') }}"
                                        alt="Warning Icon" class="h-12 w-12" />
                                </div>
                                <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi
                                    Hapus</h3>
                                <p class="mb-6 text-base text-gray-500">Apakah Anda yakin ingin menghapus data pengiriman
                                    ini? Semua data terkait juga akan dihapus.</p>
                                <div class="flex w-full justify-center gap-4">
                                    <form id="deleteForm" method="POST" class="w-1/2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-[#879FFF] w-full px-6 py-2 text-white text-center hover:bg-[#6B7EF7] focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2 transition-colors">Hapus</button>
                                    </form>
                                    <button type="button"
                                        class="rounded-lg border border-[#879FFF] w-1/2 px-6 py-2 text-[#879FFF] hover:bg-[#879FFF] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2 transition-colors"
                                        onclick="closeDeleteModal()">Batal</button>
                                </div>
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
        $(document).ready(function() {
            $('#example').DataTable();
        });

        let deleteModal = document.getElementById('deleteModal');
        let deleteForm = document.getElementById('deleteForm');

        function openDeleteModal(packageId) {
            // Set action URL untuk delete dengan package ID
            deleteForm.action = `{{ route('dashboard.data-pengiriman.index') }}/${packageId}`;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');

        }
    </script>
@endsection
