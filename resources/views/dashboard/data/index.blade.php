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
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
            width: 200px;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        table.dataTable {
            width: 100% !important;
            table-layout: fixed;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        table.dataTable tbody td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f3f4f6;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #879FFF;
            color: white !important;
            border-color: #879FFF;
        }

        /* Prevent horizontal scroll */
        .table-container {
            width: 100%;
            overflow: hidden;
        }

        /* Responsive table columns */
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
    <section class="h-full flex flex-col w-full py-5 overflow-hidden">
        {{-- Header dan Button Actions --}}
        <div class="mb-6 flex justify-between items-start flex-shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Pengiriman</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola dan pantau semua data pengiriman barang</p>
            </div>
            <div class="flex gap-3">
                {{-- Export to PDF Button --}}
                <button id="exportPdf"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                    <i class="bx bxs-file-pdf text-lg"></i>
                    Export PDF
                </button>
                {{-- Export to Excel Button --}}
                <button id="exportExcel"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                    <i class="bx bxs-file text-lg"></i>
                    Export Excel
                </button>
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
                                    class="col-no px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="col-kode px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Kode</th>
                                <th
                                    class="col-pengirim px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Pengirim</th>
                                <th
                                    class="col-penerima px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Penerima</th>
                                <th
                                    class="col-tujuan px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Daerah</th>
                                <th
                                    class="col-tujuan px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tujuan</th>
                                <th
                                    class="col-tanggal px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="col-status px-3 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="col-aksi px-3 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            {{-- Data Dummy --}}
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-4 text-sm text-gray-900 font-medium">1</td>
                                <td class="px-3 py-4">
                                    <span class="text-sm font-semibold text-[#879FFF]">PKG001</span>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900" title="John Doe">John Doe</td>
                                <td class="px-3 py-4 text-sm text-gray-900" title="Jane Smith">Jane Smith</td>
                                <td class="px-3 py-4 text-sm text-gray-900">KOT</td>
                                <td class="px-3 py-4 text-sm text-gray-900">SDN 2</td>
                                <td class="px-3 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>
                                        Terkirim
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900">15 Jan 2024</td>
                                <td class="px-3 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        {{-- <button
                                        class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <i class="bx bx-edit text-lg"></i>
                                    </button> --}}
                                        <a href="{{ route('dashboard.data-pengiriman.show', 'PKG001') }}"
                                            class="p-1.5 text-green-600 hover:text-green-900 hover:bg-green-50 rounded-lg transition-colors"
                                            title="Lihat">
                                            <i class="bx bx-show text-lg"></i>
                                        </a>
                                        <button
                                            class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus">
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Cek apakah DataTable sudah ada, jika ya destroy dulu
            if ($.fn.DataTable.isDataTable('#dataPengirimanTable')) {
                $('#dataPengirimanTable').DataTable().destroy();
            }

            const table = $('#dataPengirimanTable').DataTable({
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
                    lengthMenu: "Tampilkan _MENU_ data",
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
                        targets: [7]
                    },
                    {
                        width: "5%",
                        targets: 0
                    },
                    {
                        width: "12%",
                        targets: 1
                    },
                    {
                        width: "15%",
                        targets: [2, 3]
                    },
                    {
                        width: "12%",
                        targets: [4, 5, 6]
                    },
                    {
                        width: "17%",
                        targets: 7
                    }
                ],
                order: [
                    [0, 'asc']
                ]
            });

            // Export to PDF
            $('#exportPdf').on('click', function() {
                Swal.fire({
                    title: 'Export to PDF',
                    text: 'Apakah Anda yakin ingin mengunduh data pengiriman dalam format PDF?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Export!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data sedang diunduh dalam format PDF',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Export to Excel
            $('#exportExcel').on('click', function() {
                Swal.fire({
                    title: 'Export to Excel',
                    text: 'Apakah Anda yakin ingin mengunduh data pengiriman dalam format Excel?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Export!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data sedang diunduh dalam format Excel',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>
@endsection
