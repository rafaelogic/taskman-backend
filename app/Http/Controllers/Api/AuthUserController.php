<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        return UserResource::make($request->user());
    }
}
