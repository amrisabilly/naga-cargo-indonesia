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
            height: 400px;
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
    <section class="h-full flex flex-col w-full py-5 overflow-auto">
        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.data-pengiriman.index') }}"
                    class="flex items-center justify-center w-10 h-10 bg-[#879FFF] hover:bg-[#6B7EF7] rounded-lg transition-colors shadow-sm">
                    <i class="bx bx-arrow-back text-xl text-white"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pengiriman</h1>
                    <p class="mt-1 text-base text-gray-500">Informasi lengkap pengiriman <span class="font-bold">PKG0010201930</span></p>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
            {{-- Left Column - Info Details --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Sender & Receiver Info --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pengirim & Penerima</h3>

                    {{-- Sender --}}
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                            <i class="bx bx-user text-[#879FFF]"></i>
                            Pengirim
                        </h4>
                        <div class="info-card">
                            <div class="info-row">
                                <span class="info-label">Nama</span>
                                <span class="info-value">John Doe</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Telepon</span>
                                <span class="info-value">08123456789</span>
                            </div>
                            <div class="info-row address">
                                <span class="info-label">Alamat</span>
                                <span class="info-value">Jl. Sudirman No. 123, RT.001/RW.002, Kelurahan Tanah Abang,
                                    Kecamatan Tanah Abang, Jakarta Pusat, DKI Jakarta 10230</span>
                            </div>
                        </div>
                    </div>

                    {{-- Receiver --}}
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                            <i class="bx bx-map-pin text-[#879FFF]"></i>
                            Penerima
                        </h4>
                        <div class="info-card">
                            <div class="info-row">
                                <span class="info-label">Nama</span>
                                <span class="info-value">Jane Smith</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Telepon</span>
                                <span class="info-value">08987654321</span>
                            </div>
                            <div class="info-row address">
                                <span class="info-label">Alamat</span>
                                <span class="info-value">Jl. Gatot Subroto No. 456, RT.003/RW.004, Kelurahan Setiabudi,
                                    Kecamatan Setiabudi, Jakarta Selatan, DKI Jakarta 12920</span>
                            </div>
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
                            <img id="mainImage" src="https://picsum.photos/600/400?random=1" alt="Main Photo"
                                loading="lazy">
                            <div class="absolute top-4 left-4 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm">
                                <i class="bx bx-camera mr-1"></i>
                                <span id="imageCounter">1 / 7</span>
                            </div>
                        </div>

                        {{-- Thumbnail Grid --}}
                        <div class="thumbnail-grid">
                            <div class="thumbnail active" onclick="changeMainImage(0, this)">
                                <img src="https://picsum.photos/150/150?random=1" alt="Photo 1" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(1, this)">
                                <img src="https://picsum.photos/150/150?random=2" alt="Photo 2" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(2, this)">
                                <img src="https://picsum.photos/150/150?random=3" alt="Photo 3" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(3, this)">
                                <img src="https://picsum.photos/150/150?random=4" alt="Photo 4" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(4, this)">
                                <img src="https://picsum.photos/150/150?random=5" alt="Photo 5" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(5, this)">
                                <img src="https://picsum.photos/150/150?random=6" alt="Photo 6" loading="lazy">
                            </div>
                            <div class="thumbnail" onclick="changeMainImage(6, this)">
                                <img src="https://picsum.photos/150/150?random=7" alt="Photo 7" loading="lazy">
                                <div class="thumbnail-count">+1 Foto</div>
                            </div>
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

                {{-- Tracking Timeline --}}
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline Pengiriman</h3>

                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <div class="w-0.5 h-16 bg-green-200"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Paket Terkirim</h4>
                                        <p class="text-sm text-gray-600">Paket telah diterima oleh Jane Smith</p>
                                    </div>
                                    <span class="text-xs text-gray-500">15 Jan 2024, 14:30</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <div class="w-0.5 h-16 bg-blue-200"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Dalam Pengiriman</h4>
                                        <p class="text-sm text-gray-600">Paket sedang dalam perjalanan ke tujuan</p>
                                    </div>
                                    <span class="text-xs text-gray-500">15 Jan 2024, 08:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <div class="w-0.5 h-16 bg-yellow-200"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Paket Diambil</h4>
                                        <p class="text-sm text-gray-600">Paket diambil dari lokasi pengirim</p>
                                    </div>
                                    <span class="text-xs text-gray-500">14 Jan 2024, 16:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Order Dibuat</h4>
                                        <p class="text-sm text-gray-600">Pesanan pengiriman dibuat</p>
                                    </div>
                                    <span class="text-xs text-gray-500">14 Jan 2024, 10:00</span>
                                </div>
                            </div>
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
        // Image data
        const images = [{
                url: 'https://picsum.photos/600/400?random=1',
                description: 'Foto paket sebelum dikirim - Kondisi baik dan siap dikirim'
            },
            {
                url: 'https://picsum.photos/600/400?random=2',
                description: 'Proses packaging - Paket dibungkus dengan rapi dan aman'
            },
            {
                url: 'https://picsum.photos/600/400?random=3',
                description: 'Label pengiriman - Alamat tujuan dan informasi lengkap'
            },
            {
                url: 'https://picsum.photos/600/400?random=4',
                description: 'Paket siap dikirim - Sudah diberi label dan siap pickup'
            },
            {
                url: 'https://picsum.photos/600/400?random=5',
                description: 'Loading ke kendaraan - Paket dimuat ke dalam kendaraan pengiriman'
            },
            {
                url: 'https://picsum.photos/600/400?random=6',
                description: 'Dalam perjalanan - Paket sedang dalam perjalanan ke tujuan'
            },
            {
                url: 'https://picsum.photos/600/400?random=7',
                description: 'Paket sampai tujuan - Paket telah diterima oleh penerima'
            }
        ];

        let currentImageIndex = 0;

        // Change main image
        function changeMainImage(index, thumbnail) {
            currentImageIndex = index;

            // Update main image
            document.getElementById('mainImage').src = images[index].url;
            document.getElementById('imageCounter').textContent = `${index + 1} / 7`;
            document.getElementById('photoDescription').textContent = images[index].description;

            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        // Open modal
        function openModal(index) {
            currentImageIndex = index;
            document.getElementById('modalImage').src = images[index].url;
            document.getElementById('modalCounter').textContent = `${index + 1} / 7`;
            document.getElementById('imageModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            document.getElementById('imageModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Previous image in modal
        function prevImage() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            document.getElementById('modalImage').src = images[currentImageIndex].url;
            document.getElementById('modalCounter').textContent = `${currentImageIndex + 1} / 7`;
        }

        // Next image in modal
        function nextImage() {
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            document.getElementById('modalImage').src = images[currentImageIndex].url;
            document.getElementById('modalCounter').textContent = `${currentImageIndex + 1} / 7`;
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('imageModal').classList.contains('active')) {
                if (e.key === 'Escape') closeModal();
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
            }
        });

        // Click outside modal to close
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection
