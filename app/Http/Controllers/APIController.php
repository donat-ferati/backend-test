<?php

namespace App\Http\Controllers;

use App\Traits\APIResponse;
use function request;

class APIController extends Controller
{
    use APIResponse;

    protected mixed $perPage = 50;

    public function __construct()
    {
        if ($perPage = (int)request('items_per_page')) {
            $this->perPage = min(100, $perPage);
        }
    }
}
