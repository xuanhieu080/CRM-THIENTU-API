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

    public function updateItem(Customer $customer, array $data)
    {
        try {
            DB::beginTransaction();
            $data = CRM::clean($data);

            $customer->first_name = trim(Arr::get($data, 'first_name', $customer->first_name));
            $customer->last_name = trim(Arr::get($data, 'last_name', $customer->last_name));
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

//            Deal::create([
//                'model_type'      => Customer::class,
//                'model_id'        => $record->id,
//                'service_id'      => $data['service_id'],
//                'last_updated_at' => Carbon::now(),
//            ]);

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
        return $customer->delete();
    }
}
