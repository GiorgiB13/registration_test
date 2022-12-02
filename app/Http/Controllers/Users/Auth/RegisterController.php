<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUserRegisterRequest;
use App\Repositories\UserRegisterRepository;
use http\Env\Response;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * @param PostUserRegisterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Response
     */
    public function register(PostUserRegisterRequest $request, UserRegisterRepository $repository): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Response
    {
        $repository->register($request);

        return response(['message' => 'User Registered Successfully'], 200);
    }
}
