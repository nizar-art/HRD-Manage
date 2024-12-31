@extends('layouts/layoutMaster')

@section('title', 'Extras - Forms')

<!-- Vendor Styles -->
@section('vendor-style')
@vite(['resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/autosize/autosize.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js',
  'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/forms-extras.js'])
@endsection

@section('content')
<div class="row">
  <!-- Autosize -->
  <!--<div class="col-12">
    <div class="card mb-6">
      <h5 class="card-header">Autosize</h5>
      <div class="card-body">
        <textarea id="autosize-demo" rows="3" class="form-control"></textarea>
      </div>
    </div>
  </div>
  <!-- /Autosize -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1">Add a new Karyawan</h4>
      <p class="mb-0">Make sure this form is filled out completely and accurately</p>
    </div>
  </div>
  <!-- Input Mask -->
  <div class="col-12">
    <div class="card mb-6">
      <h5 class="card-header">Data Pribadi Karyawan</h5>
      <div class="card-body">
        <div class="row">
         <!-- Nama Lengkap -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="fullName">Nama Lengkap</label>
            <div class="input-group">
              <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Masukkan Nama Lengkap" />
            </div>
          </div>
          <!-- Email -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="emailAddress">Email</label>
            <div class="input-group">
              <input type="email" id="emailAddress" name="emailAddress" class="form-control" placeholder="Masukkan Email" />
            </div>
          </div>
          <!-- Tempat Lahir -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="birthPlace">Tempat Lahir</label>
            <div class="input-group">
              <input type="text" id="birthPlace" name="birthPlace" class="form-control" placeholder="Masukkan Tempat Lahir" />
            </div>
          </div>
          <!-- Tanggal Lahir -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="birthDate">Tanggal Lahir</label>
            <div class="input-group">
              <input type="date" id="birthDate" name="birthDate" class="form-control" />
            </div>
          </div>
          <!-- Alamat KTP -->
          <div class="col-12">
            <h6 class="mt-4">Alamat KTP</h6>
          </div>
          <!-- Jalan/Gedung -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <input type="text" id="jalanGedung" name="jalanGedung" class="form-control" placeholder="jalan/blok/gedung" />
          </div>
          <!-- RT -->
          <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
            <input type="text" id="rt" name="rt" class="form-control" placeholder="RT" />
          </div>
          <!-- RW -->
          <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
            <input type="text" id="rw" name="rw" class="form-control" placeholder="RW" />
          </div>
          <!-- Provinsi -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="provinsi" name="provinsi" class="form-select">
              <option selected disabled>Pilih Provinsi</option>
              <option value="provinsi1">Provinsi 1</option>
              <option value="provinsi2">Provinsi 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Kabupaten -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="kabupaten" name="kabupaten" class="form-select">
              <option selected disabled>Pilih Kabupaten</option>
              <option value="kabupaten1">Kabupaten 1</option>
              <option value="kabupaten2">Kabupaten 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Kecamatan -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="kecamatan" name="kecamatan" class="form-select">
              <option selected disabled>Pilih Kecamatan</option>
              <option value="kecamatan1">Kecamatan 1</option>
              <option value="kecamatan2">Kecamatan 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Desa -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="desa" name="desa" class="form-select">
              <option selected disabled>Pilih Desa</option>
              <option value="desa1">Desa 1</option>
              <option value="desa2">Desa 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Alamat Domisili -->
          <div class="col-12">
            <h6 class="mt-4">Alamat Domisili</h6>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="same-address" />
              <label class="form-check-label" for="same-address">Alamat domisili sama dengan KTP</label>
            </div>
          </div>
          <!-- Jalan/Gedung -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <input type="text" id="jalanGedung" name="jalanGedung" class="form-control" placeholder="jalan/blok/gedung">
          </div>
          <!-- RT -->
          <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
            <input type="text" id="rt" name="rt" class="form-control" placeholder="RT" />
          </div>
          <!-- RW -->
          <div class="col-xl-2 col-md-3 col-sm-6 mb-6">
            <input type="text" id="rw" name="rw" class="form-control" placeholder="RW" />
          </div>
          <!-- Provinsi -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="provinsi" name="provinsi" class="form-select">
              <option selected disabled>Pilih Provinsi</option>
              <option value="provinsi1">Provinsi 1</option>
              <option value="provinsi2">Provinsi 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Kabupaten -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="kabupaten" name="kabupaten" class="form-select">
              <option selected disabled>Pilih Kabupaten</option>
              <option value="kabupaten1">Kabupaten 1</option>
              <option value="kabupaten2">Kabupaten 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Kecamatan -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="kecamatan" name="kecamatan" class="form-select">
              <option selected disabled>Pilih Kecamatan</option>
              <option value="kecamatan1">Kecamatan 1</option>
              <option value="kecamatan2">Kecamatan 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Desa -->
          <div class="col-xl-4 col-md-6 col-sm-12 mb-6">
            <select id="desa" name="desa" class="form-select">
              <option selected disabled>Pilih Desa</option>
              <option value="desa1">Desa 1</option>
              <option value="desa2">Desa 2</option>
              <!-- Tambahkan opsi sesuai kebutuhan -->
            </select>
          </div>
          <!-- Agama -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="agama">Agama</label>
            <select id="agama" name="agama" class="form-select">
              <option selected disabled>Pilih Agama</option>
              <option value="islam">Islam</option>
              <option value="kristen">Kristen</option>
              <option value="katolik">Katolik</option>
              <option value="hindu">Hindu</option>
              <option value="buddha">Buddha</option>
              <option value="konghucu">Konghucu</option>
            </select>
          </div>

          <!-- Nomor NIK KTP -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="nik">Nomor NIK KTP</label>
            <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan Nomor NIK KTP" />
          </div>

          <!-- Nomor NPWP -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="npwp">Nomor NPWP</label>
            <input type="text" id="npwp" name="npwp" class="form-control" placeholder="Masukkan Nomor NPWP" />
          </div>

          <!-- Nomor HP -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="nomorHp">Nomor HP</label>
            <input type="text" id="nomorHp" name="nomorHp" class="form-control" placeholder="Masukkan Nomor HP" />
          </div>

          <!-- Nama Ibu Kandung -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="namaIbuKandung">Nama Ibu Kandung</label>
            <input type="text" id="namaIbuKandung" name="namaIbuKandung" class="form-control" placeholder="Masukkan Nama Ibu Kandung" />
          </div>

          <!-- Golongan Darah -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="golonganDarah">Golongan Darah</label>
            <select id="golonganDarah" name="golonganDarah" class="form-select">
              <option selected disabled>Pilih Golongan Darah</option>
              <option value="a">A</option>
              <option value="b">B</option>
              <option value="ab">AB</option>
              <option value="o">O</option>
            </select>
          </div>

          <!-- Status Perkawinan -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="statusPerkawinan">Status Perkawinan</label>
            <select id="statusPerkawinan" name="statusPerkawinan" class="form-select">
              <option selected disabled>Pilih Status Perkawinan</option>
              <option value="belumMenikah">Belum Menikah</option>
              <option value="menikah">Menikah</option>
              <option value="janda/duda">janda/duda</option>
            </select>
          </div>
        </div>
      </div>
      <hr class="mt-0">
      <h5 class="card-header">Data Kepegawaian</h5>
      <div class="card-body">
        <div class="row">
          <!-- Nomor Induk Karyawan -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="employeeID">Nomor Induk Karyawan</label>
            <div class="input-group input-group-merge">
              <input type="text" id="employeeID" name="employeeID" class="form-control" placeholder="Masukkan Nomor Induk Karyawan" />
            </div>
          </div>

          <!-- Tanggal Masuk -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="dateOfJoining">Tanggal Masuk</label>
            <div class="input-group input-group-merge">
              <input type="date" id="dateOfJoining" name="dateOfJoining" class="form-control" />
            </div>
          </div>

          <!-- Jabatan -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="position">Jabatan</label>
            <div class="input-group input-group-merge">
              <select id="position" name="position" class="form-control">
                <option value="">Pilih Jabatan</option>
                <option value="manager">Manager</option>
                <option value="developer">Developer</option>
                <option value="designer">Designer</option>
                <option value="qa">QA</option>
                <!-- Add more options as needed -->
              </select>
            </div>
          </div>

          <!-- Departemen -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="department">Departemen</label>
            <div class="input-group input-group-merge">
              <select id="department" name="department" class="form-control">
                <option value="">Pilih Departemen</option>
                <option value="hr">HR</option>
                <option value="it">IT</option>
                <option value="marketing">Marketing</option>
                <option value="finance">Finance</option>
                <!-- Add more options as needed -->
              </select>
            </div>
          </div>

          <!-- Lokasi Kerja -->
          <div class="col-md-6 col-sm-12 mb-6">
            <label class="form-label" for="workLocation">Lokasi Kerja</label>
            <div class="input-group input-group-merge">
              <input type="text" id="workLocation" name="workLocation" class="form-control" placeholder="Masukkan Lokasi Kerja" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Input Mask -->

  

  <!-- Bootstrap Maxlength -->
