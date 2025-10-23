<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.bottombar activePage="hasil"></x-navbars.bottombar>
        <style>
            /* Tampilan lebih seperti input Bootstrap */
            .select2-container--default .select2-selection--single {
                border: 1px solid #ced4da;
                font-size: 0.8rem;


            }

            /* Fokus pada dropdown */
            .select2-container--default .select2-selection--single:focus {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            /* Styling utama untuk container timer */
            .timer-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 200px;
                width: 200px;
                position: relative;
                margin: 20px auto;
            }

            /* SVG Lingkaran */
            .countdown-circle {
                position: relative;
                width: 100px;
                height: 100px;
            }

            .countdown-circle svg {
                position: absolute;
                top: 0;
                left: 0;
                transform: rotate(-90deg);
                width: 100px;
                height: 100px;
            }

            .countdown-circle circle {
                fill: none;
                stroke-width: 8;
            }

            .background-circle {
                stroke: #f0f0f0;
            }

            .progress-circle {
                stroke: #ed8b00;
                /* Warna biru untuk progress */
                stroke-dasharray: 283;
                stroke-dashoffset: 283;
                transition: stroke-dashoffset 0.2s linear;
            }

            /* Teks Timer */
            #timer-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 18px;
                font-weight: bold;
                color: #333;
            }

            /* Tombol di bawah timer */
            /* .mt-4.text-center button {
                width: 100px;
                height: 40px;
                font-size: 16px;
                margin: 5px;
                border-radius: 5px;
                border: 1px solid #007bff;
                background-color: #007bff;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s;
            } */

            .mt-4.text-center button:disabled {
                background-color: #cccccc;
                cursor: not-allowed;
            }

            .mt-4.text-center button:hover:not(:disabled) {
                background-color: #ed8b00;
            }

            /* Penataan tombol jika menggunakan Flexbox */
            .mt-4.text-center {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            #timerDetails {
                display: none;
                /* Tetap disembunyikan secara default */
                margin-top: 20px;
                padding: 15px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                width: 300px;
                max-width: 90%;
                /* Pastikan tetap proporsional di layar kecil */
                margin-left: auto;
                margin-right: auto;
                overflow-y: auto;
                /* Tambahkan scrolling jika konten melebihi ukuran */
                max-height: calc(100vh - 80px);
                /* Pastikan tidak melebihi tinggi layar */
                z-index: 100;
                /* Untuk menjaga layer di atas elemen lain */
                position: relative;
                /* Agar tetap mengikuti konteks */
            }

            /* Styling untuk paragraf dalam timerDetails */
            #timerDetails p {
                font-size: 16px;
                color: #333;
                margin: 10px 0;
                word-wrap: break-word;
                /* Untuk mencegah teks panjang keluar area */
            }

            #timerDetails .time-label {
                font-weight: bold;
            }

            /* Style untuk teks hasil */
            #stopTime,
            #duration {
                font-size: 18px;
                color: #ed8b00;
                font-weight: bold;
                text-align: center;
            }
        </style>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.perawat titlePage="Hasil"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <div class="container-fluid py-4">
                <div class="row">

                    {{-- POKOK --}}
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                                    <h5 class="text-white text-capitalize ps-3">Tugas Pokok</h5>
                                </div>
                            </div>
                            <div class="card-body px-3 pb-2">
                                <section class="container my-1">
                                    <div class="row">
                                        <div class="col-12 col-md-8 button-datatable"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="author_table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Tindakan</th>
                                                    <th>Tanggal</th>
                                                    <th>Mulai</th>
                                                    <th>Berhenti</th>
                                                    <th>Durasi</th>
                                                    <th>Nama Pasien (No. RM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($laporan->where('tindakan.status', 'Tugas Pokok')->count() > 0)
                                                    @foreach ($laporan->where('tindakan.status', 'Tugas Pokok') as $data)
                                                        <tr>
                                                            <td class="text-center">{{ $data->tindakan->tindakan ?? 'Tidak Ada Data' }}</td>
                                                            <td class="text-center">{{ $data->tanggal }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i:s') }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($data->jam_berhenti)->format('H:i:s') }}</td>
                                                            <td class="text-center">{{ floor($data->durasi / 60) }} menit {{ $data->durasi % 60 }} detik</td>
                                                            <td class="text-center">{{ $data->nama_pasien ? $data->nama_pasien  : '-' }} <br>
                                                            {{ $data->keterangan ? $data->keterangan  : '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada tindakan pokok yang ditemukan.</td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    {{-- PENUNJANG --}}
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                                    <h5 class="text-white text-capitalize ps-3">Tugas Penunjang</h5>
                                </div>
                            </div>
                            <div class="card-body px-3 pb-2">
                                <section class="container my-1">
                                    <div class="row">
                                        <div class="col-12 col-md-8 button-datatable2"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="author_table2" class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Tindakan</th>
                                                    <th>Tanggal</th>
                                                    <th>Durasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($laporan->where('tindakan.status', 'Tugas Penunjang')->count() > 0)
                                                    @foreach ($laporan->where('tindakan.status', 'Tugas Penunjang') as $data)
                                                        <tr>
                                                            <td class="text-center">{{ $data->tindakan->tindakan ?? 'Tidak Ada Data' }}</td>
                                                            <td class="text-center">{{ $data->tanggal }}</td>
                                                            {{-- <td class="text-center">{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i:s') }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($data->jam_berhenti)->format('H:i:s') }}</td> --}}
                                                            @php
                                                                $totalMenit = $data->durasi * 60;
                                                                $jam = floor($totalMenit / 60);
                                                                $menit = $totalMenit % 60;
                                                            @endphp

                                                            <td class="text-center">
                                                            {{ $jam > 0 ? $jam.' jam ' : '' }}{{ $menit }} menit
                                                            </td>
                                                            <td class="text-center">{{ $data->keterangan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada tindakan penunjang yang ditemukan.</td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    {{-- TAMBAHAN --}}
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                                    <h5 class="text-white text-capitalize ps-3">Tugas Tambahan</h5>
                                </div>
                            </div>
                            <div class="card-body px-3 pb-2">
                                <section class="container my-1">
                                    <div class="row">
                                        <div class="col-12 col-md-8 button-datatable3"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="author_table3" class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Tindakan</th>
                                                    <th>Tanggal</th>
                                                    <th>Durasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($laporan->where('tindakan.status', 'tambahan')->count() > 0)
                                                    @foreach ($laporan->where('tindakan.status', 'tambahan') as $tindakan)
                                                        <tr>
                                                            <td>{{ $tindakan->tindakan->tindakan ?? 'Tidak Ada Data' }}</td>
                                                            <td>{{ $tindakan->tanggal ?? '-' }}</td>
                                                            {{-- <td class="text-center">{{ $tindakan->durasi }} </td> --}}
                                                            @php
                                                                $totalMenit = $tindakan->durasi * 60;
                                                                $jam = floor($totalMenit / 60);
                                                                $menit = $totalMenit % 60;
                                                            @endphp

                                                            <td class="text-center">
                                                            {{ $jam > 0 ? $jam.' jam ' : '' }}{{ $menit }} menit
                                                            </td>
                                                            <td>{{ $tindakan->keterangan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada tindakan penunjang yang ditemukan.</td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    {{-- ANALISA DATA --}}
                    @php
                        $totalHasil = 0;
                    @endphp
                    @if ($recordAnalisa)
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                                    <h5 class="text-white text-capitalize ps-3">Hasil Analisa Data</h5>
                                </div>
                            </div>
                            <div class="card-body px-3 pb-2">
                                <section class="container my-1">
                                    <p>Tindakan pokok pada <strong>{{ \Carbon\Carbon::parse($recordAnalisa->tanggal_awal)->format('d/m/Y') }}</strong> -> <strong>{{ \Carbon\Carbon::parse($recordAnalisa->tanggal_akhir)->format('d/m/Y') }}</strong></p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered  table-striped">
                                            <thead>
                                                <tr class="">
                                                    <th>Tindakan</th>
                                                    <th>Frekuensi</th>
                                                    <th>SWL (Jam)</th>
                                                    <th>Hasil (Jam)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalHasil = 0;
                                                    $grouped = $recordAnalisa->laporanTindakan->groupBy('tindakan_id');
                                                @endphp
                                                @foreach($grouped as $tindakan)
                                                    <tr>
                                                        {{-- @foreach($tindakan as $perawatItem) --}}
                                                            @php
                                                                // Kelompokkan laporan berdasarkan tindakan_id


                                                                // dd($tindakan);

                                                                // Total jam semua laporan untuk tindakan ini
                                                                $totalJamTindakan = collect($tindakan)->sum(function ($laporan) {
                                                                    $mulai = \Carbon\Carbon::parse($laporan->jam_mulai);
                                                                    $berhenti = \Carbon\Carbon::parse($laporan->jam_berhenti);
                                                                    return $mulai->floatDiffInHours($berhenti);
                                                                });
                                                            @endphp
                                                        {{-- @endforeach --}}

                                                        <td>
                                                            <strong>{{ $tindakan->first()->tindakan->tindakan ?? 'Tidak Ada Data' }}</strong>

                                                        </td>
                                                        <td class="text-center">
                                                            <strong>{{ $tindakan->count() }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($tindakan->count() > 0)
                                                                <strong>{{ number_format($totalJamTindakan, 2) }}</strong>
                                                            @else
                                                                <strong>0</strong>
                                                            @endif

                                                            @if ($tindakan->count() > 0)

                                                                <div class="collapse" id="collapse{{ $tindakan->first()->id }}">
                                                                    <span style="display:block; margin-top:2px;"></span>

                                                                    @foreach ($grouped as $nama => $items)
                                                                        @php
                                                                            $totalJam = $items->sum(function ($laporan) {
                                                                                $mulai = \Carbon\Carbon::parse($laporan->jam_mulai);
                                                                                $berhenti = \Carbon\Carbon::parse($laporan->jam_berhenti);
                                                                                return $mulai->floatDiffInHours($berhenti); // Menghasilkan dalam satuan jam desimal
                                                                            });
                                                                        @endphp

                                                                        <p class="text-center my-2">{{ number_format($totalJam, 2) }}</p>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">

                                                            {{ number_format($totalJamTindakan * $tindakan->count(), 3) }}
                                                            @php
                                                                $hasilAngka = $totalJamTindakan * $tindakan->count();
                                                                $totalHasil += $hasilAngka * $tindakan->count();
                                                            @endphp
                                                        </td>
                                                        @php
                                                            $grouped = [];
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                {{-- @foreach($rataRataWaktu as $tindakanId => $rataWaktu)
                                                    <tr>
                                                        <td>{{ $laporan->where('tindakan_id', $tindakanId)->first()->tindakan->tindakan ?? 'Tidak Ada Data' }}</td>
                                                        <td>{{ number_format($rataWaktu, 2) }} jam</td>
                                                        <td>{{ number_format($swl[$tindakanId], 2) }}</td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="form-group row my-3 mt-5 align-items-center">
                                        <label for="libur_nasional" class="col-sm-3 col-form-label"><strong>Total Waktu Kerja</strong></label>
                                        <div class="col-sm-12 col-md-6">
                                        <input required type="number" class="form-control form-control-lg" id="total_waktu_kerja" name="total_waktu_kerja" value="{{ $recordAnalisa->total_waktu_kerja }}" readonly style="font-size: 2rem;">
                                        </div>
                                    </div>
                                    <div class="form-group row my-5 mt-5 align-items-center">
                                        <label for="libur_nasional" class="col-sm-3 col-form-label"><strong>Beban Kerja</strong></label>
                                        <div class="col-sm-12 col-md-6">
                                        <input required type="text" class="form-control form-control-lg
                                        @php
                                            if ($recordAnalisa->beban_kerja < 1.0) {
                                            $bebanKerjaClass = 'bg-warning';
                                            $stringBebanKerja = '(Rendah)';
                                            } else if ($recordAnalisa->beban_kerja >= 1.0 && $recordAnalisa->beban_kerja <= 1.1) {
                                            $bebanKerjaClass = 'bg-success';
                                            $stringBebanKerja = '(Normal)';
                                            } else {
                                            $bebanKerjaClass = 'bg-danger';
                                            $stringBebanKerja = '(Tinggi)';
                                            }
                                        @endphp
                                        {{ $bebanKerjaClass ?? '' }}" id="beban_kerja" name="beban_kerja" value="{{ $recordAnalisa->beban_kerja }} {{ $stringBebanKerja ?? '' }}" readonly style="font-size: 2rem;">
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    @endif


                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>

        @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const table = $('#author_table').DataTable({
                    dom: 'frtip', // 'B' untuk Buttons
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-success border rounded d-flex align-items-center',
                            text: '<i class="material-icons">grid_on</i> Excel'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-outline-danger border rounded d-flex align-items-center',
                            text: '<i class="material-icons">picture_as_pdf</i> PDF'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-dark border rounded d-flex align-items-center',
                            text: '<i class="material-icons">print</i> Print'
                        }
                    ],
                    pagingType: "simple_numbers", // atau "simple_numbers"
                    language: {
                        search: "",
                        searchPlaceholder: "Cari...",
                        lengthMenu: "_MENU_ data setiap halaman",
                        info: "Menampilkan <strong>_START_</strong> sampai <strong>_END_</strong> , total <strong>_TOTAL_</strong> data",
                    },
                    // columnDefs: [
                    //     { targets: 4, orderable: false }  // Kolom pertama tidak bisa diurutkandafsdf
                    // ]
                });
                table.buttons().container().appendTo('.button-datatable');

                const search = $('#author_table .dt-search');
                search.appendTo('.button-datatable');

                const table2 = $('#author_table2').DataTable({
                    dom: 'frtip', // 'B' untuk Buttons
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-success border rounded d-flex align-items-center',
                            text: '<i class="material-icons">grid_on</i> Excel'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-outline-danger border rounded d-flex align-items-center',
                            text: '<i class="material-icons">picture_as_pdf</i> PDF'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-dark border rounded d-flex align-items-center',
                            text: '<i class="material-icons">print</i> Print'
                        }
                    ],
                    pagingType: "simple_numbers", // atau "simple_numbers"
                    language: {
                        search: "",
                        searchPlaceholder: "Cari...",
                        lengthMenu: "_MENU_ data setiap halaman",
                        info: "Menampilkan <strong>_START_</strong> sampai <strong>_END_</strong> , total <strong>_TOTAL_</strong> data",
                    },
                });
                table2.buttons().container().appendTo('.button-datatable2');

                const search2 = $('#author_table2 .dt-search');
                search2.appendTo('.button-datatable2');

                const table3 = $('#author_table3').DataTable({
                    dom: 'frtip', // 'B' untuk Buttons
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-success border rounded d-flex align-items-center',
                            text: '<i class="material-icons">grid_on</i> Excel'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-outline-danger border rounded d-flex align-items-center',
                            text: '<i class="material-icons">picture_as_pdf</i> PDF'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-dark border rounded d-flex align-items-center',
                            text: '<i class="material-icons">print</i> Print'
                        }
                    ],
                    pagingType: "simple_numbers", // atau "simple_numbers"
                    language: {
                        search: "",
                        searchPlaceholder: "Cari...",
                        lengthMenu: "_MENU_ data setiap halaman",
                        info: "Menampilkan <strong>_START_</strong> sampai <strong>_END_</strong> , total <strong>_TOTAL_</strong> data",
                    },
                    // columnDefs: [
                    //     { targets: 4, orderable: false }  // Kolom pertama tidak bisa diurutkan
                    // ]
                });
                table3.buttons().container().appendTo('.button-datatable3');

                const search3 = $('#author_table3 .dt-search');
                search3.appendTo('.button-datatable3');

            });
        </script>
        @endpush
</x-layout>
