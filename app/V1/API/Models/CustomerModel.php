<?php

namespace App\V1\API\Models;


use App\Models\Company;
use App\Models\ContactSource;
use App\Models\Customer;
use App\Models\CustomerCompany;
use App\Models\Deal;
use App\Models\Service;
use App\Notifications\CustomerRegisterNotify;
use App\Supports\CRM;
use App\Supports\HasImage;
use App\V1\API\Resources\CustomerResource;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new Customer();
        parent::__construct($model);
    }

    public function index($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $result = $this->search($input, [], $limit);

        return CustomerResource::collection($result);
    }

    public function myContact($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $input['contact_id'] = Auth::id();
        $result = $this->search($input, [], $limit);

        return CustomerResource::collection($result);
    }

    public function unassignedContact($input)
    {
        $limit = Arr::get($input, 'limit', 999);

        $input['sort'] = ['id' => 'desc'];
        $input['contact_id'] = ['<>' => Auth::id()];
        $result = $this->search($input, [], $limit);

        return CustomerResource::collection($result);
    }

    public function updateItem(Customer $customer, array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);

            $firstName = trim(Arr::get($data, 'first_name', $customer->first_name));
            $lastName = trim(Arr::get($data, 'last_name', $customer->last_name));
            $customer->first_name = $firstName;
            $customer->last_name = $lastName;
            $customer->full_name = "$firstName $lastName";
            $customer->message = Arr::get($data, 'message', $customer->message);
            $customer->email = Arr::get($data, 'email', $customer->email);
            $customer->position_name = Arr::get($data, 'position_name', $customer->position_name);
            $customer->phone = Arr::get($data, 'phone', $customer->phone);
            $customer->contact_funnel_id = Arr::get($data, 'contact_funnel_id', $customer->contact_funnel_id);
            $customer->contact_source_id = Arr::get($data, 'contact_source_id', $customer->contact_source_id);
            $customer->lead_status_id = Arr::get($data, 'lead_status_id', $customer->lead_status_id);
            $customer->contact_id = Arr::get($data, 'contact_id', $customer->contact_id);
            $customer->service_id = Arr::get($data, 'service_id', $customer->service_id);
            $customer->last_updated_at = Carbon::now();
            if (!empty($data['avatar'])) {
                $customer->avatar = HasImage::updateImage($data['avatar'], $customer->avatar, Customer::path);
            }
            $customer->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CustomerResource($customer);
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);
//            $contactSource = ContactSource::query()
//                ->where('is_default', 1)
//                ->first();
//            if (!empty($contactSource)) {
//                $data['contact_source_id'] = $contactSource->id;
//            }
            $firstName = trim(Arr::get($data, 'first_name'));
            $lastName = trim(Arr::get($data, 'last_name'));

            $data['first_name'] = $firstName;
            $data['last_name'] = $lastName;
            $data['full_name'] = "$firstName $lastName";
            if (!empty($data['file'])) {
                $data['avatar'] = HasImage::addImage($data['avatar'], Customer::path);
            }

            $record = $this->create($data);

            if (!empty($data['company_name'])) {
                $params = ['name' => $data['company_name']];
                list($localPart, $domain) = explode('@', $data['email']);
                $company = Company::query()
                    ->where('domain', 'like', "%$domain")
                    ->first();
                if (empty($company)) {
                    $companyModel = new CompanyModel();
                    $company = $companyModel->store($params);
                }

                CustomerCompany::create([
                    'customer_id' => $record->id,
                    'company_id'  => $company->id,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CustomerResource($record);
    }


    public function register(array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);
            $contactSource = ContactSource::query()
                ->where('is_default', 1)
                ->first();
            if (!empty($contactSource)) {
                $data['contact_source_id'] = $contactSource->id;
            }
            $firstName = trim(Arr::get($data, 'first_name'));
            $lastName = trim(Arr::get($data, 'last_name'));

            $data['first_name'] = $firstName;
            $data['last_name'] = $lastName;
            $data['full_name'] = "$firstName $lastName";
            $record = $this->create($data);

            $service = Service::query()->find($data['service_id']);
            $record->notify(new CustomerRegisterNotify($service));

            $params = ['name' => $data['company_name']];
            list($localPart, $domain) = explode('@', $data['email']);
            $company = Company::query()
                ->where('domain', 'like', "%$domain")
                ->first();
            if (empty($company)) {
                $companyModel = new CompanyModel();
                $company = $companyModel->store($params);
            }

            CustomerCompany::create([
                'customer_id' => $record->id,
                'company_id'  => $company->id,
            ]);


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CustomerResource($record);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function deleteItem(Customer $customer)
    {
        HasImage::deleteImage($customer->avatar);
        return $customer->delete();
    }

    public function deleteIds($ids = [])
    {
        try {
           DB::beginTransaction();

            $data = Customer::query()
                ->whereIn('id', $ids)
                ->get();

            foreach ($data as $item) {
                $this->deleteItem($item);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        return true;
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
            $query->whereBetween('created_at', [Carbon::parse($createStartDate), Carbon::parse($createEndDate)]);
        }
        if (!empty($lastStartDate) && !empty($lastEndDate)) {
            $query->whereBetween('last_updated_at', [Carbon::parse($lastStartDate), Carbon::parse($lastEndDate)]);
        }

        if (!empty($search)) {
            $query->where(function ($qr) use ($search) {
                $qr->where("full_name", "like", "%$search%")
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
