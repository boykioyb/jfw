<?php

namespace App\Modules\Account\Presentation\API\Controllers;

use App\Shared\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        // Logic xử lý yêu cầu API

        return response()->json("OK");
    }
}
