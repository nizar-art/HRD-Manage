@extends('layouts/layoutMaster')

@section('title', 'Kontrak Kerja')

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
    @vite(['resources/js/kontrak-kerja.js'])
@endsection

@section('content')

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Data Kontrak Kerja</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>nama karyawan</th>
                        <th>awal kontrak</th>
                        <th>akhir kontrak</th>
                        <th>total kontrak</th>
                        <th>sisa kontrak</th>
                        <th class="text-center">status</th>
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

                    <!-- Start Date -->
                    <div class="mb-6">
                        <label class="form-label" for="kontrak-kerja-start-date">Start Date</label>
                        <input type="date" class="form-control" id="kontrak-kerja-start-date" name="start_date"
                            required />
                    </div>

                    <!-- End Date -->
                    <div class="mb-6">
                        <label class="form-label" for="kontrak-kerja-end-date">End Date</label>
                        <input type="date" class="form-control" id="kontrak-kerja-end-date" name="end_date" required />
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="form-label" for="kontrak-kerja-status">Status</label>
                        <select class="form-select" id="kontrak-kerja-status" name="status" required>
                            <option value="Baru">Baru</option>
                            <option value="Lanjut">Lanjut</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary me-3 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
