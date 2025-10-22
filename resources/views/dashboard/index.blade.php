@extends('dashboard.layout.app', [
    'title' => 'Dashboard',
])

@section('content')
    <section class="h-full flex flex-col max-h-[95vh] w-full py-5">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <span class="italic">Dashboard&nbsp;</span>
                Dropshiper
            </h1>
            <p class="mt-2 text-gray-500">
                Fitur ini digunakan untuk menampilkan statistik data, jumlah barang dan pengguna.
            </p>
        </div>

        <!-- Card Section -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card Data -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[20px] font-semibold text-gray-800">
                    Data Pengiriman
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[36px] font-bold text-[#879FFF]">
                        125
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#879FFF]/10">
                        <i class='bx bx-package text-3xl text-[#879FFF]'></i>
                    </div>
                </div>
            </div>

            <!-- Card User -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[20px] font-semibold text-gray-800">
                    Total Pengguna
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[36px] font-bold text-[#879FFF]">
                        125
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#879FFF]/10">
                        <i class='bx bx-package text-3xl text-[#879FFF]'></i>
                    </div>
                </div>
            </div>

            <!-- Card Produk -->
            <div class="flex h-[150px] flex-col justify-between rounded-xl bg-white p-4 shadow">
                <span class="text-left text-[20px] font-semibold text-gray-800">
                    Total Produk
                </span>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-[36px] font-bold text-[#879FFF]">
                        125
                    </span>
                    <div class="flex h-[64px] w-[64px] items-center justify-center rounded-xl bg-[#879FFF]/10">
                        <i class='bx bx-package text-3xl text-[#879FFF]'></i>
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
                    <option value="2024" selected>2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>

            {{-- Canvas untuk Grafik --}}
            <div class="flex-1">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dummy untuk chart
        const chartData = {
            "2024": {
                "Januari": {
                    "Pengiriman": 45,
                    "Produk": 20
                },
                "Februari": {
                    "Pengiriman": 52,
                    "Produk": 25
                },
                "Maret": {
                    "Pengiriman": 38,
                    "Produk": 18
                },
                "April": {
                    "Pengiriman": 61,
                    "Produk": 30
                },
                "Mei": {
                    "Pengiriman": 55,
                    "Produk": 28
                },
                "Juni": {
                    "Pengiriman": 67,
                    "Produk": 35
                },
                "Juli": {
                    "Pengiriman": 73,
                    "Produk": 40
                },
                "Agustus": {
                    "Pengiriman": 69,
                    "Produk": 38
                },
                "September": {
                    "Pengiriman": 58,
                    "Produk": 32
                },
                "Oktober": {
                    "Pengiriman": 64,
                    "Produk": 36
                },
                "November": {
                    "Pengiriman": 71,
                    "Produk": 42
                },
                "Desember": {
                    "Pengiriman": 78,
                    "Produk": 45
                }
            },
            "2023": {
                "Januari": {
                    "Pengiriman": 35,
                    "Produk": 15
                },
                "Februari": {
                    "Pengiriman": 42,
                    "Produk": 20
                },
                "Maret": {
                    "Pengiriman": 28,
                    "Produk": 12
                },
                "April": {
                    "Pengiriman": 51,
                    "Produk": 25
                },
                "Mei": {
                    "Pengiriman": 45,
                    "Produk": 22
                },
                "Juni": {
                    "Pengiriman": 57,
                    "Produk": 30
                },
                "Juli": {
                    "Pengiriman": 63,
                    "Produk": 35
                },
                "Agustus": {
                    "Pengiriman": 59,
                    "Produk": 32
                },
                "September": {
                    "Pengiriman": 48,
                    "Produk": 28
                },
                "Oktober": {
                    "Pengiriman": 54,
                    "Produk": 31
                },
                "November": {
                    "Pengiriman": 61,
                    "Produk": 37
                },
                "Desember": {
                    "Pengiriman": 68,
                    "Produk": 40
                }
            }
        };

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
