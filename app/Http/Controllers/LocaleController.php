<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocaleController extends Controller
{
    public function chooser (Request $request) {
		\Session::put('locale', $request->locale);
		return back();
	}
}
