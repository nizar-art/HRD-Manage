@php
    $configData = Helper::appClasses();
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add - Forms')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.scss', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/autosize/autosize.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite([
        'resources/assets/js/forms-karyawan.js',
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
                    <h4 class="mb-1">Formulir Lanjutan</h4>
                    <p class="mb-0">Silahkan tambahkan data riwayat pendidikan & data keluarga anda</p>
                </div>
            </div>
            <div class="bs-stepper wizard-modern wizard-modern-example">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#riwayat-pendidikan">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Riwayat Pendidikan</span>
                                <span class="bs-stepper-subtitle">Tambah Pendidikan</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#data-keluarga">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Data Keluarga</span>
                                <span class="bs-stepper-subtitle">Tambah Keluarga</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <!-- Riwayat Pendidikan -->
                    <form id="form-riwayat-pendidikan" class="needs-validation" novalidate>
                      @csrf
                        <div id="riwayat-pendidikan" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Riwayat Pendidikan</h6>
                                <small>Silahkan Tambah Riwayat Pendidikan Anda isi dengan benar.</small>
                            </div>
                            <div class="col-12 d-flex justify-content-between mt-3">
                                <button id="addEducation" type="button" class="btn btn-primary">Tambah
                                    Pendidikan</button>
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
                                            <input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $karyawanId }}">
                                            <div class="col-lg-3">
                                                <label class="form-label" for="jenjang">Jenjang Pendidikan</label>
                                                <select class="form-control education" id="jenjang" name="jenjang"
                                                    required>
                                                    <option value="">Pilih Jenjang</option>
                                                    <option value="SD">SD</option>
                                                    <option value="SMP">SMP</option>
                                                    <option value="SMA/SMK">SMA</option>
                                                    <option value="D3">D3</option>
                                                    <option value="S1">S1</option>
                                                    <option value="S2">S2</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label" for="nama_sekolah">Nama Sekolah</label>
                                                <input type="text" class="form-control schoolName" id="nama_sekolah"
                                                    name="nama_sekolah" placeholder="Nama Sekolah/Universitas" required />
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label" for="jurusan">Jurusan</label>
                                                <input type="text" class="form-control major" id="jurusan"
                                                    name="jurusan" placeholder="Contoh: Teknik Informatika" required />
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label" for="tahun_lulus">Tahun Lulus</label>
                                                <input type="number" class="form-control graduationYear"
                                                    id="tahun_lulus" name="tahun_lulus" placeholder="Contoh: 2023"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-danger deleteBtn">Delete</button>
                                            <button type="button" class="btn btn-primary saveBtn"
                                                form="form-riwayat-pendidikan">Save</button>
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
                                <button type="button" class="btn btn-primary btn-selesai"> <span
                                        class="align-middle d-sm-inline-block d-none me-sm-2">Selesai</span> <i
                                        class="ti ti-arrow-right ti-xs"></i></button>
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
                                                <input type="text" class="form-control" name="nama_lengkap"
                                                    id="nama_lengkap" placeholder="Masukkan Nama" required />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Nomer Hp</label>
                                                <input type="number" class="form-control" name="nomer_hp"
                                                    id="nomer_hp" placeholder="suami/istri wajib di isi" />
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
    </div>
@endsection
