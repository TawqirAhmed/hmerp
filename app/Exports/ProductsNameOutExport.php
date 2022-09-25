<?php

namespace App\Exports;

use App\ProductsNameOut;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsNameOutExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

     /**
    * @return \Illuminate\Support\Collection
    */
     // varible form and to 
     public function __construct(String $from = null , String $to = null, String $name = null)
     {
         $this->from = $from;
         $this->to   = $to;
         $this->name   = $name;
     }
    public function collection()
    {

    	$sales = DB::table('productout')
                        ->select('productout.id','productout.pout_name','productout.pout_sku','productout.pout_billno','productout.pout_quantity','productout.created_at')
                        ->where('productout.pout_name',$this->name)
                        ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
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
             'Name',
             'SKU',
             'Bill No.',
             'Quantity',
             'Out Date',
        ];
    }
}
