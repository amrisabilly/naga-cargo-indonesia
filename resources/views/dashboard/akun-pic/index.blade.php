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
                        <h1 class="text-3xl font-bold text-gray-900">Data Akun PIC</h1>
                        <p class="mt-1 text-base text-gray-500">Kelola akun username dan password kurir</p>
                    </div>
                    <div class="flex gap-3">
                        {{-- Tambah PIC Button --}}
                        <a href="{{ route('dashboard.data-pic.create') }}">
                            <button
                                class="bg-[#4A90E2] hover:bg-[#4A90E2] text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors shadow-sm text-sm">
                                <i class="bx bx-plus text-lg"></i>
                                Tambah pic
                            </button>
                        </a>
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
                                @foreach ($pics as $i => $pic)
                                    <tr>
                                        <td style="text-align: center">{{ $i + 1 }}</td>
                                        <td>{{ $pic->nama }}</td>
                                        <td>
                                            <div class="credential-item">
                                                <span class="credential-text ">{{ $pic->username }}</span>
                                                <button class="copy-btn p-1 rounded text-gray-500 "
                                                    onclick="copyToClipboard('{{ $pic->username }}', this)"
                                                    title="Salin Username">
                                                    <i class="bx bx-copy text-base"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="credential-item">
                                                <span class="credential-text">{{ $pic->password }}</span>
                                                <button class="copy-btn p-1 rounded text-gray-500 "
                                                    onclick="copyToClipboard('{{ $pic->password }}', this)"
                                                    title="Salin Password">
                                                    <i class="bx bx-copy text-base"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/^08/', '628', preg_replace('/[^0-9]/', '', $pic->no_hp)) }}"
                                                target="_blank"
                                                class="text-[#25D366] hover:underline font-semibold flex items-center gap-1"
                                                title="Chat WhatsApp">
                                                <i class="bx bxl-whatsapp text-lg"></i>
                                                {{ $pic->no_hp }}
                                            </a>
                                        </td>
                                        <td>{{ $pic->daerah->nama ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $pic->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                <div
                                                    class="w-1.5 h-1.5 {{ $pic->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2">
                                                </div>
                                                {{ $pic->status }}
                                            </span>
                                        </td>
                                        <td class="flex flex-row justify-center gap-2">
                                            <a href="{{ route('dashboard.data-pic.edit', $pic->id_user) }}"
                                                class="inline-flex items-start justify-start rounded bg-yellow-500 p-3 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                                                <i class="bx bx-edit text-white"></i>
                                            </a>
                                            <button type="button"
                                                onclick="openDeleteModal('{{ $pic->id_user }}', '{{ $pic->nama }}')"
                                                class="focus:ring-2 focus:ring-offset-2 inline-flex items-start justify-start p-3 bg-red-500 hover:bg-red-600 focus:outline-none rounded">
                                                <i class="bx bx-trash-alt text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Modal Konfirmasi Hapus -->
                        <div id="deleteModal"
                            class="fixed inset-0 z-10 hidden items-center justify-center bg-black bg-opacity-50 flex">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 text-center">
                                <div class="mb-4 flex justify-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-blue-50 border-2 border-blue-200 flex items-center justify-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-[#4A90E2] to-[#357ABD] flex items-center justify-center shadow-lg">
                                            <i class="bx bx-trash text-white text-2xl"></i>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi
                                    Hapus</h3>
                                <p class="mb-6 text-base text-gray-500">Apakah Anda yakin ingin menghapus data PIC ini?
                                    Semua data terkait juga akan dihapus.</p>
                                <div class="flex w-full justify-center gap-4">
                                    <form id="deleteForm" method="POST" class="w-1/2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-[#4A90E2] w-full px-6 py-2 text-white text-center hover:bg-[#397ac4] focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:ring-offset-2 transition-colors">Hapus</button>
                                    </form>
                                    <button type="button"
                                        class="rounded-lg border border-[#4A90E2] w-1/2 px-6 py-2 text-[#4A90E2] focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:ring-offset-2 transition-colors"
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
