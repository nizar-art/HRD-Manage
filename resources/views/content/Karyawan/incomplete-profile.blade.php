
@extends('layouts/layoutMaster')

@section('title', 'Profil Belum Lengkap')

@section('vendor-style')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-invoice.scss')
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection
@section('content')
<div class="container " style="margin-top: 5rem; margin-bottom:2rem">
  <div class="row">
      <div class="col-12">
          <div class="card text-center">
              <div class="card-body">
                  <h4 class="card-title text">Profil Belum Lengkap</h4>
                  <p class="card-text">
                      Anda belum mengisi data. Silakan lengkapi data Anda terlebih dahulu untuk melanjutkan.
                  </p>
                  <a href="{{ url('/form/pribadi/karyawan') }}" class="btn btn-primary">
                      Lanjutkan
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
