@extends('dashboard.layout.app', [
    'title' => 'Detail Pengiriman',
])

@section('style')
    <style>
        /* Gallery Styling */
        .gallery-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            height: 440px;
        }

        .main-image {
            grid-row: 1 / 3;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            cursor: pointer;
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .main-image:hover img {
            transform: scale(1.05);
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }

        .thumbnail {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover {
            border-color: #879FFF;
            transform: scale(1.05);
        }

        .thumbnail.active {
            border-color: #879FFF;
            box-shadow: 0 0 0 2px rgba(135, 159, 255, 0.3);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-count {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
            padding: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
        }

        /* Modal Styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            max-width: 90vw;
            max-height: 90vh;
            position: relative;
        }

        .modal-image {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .modal-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .modal-nav:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .modal-nav.prev {
            left: -60px;
        }

        .modal-nav.next {
            right: -60px;
        }

        .modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .modal-close:hover {
            opacity: 0.7;
        }

        .modal-counter {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 0.9rem;
            background: rgba(0, 0, 0, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        /* Status Badge Styling */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-terkirim {
            background: #dcfce7;
            color: #166534;
        }

        .status-proses {
            background: #fef3c7;
            color: #92400e;
        }

        .status-gagal {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Info Card Styling - Updated */
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* Changed from center to flex-start */
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
            gap: 1rem;
            /* Add gap between label and value */
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
            flex-shrink: 0;
            /* Prevent label from shrinking */
            min-width: 80px;
            /* Minimum width for labels */
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
            text-align: right;
            word-wrap: break-word;
            /* Break long words */
            overflow-wrap: break-word;
            /* Modern browsers */
            hyphens: auto;
            /* Add hyphens for long words */
            line-height: 1.4;
            /* Better line height for multi-line text */
        }

        /* Special styling for address rows */
        .info-row.address {
            align-items: flex-start;
        }

        .info-row.address .info-value {
            text-align: left;
            /* Left align for addresses */
            max-width: 200px;
            /* Limit width to prevent overflow */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .info-row {
                flex-direction: column;
                gap: 0.5rem;
            }

            .info-value {
                text-align: left;
                max-width: 100%;
            }

            .info-label {
                min-width: auto;
            }
        }
    </style>
@endsection

@section('content')
    {{-- @dd($order) --}}
    <section class="h-full flex flex-col w-full py-5 overflow-auto">
        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.data-pengiriman.daerah', $order->id_daerah) }}"
                    class="flex items-center justify-center w-10 h-10 bg-[#4A90E2] hover:bg-[#4A90E2] rounded-lg transition-colors shadow-sm">
                    <i class="bx bx-arrow-back text-xl text-white"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pengiriman</h1>
                    <p class="mt-1 text-base text-gray-500">Informasi lengkap pengiriman <span
                            class="font-bold">{{ $order->AWB }}</span></p>

                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
            {{-- Left Column - Info Details --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Sender & Receiver Info --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Keterangan</h3>

                    {{-- Sender --}}
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                            <i class="bx bx-user text-[#4A90E2]"></i>
                            Pengirim
                        </h4>
                        <div class="info-card">
                            <div class="info-row">
                                <span class="info-label">Nama</span>
                                <span class="info-value">{{ $order->user->nama ?? 'Data masih kosong' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Telepon</span>
                                <span class="info-value">{{ $order->user->no_hp ?? 'Data masih kosong' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Kirim</span>
                                <span class="info-value">{{ $date->user->no_hp ?? 'Data masih kosong' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Receiver --}}
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                            <i class="bx bx-map-pin text-[#4A90E2]"></i>
                            Penerima
                        </h4>
                        <div class="info-card">
                            <div class="info-row">
                                <span class="info-label">Nama</span>
                                <span class="info-value">{{ $order->penerima ?? 'Data masih kosong' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Telepon</span>
                                <span class="info-value">{{ $order->no_hp ?? 'Data masih kosong' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                            <i class="bx bx-map-pin text-[#4A90E2]"></i>
                            Status Pengiriman
                        </h4>
                        <div class="flex items-center gap-3">
                            <span
                                class="status-badge @if ($order->status == 'Terkirim') status-terkirim @elseif($order->status == 'Proses') status-proses @elseif($order->status == 'Gagal') status-gagal @endif">
                                <i
                                    class="bx @if ($order->status == 'Terkirim') bx-check @elseif($order->status == 'Dalam Proses') bx-loader @elseif($order->status == 'Gagal') bx-x @endif"></i>
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column - Photo Gallery --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6 h-fit">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumentasi Pengiriman</h3>

                    {{-- Gallery --}}
                    <div class="gallery-container">
                        {{-- Main Image --}}
                        <div class="main-image" onclick="openModal(0)">
                            <img id="mainImage"
                                src="{{ asset('storage/' . $fotos->first()->path_foto) ?? 'https://picsum.photos/150/150' }}"
                                alt="Main Photo" loading="lazy">
                            <div class="absolute top-4 left-4 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm">
                                <i class="bx bx-camera mr-1"></i>
                                <span id="imageCounter">1 / {{ $fotos->count() }}</span>
                            </div>
                        </div>

                        {{-- Thumbnail Grid --}}
                        <div class="thumbnail-grid">
                            @foreach ($fotos as $i => $foto)
                                <div class="thumbnail{{ $i == 0 ? ' active' : '' }}"
                                    onclick="changeMainImage({{ $i }}, this)">
                                    <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Photo {{ $i + 1 }}"
                                        loading="lazy">
                                    @if ($i == 6 && $fotos->count() > 7)
                                        <div class="thumbnail-count">+{{ $fotos->count() - 6 }} Foto</div>
                                    @endif
                                </div>
                            @endforeach
                            @if ($fotos->isEmpty())
                                <div class="thumbnail active">
                                    <img src="https://picsum.photos/150/150" alt="No Photo" loading="lazy">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Photo Description --}}
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="bx bx-info-circle text-[#879FFF]"></i>
                            <span id="photoDescription">Foto paket sebelum dikirim - Kondisi baik dan siap dikirim</span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    {{-- Modal for Full Image View --}}
    <div id="imageModal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <button class="modal-nav prev" onclick="prevImage()">
                <i class="bx bx-chevron-left text-2xl"></i>
            </button>
            <img id="modalImage" class="modal-image" src="" alt="Full Size Image">
            <button class="modal-nav next" onclick="nextImage()">
                <i class="bx bx-chevron-right text-2xl"></i>
            </button>
            <div class="modal-counter">
                <span id="modalCounter">1 / 7</span>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Data foto dari backend
        const images = [
            @foreach ($fotos as $foto)
                {
                    url: '{{ asset('storage/' . $foto->path_foto) }}',
                    description: '{{ $foto->keterangan ?? 'Tidak ada keterangan' }}'
                }
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        ];

        let currentImageIndex = 0;

        function changeMainImage(index, thumbnail) {
            currentImageIndex = index;
            document.getElementById('mainImage').src = images[index]?.url ||
                'https://via.placeholder.com/600x400?text=No+Image';
            document.getElementById('imageCounter').textContent = `${index + 1} / ${images.length}`;
            document.getElementById('photoDescription').textContent = images[index]?.description || '';
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            if (thumbnail) thumbnail.classList.add('active');
        }

        function openModal(index) {
            if (!images.length) return;
            currentImageIndex = index;
            document.getElementById('modalImage').src = images[index]?.url ||
                'https://via.placeholder.com/600x400?text=No+Image';
            document.getElementById('modalCounter').textContent = `${index + 1} / ${images.length}`;
            document.getElementById('imageModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('imageModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function prevImage() {
            if (!images.length) return;
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            document.getElementById('modalImage').src = images[currentImageIndex]?.url ||
                'https://via.placeholder.com/600x400?text=No+Image';
            document.getElementById('modalCounter').textContent = `${currentImageIndex + 1} / ${images.length}`;
        }

        function nextImage() {
            if (!images.length) return;
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            document.getElementById('modalImage').src = images[currentImageIndex]?.url ||
                'https://via.placeholder.com/600x400?text=No+Image';
            document.getElementById('modalCounter').textContent = `${currentImageIndex + 1} / ${images.length}`;
        }

        // Inisialisasi gambar utama dan deskripsi saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            changeMainImage(0, document.querySelector('.thumbnail'));
        });
    </script>
@endsection
