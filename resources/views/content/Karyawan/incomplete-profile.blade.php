
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
    <div class="d-flex flex-column justify-content-center align-items-center text-center mb-6 row-gap-4">
      <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Selamat Datang Karyawan</h4>
        <p class="mb-0">Silahkan isi profile di bawah ini dengan benar </p>
      </div>
    </div>
      <div class="col-12">
          <div class="card text-center">
              <div class="card-body">
                  <h4 class="card-title text-danger">Profil Belum Lengkap</h4>
                  <p class="card-text">
                      Anda belum mengisi profil. Silakan lengkapi data profil Anda terlebih dahulu untuk melanjutkan.
                  </p>
                  <a href="{{ url('/form/karyawan') }}" class="btn btn-primary">
                      Isi Profil
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
