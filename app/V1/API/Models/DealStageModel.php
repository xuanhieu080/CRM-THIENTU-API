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

        $input['sort'] = ['name' => 'asc'];
        if (!empty($input['search'])) {
            $input['name'] = ['like' => $input['search']];
        }
        $result = $this->search($input, [], $limit);

        return DealStageResource::collection($result);
    }

    public function updateItem(DealStage $item, array $data)
    {
        try {
            DB::beginTransaction();

            $data = CRM::clean($data);
            $item->name = Arr::get($data, 'name', $item->name);
            $item->description = Arr::get($data, 'description', $item->description);
            $item->percent = (int)Arr::get($data, 'percent', $item->percent);
            $isDefault = filter_var(Arr::get($data, 'is_default', $item->is_default), FILTER_VALIDATE_BOOLEAN);
            if ($isDefault != $item->is_default) {
                DealStage::query()->update(['is_default' => false]);
                $item->is_default = filter_var(Arr::get($data, 'is_default', $item->is_default), FILTER_VALIDATE_BOOLEAN);
            }
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
            $data['user_id'] = auth()->id();
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
