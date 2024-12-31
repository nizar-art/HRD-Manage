@extends('layouts/layoutMaster')

@section('title', 'Add Karyawan')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.scss',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
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
  'resources/assets/js/profile-karyawan-add.js',
  // 'resources/assets/js/form-wizard-numbered.js',
  'resources/assets/js/form-wizard-validation.js'
])
@endsection


@section('content')
<div class="row">
  <div class="d-flex flex-column justify-content-center align-items-center text-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1">Formulir Profile Karyawan</h4>
      <p class="mb-0">Make sure this form is filled out completely and accurately</p>
    </div>
  </div>
  <div class="bs-stepper wizard-modern wizard-modern-example">
    <div class="bs-stepper-header">
      <div class="step" data-target="#data-pribadi">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">1</span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Data Pribadi</span>
            <span class="bs-stepper-subtitle">Informasi Pribadi</span>
          </span>
        </button>
      </div>
      <div class="line"><i class="ti ti-chevron-right"></i></div>
      <div class="step" data-target="#riwayat-pendidikan">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">2</span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Riwayat Pendidikan</span>
            <span class="bs-stepper-subtitle">Tambah Pendidikan</span>
          </span>
        </button>
      </div>
      <div class="line"><i class="ti ti-chevron-right"></i></div>
      <div class="step" data-target="#data-keluarga">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">3</span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Data Keluarga</span>
            <span class="bs-stepper-subtitle">Tambah Keluarga</span>
          </span>
        </button>
      </div>
    </div>
    <div class="bs-stepper-content">

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
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
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
                          <option selected disabled>Pilih desa</option>
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

                    <!-- Nomor NIK KTP -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="nomor_nik_ktp">Nomor NIK KTP</label>
                        <input type="number" id="nomor_nik_ktp" name="nomor_nik_ktp" class="form-control" placeholder="Masukkan Nomor NIK KTP" required />
                    </div>

                    <!-- Nomor NPWP -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="nomor_npwp">Nomor NPWP</label>
                        <input type="number" id="nomor_npwp" name="nomor_npwp" class="form-control" placeholder="Masukkan Nomor NPWP" />
                    </div>

                    <!-- Nomor HP -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="nomor_hp">Nomor HP</label>
                        <input type="number" id="nomor_hp" name="nomor_hp" class="form-control" placeholder="Masukkan Nomor HP" required />
                    </div>

                    <!-- Nama Ibu Kandung -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="ibu_kandung">Nama Ibu Kandung</label>
                        <input type="text" id="ibu_kandung" name="ibu_kandung" class="form-control" placeholder="Masukkan Nama Ibu Kandung" required />
                    </div>

                    <!-- Golongan Darah -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="golongan_darah">Golongan Darah</label>
                        <select id="golongan_darah" name="golongan_darah" class="select2">
                            <option selected disabled>Pilih Golongan Darah</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                            <option value="A-">-A</option>
                            <option value="B-">-B</option>
                            <option value="AB-">-AB</option>
                            <option value="O-">-O</option>
                        </select>
                    </div>

                    <!-- Status Perkawinan -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label class="form-label" for="status_pernikahan">Status Perkawinan</label>
                        <select id="status_pernikahan" name="status_pernikahan" class="select2" required>
                            <option selected disabled>Pilih Status Perkawinan</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                            <option value="janda/duda">Janda/Duda</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary publish" form="form-data-pribadi">Simpan Data</button>
        </div>
    </form>

    <!-- Riwayat Pendidikan -->
    <form id="form-riwayat-pendidikan" class="needs-validation" novalidate>
      <div id="riwayat-pendidikan" class="content">
        <div class="content-header mb-4">
          <h6 class="mb-0">Riwayat Pendidikan</h6>
          <small>Silahkan Tambah Riwayat Pendidikan Anda isi dengan benar.</small>
        </div>
        <div class="col-12 d-flex justify-content-between mt-3">
          <button id="addEducation" type="button" class="btn btn-primary">Tambah Pendidikan</button>
          <button id="nextToFamily" type="button" class="btn btn-primary">
            <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
            <i class="ti ti-arrow-right ti-xs"></i>
          </button>
        </div>
        <div id="educationContainer">
          <!-- Template for Education Item -->
          <div id="educationItemTemplate" class="mb-3" style="display:none;">
            <div class="card-body">
              <div class="row">
                <input  name="id_karyawan" id="id_karyawan" value="{{ $karyawanId }}">
                <div class="col-lg-3">
                  <label class="form-label" for="jenjang">Jenjang Pendidikan</label>
                  <select class="form-control education" id="jenjang" name="jenjang" required>
                    <option value="">Pilih Jenjang</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                  </select>
                </div>
                <div class="col-lg-3">
                  <label class="form-label" for="nama_sekolah">Nama Sekolah</label>
                  <input type="text" class="form-control schoolName" id="nama_sekolah" name="nama_sekolah" placeholder="Nama Sekolah/Universitas" required />
                </div>
                <div class="col-lg-3">
                  <label class="form-label" for="jurusan">Jurusan</label>
                  <input type="text" class="form-control major" id="jurusan" name="jurusan" placeholder="Contoh: Teknik Informatika" required />
                </div>
                <div class="col-lg-3">
                  <label class="form-label" for="tahun_lulus">Tahun Lulus</label>
                  <input type="number" class="form-control graduationYear" id="tahun_lulus" name="tahun_lulus" placeholder="Contoh: 2023" required />
                </div>
              </div>
              <div class="mt-3">
                <button type="button" class="btn btn-danger deleteBtn">Delete</button>
                <button type="button" class="btn btn-primary saveBtn" form="form-riwayat-pendidikan">Save</button>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </form>


    <!-- Data Keluarga -->
    <form id="form-data-keluarga" class="needs-validation" novalidate>
      <div id="data-keluarga" class="content">
        <div class="content-header mb-4">
          <h6 class="mb-0">Data Keluarga</h6>
          <small>Silahkan Tambah Data Keluarga Anda Isi Dengan Benar.</small>
        </div>
        <div class="col-12 d-flex justify-content-between mt-3">
          <button id="addFamily" type="button" class="btn btn-primary">Tambah Keluarga</button>
          <button type="button" class="btn btn-primary btn-selesai"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Selesai</span> <i class="ti ti-arrow-right ti-xs"></i></button>
        </div>
        <div id="familyContainer">
          <div class="mb-3" id="familyItemTemplate" style="display:none;">
            <div class="card-body">
              <div class="row">
                <input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $karyawanId }}">
                <div class="col-lg-4">
                  <label class="form-label">Hubungan</label>
                  <select class="form-select" name="status" id="status" required>
                    <option value="" disabled selected>Pilih Hubungan</option>
                    <option value="suami/istri">Suami/Istri</option>
                    <option value="anak">Anak</option>
                    <option value="orang tua">Orang Tua</option>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama" required />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Nomer Hp</label>
                  <input type="number" class="form-control" name="nomer_hp" id="nomer_hp" placeholder="suami/istri wajib di isi" />
                </div>
              </div>
              <div class="mt-3">
                <button type="button" class="btn btn-danger deleteBtn">Delete</button>
                <button type="button" class="btn btn-primary saveBtn">Save</button>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </form>

    </div>
  </div>
</div>

@endsection
