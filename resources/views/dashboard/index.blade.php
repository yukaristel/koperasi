@php
    use Carbon\Carbon;

    $bulanIni = Carbon::now()->month;
    $surplus = $saldo['surplus'];

    $surplus_saat_ini = $surplus[$bulanIni] ?? 0;
    $surplus_bulan_lalu = $surplus[$bulanIni - 1] ?? 0;

    // Hindari pembagian nol
    if ($surplus_bulan_lalu > 0) {
        $peningkatan_surplus = round((($surplus_saat_ini - $surplus_bulan_lalu) / $surplus_bulan_lalu) * 100, 2);
    } else {
        $peningkatan_surplus = 0;
    }
@endphp

@extends('layouts.app')

@section('style')
    <style>
        .btn-pulse-outer {
            position: relative;
            height: 40%;
            aspect-ratio: 1 / 1; /* Lebar dan tinggi sama */
            min-height: 72px; /* Tinggi minimal 50px */
            border-radius: 50%;
            background-color: #009688;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }

        .btn-pulse-outer span.pulse-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #009688;
            opacity: 0.4;
            animation: pulse-ring 4s ease-out infinite;
            z-index: 0;
        }

        .btn-pulse-outer span.pulse-ring.delay {
            animation-delay: 1s;
        }

        .btn-pulse-outer span.pulse-ring.delay2 {
            animation-delay: 2s;
        }
        .btn-pulse-outer span.pulse-ring.delay3 {
            animation-delay: 3s;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 0.4;
            }

            70% {
                transform: scale(2.5);
                opacity: 0;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .btn-pulse-outer i {
            position: relative;
            z-index: 1;
            color: white;
            font-size: 24px;
        }
    </style>
@endsection

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid">
            <div class="row my-4 d-flex align-items-stretch">
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Simpanan Anggota</h6>
                            <p class="text-sm">Perkembangan simpanan anggota koperasi.</p>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart mb-2">
                                <canvas id="chart-simpanan" class="chart-canvas" height="240"></canvas>
                            </div>
                            <button class="btn btn-white mb-0 ms-auto">Lihat Laporan</button>
                        </div>
                    </div>
                </div> <!--kiri-->
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Pinjaman Anggota</h6>
                            <p class="text-sm">Perkembangan pinjaman anggota koperasi.</p>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart mb-2">
                                <canvas id="chart-pinjaman" class="chart-canvas" height="240"></canvas>
                            </div>
                            <button class="btn btn-white mb-0 ms-auto">Lihat Laporan</button>
                        </div>
                    </div>
                </div> 
                <div class="col-xl-4 col-sm-6 mb-md-0 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-body text-start p-3 w-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon icon-shape icon-sm bg-primary text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-sm text-secondary mb-1">Jumlah Anggota</p>
                                <h4 class="mb-2 font-weight-bold">1.235</h4>
                                <div class="d-flex align-items-center">
                                    <span class="text-sm text-success font-weight-bolder">
                                        <i class="fa fa-chevron-up text-xs me-1"></i>18%
                                    </span>
                                    <span class="text-sm ms-1">dari 1.047</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center h-100 mt-3 ">
                                <a href="/data/anggota" class="btn-pulse-outer">
                                    <span class="pulse-ring"></span>
                                    <span class="pulse-ring delay"></span>
                                    <span class="pulse-ring delay2"></span>
                                    <span class="pulse-ring delay3"></span>
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Ringkasan Keuangan Koperasi</h6>
                                    <p class="text-sm mb-sm-0 mb-2">Ikhtisar kondisi keuangan koperasi.</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                        Lihat Laporan
                                    </button>
                                </div>
                            </div>
                            <div class="d-sm-flex align-items-center">
                                <h3 class="mb-0 font-weight-semibold">Rp.
                                    {{ number_format($surplus_saat_ini, 0, ',', '.') }}</h3>

                                @php
                                    $warna = $peningkatan_surplus < 0 ? 'danger' : 'success';
                                    $ikonNaik = $peningkatan_surplus >= 0;
                                @endphp

                                <span
                                    class="badge badge-sm border border-{{ $warna }} text-{{ $warna }} bg-{{ $warna }} border-radius-sm ms-sm-3 px-2 d-inline-flex align-items-center gap-1">
                                    <svg width="9" height="9" viewBox="0 0 10 9" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="{{ $ikonNaik ? '' : 'transform: rotate(180deg);' }}">
                                        <path
                                            d="M0.47 4.47C0.18 4.76 0.18 5.24 0.47 5.53C0.76 5.82 1.24 5.82 1.53 5.53L0.47 4.47ZM5.53 1.53C5.82 1.24 5.82 0.76 5.53 0.47C5.24 0.18 4.76 0.18 4.47 0.47L5.53 1.53ZM5.53 0.47C5.24 0.18 4.76 0.18 4.47 0.47C4.18 0.76 4.18 1.24 4.47 1.53L5.53 0.47ZM8.47 5.53C8.76 5.82 9.24 5.82 9.53 5.53C9.82 5.24 9.82 4.76 9.53 4.47L8.47 5.53ZM1.53 5.53L5.53 1.53L4.47 0.47L0.47 4.47L1.53 5.53ZM4.47 1.53L8.47 5.53L9.53 4.47L5.53 0.47L4.47 1.53Z"
                                            fill="currentColor" />
                                    </svg>
                                    {{ $peningkatan_surplus }}%
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart mt-n6">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div><!--tengah-->
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        if (document.getElementsByClassName('mySwiper')) {
            var swiper = new Swiper(".mySwiper", {
                effect: "cards",
                grabCursor: true,
                initialSlide: 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        };

        var ctx = document.getElementById("chart-simpanan").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: @json($simp_labels),
                datasets: @json($simp_set)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        min: 0,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4],
                        },
                        ticks: {
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        },
                    },
                },
            }
        });


        var ctx = document.getElementById("chart-pinjaman").getContext("2d");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: @json($pinjaman_labels),
                datasets: [{
                    data: @json($pinjaman_data),
                    backgroundColor: [
                        "#2ca8ff",
                        "#7c3aed",
                        "#ed3a7c",
                        "#4adf83",
                        "#0f0b06",
                        "#a855f7"
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });

        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(45,168,255,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(45,168,255,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(45,168,255,0)');

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke2.addColorStop(1, 'rgba(119,77,211,0.4)');
        gradientStroke2.addColorStop(0.7, 'rgba(119,77,211,0.1)');
        gradientStroke2.addColorStop(0, 'rgba(119,77,211,0)');

        new Chart(ctx2, {
            plugins: [{
                    beforeInit(chart) {
                        const originalFit = chart.legend.fit;
                        chart.legend.fit = function fit() {
                            originalFit.bind(chart.legend)();
                            this.height += 40;
                        };
                    }
                },
                {
                    id: 'currentDateLine',
                    afterDraw: (chart) => {
                        const now = new Date();
                        const currentMonth = now.getMonth(); // 0 = Jan
                        const currentDate = now.getDate();
                        const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();

                        const xAxis = chart.scales.x;
                        const chartArea = chart.chartArea;

                        if (!xAxis) return;

                        const startX = xAxis.getPixelForValue(currentMonth);
                        const endX = xAxis.getPixelForValue(currentMonth + 1);

                        const dayPercent = currentDate / daysInMonth;
                        const lineX = startX + (endX - startX) * dayPercent;

                        const ctx = chart.ctx;
                        ctx.save();
                        ctx.beginPath();
                        ctx.moveTo(lineX, chartArea.top);
                        ctx.lineTo(lineX, chartArea.bottom);
                        ctx.lineWidth = 1;
                        ctx.strokeStyle = 'rgba(0,0,0,0.5)';
                        ctx.stroke();
                        ctx.restore();
                    }
                }
            ],
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                datasets: [{
                        label: "Pendapatan",
                        type: "bar",
                        order: 1,
                        tension: 0.4,
                        borderWidth: 0,
                        borderSkipped: false,
                        backgroundColor: "#4adf83",
                        data: @json(array_values($saldo[4])),
                        maxBarThickness: 24
                    },
                    {
                        label: "Beban",
                        type: "bar",
                        order: 1,
                        tension: 0.4,
                        borderWidth: 0,
                        borderSkipped: false,
                        backgroundColor: "#ed3a7c",
                        data: @json(array_map(fn($v) =>  $v, array_values($saldo[5]))),
                        maxBarThickness: 24
                    },
                    {
                        label: "Surplus",
                        type: "line",
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#2ca8ff",
                        pointBorderColor: "#2ca8ff",
                        pointBackgroundColor: "#2ca8ff",
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: @json(array_values($saldo['surplus'])),
                        maxBarThickness: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 6,
                            boxHeight: 6,
                            padding: 20,
                            pointStyle: 'circle',
                            borderRadius: 50,
                            usePointStyle: true,
                            font: {
                                weight: 400,
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        pointRadius: 2,
                        usePointStyle: true,
                        boxWidth: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        stacked: false,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp. ' + parseInt(value).toLocaleString();
                            },
                            display: true,
                            padding: 10,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    },
                    x: {
                        stacked: false,
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            display: true,
                            padding: 20,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    }
                }
            }
        });
    </script>
@endsection
