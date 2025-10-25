@extends('dashboard.layout.app', [
    'title' => 'Data Akun Kurir',
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
                <div class="mb-6 flex justify-between items-start flex-shrink-0">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Data Akun Kurir</h1>
                        <p class="mt-1 text-base text-gray-500">Kelola akun username dan password kurir</p>
                    </div>
                    <div class="flex gap-3">
                        {{-- Tambah PIC Button --}}
                        <button
                            class="bg-[#879FFF] hover:bg-[#6B7EF7] text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                            <i class="bx bx-plus text-lg"></i>
                            Tambah Kurir
                        </button>
                    </div>
                </div>
                <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10 rounded-md">
                    <div class="mt-4 overflow-x-auto">
                        <table id="example" class="display" style="overflow-x: scroll;">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Nama Lengkap</th>
                                    <th style="text-align: center">Username</th>
                                    <th style="text-align: center">Password</th>
                                    <th style="text-align: center">No. Telepon</th>
                                    <th style="text-align: center">Daerah</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>billy</td>
                                    <td class="px-3 py-4">
                                        <div class="credential-item">
                                            <span class="credential-text text-[#879FFF] font-semibold">ahmad_pic</span>
                                            <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                                onclick="copyToClipboard('ahmad_pic', this)" title="Salin Username">
                                                <i class="bx bx-copy text-base"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="credential-item">
                                            <span class="credential-text">kurniawan123</span>
                                            <button class="copy-btn p-1 rounded text-gray-500 hover:text-[#879FFF]"
                                                onclick="copyToClipboard('kurniawan123', this)" title="Salin Password">
                                                <i class="bx bx-copy text-base"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>085729447324</td>
                                    <td>Depok</td>
                                    <td class="px-3 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="flex flex-row justify-center gap-2">
                                        <a href=""
                                            class="inline-flex items-start justify-start rounded bg-yellow-500 p-3 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                                            <i class="bx bx-edit text-white"></i>
                                        </a>
                                        <button type="button" onclick="openDeleteModal()"
                                            class="focus:ring-2 focus:ring-offset-2 inline-flex items-start justify-start p-3 bg-red-500 hover:bg-red-600 focus:outline-none rounded">
                                            <i class="bx bx-trash-alt text-white"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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
                                <p class="mb-6 text-base text-gray-500">Apakah Anda yakin ingin menghapus data ini? Semua
                                    data terkait juga akan dihapus.</p>
                                <div class="flex w-full justify-center gap-4">
                                    <form id="deleteForm" method="POST" class="w-1/2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-[#879FFF] w-full px-6 py-2 text-white text-center hover:bg-[#879FFF] focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2">Hapus</button>
                                    </form>
                                    <button type="button"
                                        class="rounded-lg border border-[#879FFF] w-1/2 px-6 py-2 text-[#879FFF] focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:ring-offset-2"
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
        let deleteModal = document.getElementById('deleteModal');
        let deleteForm = document.getElementById('deleteForm');

        function openDeleteModal(classId) {
            deleteForm.action = ``;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

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
    </script>
@endsection
