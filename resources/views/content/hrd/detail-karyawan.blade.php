@extends('layouts/layoutMaster')

@section('title', 'Preview - Keluarga')

@section('vendor-style')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-invoice.scss')
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/offcanvas-add-payment.js',
  'resources/assets/js/offcanvas-send-invoice.js'
])
@endsection

@section('content')
<div class="row invoice-preview">
  <div class="d-flex flex-column justify-content-center align-items-center text-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Detail Karyawan</h4>
        <p class="mb-0">PT.Leader Kontraktor Indonesia</p>
    </div>
  </div>
  <!-- Detail Karyawan -->
  <div class="col-12">
    <div class="card invoice-preview-card p-sm-12 p-6">
      <div class="card-body invoice-preview-header rounded text-center">
        <div class="d-flex flex-column align-items-center">
          <div class="mb-6 text-heading">
            <div class="d-flex svg-illustration gap-2 align-items-center justify-content-center mb-3">
              <div class="app-brand-logo demo">@include('_partials.macros',["height"=>22,"withbg"=>''])</div>
              <span class="app-brand-text fw-bold fs-4 ms-50">
                {{ config('variables.templateName') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      @if ($dataPribadi)
      <div class="card-body px-1">
          <div class="row">
              <div class="col-12">
                  <h6>Data Pribadi</h6>
                  <table class="table">
                      <tbody>
                          <tr>
                              <td class="pe-1"><strong>Nama Lengkap:</strong></td>
                              <td class="fw-medium">{{ $dataPribadi->nama_lengkap }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Jenis Kelamin:</strong></td>
                              <td>{{ $dataPribadi->jenis_kelamin }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Tempat Lahir:</strong></td>
                              <td>{{ $dataPribadi->tempat_lahir }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Tanggal Lahir:</strong></td>
                              <td>{{ $dataPribadi->tanggal_lahir->format('d-m-Y') }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Alamat KTP:</strong></td>
                              <td>{{ $dataPribadi->alamat_ktp }}</td>
                          </tr>
                          <tr>
                              <td class="pe-1"><strong>Alamat Domisili:</strong></td>
                              <td>{{ $dataPribadi->alamat_domisili }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Email:</strong></td>
                              <td>{{ $dataPribadi->email }}</td>
                          </tr>
                          <tr>
                              <td class="pe-1"><strong>NIK KTP:</strong></td>
                              <td class="fw-medium">{{ $dataPribadi->nomor_nik_ktp }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Nomor NPWP:</strong></td>
                              <td>{{ $dataPribadi->nomor_npwp ?? '-' }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Nomor HP:</strong></td>
                              <td>{{ $dataPribadi->nomor_hp }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Ibu Kandung:</strong></td>
                              <td>{{ $dataPribadi->ibu_kandung }}</td>
                          </tr>
                          <tr>
                              <td class="pe-3"><strong>Golongan Darah:</strong></td>
                              <td>{{ $dataPribadi->golongan_darah }}</td>
                          </tr>
                          <tr>
                              <td class="pe-1"><strong>Status Perkawinan:</strong></td>
                              <td>{{ $dataPribadi->status_pernikahan }}</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      @endif

      <!-- Riwayat Pendidikan -->
      @if ($dataPendidikan && $dataPendidikan->isNotEmpty())
      <div class="card-body px-1">
          <div class="row">
              <h6>Data Riwayat Pendidikan</h6>
              <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Nama Sekolah</th>
                              <th>Jurusan</th>
                              <th class="text-center">Jenjang</th>
                              <th class="text-center">Tahun Lulus</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataPendidikan as $pendidikan)
                          <tr>
                              <td class="text-nowrap">{{ $pendidikan->nama_sekolah }}</td>
                              <td class="text-nowrap">{{ $pendidikan->jurusan }}</td>
                              <td class="text-center">{{ $pendidikan->jenjang }}</td>
                              <td class="text-center">{{ $pendidikan->tahun_lulus }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      @endif

      <!-- Data Keluarga -->
      @if ($dataKeluarga && $dataKeluarga->isNotEmpty())
      <div class="card-body px-1">
          <div class="row">
              <h6>Data Keluarga</h6>
              <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Nama</th>
                              <th class="text-center">Hubungan</th>
                              <th class="text-center">Nomer Hp</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataKeluarga as $keluarga)
                          <tr>
                              <td class="text-nowrap">{{ $keluarga->nama_lengkap }}</td>
                              <td class="text-center">{{ $keluarga->status }}</td> <!-- Asumsi status adalah hubungan -->
                              <td class="text-center">{{ $keluarga->nomer_hp }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      @endif

      @if ($dataKepegawaian)
          <div class="card-body px-1">
              <div class="row">
                  <div class="col-12">
                      <h6>Data Kepegawaian</h6>
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td class="pe-1"><strong>Nomor Kerja:</strong></td>
                                  <td class="fw-medium">{{ $dataKepegawaian->nomer_kerja }}</td>
                              </tr>
                              <tr>
                                  <td class="pe-3"><strong>Tanggal Masuk:</strong></td>
                                  <td>{{ $dataKepegawaian->tanggal_masuk->format('d-m-Y') }}</td> <!-- Format tanggal -->
                              </tr>
                              <tr>
                                  <td class="pe-3"><strong>Department:</strong></td>
                                  <td>{{ $dataKepegawaian->department->name_department ?? '-' }}</td> <!-- If department exists, show its name -->
                              </tr>
                              <tr>
                                  <td class="pe-3"><strong>Jabatan:</strong></td>
                                  <td>{{ $dataKepegawaian->jabatan->name_jabatan ?? '-' }}</td> <!-- If jabatan exists, show its name -->
                              </tr>
                              <tr>
                                  <td class="pe-3"><strong>Lokasi Kerja:</strong></td>
                                  <td>{{ $dataKepegawaian->lokasi_kerja }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      @endif

      <!-- Riwayat Kontrak -->
      @if ($dataHistoryKontrak && $dataHistoryKontrak->isNotEmpty())
      <div class="card-body px-1">
          <div class="row">
              <h6>Data Riwayat Kontrak Kerja</h6>
              <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th class="text-center">Tahap</th>
                              <th class="text-center"> Awal Kontrak</th>
                              <th class="text-center">Akhir Kontrak</th>
                              <th class="text-center">Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php
                          $no = 1; // Inisialisasi counter
                        @endphp
                        @foreach ($dataHistoryKontrak as $historyKontrak)
                          <tr>
                              <!-- Display Contract Data -->
                              <td class="text-center">{{ $no++ }}</td>
                              <td class="text-center">{{ \Carbon\Carbon::parse($historyKontrak->start_date)->format('d-m-Y') }}</td>
                              <td class="text-center">{{ \Carbon\Carbon::parse($historyKontrak->end_date)->format('d-m-Y') }}</td>
                              <td class="text-center">{{ ucfirst($historyKontrak->status) }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      @endif


    </div>
  </div>
</div>
@endsection
