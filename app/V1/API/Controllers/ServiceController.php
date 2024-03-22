<?php

namespace App\V1\API\Controllers;


use App\Models\Service;
use App\Supports\CRM_ERROR;
use App\V1\API\Models\ServiceModel;
use App\V1\API\Requests\Services\CreateRequest;
use App\V1\API\Requests\Services\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServiceModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', Service::class);
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
//        $this->authorize('create', Service::class);

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
     * @param  Service  $service
     *
     * @throws AuthorizationException
     */
    public function show(Service $service)
    {
//        $this->authorize('view', Service::class);

        $model = $this->model->show($service);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service  $service
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Service $service)
    {
//        $this->authorize('edit', Service::class);

        return $this->show($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Service  $service
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Service $service)
    {
//        $this->authorize('edit', Service::class);

        $data = $request->validated();
        if ($service = $this->model->updateItem($service, $data)) {
            return $this->responseUpdateSuccess(['data' => $service]);
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
    public function destroy(Service $service)
    {
        if ($this->model->deleteItem($service)) {
            return $this->responseDeleteSuccess(['data' => $service]);
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
