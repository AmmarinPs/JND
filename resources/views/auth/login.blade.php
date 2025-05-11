@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ')

@section('content')
<div class="container">
    <div class="row vh-100 justify-content-center align-items-center">
      <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h2 class="card-title text-center mb-4">เข้าสู่ระบบ</h2>

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label for="login" class="form-label">Email หรือ Username</label>
                <input
                  type="text"
                  id="login"
                  name="login"
                  value="{{ old('login') }}"
                  required
                  autofocus
                  class="form-control @error('login') is-invalid @enderror"
                >
                @error('login')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

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
              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="remember"
                  name="remember"
                  {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">
                  จดจำฉัน
                </label>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block">
                  เข้าสู่ระบบ
                </button>
              </div>
            </form>
            <div class="text-center mt-3">
              <a href="{{ route('register') }}">ยังไม่มีบัญชี? สมัครเลย</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
