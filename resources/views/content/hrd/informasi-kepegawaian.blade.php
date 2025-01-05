@extends('layouts/layoutMaster')

@section('title', 'Informasi Kepegawaian')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/informasi-kepegawaian.js'])
@endsection

@section('content')

    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Karyawan</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalKaryawan }}</h4>
                                <p class="text-success mb-0">(+100%)</p> <!-- Display total employees -->
                            </div>
                            <small class="mb-0">Total Employees</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-users ti-26px"></i> <!-- Updated icon for employees -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Departments</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalDepartments }}</h4>
                                <p class="text-success mb-0">(+90%)</p> <!-- Display total departments -->
                            </div>
                            <small class="mb-0">Total Departments</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-building ti-26px"></i> <!-- Icon representing departments -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Jabatan</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalJabatan }}</h4>
                                <p class="text-success mb-0">(100%)</p> <!-- Display total job positions -->
                            </div>
                            <small class="mb-0">Total Job Positions</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-clipboard ti-26px"></i> <!-- Icon representing job positions -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Total Kontrak Kepegawaian</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $totalKepegawaian }}</h4>
                                <p class="text-danger mb-0">(100%)</p>
                                <!-- Display total contract workers -->
                            </div>
                            <small class="mb-0">Total Contract Workers</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-file-text ti-26px"></i> <!-- Icon representing contracts -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Data Informasi Kepegawaian</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>nama karyawan</th>
                        <th class="text-center">Perusahaan</th>
                        <th>NIK Kerja</th>
                        <th>tanggal masuk</th>
                        <th>jabatan</th>
                        <th>department</th>
                        <th>lokasi kerja</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Informasi Kepegawaian</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm">
                    <input type="hidden" name="id" id="id">
                    <!-- Karyawan -->
                    <div class="mb-6">
                        <label class="form-label" for="id_karyawan">Karyawan</label>
                        <select class="select2" id="id_karyawan" name="id_karyawan" required>
                            <option value="" disabled selected>Select a jabatan</option>
                            @foreach ($karyawan as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Perusahaan -->
                    <div class="mb-6">
                        <label class="form-label" for="perusahaan">Perusahaan</label>
                        <select id="perusahaan" name="perusahaan" class="form-select ">
                            <option value="" disabled selected>Select a company</option>
                            <option value="LKI">LKI</option>
                            <option value="Green Cold">Green Cold</option>
                        </select>
                    </div>
                    <!-- Nomor Induk Karyawan -->
                    <div class="mb-6">
                        <label class="form-label" for="nomer_kerja">Nomor Induk Karyawan</label>
                        <input type="text" id="nomer_kerja" name="nomer_kerja" class="form-control"
                            placeholder="Masukkan Nomor Induk Karyawan" required />
                    </div>
                    <!-- Tanggal Masuk -->
                    <div class="mb-6">
                        <label class="form-label" for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" required />
                    </div>
                    <!-- Jabatan -->
                    <div class="mb-6">
                        <label class="form-label" for="id_jabatan">Jabatan</label>
                        <select id="id_jabatan" name="id_jabatan" class="form-select ">
                            <option value="" disabled selected>Select a jabatan</option>
                            @foreach ($jabatan as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->name_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Departemen -->
                    <div class="mb-6">
                        <label class="form-label" for="id_department">Departemen</label>
                        <select id="id_department" name="id_department" class="form-select">
                            <option value="" disabled selected>Select a department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name_department }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lokasi Kerja -->
                    <div class="mb-6">
                        <label class="form-label" for="lokasi_kerja">Lokasi Kerja</label>
                        <input type="text" id="lokasi_kerja" name="lokasi_kerja" class="form-control"
                            placeholder="Masukkan Lokasi Kerja" required />
                    </div>


                    <button type="submit" class="btn btn-primary me-3 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
