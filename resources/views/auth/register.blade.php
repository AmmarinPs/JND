@extends('layouts.app')

@section('title', 'สมัครสมาชิก')

@section('content')
<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
  <div class="card" style="max-width: 24rem; width: 100%;">
    <div class="card-body p-4">
      <h2 class="card-title text-center mb-4">สมัครสมาชิก</h2>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- ชื่อ-นามสกุล --}}
        <div class="mb-3">
          <label for="name" class="form-label">ชื่อ-นามสกุล</label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required
            class="form-control @error('name') is-invalid @enderror"
          >
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="form-control @error('email') is-invalid @enderror"
          >
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Username --}}
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            value="{{ old('username') }}"
            required
            class="form-control @error('username') is-invalid @enderror"
          >
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
          <label for="password" class="form-label">รหัสผ่าน</label>
          <input
            type="password"
            id="password"
            name="password"
            required
            class="form-control @error('password') is-invalid @enderror"
          >
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            class="form-control"
          >
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">
            สมัครสมาชิก
          </button>
        </div>
      </form>

      <div class="text-center mt-3">
        <a href="{{ route('login') }}">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
      </div>
    </div>
  </div>
</div>
@endsection
