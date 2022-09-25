<?php

namespace App\Exports;

// use App\Mhin;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class MhinExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$mhin = DB::table('mhins')
                        ->select('mhins.id','mhins.mhin_head','mhins.mhin_amount','mhins.mhin_note','mhins.mhin_user','mhins.created_at','mhins.mhin_disburse','mhins.updated_at')
                        ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
                        ->get();

        // $mhin = DB::table('mhins')
        //                 ->select('mhins.mhin_head AS head','mhins.mhin_amount AS credit',DB::raw('"" AS debit'),'mhins.created_at')
        //                 ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
        //                 ->get();
        // $tableoccsview = DB::table('occsview')
        //                 ->select('occsview.occview_particulars AS head', DB::raw('"" AS credit'), 'occsview.occview_credit AS debit','occsview.created_at')
        //                 ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
        //                 ->get();

        // $data = $mhin->merge($tableoccsview);
        // $sorted = $data->sortBy('created_at');
        // $sorted->values()->all();

        // echo "<pre>";
        // print_r($sorted);
        // exit();

        // return $sorted;

        return $mhin;
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
             'Head-Particulars',
             'Amount',
             'Note',
             'User',
             'Created',
             'Disburse',
             'Modified',
        ];
    }
}
