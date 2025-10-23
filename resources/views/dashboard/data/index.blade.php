{{-- filepath: c:\laragon\www\project-dropshiper\dropshiper\resources\views\dashboard\data\index.blade.php --}}
@extends('dashboard.layout.app', [
    'title' => 'Data Pengiriman',
])

@section('style')
    <style>
        /* Custom DataTable Styling */
        .dataTables_wrapper {
            width: 100%;
            overflow: hidden;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 0;
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
            width: 200px;
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
        }

        table.dataTable {
            width: 100% !important;
            table-layout: fixed;
            font-size: 1rem;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
        }

        table.dataTable tbody td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background: white;
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f3f4f6;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #879FFF;
            color: white !important;
            border-color: #879FFF;
        }

        /* Modal Popup Styling */
        .region-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .region-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            max-height: 70vh;
            overflow-y: auto;
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s ease;
            position: relative;
        }

        .region-modal.active .modal-content {
            transform: scale(1) translateY(0);
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .main-content.grayed {
            background-color: #f3f4f6;
            opacity: 0.7;
            pointer-events: none;
        }

        .close-button {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: #f3f4f6;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #6b7280;
            font-size: 1.2rem;
        }

        .close-button:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #879FFF;
            box-shadow: 0 0 0 3px rgba(135, 159, 255, 0.1);
        }

        .region-item {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            margin-bottom: 0.5rem;
            text-decoration: none;
        }

        .region-item:hover {
            border-color: #879FFF;
            background: #f8faff;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .region-item.hidden {
            display: none;
        }

        .recommendations-container {
            max-height: 250px;
            overflow-y: auto;
        }

        .no-results {
            text-align: center;
            padding: 1.5rem;
            color: #6b7280;
        }

        .table-container {
            width: 100%;
            overflow: hidden;
        }

        .col-no {
            width: 5%;
        }

        .col-kode {
            width: 12%;
        }

        .col-pengirim {
            width: 15%;
        }

        .col-penerima {
            width: 15%;
        }

        .col-tujuan {
            width: 12%;
        }

        .col-status {
            width: 12%;
        }

        .col-tanggal {
            width: 12%;
        }

        .col-aksi {
            width: 17%;
        }
    </style>
@endsection

