@extends('layouts/layoutMaster')

@section('title', 'Category Jabatan')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/quill/typography.scss',
'resources/assets/vendor/libs/quill/katex.scss',
'resources/assets/vendor/libs/quill/editor.scss',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-ecommerce.scss'
      )
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/quill/katex.js',
  'resources/assets/vendor/libs/quill/quill.js'
  ])
@endsection

@section('page-script')
@vite('resources/assets/js/category-jabatan.js'
      //'resources/assets/js/modal-enable-otp'
      )
@endsection

@section('content')
<div class="app-ecommerce-category">
  <!-- Category List Table -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="datatables-category-list table border-top">
        <thead>
          <tr>
            <th></th>
            <th>id</th>
            <th>Categories Jabatan</th>
            <th class="text-center">Departement</th>
            <th class="text-center">Total Pegawai &nbsp;</th>
            <th class="text-center"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<!-- Add Category Jabatan Modal -->
<div class="modal fade" id="addCategoryJabatan" tabindex="addCategoryJabatan" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-add-category-jabatan modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Add Category Jabatan</h4>
          <p>Fill out the form below to add a new category.</p>
        </div>
        <form id="addCategoryJabatanForm" class="row g-5" onsubmit="return false" method="post">
          <div class="col-12">
            <label class="form-label" for="modalAddCategory">Jabatan Name</label>
            <div class="input-group">
              <input type="text" id="name_jabatan" name="name_jabatan" class="form-control" placeholder="Enter jabatan name" />
            </div>
          </div>
          <div class="col-12">
            <label class="form-label" for="modalAddDepartment">Department</label>
            <select id="id_department" name="id_department" class="select2 form-control">
              <option value="" disabled selected>Select a department</option>
              @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name_department }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <button type="submit" id="type-success" class="btn btn-primary" form="addCategoryJabatanForm">Submit</button>
            <button type="reset" class="btn btn-label-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Add Category Jabatan Modal -->


@endsection
