@extends('layouts/layoutMaster')

@section('title', 'Data Profile Karyawan')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss', // Fix dari select2.sccs menjadi select2.scss
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/autosize/autosize.js',
        'resources/assets/vendor/libs/cleavejs/cleave.js',
        'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
        'resources/assets/vendor/libs/jquery/jquery.js', // Pastikan ini diperlukan untuk select2
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js'
    ])
@endsection


@section('page-script')
    @vite(['resources/assets/js/profile-karyawan-list.js'])
@endsection

@section('content')
    <!-- Product List Widget -->
    <div class="card mb-6">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <p class="mb-1">In-store Sales</p>
                                <h4 class="mb-1">$5,345.43</h4>
                                <p class="mb-0"><span class="me-2">5k orders</span><span
                                        class="badge bg-label-success">+5.7%</span></p>
                            </div>
                            <span class="avatar me-sm-6">
                                <span class="avatar-initial rounded"><i
                                        class="ti-28px ti ti-smart-home text-heading"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <p class="mb-1">Website Sales</p>
                                <h4 class="mb-1">$674,347.12</h4>
                                <p class="mb-0"><span class="me-2">21k orders</span><span
                                        class="badge bg-label-success">+12.4%</span></p>
                            </div>
                            <span class="avatar p-2 me-lg-6">
                                <span class="avatar-initial rounded"><i
                                        class="ti-28px ti ti-device-laptop text-heading"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                            <div>
                                <p class="mb-1">Discount</p>
                                <h4 class="mb-1">$14,235.12</h4>
                                <p class="mb-0">6k orders</p>
                            </div>
                            <span class="avatar p-2 me-sm-6">
                                <span class="avatar-initial rounded"><i class="ti-28px ti ti-gift text-heading"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Affiliate</p>
                                <h4 class="mb-1">$8,345.23</h4>
                                <p class="mb-0"><span class="me-2">150 orders</span><span
                                        class="badge bg-label-danger">-3.5%</span></p>
                            </div>
                            <span class="avatar p-2">
                                <span class="avatar-initial rounded"><i
                                        class="ti-28px ti ti-wallet text-heading"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Data Karyawan</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-products table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Nama Lengkap</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat Email</th>
                        <th>Nomor HP</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditUser" aria-labelledby="offcanvasEditUserLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasEditUserLabel" class="offcanvas-title">Edit Data Pribadi</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
            <form id="form-data-pribadi" class="needs-validation" novalidate>
                <div id="data-pribadi" class="content">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="user_id" id="user_id"
                                value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">

                            <!-- Nama Lengkap -->
                            <div class="mb-6">
                                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                    placeholder="Masukkan Nama Lengkap" required />
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-6">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="select2" required>
                                    <option selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-6">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control"
                                    placeholder="Masukkan Tempat Lahir" required />
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-6">
                                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                    required />
                            </div>

                            <!-- Alamat KTP -->
                            <div class="mb-6">
                                <h6 class="mt-4">Alamat KTP</h6>
                            </div>
                            <div class="mb-6">
                                <input type="text" id="jalan_ktp" name="alamat_ktp[jalan]" class="form-control"
                                    placeholder="Jalan/Blok/Gedung" required />
                            </div>
                            <div class="mb-6">
                                <input type="number" id="rt_ktp" name="alamat_ktp[rt]" class="form-control"
                                    placeholder="RT" required />
                            </div>
                            <div class="mb-6">
                                <input type="number" id="rw_ktp" name="alamat_ktp[rw]" class="form-control"
                                    placeholder="RW" required />
                            </div>
                            <div class="mb-6">
                                <select id="provinsi_ktp" name="alamat_ktp[provinsi]" class="select2" required>
                                    <option selected disabled>Pilih Provinsi</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="kabupaten_ktp" name="alamat_ktp[kabupaten]" class="select2" required>
                                    <option selected disabled>Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="kecamatan_ktp" name="alamat_ktp[kecamatan]" class="select2" required>
                                    <option selected disabled>Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="desa_ktp" name="alamat_ktp[desa]" class="select2" required>
                                    <option selected disabled>Pilih Desa</option>
                                </select>
                            </div>

                            <!-- Alamat Domisili -->
                            <div class="mb-6">
                                <h6 class="mt-4">Alamat Domisili</h6>
                            </div>
                            <div class="mb-6">
                                <div class="form-check">
                                    <input type="checkbox" id="same-address" class="form-check-input">
                                    <label for="same-address" class="form-check-label">Sama dengan Alamat KTP</label>
                                </div>
                            </div>
                            <div class="mb-6">
                                <input type="text" id="jalan_domisili" name="alamat_domisili[jalan]"
                                    class="form-control" placeholder="Jalan/Blok/Gedung">
                            </div>
                            <div class="mb-6">
                                <input type="number" id="rt_domisili" name="alamat_domisili[rt]" class="form-control"
                                    placeholder="RT" />
                            </div>
                            <div class="mb-6">
                                <input type="number" id="rw_domisili" name="alamat_domisili[rw]" class="form-control"
                                    placeholder="RW" />
                            </div>
                            <div class="mb-6">
                                <select id="provinsi_domisili" name="alamat_domisili[provinsi]" class="select2">
                                    <option selected disabled>Pilih Provinsi</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="kabupaten_domisili" name="alamat_domisili[kabupaten]" class="select2">
                                    <option selected disabled>Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="kecamatan_domisili" name="alamat_domisili[kecamatan]" class="select2">
                                    <option selected disabled>Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <select id="desa_domisili" name="alamat_domisili[desa]" class="select2">
                                    <option selected disabled>Pilih Desa</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Masukkan Email" required />
                            </div>

                            <!-- Agama -->
                            <div class="mb-6">
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
                            <div class="mb-6">
                                <label class="form-label" for="nomor_nik_ktp">Nomor NIK KTP</label>
                                <input type="number" id="nomor_nik_ktp" name="nomor_nik_ktp" class="form-control"
                                    placeholder="Masukkan Nomor NIK KTP" required />
                            </div>

                            <!-- Nomor NPWP -->
                            <div class="mb-6">
                                <label class="form-label" for="nomor_npwp">Nomor NPWP</label>
                                <input type="number" id="nomor_npwp" name="nomor_npwp" class="form-control"
                                    placeholder="Masukkan Nomor NPWP" />
                            </div>

                            <!-- Nomor HP -->
                            <div class="mb-6">
                                <label class="form-label" for="nomor_hp">Nomor HP</label>
                                <input type="number" id="nomor_hp" name="nomor_hp" class="form-control"
                                    placeholder="Masukkan Nomor HP" required />
                            </div>

                            <!-- Nama Ibu Kandung -->
                            <div class="mb-6">
                                <label class="form-label" for="ibu_kandung">Nama Ibu Kandung</label>
                                <input type="text" id="ibu_kandung" name="ibu_kandung" class="form-control"
                                    placeholder="Masukkan Nama Ibu Kandung" required />
                            </div>

                            <!-- Golongan Darah -->
                            <div class="mb-6">
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
                            <div class="mb-6">
                                <label class="form-label" for="status_pernikahan">Status Perkawinan</label>
                                <select id="status_pernikahan" name="status_pernikahan" class="select2" required>
                                    <option selected disabled>Pilih Status Perkawinan</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="janda/duda">Janda/Duda</option>
                                </select>
                            </div>


                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
