<?php

namespace App\V1\API\Controllers;


use App\Models\ContactSource;
use App\V1\API\Models\ContactSourceModel;
use App\V1\API\Requests\ContactSources\CreateRequest;
use App\V1\API\Requests\ContactSources\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactSourceController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new ContactSourceModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', ContactSource::class);
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
//        $this->authorize('create', ContactSource::class);

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
     * @param  ContactSource  $contactSource
     *
     * @throws AuthorizationException
     */
    public function show(ContactSource $contactSource)
    {
//        $this->authorize('view', ContactSource::class);

        $model = $this->model->show($contactSource);
        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ContactSource  $contactSource
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(ContactSource $contactSource)
    {
//        $this->authorize('edit', ContactSource::class);

        return $this->show($contactSource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  ContactSource  $contactSource
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, ContactSource $contactSource)
    {
//        $this->authorize('edit', ContactSource::class);

        $data = $request->validated();
        if ($contactSource = $this->model->updateItem($contactSource, $data)) {
            return $this->responseUpdateSuccess(['model' => $contactSource]);
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
    public function destroy(Request $request, ContactSource $contactSource)
    {
//        $this->authorize('delete', ContactSource::class);

        if ($this->model->deleteItem($contactSource)) {
            return $this->responseDeleteSuccess(['model' => $contactSource]);
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
