<?php

namespace App\V1\API\Controllers;


use App\Models\LeadStatus;
use App\V1\API\Models\LeadStatusModel;
use App\V1\API\Requests\LeadStatus\CreateRequest;
use App\V1\API\Requests\LeadStatus\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new LeadStatusModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', LeadStatus::class);
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
//        $this->authorize('create', LeadStatus::class);

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
     * @param  LeadStatus  $leadStatus
     *
     * @throws AuthorizationException
     */
    public function show(LeadStatus $leadStatus)
    {
//        $this->authorize('view', LeadStatus::class);

        $model = $this->model->show($leadStatus);
        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  LeadStatus  $leadStatus
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(LeadStatus $leadStatus)
    {
//        $this->authorize('edit', LeadStatus::class);

        return $this->show($leadStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  LeadStatus  $leadStatus
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, LeadStatus $leadStatus)
    {
//        $this->authorize('edit', LeadStatus::class);

        $data = $request->validated();
        if ($leadStatus = $this->model->updateItem($leadStatus, $data)) {
            return $this->responseUpdateSuccess(['model' => $leadStatus]);
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
    public function destroy(Request $request, LeadStatus $leadStatus)
    {
//        $this->authorize('delete', LeadStatus::class);

        if ($this->model->deleteItem($leadStatus)) {
            return $this->responseDeleteSuccess(['model' => $leadStatus]);
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
