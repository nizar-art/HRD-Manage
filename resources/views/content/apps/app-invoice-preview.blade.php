@extends('layouts/layoutMaster')

@section('title', 'Preview - Invoice')

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
            <h5 class="mb-0">Detail Karyawan</h5>
          </div>
        </div>
      </div>


      <!-- Data Pribadi -->
      <div class="card-body px-1">
        <div class="row">
          <div class="col-12">
            <h6>Data Pribadi</h6>
            <table class="table">
              <tbody>
                <tr>
                  <td class="pe-1"><strong>Nama Lengkap:</strong></td>
                  <td class="fw-medium">Nizar Zul Islami</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Jenis Kelamin:</strong></td>
                  <td>L</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Tempat Lahir:</strong></td>
                  <td>Purwakarta</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Tanggal Lahir:</strong></td>
                  <td>31-03-2004</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Alamat Ktp:</strong></td>
                  <td>Jln. Raya Kemiri, RT021, RW004, Provinsi Jawa Barat, Kabupaten Karawang, Kecamatan Jayakerta, Desa Kemiri</td>
                </tr>
                <tr>
                  <td class="pe-1"><strong>Alamat Domisisli:</strong></td>
                  <td>Jln. Raya Kemiri, RT021, RW004, Provinsi Jawa Barat, Kabupaten Karawang, Kecamatan Jayakerta, Desa Kemiri</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Email:</strong></td>
                  <td>nizarzull03@gmail.com</td>
                </tr>
                <tr>
                  <td class="pe-1"><strong>Nik Ktp:</strong></td>
                  <td class="fw-medium">3216163103040005</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Nomer Npwp:</strong></td>
                  <td>-</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Nomer Hp:</strong></td>
                  <td>085717818445</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Ibu Kandung:</strong></td>
                  <td>Eni Sri Handayani</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Golongan darah:</strong></td>
                  <td>A</td>
                </tr>
                <tr>
                  <td class="pe-1"><strong>Status Perkawinan:</strong></td>
                  <td>Belum Menikah</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-body px-1">
        <div class="row">
          <h6>Data Riwayat pendidikan</h6>
          <!-- Riwayat Pendidikan -->
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
                <tr>
                  <td class="text-nowrap">Smpn Karawang 1</td>
                  <td class="text-nowrap">IPA</td>
                  <td class="text-center">SMP</td>
                  <td class="text-center">2019</td>
                </tr>
                <tr>
                  <td class="text-nowrap">Sman Karawang 1</td>
                  <td class="text-nowrap">IPA</td>
                  <td class="text-center">SMA</td>
                  <td class="text-center">2022</td>
                </tr>
                <tr>
                  <td class="text-nowrap">Universitas Buana Perjuangan</td>
                  <td class="text-nowrap">Teknik Informatika</td>
                  <td class="text-center">S1</td>
                  <td class="text-center">2026</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-body px-1">
        <div class="row">
          <h6>Data Keluarga</h6>
          <!-- Data Keluarga -->
          <div class="table-responsive border border-bottom-0 border-top-0 rounded">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th class="text-center">Hubungan</th>
                  <th class="text-center">Nomer HP</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-nowrap">Hanni handayani</td>
                  <td class="text-center">istri</td>
                  <td class="text-center">085717818445</td>
                </tr>
                <tr>
                  <td class="text-nowrap">Hana Nurhusna</td>
                  <td class="text-center">Anak</td>
                  <td class="text-center">-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Data Kepegawaian -->
      <div class="card-body px-1">
        <div class="row">
          <div class="col-xl-6 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
            <h6>Data Kepegawaian</h6>
            <table class="table">
              <tbody>
                <tr>
                  <td class="pe-1"><strong>Nik Kerja:</strong></td>
                  <td class="fw-medium">123456789</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Tanggal Masuk:</strong></td>
                  <td>17-12-2024</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Department:</strong></td>
                  <td>Information & Technology (IT)</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Jabatan:</strong></td>
                  <td>Staff IT</td>
                </tr>
                <tr>
                  <td class="pe-3"><strong>Lokasi Kerja:</strong></td>
                  <td>Karawang</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-body px-1">
        <div class="row">
          <h6>Data Kontrak Kerja</h6>
          <!--kontrak-->
          <div class="table-responsive border border-bottom-0 border-top-0 rounded">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>tahap</th>
                  <th>awal kontrak</th>
                  <th>akhir kontrak</th>
                  <th>toatl kontrak</th>
                  <th>status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>tahap I</td>
                  <td>11/11/2024</td>
                  <td>11/01/2025</td>
                  <td>2bulan</td>
                  <td>Baru</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <hr class="mt-0 mb-6">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <span class="fw-medium text-heading">Note:</span>
            <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Detail Karyawan -->
</div>
@endsection
