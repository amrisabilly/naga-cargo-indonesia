@extends('dashboard.layout.app', [
    'title' => 'Dashboard',
])

@section('content')
    <section class="h-full flex flex-col max-h-[95vh] w-full py-5 pt-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Dashboard <span class="">
                    Dropshiper
                </span>
            </h1>
            <p class="mt-2 text-gray-500 text-base">
                Fitur ini digunakan untuk menampilkan statistik data, jumlah barang dan pengguna.
            </p>
        </div>

        <!-- Card Section -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card Data -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[18px] font-semibold text-gray-800">
                    Data Pengiriman
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[33px] font-bold">
                        {{ $totalPengiriman }}
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#4A90E2]/10">
                        <i class='bx bx-package text-3xl text-[#4A90E2]'></i>
                    </div>
                </div>
            </div>

            <!-- Card User -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[20px] font-semibold text-gray-800">
                    Total Kurir
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[33px] font-bold">
                        {{ $totalKurir }}
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#4A90E2]/10">
                        <i class='bx bx-user text-3xl text-[#4A90E2]'></i>
                    </div>
                </div>
            </div>

            <!-- Card Produk -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[20px] font-semibold text-gray-800">
                    Total <span class="italic">PIC</span> 
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[33px] font-bold">
                        {{ $totalPIC }}
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#4A90E2]/10">
                        <i class='bx bx-user-check text-3xl text-[#4A90E2]'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="flex flex-1 flex-col rounded-lg bg-white shadow p-5">
            {{-- Header dengan Judul dan Dropdown Tahun --}}
            <div class="mb-2 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Statistik Pengiriman Bulanan</h3>
                <select id="yearSelector"
                    class="rounded-lg border text-xs focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="2026" >2026</option>
                    <option value="2025" selected>2025</option>
                    <option value="2024" >2024</option>
                </select>
            </div>

            {{-- Canvas untuk Grafik --}}
            <div class="flex-1">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        {{-- <pre>
            {{ json_encode($statistikPengiriman, JSON_PRETTY_PRINT) }}
        </pre> --}}
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dummy untuk chart
        const chartData = @json($statistikPengiriman);

        const allCategories = ["Pengiriman", "Produk"];

        const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ];

        // Palet warna untuk setiap kategori
        const colorPalette = [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)'
        ];

        // Fungsi untuk membuat dataset berdasarkan tahun
        function createDatasets(year) {
            const dataForYear = chartData[year] || {};

            return allCategories.map((category, index) => {
                const monthlyData = labels.map((month) => {
                    return dataForYear[month]?.[category] ?? 0;
                });

                return {
                    label: category,
                    data: monthlyData,
                    backgroundColor: colorPalette[index % colorPalette.length],
                    borderColor: colorPalette[index % colorPalette.length].replace('0.6', '1'),
                    borderWidth: 2,
                };
            });
        }

        // Inisialisasi Grafik
        const ctx = document.getElementById('myChart').getContext('2d');
        const yearSelector = document.getElementById('yearSelector');
        const initialYear = yearSelector.value;

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: createDatasets(initialYear),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Laporan Bulanan Dropshiper',
                        font: {
                            size: 18
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        position: 'top'
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                },
            },
        });

        // Event Listener untuk Dropdown
        yearSelector.addEventListener('change', function() {
            const selectedYear = this.value;
            myChart.data.datasets = createDatasets(selectedYear);
            myChart.update();
        });
    </script>
@endsection
