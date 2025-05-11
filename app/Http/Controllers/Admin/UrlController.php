<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403);
            }
            return $next($request);
        }]);
    }

    public function index()
    {
        $urls = Url::join('users','urls.user_id','=','users.id')
                ->orderBy('urls.id', 'desc')
                ->select('urls.*', 'users.name as user_name')
                ->paginate(10);
        // dd($urls);
        return view('admin.url.index', compact('urls'));
    }

    public function edit(Url $url)
    {
        return view('admin.url.createOrEdit', compact('url'));
    }

    public function update(Request $request, Url $url)
    {
        $data = $request->validate([
            'url_original' => 'required',
            'url_short'    => 'required|string|max:6',
            'title'        => 'required',
            'id'        => 'required',
        ]);
        $data =  Url::where('id',$data['id'])->first();
        $data->url_original = $request->input('url_original');
        $data->url_short    = $request->input('url_short');
        $data->title        = $request->input('title');
        $data->user_id      = auth()->id();
        $data->save();

        return redirect()->route('admin.urls.index')->with('success', 'อัปเดตเรียบร้อย');
    }

    public function destroy(Url $url)
    {
        $url->delete();
        return redirect()->route('admin.urls.index')->with('success', 'ลบเรียบร้อย');
    }
}
