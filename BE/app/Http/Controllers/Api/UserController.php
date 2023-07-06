<?php

namespace App\Http\Controllers\Api;

use App\Abstracts\AbstractController;
use App\Models\User;

class UserController extends AbstractController
{
    public function index() {
        return $this->jsonResponse(data: User::all('id', 'name', 'email'));
    }
}