<!--<div div class="col-12">
    <div class="card mb-6">
      <h5 class="card-header">Bootstrap Maxlength</h5>
      <div class="card-body">
        <div class="row">
          <div class="col-12 mb-6">
            <label class="form-label" for="bootstrap-maxlength-example1">Input</label>
            <input type="text" id="bootstrap-maxlength-example1" class="form-control bootstrap-maxlength-example" maxlength="25" />
          </div>
          <div class="col-12">
            <label class="form-label" for="bootstrap-maxlength-example2">Textarea</label>
            <textarea id="bootstrap-maxlength-example2" class="form-control bootstrap-maxlength-example" rows="3" maxlength="255"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <-- /Bootstrap Maxlength -->

  <!-- Form Repeater -->
  <div class="col-12">
    <div class="card">
      <h5 class="card-header">Data Riwayat Pendidikan</h5>
      <div class="card-body">
        <form class="form-repeater">
          <div data-repeater-list="group-a">
            <div data-repeater-item>
              <div class="row">
                <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                  <label class="form-label" for="education">Pendidikan</label>
                  <select id="education" class="form-select">
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                  </select>
                </div>
                <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
                  <label class="form-label" for="schoolName">Nama Sekolah/Instansi</label>
                  <input type="text" id="schoolName" class="form-control" placeholder="Masukkan Nama Sekolah atau Instansi" />
                </div>
                <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
                  <label class="form-label" for="major">Jurusan</label>
                  <input type="text" id="major" class="form-control" placeholder="Masukkan Jurusan" />
                </div>
                <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                  <label class="form-label" for="graduationYear">Tahun Lulus</label>
                  <input type="number" id="graduationYear" class="form-control" placeholder="Tahun Lulus" min="1900" max="2099" step="1" />
                </div>
                <div class="mb-6 col-lg-12 col-xl-2 col-12 d-flex align-items-end mb-0">
                  <button class="btn btn-label-danger" data-repeater-delete>
                    <i class="ti ti-x ti-xs me-1"></i>
                    <span class="align-middle">Delete</span>
                  </button>
                </div>
              </div>
              <hr class="mt-0">
            </div>
          </div>
          <div class="mb-0">
            <button class="btn btn-primary" data-repeater-create>
              <i class="ti ti-plus ti-xs me-2"></i>
              <span class="align-middle">Add Riwayat Pendidikan</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Form Repeater -->
  <!-- Form Repeater2 -->
