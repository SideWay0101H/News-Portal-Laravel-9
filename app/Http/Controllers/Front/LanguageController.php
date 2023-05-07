<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Helper\Helpers;

class LanguageController extends Controller
{
    public function switch_language(Request $request)
    {
        Helpers::read_json();
        session()->put('session_short_name',$request->short_name);
        return redirect()->back();
    }
}
