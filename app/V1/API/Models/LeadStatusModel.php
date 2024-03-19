<?php

namespace App\V1\API\Models;


use App\Models\LeadStatus;
use App\Supports\CRM;
use App\V1\API\Resources\LeadStatusResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LeadStatusModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new LeadStatus();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return LeadStatusResource::collection($result);
    }

    public function updateItem(LeadStatus $item, array $data)
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

        return new LeadStatusResource($item);
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

        return new LeadStatusResource($record);
    }

    public function show(LeadStatus $item)
    {
        return new LeadStatusResource($item);
    }

    public function deleteItem(LeadStatus $item)
    {
        return $item->delete();
    }
}
