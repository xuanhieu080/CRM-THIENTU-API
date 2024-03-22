<?php

namespace App\V1\API\Controllers;


use App\Models\ContactFunnel;
use App\V1\API\Models\ContactFunnelModel;
use App\V1\API\Requests\ContactFunnels\CreateRequest;
use App\V1\API\Requests\ContactFunnels\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactFunnelController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new ContactFunnelModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', ContactFunnel::class);
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
//        $this->authorize('create', ContactFunnel::class);

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
     * @param  ContactFunnel  $contactFunnel
     *
     * @throws AuthorizationException
     */
    public function show(ContactFunnel $contactFunnel)
    {
//        $this->authorize('view', ContactFunnel::class);

        $model = $this->model->show($contactFunnel);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ContactFunnel  $contactFunnel
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(ContactFunnel $contactFunnel)
    {
//        $this->authorize('edit', ContactFunnel::class);

        return $this->show($contactFunnel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  ContactFunnel  $contactFunnel
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, ContactFunnel $contactFunnel)
    {
//        $this->authorize('edit', ContactFunnel::class);

        $data = $request->validated();
        if ($contactFunnel = $this->model->updateItem($contactFunnel, $data)) {
            return $this->responseUpdateSuccess(['data' => $contactFunnel]);
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
    public function destroy(Request $request, ContactFunnel $contactFunnel)
    {
//        $this->authorize('delete', ContactFunnel::class);

        if ($this->model->deleteItem($contactFunnel)) {
            return $this->responseDeleteSuccess(['data' => $contactFunnel]);
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
