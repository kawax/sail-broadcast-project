<?php

namespace App\Http\Controllers;

use App\Events\PresenceSubmit;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        PresenceSubmit::broadcast($request->user()->name, $request->input('chat'));
    }
}
