<?php

namespace App\Http\Controllers;

use App\Events\PrivateSubmit;
use Illuminate\Http\Request;

class PrivateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        PrivateSubmit::broadcast($request->user()->id, $request->user()->name, $request->input('chat'));
    }
}
