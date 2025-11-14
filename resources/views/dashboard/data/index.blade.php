@extends('dashboard.layout.app', [
    'title' => 'Data Daerah',
])

@section('style')
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 6px;
            background-color: #f9fafb;
            color: #374151;
        }

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

        .dataTables_wrapper .dataTables_length {
            float: left;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
        }

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
            <div class="w-full">
                <div class="mb-6 flex justify-between items-start flex-shrink-0">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Data Pengiriman</h1>
                        <p class="mt-1 text-base text-gray-500">Kelola data daerah pengiriman</p>
                    </div>
                    <div class="flex gap-3">
                        {{-- Tombol Tambah Daerah --}}
                        <button onclick="openCreateModal()"
                            class="bg-[#4A90E2] hover:bg-[#357ABD] text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                            <i class="bx bx-plus text-lg"></i>
                            Tambah Daerah
                        </button>

                        <!-- Modal Create Daerah -->
                        <div id="createModal"
                            class="fixed inset-0 z-10 hidden items-center justify-center bg-black bg-opacity-50 flex">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 text-center">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Tambah Daerah</h3>
                                <form id="createForm" method="POST" action="{{ route('dashboard.data-daerah.store') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="text" name="kode_daerah" class="w-full border rounded px-3 py-2"
                                            placeholder="Kode Daerah" required>
                                    </div>
                                    <div class="mb-4">
                                        <input type="text" name="nama" class="w-full border rounded px-3 py-2"
                                            placeholder="Nama Daerah" required>
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="submit"
                                            class="rounded-lg bg-[#4A90E2] w-full px-6 py-2 text-white">Simpan</button>
                                        <button type="button" onclick="closeCreateModal()"
                                            class="rounded-lg border border-[#4A90E2] w-full px-6 py-2 text-[#4A90E2]">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10 rounded-md">
                    <div class="mt-4 overflow-x-auto">
                        <table id="example" class="display" style="overflow-x: scroll;">
                            <thead>
                                <tr>
                                    <th style="text-align: center" class="sorting_disabled">No</th>
                                    <th style="text-align: center">Nama Daerah</th>
                                    <th style="text-align: center">Kode Daerah</th>
                                    <th style="text-align: center">Pengiriman</th>
                                    <th style="text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daerah as $i => $item)
                                    <tr>
                                        <td style="text-align: center">{{ $i + 1 }}</td>
                                        <td style="text-align: left">{{ $item['nama'] }}</td>
                                        <td style="text-align: center">{{ $item['kode_daerah'] }}</td>
                                        <td style="text-align: center">
                                            <a href="{{ route('dashboard.data-pengiriman.daerah', $item['id_daerah']) }}"
                                                class="inline-flex items-center justify-center bg-[#4A90E2] hover:bg-[#357ABD] text-white rounded-lg px-3 py-2 transition-colors"
                                                title="Lihat Detail Pengiriman">
                                                <i class="bx bx-map-pin text-lg mr-1"></i>
                                                Detail Pengiriman
                                            </a>
                                        </td>
                                        <td style="text-align: center">
                                            <div class="flex flex-row justify-center gap-2">
                                                <a href="javascript:void(0)"
                                                    onclick="openEditModal('{{ $item['id_daerah'] }}', '{{ $item['kode_daerah'] }}', '{{ $item['nama'] }}')"
                                                    class="inline-flex items-center justify-center rounded bg-yellow-500 p-3 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2"
                                                    title="Edit Daerah">
                                                    <i class="bx bx-edit text-white"></i>
                                                </a>
                                                <button type="button"
                                                    onclick="openDeleteModal('{{ $item['id_daerah'] }}', '{{ $item['nama'] }}')"
                                                    class="focus:ring-2 focus:ring-offset-2 inline-flex items-center justify-center p-3 bg-red-500 hover:bg-red-600 focus:outline-none rounded"
                                                    title="Hapus Daerah">
                                                    <i class="bx bx-trash-alt text-white"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada data daerah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Modal Konfirmasi Hapus -->
                        <div id="deleteModal"
                            class="fixed inset-0 z-10 hidden items-center justify-center bg-black bg-opacity-50 flex">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 text-center">
                                <div class="mb-4 flex justify-center">
                                    <img src="{{ asset('assets/images/dashboard/warning.png') }}" alt="Warning Icon"
                                        class="h-12 w-12" />
                                </div>
                                <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi
                                    Hapus
                                </h3>
                                <p class="mb-6 text-base text-gray-500" id="deleteModalText">
                                    Apakah Anda yakin ingin menghapus data daerah ini?
                                </p>
                                <div class="flex w-full justify-center gap-4">
                                    <form id="deleteForm" method="POST" class="w-1/2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-[#4A90E2] w-full px-6 py-2 text-white text-center hover:bg-[#357ABD] focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:ring-offset-2">Hapus</button>
                                    </form>
                                    <button type="button"
                                        class="rounded-lg border border-[#4A90E2] w-1/2 px-6 py-2 text-[#4A90E2] focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:ring-offset-2"
                                        onclick="closeDeleteModal()">Batal</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->

                        <!-- Modal Edit Daerah -->
                        <div id="editModal" class="fixed inset-0 z-10 hidden items-center justify-center bg-black bg-opacity-50 flex">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 text-center">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Edit Daerah</h3>
                                <form id="editForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <input type="text" name="kode_daerah" id="editKodeDaerah" class="w-full border rounded px-3 py-2"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <input type="text" name="nama" id="editNama" class="w-full border rounded px-3 py-2"
                                            required>
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="submit"
                                            class="rounded-lg bg-[#4A90E2] w-full px-6 py-2 text-white">Update</button>
                                        <button type="button" onclick="closeEditModal()"
                                            class="rounded-lg border border-[#4A90E2] w-full px-6 py-2 text-[#4A90E2]">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Create Modal
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }
        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        // Edit Modal
        function openEditModal(id, kode_daerah, nama) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editKodeDaerah').value = kode_daerah;
            document.getElementById('editNama').value = nama;
            document.getElementById('editForm').action = "/dashboard/data-daerah/" + id;
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Delete Modal (sudah ada)
        let deleteModal = document.getElementById('deleteModal');
        let deleteForm = document.getElementById('deleteForm');
        let deleteModalText = document.getElementById('deleteModalText');
        function openDeleteModal(idDaerah, namaDaerah) {
            deleteForm.action = "/dashboard/data-daerah/" + idDaerah;
            deleteModalText.innerHTML = "Apakah Anda yakin ingin menghapus daerah <b>" + namaDaerah + "</b>?";
            deleteModal.classList.remove('hidden');
        }
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Swal Toast Success/Error
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
        @endif

        @if($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ $errors->first() }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>
@endsection
