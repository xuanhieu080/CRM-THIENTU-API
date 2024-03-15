<?php

namespace App\V1\API\Models;


use App\Models\Company;
use App\Supports\CRM;
use App\V1\API\Resources\CompanyResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CompanyModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new Company();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return CompanyResource::collection($result);
    }

    public function updateItem(Company $item, array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);
            $item->name = Arr::get($data, 'name', $item->name);
            $item->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CompanyResource($item);
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);
            $record = $this->create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CompanyResource($record);
    }

    public function show(Company $item)
    {
        return new CompanyResource($item);
    }

    public function deleteItem(Company $item)
    {
        return $item->delete();
    }
}
