<?php

namespace App\Exports;

// use App\Mhout;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class MhoutExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	// $sales = DB::table('mh_info')
     //                    ->select('mh_info.id','mh_info.mh_name','mh_info.mh_amount','mh_info.mh_purpose','mh_info.mh_method','mh_info.created_at')
     //                    ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
     //                    ->get();

    	$tablesuppliesview = DB::table('suppliesview')->select('created_at',DB::raw("CONCAT(suppliesview.suppliesview_particulars,' : ',suppliesview.suppliesview_name) AS suppliesview_particulars"),'suppliesview_id','suppliesview_folio','suppliesview_user', 'suppliesview_credit', 'suppliesview_note')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('suppliesview_credit','>',0)->get();

    	// $tableoccsview = DB::table('occsview')->select('created_at','occsview.occview_particulars AS suppliesview_particulars','occsview.occview_id AS suppliesview_id','occsview.occview_folio AS suppliesview_folio', 'occsview.occview_user AS suppliesview_user', 'occsview.occview_credit AS suppliesview_credit', 'occsview.occview_note AS suppliesview_note')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('occsview.occview_credit','>',0)->get();

        $tablecivilsview = DB::table('civilsview')->select('created_at','civilsview.civilview_particulars AS suppliesview_particulars','civilsview.civilview_id AS suppliesview_id','civilsview.civilview_folio AS suppliesview_folio', 'civilsview.civilview_user AS suppliesview_user', 'civilsview.civilview_credit AS suppliesview_credit', 'civilsview.civilview_note AS suppliesview_note')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('civilsview.civilview_credit','>',0)->get();

        $tableictsview = DB::table('ictsview')->select('created_at','ictsview.ictview_particulars AS suppliesview_particulars','ictsview.ictview_id AS suppliesview_id','ictsview.ictview_folio AS suppliesview_folio', 'ictsview.ictview_user AS suppliesview_user', 'ictsview.ictview_credit AS suppliesview_credit', 'ictsview.ictview_note AS suppliesview_note')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('ictsview.ictview_credit','>',0)->get();

        $tableotherssview = DB::table('othersview')->select('created_at','othersview.othersview_particulars AS suppliesview_particulars','othersview.othersview_id AS suppliesview_id','othersview.othersview_folio AS suppliesview_folio', 'othersview.othersview_user AS suppliesview_user', 'othersview.othersview_credit AS suppliesview_credit', 'othersview.othersview_note AS suppliesview_note')->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)->where('othersview.othersview_credit','>',0)->get();

        // $data = $tablesuppliesview->merge($tableoccsview);
        $data = $tablesuppliesview->merge($tablecivilsview);
        $data = $data->merge($tableictsview);
        $data = $data->merge($tableotherssview);

        $sorted = $data->sortBy('created_at');
        $sorted->values()->all();

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
             'Date Created',
             'Head-Particulars',
             'Project ID',
             'Folio',
             'User',
             'Credit',
             'Note',
        ];
    }
}
