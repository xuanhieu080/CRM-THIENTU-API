<?php

namespace App\V1\API\Models;


use App\Models\Industry;
use App\Supports\CRM;
use App\V1\API\Resources\IndustryResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class IndustryModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new Industry();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return IndustryResource::collection($result);
    }

    public function updateItem(Industry $item, array $data)
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

        return new IndustryResource($item);
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

        return new IndustryResource($record);
    }

    public function show(Industry $item)
    {
        return new IndustryResource($item);
    }

    public function deleteItem(Industry $item)
    {
        return $item->delete();
    }
}
