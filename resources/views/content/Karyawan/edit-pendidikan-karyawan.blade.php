@php
$configData = Helper::appClasses();
$isMenu = false;
$navbarHideToggle =false;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit - Pendidikan')

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

@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom:5rem">
  <div class="row">
    <div class="d-flex flex-column justify-content-center align-items-center text-center mb-6 row-gap-4">
      <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Edit Riwayat Pendidikan</h4>
        <p class="mb-0">Make sure this form is filled out completely and accurately</p>
      </div>
    </div>
    <div class="col-12">
      <div class="card invoice-preview-card p-sm-12 p-6">
        <form id="form-riwayat-pendidikan" class="needs-validation" novalidate>
          <div id="riwayat-pendidikan" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Riwayat Pendidikan</h6>
              <small>Silahkan Tambah Riwayat Pendidikan Anda isi dengan benar.</small>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
              <button id="addEducation" type="button" class="btn btn-primary">Tambah Pendidikan</button>
              <button class="btn btn-primary btn-next">
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
                      <select class="form-control education select2" id="jenjang" name="jenjang" required>
                        <option value="" disabled selected>Pilih Jenjang</option>
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
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('addEducation').addEventListener('click', function (e) {
  e.preventDefault();

  const container = document.getElementById('educationContainer');
  const template = document.getElementById('educationItemTemplate');

  if (!template) {
    console.error('Education template not found');
    return;
  }

  const clone = template.cloneNode(true);
  clone.style.display = '';
  clone.removeAttribute('id');

  // Inisialisasi Select2 untuk elemen yang baru ditambahkan
  const educationSelect = clone.querySelector('.education');
  $(educationSelect).select2(); // Pastikan library Select2 sudah di-load di halaman Anda

  // Tambahkan event listener untuk tombol delete
  const deleteButton = clone.querySelector('.deleteBtn');
  deleteButton.addEventListener('click', function () {
    clone.remove();
  });

  // Tambahkan event listener untuk tombol save
  const saveButton = clone.querySelector('.saveBtn');
  saveButton.addEventListener('click', function () {
    // Ambil nilai dari input dalam elemen ini
    const karyawanId = clone.querySelector('#id_karyawan').value;
    const jenjang = clone.querySelector('#jenjang').value;
    const namaSekolah = clone.querySelector('#nama_sekolah').value;
    const jurusan = clone.querySelector('#jurusan').value ||"-";
    const tahunLulus = clone.querySelector('#tahun_lulus').value;

    // Validasi input
    if (!jenjang || !namaSekolah || !tahunLulus) {
      Swal.fire({
        icon: 'error',
        title: 'Input Tidak Lengkap',
        text: 'Harap lengkapi semua field sebelum menyimpan.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
      return;
    }

    const formData = {
      id_karyawan: karyawanId,
      jenjang: jenjang,
      nama_sekolah: namaSekolah,
      jurusan: jurusan,
      tahun_lulus: tahunLulus
    };

    // Kirim data ke server menggunakan AJAX
    $.ajax({
      url: '/form/karyawan/storeRiwayatPendidikan', // Endpoint Laravel Anda
      method: 'POST',
      data: JSON.stringify(formData),
      cache: false,
      contentType: 'application/json',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token Laravel
      },
      success: function (response) {
        Swal.fire({
            icon: 'success',
            title: 'Successfully Added!',
            text: 'Data pendidikan berhasil disimpan.',
            customClass: {
                confirmButton: 'btn btn-success'
            }
          }).then((result) => {
              if (result.isConfirmed) {
                  // Jika berhasil, ubah tombol Save menjadi Edit
                  saveButton.textContent = 'Edit';
                  saveButton.classList.replace('btn-primary', 'btn-warning');

                  // Tambahkan fungsi untuk edit
                  saveButton.addEventListener('click', function () {
                      clone.querySelectorAll('input, select').forEach((field) => {
                          field.disabled = false;
                      });
                      saveButton.textContent = 'Save';
                      saveButton.classList.replace('btn-warning', 'btn-primary');
                  });

                  // Disable input setelah save
                  clone.querySelectorAll('input, select').forEach((field) => {
                      field.disabled = true;
                  });
              }
          });
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText); // Log error jika terjadi error dari server
      }
    });
  });

  container.appendChild(clone);
});
</script>
@endsection
