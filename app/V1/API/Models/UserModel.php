<?php

namespace App\V1\API\Models;


use App\Models\User;
use App\Supports\CRM;
use App\V1\API\Resources\UserResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new User();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return UserResource::collection($result);
    }

    public function updateItem(User $item, array $data)
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

        return new UserResource($item);
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

        return new UserResource($record);
    }

    public function show(User $item)
    {
        return new UserResource($item);
    }

    public function deleteItem(User $item)
    {
        return $item->delete();
    }


    //// Auth
    ///
    ///
     
}
