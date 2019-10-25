<?php

namespace App\Imports;

use App\EnterpriseModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnterpriseImport implements ToModel, WithHeadingRow
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

        return new EnterpriseModel([
            'name' => $row['company'],
            'representative' => $row['represent'],
            'registered_capital' => $row['real'],
            'setup_time' => $row['setup'],
            'biz_status' => $row['status'],
            'region' => $row['province'],
            'city' => $row['city'] ? $row['city'] : '-',
            'district' => $row['district'] ? $row['district'] : '-',
            'phone' => $row['phone'] . ';' . $row['telephone'],
            'email' => $row['email'] ? $row['email'] : '-',
            'word' => $row['word'] ? $row['word'] : '-'
        ]);
    }
}
