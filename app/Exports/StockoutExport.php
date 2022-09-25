<?php

namespace App\Exports;

use App\Stockout;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockoutExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

     /**
    * @return \Illuminate\Support\Collection
    */
     // varible form and to 
     public function __construct(String $from = null , String $to = null)
     {
         $this->from = $from;
         $this->to   = $to;
     }
    public function collection()
    {

    	$sales = DB::table('stockouts')
    					->join('customers','stockouts.id_customer','customers.id')
    					->join('users','stockouts.id_seller','users.id')
                        ->select('stockouts.id','stockouts.bill_code','customers.c_name','customers.c_code','users.name','users.email','stockouts.total_price','stockouts.created_at')
                        ->where('stockouts.created_at','>=',$this->from)->where('stockouts.created_at','<=', $this->to)
                        ->get();

        
        return $sales;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
             
            },
        ];
    }
    
    //function header in excel
     public function headings(): array
     {
         return [
             'Id',
             'Bill Code',
             'Customer Name',
             'Customer Code',
             'Seller Name',
             'Seller Email',
             'Total Price',
             'Sell Date',
        ];
    }
}
