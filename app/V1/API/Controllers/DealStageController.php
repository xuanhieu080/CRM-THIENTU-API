<?php

namespace App\V1\API\Controllers;


use App\Models\DealStage;
use App\V1\API\Models\DealStageModel;
use App\V1\API\Requests\DealStages\CreateRequest;
use App\V1\API\Requests\DealStages\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealStageController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new DealStageModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', DealStage::class);
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
//        $this->authorize('create', DealStage::class);

        $input = $request->validated();
        $record = $this->model->store($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['model' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param  DealStage  $dealStage
     *
     * @throws AuthorizationException
     */
    public function show(DealStage $dealStage)
    {
//        $this->authorize('view', DealStage::class);

        $model = $this->model->show($dealStage);
        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  DealStage  $dealStage
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(DealStage $dealStage)
    {
//        $this->authorize('edit', DealStage::class);

        return $this->show($dealStage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  DealStage  $dealStage
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, DealStage $dealStage)
    {
//        $this->authorize('edit', DealStage::class);

        $data = $request->validated();
        if ($dealStage = $this->model->updateItem($dealStage, $data)) {
            return $this->responseUpdateSuccess(['model' => $dealStage]);
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
    public function destroy(Request $request, DealStage $dealStage)
    {
//        $this->authorize('delete', DealStage::class);

        if ($this->model->deleteItem($dealStage)) {
            return $this->responseDeleteSuccess(['model' => $dealStage]);
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
