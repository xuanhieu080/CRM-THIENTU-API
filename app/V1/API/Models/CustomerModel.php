<?php

namespace App\V1\API\Models;


use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerCompany;
use App\Models\Deal;
use App\Supports\CRM;
use App\V1\API\Resources\CustomerResource;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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

    public function updateItem(Customer $item, array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);

            $item->first_name = trim(Arr::get($data, 'first_name', $item->first_name));
            $item->last_name = trim(Arr::get($data, 'last_name', $item->last_name));
            $item->message = Arr::get($data, 'message', $item->message);
            $item->email = Arr::get($data, 'email', $item->email);
            $item->position_name = Arr::get($data, 'position_name', $item->position_name);
            $item->phone = Arr::get($data, 'phone', $item->phone);
            $item->contact_funnel_id = Arr::get($data, 'contact_funnel_id', $item->contact_funnel_id);
            $item->contact_source_id = Arr::get($data, 'contact_source_id', $item->contact_source_id);
            $item->lead_status_id = Arr::get($data, 'lead_status_id', $item->lead_status_id);
            $item->contact_id = Arr::get($data, 'contact_id', $item->contact_id);
            $item->service_id = Arr::get($data, 'service_id', $item->service_id);
            $item->last_updated_at = Carbon::now();

            $item->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return new CustomerResource($item);
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);

            $record = $this->create($data);

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


    public function register(array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);

            $record = $this->create($data);

            $params = ['name' => $data['company_name']];
            list($localPart, $domain) = explode('@', $data['email']);
            $company = Company::query()
                ->where('domain', 'like', "%$domain")
                ->first();
            if (empty($company)) {
                $companyModel = new CompanyModel();
                $company = $companyModel->store($params);
            }

            Deal::create([
                'model_type'      => Customer::class,
                'model_id'        => $record->id,
                'service_id'      => $data['service_id'],
                'last_updated_at' => Carbon::now(),
            ]);

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

    public function show(Customer $item)
    {
        return new CustomerResource($item);
    }

    public function deleteItem(Customer $item)
    {
        return $item->delete();
    }
}
