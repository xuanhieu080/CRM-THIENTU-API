<?php

namespace App\V1\API\Models;


use App\Models\DealStage;
use App\Supports\CRM;
use App\V1\API\Resources\DealStageResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DealStageModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new DealStage();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return DealStageResource::collection($result);
    }

    public function updateItem(DealStage $item, array $data)
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

        return new DealStageResource($item);
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

        return new DealStageResource($record);
    }

    public function show(DealStage $item)
    {
        return new DealStageResource($item);
    }

    public function deleteItem(DealStage $item)
    {
        return $item->delete();
    }
}
