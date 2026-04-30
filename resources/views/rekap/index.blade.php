@extends('rekap.layout.base')

@section('content')
    <form action="" method="post" id="defaultForm">
        @csrf

        <input type="hidden" name="tgl" id="tgl" value="{{ date('d/m/Y') }}">
    </form>

    <style>
        .text-justify {
            text-align: justify;
        }
    </style>

    <div class="container-fluid py-2">

        {{-- ROW 1: Widget cards --}}
        <div class="row my-4 d-flex align-items-stretch">
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0">
                        <h6 class="font-weight-semibold text-lg mb-0">Keanggotaan</h6>
                    </div>
                    <div class="card-body py-3" id="btnAktif">
                        @php
                        $calon = $total->anggota - $total->total_2;
                        $total_s = $total->total_1 + $total->total_2;
                        @endphp
                        <div class="widget-numbers text-secondary" style="font-size: 17px;">
                            <strong>{{$total->total_1}}</strong> Anggota umum
                        </div>
                        <div class="widget-numbers" style="font-size: 17px;">
                            <strong class="text-warning">{{$total->total_2}}</strong> Anggota Pendiri
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-semibold text-lg mb-0">Simpanan</h6>
                        <span class="text-xs text-secondary">{{ date('d/m/y') }}</span>
                    </div>
                    <div class="card-body py-3">
                        <div class="widget-numbers text-secondary" style="font-size: 17px;">
                            <strong>{{$total_s}}</strong> Total Simpanan
                        </div>
                        <div class="widget-numbers" style="font-size: 17px;">
                            <strong class="text-warning">{{$total->total_1}}</strong> Simpanan Umum
                        </div>
                        <div class="widget-numbers text-success" style="font-size: 17px;">
                            <strong>{{$total->total_2}}</strong> Simpanan Pokok
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-semibold text-lg mb-0">Pinjaman</h6>
                        <span class="text-xs text-secondary">{{ date('d/m/y') }}</span>
                    </div>
                    <div class="card-body py-3">
                        <div class="widget-numbers text-primary" style="font-size: 17px;">
                            <strong>{{$total->total_p}}</strong> Proposal
                        </div>
                        <div class="widget-numbers text-warning" style="font-size: 17px;">
                            <strong>{{$total->total_v}}</strong> Verifikasi
                        </div>
                        <div class="widget-numbers text-success" style="font-size: 17px;">
                            <strong>{{$total->total_a}}</strong> Aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 2: Charts --}}
        <div class="row mb-4 d-flex align-items-stretch">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0">
                        <h6 class="font-weight-semibold text-lg mb-0">Surplus Hari Ini</h6>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart">
                            <canvas id="myChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-8 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-semibold text-lg mb-0">Realisasi Pendapatan dan Beban</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-success"></i>
                                <span class="text-dark text-xs">Pendapatan</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-warning"></i>
                                <span class="text-dark text-xs">Beban</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-info"></i>
                                <span class="text-dark text-xs">Laba</span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="400"
                                style="display: block; box-sizing: border-box; height: 210px; width: 844.4px;"
                                width="1688"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <textarea name="msgInvoice" id="msgInvoice" class="d-none">{{ Session::get('msg') }}</textarea>
    <form action="/pelaporan/preview" method="post" id="FormLaporanDashboard" target="_blank">
        @csrf

        <input type="hidden" name="type" id="type" value="pdf">
        <input type="hidden" name="tahun" id="tahun" value="{{ date('Y') }}">
        <input type="hidden" name="bulan" id="bulan" value="{{ date('m') }}">
        <input type="hidden" name="hari" id="hari" value="{{ date('d') }}">
        <input type="hidden" name="laporan" id="laporan" value="">
        <input type="hidden" name="sub_laporan" id="sub_laporan" value="">
    </form>
@endsection

@section('script')
    @php
        $surplus_pie_label = collect($saldo_kec)->pluck('nama')->toArray();
        $surplus_pie_data = collect($saldo_kec)->pluck('surplus')->toArray();
        $pendapatan = collect($saldo_kec)->pluck('laba_rugi.pendapatan')->toArray();
        $biaya      = collect($saldo_kec)->pluck('laba_rugi.biaya')->toArray();
    @endphp
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })

        var ctx1 = document.getElementById("chart-line").getContext("2d");
        var ctx2 = document.getElementById("myChart").getContext("2d");

        // Line chart
        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: @json($surplus_pie_label),
                datasets: [{
                        label: "Pendapatan",
                        backgroundColor: "#4CAF50",
                        borderWidth: 1,
                        data: @json($pendapatan),
                    },{
                        label: "Surplus",
                        backgroundColor: "#1A73E8",
                        borderWidth: 1,
                        data: @json($surplus_pie_data),
                    },{
                        label: "Biaya",
                        backgroundColor: "#e91e63",
                        borderWidth: 1,
                        data: @json($biaya),
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#9ca2b7',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: true,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            color: '#9ca2b7',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        // Pie chart
        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: { 
                labels: @json($surplus_pie_label),
                datasets: [{
                    label: 'Projects',
                    backgroundColor: [
                        '#1a73e8',
                        '#4caf50',
                        '#344767',
                        '#fb8c00',
                        '#f44335',
                        '#1a73e8',
                        '#4caf50',
                        '#344767',
                        '#fb8c00',
                        '#f44335',
                    ],
                    borderWidth: 1,
                    data: @json($surplus_pie_data),
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });

        let childWindow, loading;
        $(document).on('click', '#simpanSaldo', function(e) {
            var link = $(this).attr('data-href')

            loading = Swal.fire({
                title: "Mohon Menunggu..",
                html: "Menyimpan Saldo Januari sampai Desember Th. {{ date('Y') }}",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })

            childWindow = window.open(link, '_blank');
        })

        window.addEventListener('message', function(event) {
            if (event.data === 'closed') {
                loading.close()
                window.location.reload()
            }
        })

    </script>
@endsection
