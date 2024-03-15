<?php

namespace App\V1\API\Controllers;

use App\V1\API\Models\AuthModel;
use App\V1\API\Requests\Auth\ForgotPasswordRequest;
use App\V1\API\Requests\Auth\LoginRequest;
use App\V1\API\Requests\Auth\NewPasswordRequest;
use App\V1\API\Requests\Customers\CreateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new AuthModel();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        return $this->model->login($data);
    }

    public function logout(Request $request)
    {
        return $this->model->logout();
    }

    public function forgotPass(ForgotPasswordRequest $request)
    {
        $data = $request->validated();
        return $this->model->forgot($data);
    }

    public function newPassword(NewPasswordRequest $request, $token)
    {
        $data = $request->validated();
        $data['token'] = $token;
        return $this->model->newPassword($data);
    }


    /**
     * Render properties
     * @return array
     */
    public function properties()
    {
        return [];
    }
}
