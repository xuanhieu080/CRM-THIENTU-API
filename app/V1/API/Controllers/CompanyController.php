<?php

namespace App\V1\API\Controllers;


use App\Models\Company;
use App\V1\API\Models\CompanyModel;
use App\V1\API\Requests\Companies\CreateRequest;
use App\V1\API\Requests\Companies\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new CompanyModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', Company::class);
        $input = $request->all();

        return $this->model->index($input);
    }
    public function myCompany(Request $request)
    {
//        $this->authorize('list', Company::class);
        $input = $request->all();

        return $this->model->myCompany($input);
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
//        $this->authorize('create', Company::class);

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
     * @param  Company  $company
     *
     * @throws AuthorizationException
     */
    public function show(Company $company)
    {
//        $this->authorize('view', Company::class);

        $model = $this->model->show($company);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company  $company
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Company $company)
    {
//        $this->authorize('edit', Company::class);

        return $this->show($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Company  $company
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Company $company)
    {
//        $this->authorize('edit', Company::class);

        $data = $request->validated();
        if ($item = $this->model->updateItem($company, $data)) {
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
    public function destroy(Request $request, Company $company)
    {
//        $this->authorize('delete', Company::class);

        if ($this->model->deleteItem($company)) {
            return $this->responseDeleteSuccess(['data' => $company]);
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
