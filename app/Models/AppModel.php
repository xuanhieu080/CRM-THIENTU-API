<?php

namespace App\Models;

use App\Supports\FORUM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AppModel extends Model
{
    /**
     * @return array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * @param $query
     * @param int $is_active
     */
    public function filterData(&$query, $is_active = 1)
    {
        $query->where($this->getTable() . '.is_active', $is_active);
    }

    public function byUser(&$query)
    {
        $query->where($this->getTable() . '.created_by', auth('api')->id());
    }

}
