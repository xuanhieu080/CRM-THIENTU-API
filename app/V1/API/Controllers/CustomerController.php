<?php

namespace App\V1\API\Controllers;


use App\Models\Customer;
use App\V1\API\Models\CustomerModel;
use App\V1\API\Requests\Customers\CreateRequest;
use App\V1\API\Requests\Customers\DeleteRequest;
use App\V1\API\Requests\Customers\UpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
//        $this->authorize('list', Customer::class);
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
//        $this->authorize('create', Customer::class);

        $input = $request->validated();
        $record = $this->model->store($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['data' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function register(CreateRequest $request)
    {
//        $this->authorize('create', Customer::class);

        $input = $request->validated();
        $record = $this->model->register($input);
        if (!is_null($record)) {
            return response()->json(['message' => 'Đăng ký thành công', 'status' => 200, 'data' => $record]);
        } else {
            return response()->json(['message' => 'Đăng ký không thành công']);
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     * @param  Customer  $customer
     *
     * @throws AuthorizationException
     */
    public function show(Customer $customer)
    {
//        $this->authorize('view', Customer::class);

        $model = $this->model->show($customer);
        return $this->responseDataSuccess(['data' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer  $customer
     *
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Customer $customer)
    {
//        $this->authorize('edit', Customer::class);

        return $this->show($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Customer  $customer
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
//        $this->authorize('edit', Customer::class);

        $data = $request->validated();
        if ($item = $this->model->updateItem($customer, $data)) {
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
    public function destroy(Request $request, Customer $customer)
    {
//        $this->authorize('delete', Customer::class);

        if ($this->model->deleteItem($customer)) {
            return $this->responseDeleteSuccess(['data' => $customer]);
        }

        return $this->responseDeleteFail();

    }

    /**
     * @throws \Exception
     */
    public function deleteIds(DeleteRequest $request)
    {
//        $this->authorize('delete', Customer::class);
        $data = $request->validated();
        if ($this->model->deleteIds($data['ids'])) {
            return $this->responseDeleteSuccess();
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