@section('content')
    @php
        // Data statis untuk setiap daerah
        $regionData = [
            'Jakarta' => [
                [
                    'kode' => '19201011208092',
                    'pengirim' => 'John Doe',
                    'penerima' => 'Jane Smith',
                    'daerah' => 'JKT',
                    'tujuan' => 'BSD 1',
                    'tanggal' => '15 Jan 2024',
                    'status' => 'Terkirim',
                ],
            ],
            'Bandung' => [
                [
                    'kode' => '19201011208094',
                    'pengirim' => 'Michael Brown',
                    'penerima' => 'Sarah Davis',
                    'daerah' => 'BDG',
                    'tujuan' => 'CKR 3',
                    'tanggal' => '17 Jan 2024',
                    'status' => 'Diproses',
                ],
            ],
            'Surabaya' => [
                [
                    'kode' => '19201011208096',
                    'pengirim' => 'Chris Anderson',
                    'penerima' => 'Lisa White',
                    'daerah' => 'SBY',
                    'tujuan' => 'MLG 2',
                    'tanggal' => '19 Jan 2024',
                    'status' => 'Dalam Perjalanan',
                ],
            ],
            'Medan' => [
                [
                    'kode' => '19201011208097',
                    'pengirim' => 'Alex Johnson',
                    'penerima' => 'Maria Garcia',
                    'daerah' => 'MDN',
                    'tujuan' => 'DLI 1',
                    'tanggal' => '20 Jan 2024',
                    'status' => 'Terkirim',
                ],
            ],
            'Makassar' => [
                [
                    'kode' => '19201011208098',
                    'pengirim' => 'Ryan Smith',
                    'penerima' => 'Nina Brown',
                    'daerah' => 'MKS',
                    'tujuan' => 'PLU 3',
                    'tanggal' => '21 Jan 2024',
                    'status' => 'Diproses',
                ],
            ],
            'Yogyakarta' => [
                [
                    'kode' => '19201011208099',
                    'pengirim' => 'Kevin Lee',
                    'penerima' => 'Anna Wilson',
                    'daerah' => 'YGY',
                    'tujuan' => 'SLM 2',
                    'tanggal' => '22 Jan 2024',
                    'status' => 'Terkirim',
                ],
            ],
            'Semarang' => [
                [
                    'kode' => '19201011208100',
                    'pengirim' => 'Robert Clark',
                    'penerima' => 'Linda Moore',
                    'daerah' => 'SMG',
                    'tujuan' => 'UGM 1',
                    'tanggal' => '23 Jan 2024',
                    'status' => 'Diproses',
                ],
            ],
            'Palembang' => [
                [
                    'kode' => '19201011208101',
                    'pengirim' => 'Mark Taylor',
                    'penerima' => 'Helen Davis',
                    'daerah' => 'PLG',
                    'tujuan' => 'IBA 2',
                    'tanggal' => '24 Jan 2024',
                    'status' => 'Terkirim',
                ],
            ],
        ];

        $selectedRegion = request('region', '');
        $currentData = isset($regionData[$selectedRegion]) ? $regionData[$selectedRegion] : [];

        // Helper function untuk status class
        function getStatusClass($status)
        {
            switch ($status) {
                case 'Terkirim':
                    return ['class' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-500'];
                case 'Dalam Perjalanan':
                    return ['class' => 'bg-yellow-100 text-yellow-800', 'dot' => 'bg-yellow-500'];
                case 'Diproses':
                    return ['class' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-500'];
                default:
                    return ['class' => 'bg-gray-100 text-gray-800', 'dot' => 'bg-gray-500'];
            }
        }
    @endphp

    @if (!$selectedRegion)
        <!-- Region Selection Modal -->
        <div id="regionModal" class="region-modal active">
            <div class="modal-content">
                <!-- Close Button -->
                <button type="button" class="close-button" id="closeModal" title="Tutup">
                    <i class="bx bx-x"></i>
                </button>

                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Pilih Daerah</h2>
                    <p class="text-gray-600 text-sm">Masukkan nama daerah untuk melihat data pengiriman</p>
                </div>

                <form action="{{ route('dashboard.data-pengiriman.index') }}" method="GET" class="mb-4">
                    <input type="text" name="region" id="region_search" class="search-input"
                        placeholder="Ketik nama daerah..." autocomplete="off" value="{{ $selectedRegion }}">
                    <button type="submit" class="hidden">Submit</button>
                </form>

                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Daerah Tersedia:</h3>
                    <div class="recommendations-container" id="recommendationsContainer">
                        @foreach ($regionData as $region => $data)
                            <a href="{{ route('dashboard.data-pengiriman.index', ['region' => $region]) }}"
                                class="region-item block" data-region="{{ $region }}"
                                data-keywords="{{ strtolower($region) }} {{ str_replace(' ', ' ', strtolower($region)) }}">
                                <div class="font-medium text-gray-900">{{ $region }}</div>
                            </a>
                        @endforeach
                    </div>

                    <div id="noResults" class="no-results hidden">
                        <p class="text-sm">Tidak ada daerah yang ditemukan</p>
                        <p class="text-xs text-gray-400">Coba dengan kata kunci lain</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div id="mainContent" class="main-content {{ !$selectedRegion ? 'grayed' : '' }}">
        <section class="h-full flex flex-col w-full py-5 overflow-hidden">
            @if ($selectedRegion)
                {{-- Header dan Button Actions --}}
                <div class="mb-6 flex justify-between items-start flex-shrink-0">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Data Pengiriman - <span class="text-[#879FFF]">{{ $selectedRegion }}</span>
                        </h1>
                        <p class="mt-1 text-base text-gray-500">Kelola dan pantau semua data pengiriman barang</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard.data-pengiriman.index') }}"
                            class="px-4 py-2 bg-white border border-[#879FFF] text-[#879FFF] rounded-lg font-semibold hover:bg-[#879FFF] hover:text-white transition-colors">
                            Ganti Daerah
                        </a>
                    </div>
                </div>

                {{-- DataTable Card --}}
                <div class="flex-1 bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="table-container flex-1">
                            <table id="dataPengirimanTable" class="w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th
                                            class="col-no px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="col-kode px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Kode</th>
                                        <th
                                            class="col-pengirim px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Pengirim</th>
                                        <th
                                            class="col-penerima px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Penerima</th>
                                        <th
                                            class="col-tujuan px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Daerah</th>
                                        <th
                                            class="col-tujuan px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Tujuan</th>
                                        <th
                                            class="col-tanggal px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="col-status px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="col-aksi px-3 py-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($currentData as $index => $item)
                                        @php
                                            $statusInfo = getStatusClass($item['status']);
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-3 py-4 text-base text-gray-900 font-medium">{{ $index + 1 }}
                                            </td>
                                            <td class="px-3 py-4">
                                                <span
                                                    class="text-base font-semibold text-[#879FFF]">{{ $item['kode'] }}</span>
                                            </td>
                                            <td class="px-3 py-4 text-base text-gray-900" title="{{ $item['pengirim'] }}">
                                                {{ $item['pengirim'] }}</td>
                                            <td class="px-3 py-4 text-base text-gray-900" title="{{ $item['penerima'] }}">
                                                {{ $item['penerima'] }}</td>
                                            <td class="px-3 py-4 text-base text-gray-900">{{ $item['daerah'] }}</td>
                                            <td class="px-3 py-4 text-base text-gray-900">{{ $item['tujuan'] }}</td>
                                            <td class="px-3 py-4 text-base text-gray-900">{{ $item['tanggal'] }}</td>
                                            <td class="px-3 py-4">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $statusInfo['class'] }}">
                                                    <div class="w-1.5 h-1.5 {{ $statusInfo['dot'] }} rounded-full mr-2">
                                                    </div>
                                                    {{ $item['status'] }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-4 text-center">
                                                <div class="flex justify-center gap-3">
                                                    <a href="{{ route('dashboard.data-pengiriman.show', $item['kode']) }}"
                                                        class="px-3 py-2 text-green-600 hover:text-green-900 hover:bg-green-50 rounded-lg transition-colors border border-green-200 hover:border-green-300"
                                                        title="Lihat Detail">
                                                        <i class="bx bx-show text-xl"></i>
                                                    </a>
                                                    <button
                                                        class="px-3 py-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors border border-red-200 hover:border-red-300"
                                                        title="Hapus Data">
                                                        <i class="bx bx-trash text-xl"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-3 py-8 text-center text-gray-500">
                                                <p class="text-base">Tidak ada data pengiriman untuk daerah
                                                    {{ $selectedRegion }}</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                {{-- Placeholder content when no region selected --}}
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center text-gray-400">
                        <i class="bx bx-map text-6xl mb-4"></i>
                        <h2 class="text-xl font-semibold mb-2">Pilih Daerah</h2>
                        <p>Silakan pilih daerah untuk melihat data pengiriman</p>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            @if ($selectedRegion)
                // Initialize DataTable hanya jika ada data
                $('#dataPengirimanTable').DataTable({
                    responsive: false,
                    scrollX: false,
                    autoWidth: false,
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 25, 50],
                        [5, 10, 25, 50]
                    ],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 hingga 0 dari 0 data",
                        infoFiltered: "(disaring dari _MAX_ total data)",
                        zeroRecords: "Tidak ada data yang ditemukan",
                        emptyTable: "Tidak ada data tersedia",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: [8]
                    }],
                    order: [
                        [0, 'asc']
                    ]
                });
            @else
                // Close modal functions
                function closeModal() {
                    window.history.back();
                }

                // Close button click
                $('#closeModal').on('click', function() {
                    closeModal();
                });

                // Click outside modal to close
                $('#regionModal').on('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });

                // Prevent modal close when clicking inside modal content
                $('.modal-content').on('click', function(e) {
                    e.stopPropagation();
                });

                // ESC key to close modal
                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeModal();
                    }
                });

                // Search functionality untuk modal
                $('#region_search').on('input', function() {
                    const searchTerm = $(this).val().toLowerCase();
                    const regions = $('.region-item');
                    let hasResults = false;

                    regions.each(function() {
                        const keywords = $(this).data('keywords');
                        const regionName = $(this).data('region').toLowerCase();

                        if (keywords.includes(searchTerm) || regionName.includes(searchTerm) ||
                            searchTerm === '') {
                            $(this).removeClass('hidden');
                            hasResults = true;
                        } else {
                            $(this).addClass('hidden');
                        }
                    });

                    if (hasResults || searchTerm === '') {
                        $('#noResults').addClass('hidden');
                    } else {
                        $('#noResults').removeClass('hidden');
                    }
                });

                // Enter key to submit form
                $('#region_search').on('keypress', function(e) {
                    if (e.which === 13) {
                        $(this).closest('form').submit();
                    }
                });
            @endif
        });
    </script>
@endsection
