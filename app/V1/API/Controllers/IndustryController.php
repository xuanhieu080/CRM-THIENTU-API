<?php

namespace App\V1\API\Controllers;


use App\Models\Industry;
use App\V1\API\Models\IndustryModel;
use App\V1\API\Requests\Industries\CreateRequest;
use App\V1\API\Requests\Industries\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new IndustryModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', Industry::class);
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
//        $this->authorize('create', Industry::class);

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
     * @param  Industry  $industry
     *
     * @throws AuthorizationException
     */
    public function show(Industry $industry)
    {
//        $this->authorize('view', Industry::class);

        $model = $this->model->show($industry);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Industry  $industry
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Industry $industry)
    {
//        $this->authorize('edit', Industry::class);

        return $this->show($industry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Industry  $industry
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Industry $industry)
    {
//        $this->authorize('edit', Industry::class);

        $data = $request->validated();
        if ($industry = $this->model->updateItem($industry, $data)) {
            return $this->responseUpdateSuccess(['data' => $industry]);
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
    public function destroy(Request $request, Industry $industry)
    {
//        $this->authorize('delete', Industry::class);

        if ($this->model->deleteItem($industry)) {
            return $this->responseDeleteSuccess(['data' => $industry]);
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
