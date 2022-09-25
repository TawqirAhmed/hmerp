<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use DB;
use App\Exports\MHExport;
use App\Exports\MhinExport;
use App\Exports\MhoutExport;
use App\Exports\OCCExport;
use App\Exports\OCCNameExport;
use App\Exports\SupplyExport;
use App\Exports\SupplyNameExport;
use App\Exports\CivilExport;
use App\Exports\CivilNmaeExport;
use App\Exports\ICTExport;
use App\Exports\ICTNameExport;
use App\Exports\OthersExport;
use App\Exports\OthersNameExport;
use App\Exports\ProductsNameExport;
use App\Exports\ProductsNameOutExport;
use App\Exports\ApprovedSalesExport;
use App\Exports\ApprovedNameExport;
use App\Exports\AdvancedSalesExport;
use App\Exports\AdvancedNameSalesExport;
use App\Exports\DuesExport;
use App\Exports\DueNameExport;
use App\Exports\CustomersPurchaseExport;
use App\Exports\CustomersExport;
use App\Exports\ProductsExport;
use App\Exports\ProfitExport;
use App\Exports\StockoutExport;
use App\Exports\StockoutNameExport;

class ReportController extends Controller
{
	public function index()
    {
    	return view('reports');
    }

    public function MHReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new MHExport($from, $to), 'Excel-MH.xlsx');
            } 
        }
        
    }

    public function MHinReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new MhinExport($from, $to), 'Excel-MH_in.xlsx');
            } 
        }
        
    }

    public function MHoutReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new MhoutExport($from, $to), 'Excel-MH_out.xlsx');
            } 
        }
        
    }

     public function OCCReport(Request $req)
    {

        // echo "<pre>";
        // print_r($req->all());
        // exit();

        $method = $req->method();

        if ($req->occ_id != "") {

            $occs = DB::table('occs')->where('occ_id',$req->occ_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->occ_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new OCCNameExport($from, $to,$name), 'Excel-OCC_Transaction'.$occs->occ_name.'.xlsx');
                } 
            }
            
        }
        else{

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new OCCExport($from, $to), 'Excel-OCC_Transaction.xlsx');
                } 
            }
        }
        
    }

    public function SupplyReport(Request $req)
    {
        $method = $req->method();

        if ($req->supplies_id != "") {
            $supplies = DB::table('supplies')->where('supplies_id',$req->supplies_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->supplies_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new SupplyNameExport($from, $to,$name), 'Excel-Supply_Transaction'.$supplies->supplies_name.'.xlsx');
                } 
            }
        }

        else{
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new SupplyExport($from, $to), 'Excel-Supply_Transaction.xlsx');
                } 
            }
        } 
    }


    public function CivilReport(Request $req)
    {
        $method = $req->method();

        if ($req->civil_id != "") {
            $civils = DB::table('civils')->where('civil_id',$req->civil_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->civil_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new CivilNmaeExport($from, $to,$name), 'Excel-Civil_Transaction'.$civils->civil_name.'.xlsx');
                } 
            }
        }

        else{
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new CivilExport($from, $to), 'Excel-Civil_Transaction.xlsx');
                } 
            }
        } 
    }


     public function ICTReport(Request $req)
    {
        $method = $req->method();

        if ($req->ict_id != "") {
            $icts = DB::table('icts')->where('ict_id',$req->ict_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->ict_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ICTNameExport($from, $to,$name), 'Excel-ICT_Transaction'.$icts->ict_name.'.xlsx');
                } 
            }
        }

        else{
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ICTExport($from, $to), 'Excel-ICT_Transaction.xlsx');
                } 
            }
        } 
    }

    

    public function OthersReport(Request $req)
    {
        $method = $req->method();

        if ($req->others_id != "") {
            $others = DB::table('others')->where('others_id',$req->others_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->others_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new OthersNameExport($from, $to,$name), 'Excel-Others_Transaction'.$others->others_name.'.xlsx');
                } 
            }
        }

        else{
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new OthersExport($from, $to), 'Excel-Others_Transaction.xlsx');
                } 
            }
        } 
    }


    public function ProductsReport(Request $req)
    {
        $method = $req->method();

        if ($req->products_id != "-113920") {
            $products = DB::table('products')->where('p_name',$req->products_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->products_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ProductsNameExport($from, $to,$name), 'Excel-Product_In_Report'.$products->p_name.'.xlsx');
                } 
            }
        } 
    }


    public function ProductsReportOut(Request $req)
    {
        $method = $req->method();

        if ($req->products_id != "-113920") {
            $products = DB::table('products')->where('p_name',$req->products_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $req->products_id;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ProductsNameOutExport($from, $to,$name), 'Excel-Product_Out_Report'.$products->p_name.'.xlsx');
                } 
            }
        } 
    }

    public function StockoutReport(Request $req)
    {
        $method = $req->method();

        if ($req->custdue_id !="") {
            $customerN = DB::table('customers')->where('id',$req->custdue_id)->first();
            $customerName = $customerN->c_name;

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                $customerinfo = explode(':', $req->custdue_id);

                $customerID = $customerinfo[0];

                $name = $customerID;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new StockoutNameExport($from, $to,$name), 'Excel-Stockout_Report_'.$customerName.'_Customer Code:_'.$customerN->c_code.'.xlsx');
                } 
            }


        } else {
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new StockoutExport($from, $to), 'Excel-Stockout_Report.xlsx');
                } 
            } 
        }
    }

    public function Approvedsales(Request $req)
    {
        $method = $req->method();

        if ($req->custdue_id !="") {
            $customerN = DB::table('customers')->where('id',$req->custdue_id)->first();
            $customerName = $customerN->c_name;

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                $customerinfo = explode(':', $req->custdue_id);

                $customerID = $customerinfo[0];

                $name = $customerID;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ApprovedNameExport($from, $to,$name), 'Excel-Approved_Report_'.$customerName.'_Customer Code:_'.$customerN->c_code.'.xlsx');
                } 
            }


        } else {
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new ApprovedSalesExport($from, $to), 'Excel-Approved_Sales.xlsx');
                } 
            } 
        }
    }
    

    public function Advancedsales(Request $req)
    {
        $method = $req->method();

        if ($req->custdue_id !="") {
            $customerN = DB::table('customers')->where('id',$req->custdue_id)->first();
            $customerName = $customerN->c_name;

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                
                $customerinfo = explode(':', $req->custdue_id);

                $customerID = $customerinfo[0];

                $name = $customerID;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new AdvancedNameSalesExport($from, $to,$name), 'Excel-AdvancedSales_Report_'.$customerName.'_Customer Code:_'.$customerN->c_code.'.xlsx');
                } 
            }


        } else {
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new AdvancedSalesExport($from, $to), 'Excel-AdvancedSales_Sales.xlsx');
                } 
            } 
        }
    }

    public function Duesales(Request $req)
    {
        $method = $req->method();

        if ($req->custdue_id !="") {
            $customerN = DB::table('customers')->where('id',$req->custdue_id)->first();
            $customerName = $customerN->c_name;

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                
                $customerinfo = explode(':', $req->custdue_id);

                $customerID = $customerinfo[0];

                $name = $customerID;

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new DueNameExport($from, $to,$name), 'Excel-Due_Report_'.$customerName.'_Customer Code:_'.$customerN->c_code.'.xlsx');
                } 
            }


        } else {
            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new DuesExport($from, $to), 'Excel-Due_Sales.xlsx');
                } 
            } 
        }
            
    }


    public function CustomerPurchase(Request $req)
    {

        // echo "<pre>";
        // print_r($req->all());
        // exit();

        $method = $req->method();


        if ($req->cust_id != "") {
            $products = DB::table('customers')->where('c_name',$req->cust_id)->first();

            if ($req->isMethod('post'))
            {
                $tempFrom = $req->input('from');
                $tempTo   = $req->input('to');

                $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
                $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
                $name = $products->id;

                

                if($req->has('exportExcel'))
                 {           
                    // select Excel
                    return Excel::download(new CustomersPurchaseExport($from, $to,$name), 'Excel-Customer_Purchase_Report_'.$products->c_name.'.xlsx');
                } 
            }
        } 
    }

    public function AllCustomers()
    {
        return Excel::download(new CustomersExport, 'AllCustomers.xlsx');
    }

    public function AllProducts()
    {
        return Excel::download(new ProductsExport, 'AllProducts.xlsx');
    }

    public function ProfitReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new ProfitExport($from, $to), 'Excel-Profits_reports.xlsx');
            } 
        } 
    }



    //------------------------------------------------------------------------------------------

     public function ProfitReports(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {

            $From = $req->input('from');
            $To   = $req->input('to');

            $profits = DB::table('profits')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();

            $Totalprofit = 0;
            foreach ($profits as $key ) {
                $Totalprofit = $Totalprofit + $key->p_total;
            }

            return view('profits',compact('profits','From','To','Totalprofit'));
        }
        else
        {
            $From = 0;
            $To   = 0;

            $profits = DB::table('profits')->get();

            $Totalprofit = 0;
            foreach ($profits as $key ) {
                $Totalprofit = $Totalprofit + $key->p_total;
            }

            return view('profits',compact('profits','From','To','Totalprofit'));
        }
    }




    public function ViewDetails($id)
    {
        $profit_single = DB::table('profits')->where('p_bill_code',$id)->first();
        $sale_data = array();
        $sale_data = json_decode( $profit_single->p_data);

        // echo "<pre>";
        // print_r($sale_data);
        // exit();

        $all_sale_data = array();
        foreach ($sale_data as $key) {

            $data = json_decode($key);
            $product = DB::table('products')->where('id',$data->id)->first();

            $data->pro_name = $product->p_name;
            // $data->pro_photo = $product->photo;

            array_push($all_sale_data, $data);
        }

        // echo "<pre>";
        // print_r($profit_single->p_data);
        // exit();

        return view('profitdetails',compact('profit_single','all_sale_data'));
    }


  //---------------------------------------------------------------------------------------------  
}
