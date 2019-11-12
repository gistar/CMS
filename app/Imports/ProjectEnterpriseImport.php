<?php

namespace App\Imports;

use App\ProjectEnterpriseModel;
use Encore\Admin\Facades\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectEnterpriseImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if (!isset($row['company'])) {
            return null;
        }

        return new ProjectEnterpriseModel([
            'name' => $row['company'],
            'representative' => $row['representative'],
            'registered_capital' => $row['registered_capital'] ? $row['registered_capital'] : '',
            'address' => $row['address'] ? $row['address'] : '',
            'region' => $row['province'] ? $row['province'] : '',
            'city' => $row['city'] ? $row['city'] : '',
            'district' => $row['area'] ? $row['area'] : '',
            'biz_status' => $row['biz_status'] ? $row['biz_status'] : '',
            'credit_code' => $row['credit_code'] ? $row['credit_code'] : '',
            'register_code' => $row['register_code'] ? $row['register_code'] : '',
            'phone' => $row['phone'] ? $row['phone'] : '',
            'email' => $row['email'] ? $row['email'] : '',
            'setup_time' => $row['setup_time'] ? $row['setup_time'] : '',
            'industry' => $row['industry'] ? $row['industry'] : $row['industry'],
            'biz_scope' => $row['biz_scope'] ? $row['biz_scope'] : '',
            'registered_capital' => $row['registered_capital'] ? $row['registered_capital'] : '',
            'word' => $row['word'] ? $row['word'] : '',
            'project_id' => $row['project_id'],
            'create_user_id' => Admin::user()->id,
            'note' => $row['note'] ? $row['note'] : '',
        ]);
    }
}
