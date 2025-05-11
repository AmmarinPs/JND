{{-- resources/views/url/createOrEdit.blade.php --}}
@extends('layouts.app')

@section('title')
    {{ isset($url) && $url->exists ? 'แก้ไข URL' : 'สร้าง URL ใหม่' }}
@endsection

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4 text-center">
            {{ isset($url) && $url->exists ? 'แก้ไข URL' : 'สร้าง URL ใหม่' }}
          </h3>

          <form
            method="POST"
            action="{{ isset($url) && $url->exists
                        ? route('data.update', $url->id)
                        : route('data.store') }}"
          >
            @csrf
            @if(isset($url) && $url->exists)
              @method('PUT')
            @endif

            <div class="mb-3">
              <label for="title" class="form-label">หัวข้อ (Title)</label>
              <input
                type="text"
                id="title"
                name="title"
                required
                value="{{ old('title', $url->title ?? '') }}"
                placeholder="ใส่หัวข้อสำหรับลิงก์นี้"
                class="form-control @error('title') is-invalid @enderror"
              >
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="url_original" class="form-label">URL ต้นฉบับ</label>
              <input
                type="url"
                id="url_original"
                name="url_original"
                required
                value="{{ old('url_original', $url->url_original ?? '') }}"
                placeholder="https://example.com/..."
                class="form-control @error('url_original') is-invalid @enderror"
              >
              @error('url_original')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if(isset($url) && $url->exists)
              <div class="mb-3">
                <label for="url_short" class="form-label">Short URL</label>
                <div class="input-group">
                  <input
                    type="text"
                    id="url_short"
                    value="{{ url($url->url_short) }}"
                    readonly
                    class="form-control"
                  >
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="navigator.clipboard.writeText(document.getElementById('url_short').value)"
                  >
                    คัดลอก
                  </button>
                </div>
              </div>
            @endif

            <div class="d-flex justify-content-between">
              <a href="{{ route('data.index') }}" class="btn btn-outline-secondary">
                ย้อนกลับ
              </a>
              <button type="submit" class="btn btn-primary">
                {{ isset($url) && $url->exists ? 'อัปเดต URL' : 'สร้าง URL' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
