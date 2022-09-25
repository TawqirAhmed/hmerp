<?php

namespace App\Exports;

// use App\CivilName;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class CivilNmaeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$sales = DB::table('civilsview')
                        ->select('civilsview.id','civilsview.civilview_particulars','civilsview.civilview_id','civilsview.civilview_folio','civilsview.civilview_user','civilsview.civilview_credit','civilsview.civilview_debit','civilsview.civilview_balance','civilsview.civilview_note','civilsview.civilview_disburse','civilsview.created_at','civilsview.updated_at')
                        ->where('civilsview.civilview_id',$this->name)
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
             'Civil ID',
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
