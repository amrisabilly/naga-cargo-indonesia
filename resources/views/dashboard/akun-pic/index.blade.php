{{-- filepath: c:\laragon\www\project-dropshiper\dropshiper\resources\views\dashboard\akun-pic\index.blade.php --}}
@extends('dashboard.layout.app', [
    'title' => 'Data Akun PIC',
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

        /* Copy button styling */
        .copy-btn {
            cursor: pointer;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            background-color: #f3f4f6;
        }

        /* Modal styling */
        .modal {
            transition: opacity 0.15s linear;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Credential display */
        .credential-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 8px;
            border-radius: 6px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .credential-text {
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            color: #1e293b;
        }
    </style>
@endsection

@section('content')
    <section class="h-full flex flex-col w-full py-5 overflow-hidden">
        {{-- Header dan Button Actions --}}
        <div class="mb-6 flex justify-between items-start flex-shrink-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Data Akun <span class="italic">PIC</span></h1>
                <p class="mt-1 text-base text-gray-500">Kelola akun username dan password <span class="italic">PIC</span></p>
            </div>
            <div class="flex gap-3">
                {{-- Tambah PIC Button --}}
                <button id="tambahKurir"
                    class="bg-[#879FFF] hover:bg-[#6B7EF7] text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                    <i class="bx bx-plus text-lg"></i>
                    Tambah <span class="italic">PIC</span>
                </button>
            </div>
        </div>

        {{-- DataTable Card --}}
        <div class="flex-1 bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
            <div class="p-6 flex-1 flex flex-col">
                <div class="table-container flex-1">
                    <table id="dataKurirTable" class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider w-8">
                                    No</th>
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Lengkap</th>
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Username</th>
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Password</th>
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    No. Telepon</th>
                                <th
                                    class="px-3 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-3 py-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider w-20">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            {{-- Data Dummy --}}
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-4 text-base text-gray-900 font-medium">1</td>
                                <td class="px-3 py-4 text-base text-gray-900" title="Ahmad Kurniawan">Ahmad Kurniawan</td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text text-[#879FFF] font-semibold">ahmad_pic</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('ahmad_pic', this)" title="Salin Username">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text">kurniawan123</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('kurniawan123', this)" title="Salin Password">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-base text-gray-900">08123456789</td>
                                <td class="px-3 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            class="edit-kurir p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit" data-id="1">
                                            <i class="bx bx-edit text-xl"></i>
                                        </button>
                                        <button
                                            class="hapus-kurir p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus" data-id="1">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-4 text-base text-gray-900 font-medium">2</td>
                                <td class="px-3 py-4 text-base text-gray-900" title="Budi Santoso">Budi Santoso</td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text text-[#879FFF] font-semibold">budi_pic</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('budi_pic', this)" title="Salin Username">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text">santoso456</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('santoso456', this)" title="Salin Password">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-base text-gray-900">08234567890</td>
                                <td class="px-3 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                        <div class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-2"></div>
                                        Nonaktif
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            class="edit-kurir p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit" data-id="2">
                                            <i class="bx bx-edit text-xl"></i>
                                        </button>
                                        <button
                                            class="hapus-kurir p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus" data-id="2">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-4 text-base text-gray-900 font-medium">3</td>
                                <td class="px-3 py-4 text-base text-gray-900" title="Sari Melati">Sari Melati</td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text text-[#879FFF] font-semibold">sari_pic</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('sari_pic', this)" title="Salin Username">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="credential-item">
                                        <span class="credential-text">melati789</span>
                                        <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                            onclick="copyToClipboard('melati789', this)" title="Salin Password">
                                            <i class="bx bx-copy text-base"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-base text-gray-900">08345678901</td>
                                <td class="px-3 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            class="edit-kurir p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit" data-id="3">
                                            <i class="bx bx-edit text-xl"></i>
                                        </button>
                                        <button
                                            class="hapus-kurir p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Hapus" data-id="3">
                                            <i class="bx bx-trash text-xl"></i>
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

    {{-- Modal Tambah/Edit PIC --}}
    <div id="modalKurir" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-[30em] shadow-lg rounded-lg bg-white">
            <div class="mt-3">
                {{-- Header Modal --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Tambah PIC Baru</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>

                {{-- Form --}}
                <form id="formKurir">
                    <input type="hidden" id="kurirId" name="id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="namaLengkap" name="nama_lengkap"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent"
                            placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" id="username" name="username"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent"
                            placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent"
                            placeholder="Masukkan password" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="text" id="noTelepon" name="no_telepon"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent"
                            placeholder="Masukkan no. telepon" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3">
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-4 py-2 bg-[#879FFF] text-white rounded-lg hover:bg-[#6B7EF7] transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Copy to clipboard function
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(function() {
                const icon = button.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'bx bx-check text-base text-green-500';

                const originalTitle = button.title;
                button.title = 'Tersalin!'

                setTimeout(() => {
                    icon.className = originalClass;
                    button.title = originalTitle;
                }, 1500);
            }).catch(function(err) {
                console.error('Error copying text: ', err);
                alert('Gagal menyalin ke clipboard');
            });
        }

        $(document).ready(function() {
            // Initialize DataTable
            if ($.fn.DataTable.isDataTable('#dataKurirTable')) {
                $('#dataKurirTable').DataTable().destroy();
            }

            const table = $('#dataKurirTable').DataTable({
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
                        targets: [6]
                    },
                    {
                        width: "5%",
                        targets: 0
                    },
                    {
                        width: "20%",
                        targets: 1
                    },
                    {
                        width: "15%",
                        targets: [2, 3]
                    },
                    {
                        width: "15%",
                        targets: 4
                    },
                    {
                        width: "12%",
                        targets: 5
                    },
                    {
                        width: "13%",
                        targets: 6
                    }
                ],
                order: [
                    [0, 'asc']
                ]
            });

            // Modal functions
            function openModal(title) {
                $('#modalTitle').text(title);
                $('#modalKurir').removeClass('hidden');
            }

            function closeModal() {
                $('#modalKurir').addClass('hidden');
                $('#formKurir')[0].reset();
                $('#kurirId').val('');
            }

            // Event Listeners
            $('#tambahKurir').on('click', function() {
                openModal('Tambah PIC Baru');
            });

            $('#closeModal, #cancelBtn').on('click', function() {
                closeModal();
            });

            // Edit PIC - Hanya tampilkan modal tanpa load data
            $(document).on('click', '.edit-kurir', function() {
                openModal('Edit Data PIC');
            });

            // Delete PIC - Hanya tampilkan alert
            $(document).on('click', '.hapus-kurir', function() {
                Swal.fire({
                    title: 'Hapus PIC',
                    text: 'Apakah Anda yakin ingin menghapus data PIC ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data PIC berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Form Submit - Hanya tampilkan alert
            $('#formKurir').on('submit', function(e) {
                e.preventDefault();

                const isEdit = $('#kurirId').val() !== '';

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data PIC berhasil ${isEdit ? 'diperbarui' : 'ditambahkan'}.`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    closeModal();
                });
            });

            // Close modal when clicking outside
            $('#modalKurir').on('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
