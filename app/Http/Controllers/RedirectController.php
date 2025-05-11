<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
class RedirectController extends Controller
{
    public function go($short)
    {
        $url = Url::where('url_short', $short)->firstOrFail();
        return redirect()->to($url->url_original);
    }
}
