<?php

namespace App\V1\API\Models;


use App\Models\ContactFunnel;
use App\Supports\CRM;
use App\V1\API\Resources\ContactFunnelResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ContactFunnelModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new ContactFunnel();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return ContactFunnelResource::collection($result);
    }

    public function updateItem(ContactFunnel $item, array $data)
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

        return new ContactFunnelResource($item);
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

        return new ContactFunnelResource($record);
    }

    public function show(ContactFunnel $item)
    {
        return new ContactFunnelResource($item);
    }

    public function deleteItem(ContactFunnel $item)
    {
        return $item->delete();
    }
}
