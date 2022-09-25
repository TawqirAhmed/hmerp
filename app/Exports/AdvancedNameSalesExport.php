<?php

namespace App\Exports;

use App\AdvancedNameSales;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;


class AdvancedNameSalesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('approvedadvancedsales')
    					->join('customers','approvedadvancedsales.id_customer','customers.id')
                        ->select('approvedadvancedsales.id','approvedadvancedsales.bill_code','customers.c_name','customers.c_code','approvedadvancedsales.vat_percent','approvedadvancedsales.total_vat','approvedadvancedsales.total_price','approvedadvancedsales.payment_method','approvedadvancedsales.payment_description','approvedadvancedsales.amount_paid','approvedadvancedsales.amount_due','approvedadvancedsales.profits','approvedadvancedsales.created_at')
                        ->where('approvedadvancedsales.id_customer',$this->name)
                        ->where('approvedadvancedsales.created_at','>=',$this->from)->where('approvedadvancedsales.created_at','<=', $this->to)
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
