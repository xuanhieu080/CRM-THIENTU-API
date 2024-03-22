<?php

namespace App\V1\API\Controllers;


use App\Models\User;
use App\V1\API\Models\UserModel;
use App\V1\API\Requests\Users\CreateRequest;
use App\V1\API\Requests\Users\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', User::class);
        $input = $request->all();

        return $this->model->index($input);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateRequest $request)
    {
//        $this->authorize('create', User::class);

        $input = $request->validated();
        $record = $this->model->store($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['data' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }


    /**
     *  Show the form for editing the specified resource.
     *
     * @param  User  $user
     *
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
//        $this->authorize('view', User::class);

        $model = $this->model->show($user);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
//        $this->authorize('edit', User::class);

        return $this->show($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  User  $user
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, User $user)
    {
//        $this->authorize('edit', User::class);

        $data = $request->validated();
        if ($item = $this->model->updateItem($user, $data)) {
            return $this->responseUpdateSuccess(['data' => $item]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, User $user)
    {
//        $this->authorize('delete', User::class);

        if ($this->model->deleteItem($user)) {
            return $this->responseDeleteSuccess(['data' => $user]);
        }

        return $this->responseDeleteFail();

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
