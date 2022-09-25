<?php

namespace App\Exports;

use App\Others;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class OthersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('othersview')
                        ->select('othersview.id','othersview.othersview_particulars','othersview.othersview_id','othersview.othersview_folio','othersview.othersview_user','othersview.othersview_credit','othersview.othersview_debit','othersview.othersview_balance','othersview.othersview_note','othersview.othersview_disburse','othersview.created_at','othersview.updated_at')
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
             'Others ID',
             'Folio',
             'User',
             'Credit',
             'Debit',
             'Balance',
             'Note',
             'Date Disburse',
             'Created Date',
             'Modified',
        ];
    }
}
