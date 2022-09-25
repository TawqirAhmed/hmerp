<?php

namespace App\Exports;

use App\DueName;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class DueNameExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

     /**
    * @return \Illuminate\Support\Collection
    */
     // varible form and to 
     public function __construct(String $from = null , String $to = null,String $name = null)
     {
         $this->from = $from;
         $this->to   = $to;
         $this->name   = $name;
     }
    public function collection()
    {

    	$sales = DB::table('approvedsales')
    					->join('customers','approvedsales.id_customer','customers.id')
                        ->select('approvedsales.id','approvedsales.bill_code','customers.c_name','customers.c_code','approvedsales.vat_percent','approvedsales.total_vat','approvedsales.total_price','approvedsales.payment_method','approvedsales.payment_description','approvedsales.amount_paid','approvedsales.amount_due','approvedsales.profits','approvedsales.created_at')
                        ->where('approvedsales.id_customer',$this->name)
                        ->where('approvedsales.amount_due','>',0)
                        ->where('approvedsales.created_at','>=',$this->from)->where('approvedsales.created_at','<=', $this->to)
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
             'VAT %',
             'Total VAT',
             'Total Price',
             'Payment Method',
             'Payment Details',
             'Amount Paid',
             'Amount Due',
             'Profit',
             'Sell Date',
        ];
    }
}
