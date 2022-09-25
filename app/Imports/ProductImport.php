<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            

            // 'p_name' => $row[0], 
            // 'p_sku' => $row[1], 
            // 'p_box' => $row[2], 
            // 'p_description' => $row[3], 
            // 'p_buy' => $row[4], 
            // 'p_profit' => $row[5], 
            // 'p_sell' => $row[6], 
            // 'p_unit' => $row[7], 
            // 'p_previous' => $row[8], 
            // 'p_new' => $row[9], 
            // 'p_total' => $row[10], 
            // 'p_out' => $row[11], 
            // 'p_disburse' => $row[12],

        ]);
    }
}
