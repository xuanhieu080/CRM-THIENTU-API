<?php

namespace App\V1\API\Models;


use App\Models\Service;
use App\Supports\CRM;
use App\V1\API\Resources\ServiceResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ServiceModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new Service();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return ServiceResource::collection($result);
    }

    public function updateItem(Service $item, array $data)
    {
        try {
            DB::beginTransaction();

            $data = CRM::clean($data);
            $item->name = Arr::get($data, 'name', $item->name);
            $item->description = Arr::get($data, 'description', $item->description);
            $isDefault = filter_var(Arr::get($data, 'is_default', $item->is_default), FILTER_VALIDATE_BOOLEAN);
            if ($isDefault == $item->is_default) {
                Service::query()->update(['is_default' => false]);
                $item->is_default = filter_var(Arr::get($data, 'is_default', $item->is_default), FILTER_VALIDATE_BOOLEAN);
            }
            $item->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new ServiceResource($item);
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

        return new ServiceResource($record);
    }

    public function show(Service $item)
    {
        return new ServiceResource($item);
    }

    public function deleteItem(Service $item)
    {
        $i = Service::query()
            ->find($item->id);
        return $i->delete();
    }
}
