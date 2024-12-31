@php
$configData = Helper::appClasses();
$isMenu = false;
$navbarHideToggle =false;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add - Forms')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.scss',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/scss/pages/app-invoice.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/autosize/autosize.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js',
  'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js',
  'resources/assets/vendor/libs/jquery/jquery.js',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite([
  'resources/assets/js/edit-form.js',
  // 'resources/assets/js/form-wizard-numbered.js',
  //'resources/assets/js/form-wizard-validation.js'
])
@endsection
@php
    use App\Models\User;
    use Illuminate\Support\Facade\Auth;
@endphp

@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom:5rem">
  <div class="row">
    <div class="d-flex flex-column justify-content-center align-items-center text-center mb-6 row-gap-4">
      <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Edit Profile Karyawan</h4>
        <p class="mb-0">Make sure this form is filled out completely and accurately</p>
      </div>
    </div>
    <div class="col-12">
      <div class="card invoice-preview-card p-sm-12 p-6">
        <form id="form-data-pribadi" class="needs-validation">
          <div id="data-pribadi" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Data Pribadi</h6>
              <small>Silahkan Masukan Data Diri Anda.</small>
            </div>
            <div class="card-body">
              <div class="row">
                <input type="hidden" name="user_id" id="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                <!-- Nama Lengkap -->
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                  <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required />
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                  <select id="jenis_kelamin" name="jenis_kelamin" class="select2" required>
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>

                <!-- Tempat Lahir -->
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                  <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" required />
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                  <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required />
                </div>

                <!-- Alamat KTP -->
                <div class="col-12">
                  <h6 class="mt-4">Alamat KTP</h6>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <input type="text" id="jalan_ktp" name="alamat_ktp[jalan]" class="form-control" placeholder="Jalan/Blok/Gedung" required />
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
                  <input type="number" id="rt_ktp" name="alamat_ktp[rt]" class="form-control" placeholder="RT" required />
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
                  <input type="number" id="rw_ktp" name="alamat_ktp[rw]" class="form-control" placeholder="RW" required />
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="provinsi_ktp" name="alamat_ktp[provinsi]" class="select2" required>
                    <option selected disabled>Pilih Provinsi</option>
                    @foreach ($provinsis as $provinsi)
                      <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="kabupaten_ktp" name="alamat_ktp[kabupaten]" class="select2" required>
                    <option selected disabled>Pilih Kabupaten</option>
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="kecamatan_ktp" name="alamat_ktp[kecamatan]" class="select2" required>
                    <option selected disabled>Pilih Kecamatan</option>
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="desa_ktp" name="alamat_ktp[desa]" class="select2" required>
                    <option selected disabled>Pilih Desa</option>
                  </select>
                </div>

                <!-- Alamat Domisili -->
                <div class="col-12">
                  <h6 class="mt-4">Alamat Domisili</h6>
                </div>
                <div class="col-12 mb-3">
                  <div class="form-check">
                    <input type="checkbox" id="same-address" class="form-check-input">
                    <label for="same-address" class="form-check-label">Sama dengan Alamat KTP</label>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <input type="text" id="jalan_domisili" name="alamat_domisili[jalan]" class="form-control" placeholder="Jalan/Blok/Gedung">
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
                  <input type="number" id="rt_domisili" name="alamat_domisili[rt]" class="form-control" placeholder="RT" />
                </div>
                <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
                  <input type="number" id="rw_domisili" name="alamat_domisili[rw]" class="form-control" placeholder="RW" />
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="provinsi_domisili" name="alamat_domisili[provinsi]" class="select2">
                    <option selected disabled>Pilih Provinsi</option>
                    @foreach ($provinsis as $provinsi)
                      <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="kabupaten_domisili" name="alamat_domisili[kabupaten]" class="select2">
                    <option selected disabled>Pilih Kabupaten</option>
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="kecamatan_domisili" name="alamat_domisili[kecamatan]" class="select2">
                    <option selected disabled>Pilih Kecamatan</option>
                  </select>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
                  <select id="desa_domisili" name="alamat_domisili[desa]" class="select2">
                    <option selected disabled>Pilih Desa</option>
                  </select>
                </div>

                <!-- Email, Agama, dan Data Lainnya -->
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="email">Email</label>
                  <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" required />
                </div>
                <div class="col-md-6 col-sm-12 mb-6">
                  <label class="form-label" for="agama">Agama</label>
                  <select id="agama" name="agama" class="select2" required>
                    <option selected disabled>Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                  </select>
                </div>
              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
