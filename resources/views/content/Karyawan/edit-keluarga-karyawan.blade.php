
@extends('layouts/layoutMaster')

@section('title', 'Edit - Keluarga')

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
        <h4 class="mb-1">Edit Data Keluarga</h4>
        <p class="mb-0">Make sure this form is filled out completely and accurately</p>
      </div>
    </div>
    <div class="col-12">
      <div class="card invoice-preview-card p-sm-12 p-6">
        <form id="form-data-keluarga" class="needs-validation" novalidate>
          <div id="data-keluarga" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Data Keluarga</h6>
              <small>Silahkan Tambah Data Keluarga Anda Isi Dengan Benar.</small>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
              <button id="addFamily" type="button" class="btn btn-primary">Tambah Keluarga</button>
              <button class="btn btn-primary btn-selesai"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Selesai</span> <i class="ti ti-arrow-right ti-xs"></i></button>
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
</div>
<script>
  document.getElementById('addFamily').addEventListener('click', function (e) {
  e.preventDefault();

  const container = document.getElementById('familyContainer');
  const template = document.getElementById('familyItemTemplate');

  if (!template) {
    console.error('Family template not found');
    return;
  }

  const clone = template.cloneNode(true);
  clone.style.display = '';
  clone.removeAttribute('id');

  // Add event listener for Delete button
  const deleteButton = clone.querySelector('.deleteBtn');
  deleteButton.addEventListener('click', function () {
    clone.remove();
  });

  // Add event listener for Save button
  const saveButton = clone.querySelector('.saveBtn');
  saveButton.addEventListener('click', function () {
    // Ambil nilai dari input dalam elemen ini
    const karyawanId = clone.querySelector('#id_karyawan').value;
    const status = clone.querySelector('#status').value;
    const namaLengkap = clone.querySelector('#nama_lengkap').value;
    const nomerHp = clone.querySelector('#nomer_hp').value ||"-";

    // Validasi input
    if (!status || !namaLengkap) {
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
      status: status,
      nama_lengkap: namaLengkap,
      nomer_hp: nomerHp
    };

    // Kirim data ke server menggunakan AJAX
    $.ajax({
      url: '/form/karyawan/storeKeluarga', // Endpoint Laravel Anda
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
          text: 'Data keluarga berhasil disimpan.',
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
        Swal.fire({
          icon: 'error',
          title: 'Failed to Save!',
          text: 'Terjadi kesalahan saat menyimpan data.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  container.appendChild(clone);
});
</script>
@endsection
