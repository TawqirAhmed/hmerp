<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class MHExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
                        ->select('mhins.mhin_head AS head',DB::raw('"" AS project_id'),DB::raw('"" AS folio'),'mhins.mhin_amount AS credit',DB::raw('"" AS debit'),'mhins.mhin_note AS note','mhins.mhin_user AS user','mhins.created_at')
                        ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
                        ->get();
        
        $tablesuppliesview = DB::table('suppliesview')
        					->select(DB::raw("CONCAT(suppliesview.suppliesview_particulars,' : ',suppliesview.suppliesview_name) AS head"),'suppliesview_id AS project_id','suppliesview_folio AS folio',DB::raw('"" AS credit'), 'suppliesview_credit AS debit', 'suppliesview_note AS note','suppliesview_user AS user','suppliesview.created_at')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('suppliesview_credit','>',0)->get();
        
        // $tableoccsview = DB::table('occsview')
        //                 ->select('occsview.occview_particulars AS head','occsview.occview_id AS project_id','occsview.occview_folio AS folio',DB::raw('"" AS credit'), 'occsview.occview_credit AS debit', 'occsview.occview_note AS note','occsview.occview_user AS user','occsview.created_at')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('occview_credit','>',0)->get();

        $tablecivilsview = DB::table('civilsview')
                            ->select('civilsview.civilview_particulars AS head','civilsview.civilview_id AS project_id','civilsview.civilview_folio AS folio',DB::raw('"" AS credit'), 'civilsview.civilview_credit AS debit', 'civilsview.civilview_note AS note','civilsview.civilview_user AS user','civilsview.created_at')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('civilview_credit','>',0)->get();

        $tableictsview = DB::table('ictsview')
                        ->select('ictsview.ictview_folio AS head','ictsview.ictview_id AS project_id','ictsview.ictview_folio AS folio',DB::raw('"" AS credit'), 'ictsview.ictview_credit AS debit', 'ictsview.ictview_note AS note','ictsview.ictview_user AS user','ictsview.created_at')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('ictsview.ictview_credit','>',0)->get();

        $tableotherssview = DB::table('othersview')
                            ->select('othersview.othersview_particulars AS head','othersview.othersview_id AS project_id','othersview.othersview_folio AS folio',DB::raw('"" AS credit'), 'othersview.othersview_credit AS debit', 'othersview.othersview_note AS note','othersview.othersview_user AS user','othersview.created_at')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('othersview.othersview_credit','>',0)->get();
        
        $data = $mhin->merge($tablesuppliesview);
        // $data = $data->merge($tableoccsview);
        $data = $data->merge($tablecivilsview);
        $data = $data->merge($tableictsview);
        $data = $data->merge($tableotherssview);

        $sorted = $data->sortBy('created_at');
        $sorted->values()->all();

        // echo "<pre>";
        // print_r($sorted);
        // exit();

        return $sorted;

        
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
             'Head-Particulars',
             'Project ID',
             'Folio',
             'Debit',
             'Credit',
             'Note',
             'User',
             'Date Created',
        ];
    }
}
