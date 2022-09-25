<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

use Illuminate\Support\Collection;

class MHOutController extends Controller
{
    public function index(Request $request)
    {
        
        
        // echo "<pre>";
        // print_r($data);
        // exit();

    	if ($request->ajax()) {
    		$tablesuppliesview = DB::table('suppliesview')->select('id',DB::raw("CONCAT(suppliesview.suppliesview_particulars,' : ',suppliesview.suppliesview_name) AS suppliesview_particulars"),'suppliesview_id','suppliesview_folio','suppliesview_user', 'suppliesview_credit', 'suppliesview_note','created_at')
                ->where('suppliesview_credit','>',0)
                ->get();

        // $tableoccsview = DB::table('occsview')->select('id','occsview.occview_particulars AS suppliesview_particulars','occsview.occview_id AS suppliesview_id','occsview.occview_folio AS suppliesview_folio','occsview.occview_user AS suppliesview_user', 'occsview.occview_credit AS suppliesview_credit', 'occsview.occview_note AS suppliesview_note','created_at')
        //     ->where('occsview.occview_credit','>',0)
        //     ->get();

        $tablecivilsview = DB::table('civilsview')->select('id','civilsview.civilview_particulars AS suppliesview_particulars','civilsview.civilview_id AS suppliesview_id','civilsview.civilview_folio AS suppliesview_folio','civilsview.civilview_user AS suppliesview_user', 'civilsview.civilview_credit AS suppliesview_credit', 'civilsview.civilview_note AS suppliesview_note','created_at')
            ->where('civilsview.civilview_credit','>',0)
            ->get();

        $tableictsview = DB::table('ictsview')->select('id','ictsview.ictview_particulars AS suppliesview_particulars','ictsview.ictview_id AS suppliesview_id','ictsview.ictview_folio AS suppliesview_folio','ictsview.ictview_user AS suppliesview_user', 'ictsview.ictview_credit AS suppliesview_credit', 'ictsview.ictview_note AS suppliesview_note','created_at')
            ->where('ictsview.ictview_credit','>',0)
            ->get();

        $tableotherssview = DB::table('othersview')->select('id','othersview.othersview_particulars AS suppliesview_particulars','othersview.othersview_id AS suppliesview_id','othersview.othersview_folio AS suppliesview_folio','othersview.othersview_user AS suppliesview_user', 'othersview.othersview_credit AS suppliesview_credit', 'othersview.othersview_note AS suppliesview_note','created_at')
            ->where('othersview.othersview_credit','>',0)
            ->get();

        // $data = $tablesuppliesview->merge($tableoccsview);
        $data = $tablesuppliesview->merge($tablecivilsview);
        $data = $data->merge($tableictsview);
        $data = $data->merge($tableotherssview);

		// $data = DB::table('mhouts')->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-mh" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		';

		

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('mhout');
    }
}
