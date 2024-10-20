<?php

namespace App\Shared\Presentation\Console\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{

    abstract public function rules();
}
