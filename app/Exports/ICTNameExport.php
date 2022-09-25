<?php

namespace App\Exports;

use App\ICTName;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;


class ICTNameExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('ictsview')
                        ->select('ictsview.id','ictsview.ictview_particulars','ictsview.ictview_id','ictsview.ictview_folio','ictsview.ictview_user','ictsview.ictview_credit','ictsview.ictview_debit','ictsview.ictview_balance','ictsview.ictview_note','ictsview.ictview_disburse','ictsview.created_at','ictsview.updated_at')
                        ->where('ictsview.ictview_id',$this->name)
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
             'ICT ID',
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
