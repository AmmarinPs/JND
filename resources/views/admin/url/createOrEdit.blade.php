@extends('layouts.app')

@section('title', 'แก้ไขลิงก์ (Admin)')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title text-center mb-4">แก้ไขลิงก์ (Admin)</h3>

          <form
            method="POST"
            action="{{ route('admin.urls.update', $url->id) }}"
          >
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">หัวข้อ (Title)</label>
              <input
                type="text"
                id="title"
                name="title"
                value="{{ $url->title }}"
                required
                class="form-control @error('title') is-invalid @enderror"
              >
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="url_original" class="form-label">URL ต้นฉบับ</label>
              <input type="hidden" name="id" value="{{ $url->id }}">
              <input
                type="url"
                id="url_original"
                name="url_original"
                value="{{ $url->url_original }}"
                readonly
                class="form-control-plaintext"
              >
            </div>

            {{-- Short Code --}}
            <div class="mb-3">
              <label for="url_short" class="form-label">Short Code</label>
              <input
                type="text"
                id="url_short"
                name="url_short"
                value="{{ $url->url_short }}"
                required
                class="form-control @error('url_short') is-invalid @enderror"
              >
              @error('url_short')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('admin.urls.index') }}" class="btn btn-outline-secondary">
                ย้อนกลับ
              </a>
              <button type="submit" class="btn btn-primary">
                อัปเดตข้อมูล
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
