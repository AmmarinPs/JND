<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Url::where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            // ->get();
            ->paginate(10);
        // dd($data[0]->user);
        return view('url.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('url.createOrEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'url_original' => 'required',
        //     'url_short'    => 'required',
        // ]);
        // $data['user_id'] = auth()->user()->id;
        // dd($data);
        // Url::create($data);
        // return redirect()->route('data.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        $request->validate([
            'url_original' => 'required|url|max:2048',
            'title'        => 'required',
        ]);
        $original = $request->input('url_original');
        $title = $request->input('title');
        $userID   = auth()->id();
        do {
            $code = \Illuminate\Support\Str::random(6);
        } while (\App\Models\Url::where('url_short', $code)->exists());
        Url::create([
            'user_id'      => $userID,
            'url_original' => $original,
            'url_short'    => $code,
            'title'    => $title,
        ]);
        return redirect()->route('data.index')
            ->with('shortUrl', url($code))
            ->with('success', 'ย่อลิงก์เรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        //
    }
}
