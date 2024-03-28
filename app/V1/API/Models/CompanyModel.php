<?php

namespace App\V1\API\Models;


use App\Models\Company;
use App\Supports\CRM;
use App\Supports\HasImage;
use App\V1\API\Resources\CompanyResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function myCompany($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $input['contact_id'] = Auth::id();
        $result = $this->search($input, [], $limit);

        return CompanyResource::collection($result);
    }

    public function updateItem(Company $item, array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);
            $item->name = Arr::get($data, 'name', $item->name);
            $item->phone = Arr::get($data, 'phone', $item->phone);
            $item->domain = Arr::get($data, 'domain', $item->domain);
            $item->email = Arr::get($data, 'email', $item->email);
            $item->address = Arr::get($data, 'address', $item->address);
            $item->description = Arr::get($data, 'description', $item->description);
            $item->facebook_link = Arr::get($data, 'facebook_link', $item->facebook_link);
            $item->linkedin_link = Arr::get($data, 'linkedin_link', $item->linkedin_link);
            $item->industry_id = Arr::get($data, 'industry_id', $item->industry_id);
            $item->contact_id = Arr::get($data, 'contact_id', $item->contact_id);
            $item->lead_status_id = Arr::get($data, 'lead_status_id', $item->lead_status_id);
            if (!empty($data['image'])) {
                $item->image = HasImage::updateImage( $data['image'],$item->image, Company::path);
            }
            $item->last_updated_at = Carbon::now();
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
            if (!empty($data['image'])) {
                $data['image'] = HasImage::addImage($data['image'], Company::path);
            }
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

    public function search($input = [], $with = [], $limit = null)
    {
        $createStartDate = Arr::get($input, 'create_start_date');
        $createEndDate = Arr::get($input, 'create_end_date');
        $lastStartDate = Arr::get($input, 'last_start_date');
        $lastEndDate = Arr::get($input, 'last_end_date');
        $search = Arr::get($input, 'search');
        $query = $this->make($with);
        $orWhere = Arr::get($input, 'orWhere', []);
        $this->sortBuilder($query, $input);
        $full_columns = $this->model->getFillable();

        $input = array_intersect_key($input, array_flip($full_columns));
        $orWhere = array_intersect_key($orWhere, array_flip($full_columns));

        foreach ($input as $field => $value) {
            if ($value === "") {
                continue;
            }
            if (is_array($value)) {
                $query->where(function ($q) use ($field, $value) {
                    foreach ($value as $action => $data) {
                        $action = strtoupper($action);
                        if ($data === "") {
                            continue;
                        }
                        switch ($action) {
                            case "LIKE":
                                $q->orWhere(DB::raw($field), "like", "%$data%");
                                break;
                            case "IN":
                                $q->orWhereIn(DB::raw($field), $data);
                                break;
                            case "NOT IN":
                                $q->orWhereNotIn(DB::raw($field), $data);
                                break;
                            case "NULL":
                                $q->orWhereNull(DB::raw($field));
                                break;
                            case "NOT NULL":
                                $q->orWhereNotNull(DB::raw($field));
                                break;
                            case "BETWEEN":
                                $q->orWhereBetween(DB::raw($field), $value);
                                break;
                            default:
                                $q->orWhere(DB::raw($field), $action, $data);
                                break;
                        }
                    }
                });
            } else {
                $query->where(DB::raw($field), $value);
            }
        }
        $query->where(function ($qr) use ($orWhere) {
            foreach ($orWhere as $field => $value) {
                if ($value === "") {
                    continue;
                }
                if (is_array($value)) {
                    $qr->orWhere(function ($q) use ($field, $value) {
                        foreach ($value as $action => $data) {
                            $action = strtoupper($action);
                            if ($data === "") {
                                continue;
                            }
                            switch ($action) {
                                case "LIKE":
                                    $q->orWhere(DB::raw($field), "like", "%$data%");
                                    break;
                                case "IN":
                                    $q->orWhereIn(DB::raw($field), $data);
                                    break;
                                case "NOT IN":
                                    $q->orWhereNotIn(DB::raw($field), $data);
                                    break;
                                case "NULL":
                                    $q->orWhereNull(DB::raw($field));
                                    break;
                                case "NOT NULL":
                                    $q->orWhereNotNull(DB::raw($field));
                                    break;
                                case "BETWEEN":
                                    $q->orWhereBetween(DB::raw($field), $value);
                                    break;
                                default:
                                    $q->orWhere(DB::raw($field), $action, $data);
                                    break;
                            }
                        }
                    });
                } else {
                    $qr->orwhere(DB::raw($field), $value);
                }
            }
        });
        if (!empty($createStartDate) && !empty($createEndDate)) {
            $query->whereBetween('created_at', [\Carbon\Carbon::parse($createStartDate), Carbon::parse($createEndDate)]);
        }
        if (!empty($lastStartDate) && !empty($lastEndDate)) {
            $query->whereBetween('last_updated_at', [Carbon::parse($lastStartDate), Carbon::parse($lastEndDate)]);
        }

        if (!empty($search)) {
            $query->where(function ($qr) use ($search) {
                $qr->where("name", "like", "%$search%")
                    ->orWhere("email", "like", "%$search%")
                    ->orWhere("phone", "like", "%$search%");
            });
        }

        if ($limit) {
            if ($limit === 1) {
                return $query->first();
            } else {
                return $query->paginate($limit);
            }
        } else {
            return $query->get();
        }
    }
}
