@extends('layouts.app')

@section('title', 'จัดการลิงก์ทั้งหมด (Admin)')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">จัดการลิงก์ทั้งหมด</h3>
    <form action="{{ route('logout') }}" method="POST" class="m-0">
      @csrf
      <button type="submit" class="btn btn-outline-danger">
        ออกจากระบบ
      </button>
    </form>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>title</th>
              <th>ต้นฉบับ</th>
              <th>ลิงก์ย่อ</th>
              <th>Owner</th>

              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($urls as $item)
              <tr>
                <td>{{ $loop->iteration + ($urls->currentPage()-1)*$urls->perPage() }}</td>
                <td class="text-break">{{ $item->title??"" }}</td>
                <td class="text-break">{{ $item->url_original }}</td>
                <td class="text-break">
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="short-{{ $item->id }}"
                    value="{{ url($item->url_short) }}"
                    readonly
                  >
                </td>
                <td>{{ $item->user_name }}
                    {{-- ({{ $item->user->email }}) --}}
                </td>
                {{-- <td>{{ $item->created_at->format('Y-m-d H:i') }}</td> --}}
                <td class="text-center">
                  <button
                    class="btn btn-sm btn-outline-secondary"
                    onclick="navigator.clipboard.writeText(document.getElementById('short-{{ $item->id }}').value).then(()=>alert('คัดลอกสำเร็จ'))"
                  >
                    คัดลอก
                  </button>

                  <a
                    href="{{ route('redirect', ['short' => $item->url_short]) }}"
                    target="_blank"
                    class="btn btn-sm btn-primary"
                  >
                    เปิดดู
                  </a>

                  <a
                    href="{{ route('admin.urls.edit', $item->id) }}"
                    class="btn btn-sm btn-warning"
                  >
                    แก้ไข
                  </a>
                  <form
                    action="{{ route('admin.urls.destroy', $item->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('ลบลิงก์นี้จริงหรือไม่?');"
                  >
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">ลบ</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">
                  ยังไม่มีลิงก์ให้จัดการ
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="mt-3">
    {{ $urls->links() }}
  </div>
</div>
@endsection
