<?php

namespace App\Exports;

// use App\OCC;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class OCCExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('occsview')
                        ->select('occsview.id','occsview.occview_particulars','occsview.occview_id','occsview.occview_folio','occsview.occview_user','occsview.occview_credit','occsview.occview_debit','occsview.occview_balance','occsview.occview_note','occsview.occview_disburse','occsview.created_at','occsview.updated_at')
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
