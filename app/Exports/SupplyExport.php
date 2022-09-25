<?php

namespace App\Exports;

// use App\Supply;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('suppliesview')
                        ->select('suppliesview.id','suppliesview.suppliesview_name','suppliesview.suppliesview_particulars','suppliesview.suppliesview_id','suppliesview.suppliesview_folio','suppliesview.suppliesview_user','suppliesview.suppliesview_credit','suppliesview.suppliesview_debit','suppliesview.suppliesview_balance','suppliesview.suppliesview_note','suppliesview.suppliesview_disburse','suppliesview.created_at','suppliesview.updated_at')
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
             'Particulars',
             'District',
             'OCC ID',
             'Folio',
             'User',
             'Debit',
             'Credit',
             'Balance',
             'Note',
             'Date Disburse',
             'Created Date',
             'Modified',
        ];
    }
}
