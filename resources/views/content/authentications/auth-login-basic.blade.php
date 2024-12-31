@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/pages-auth.js'
])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">
      <!-- Login -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-6">
            <a href="{{ url('/') }}" class="app-brand-link">
              <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
              <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1">Hai Karyawan LKI !! 👋</h4>
          <p class="mb-6">Untuk Mengisi Data Karyawan Anda Perlu Masuk Menggunakan Google</p>

          @auth
          <p class="mb-6">Anda sudah masuk. Silakan lanjutkan ke <a href="{{ url('/view/karyawan') }}">Formulir Karyawan</a>.</p>
          @else
          <div class="mb-6">
            <a href="{{ route('auth.google') }}" class="btn btn-primary d-grid w-100">
              <i class="ti ti-brand-google"></i>
              <span class="align-middle d-sm-inline-block d-none me-sm-2">Masuk Dengan Google</span>
            </a>
          </div>
          @endauth

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
