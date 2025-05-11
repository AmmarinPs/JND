@extends('layouts.app')

@section('title', 'รายการ URL')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('data.create') }}" class="btn btn-success">
      + ย่อลิงก์ใหม่
    </a>
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
              <th>หัวข้อ</th>
              <th>ต้นฉบับ</th>
              <th>ลิงก์ย่อ</th>
              <th>Owner</th>
              <th>สร้างเมื่อ</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($datas as $item)
              <tr>
                <td>{{ $loop->iteration + ($datas->currentPage()-1)*$datas->perPage() }}</td>
                <td class="text-break">{{ $item->title??"" }}</td>
                <td class="text-break">{{ $item->url_original }}</td>
                <td>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    value="{{ url($item->url_short) }}"
                    readonly
                    id="short-{{ $item->id }}"
                  >
                </td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                <td class="text-center">
                  <button
                    class="btn btn-sm btn-outline-secondary"
                    onclick="navigator.clipboard.writeText(document.getElementById('short-{{ $item->id }}').value).then(() => alert('คัดลอกสำเร็จ'))"
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
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">
                  ยังไม่มีลิงก์ใดๆ
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="mt-3">
    {{ $datas->links() }}
  </div>
</div>
@endsection