<div class="col-12 mt-4">
  <div class="card">
    <h5 class="card-header">Data Keluarga</h5>
    <div class="card-body">
      <form class="form-repeater">
        <div data-repeater-list="group-a">
          <div data-repeater-item>
            <div class="row">
              <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                <label class="form-label" for="familyRelation">Keluarga</label>
                <select id="familyRelation" class="form-select">
                  <option value="spouse">Istri/Suami</option>
                  <option value="child">Anak</option>
                </select>
              </div>
              <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
                <label class="form-label" for="familyName">Nama</label>
                <input type="text" id="familyName" class="form-control" placeholder="Masukkan Nama" />
              </div>
              <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
                <label class="form-label" for="familyDob">Tanggal Lahir</label>
                <input type="date" id="familyDob" class="form-control" />
              </div>
              <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                <label class="form-label" for="familyPhone">Nomor HP</label>
                <input type="number" id="familyPhone" class="form-control" placeholder="Masukkan Nomor HP" />
              </div>
              <div class="mb-6 col-lg-12 col-xl-2 col-12 d-flex align-items-end mb-0">
                <button class="btn btn-label-danger" data-repeater-delete>
                  <i class="ti ti-x ti-xs me-1"></i>
                  <span class="align-middle">Delete</span>
                </button>
              </div>
            </div>
            <hr class="mt-0">
          </div>
        </div>
        <div class="mb-0">
          <button class="btn btn-primary" data-repeater-create>
            <i class="ti ti-plus ti-xs me-2"></i>
            <span class="align-middle">Add Data Keluarga</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!--/Form Repeater-->
</div>
@endsection
