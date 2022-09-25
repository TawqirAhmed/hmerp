<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();



Route::middleware(['auth:sanctum', 'verified'])->get('/home', function () {
    $Sessionid=Auth::id();
	$Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
	$role = $Sessionuser->role;
    if ($role ==3){
	    $product=DB::table('products')->get();
	    $customer = DB::table('customers')->get();
	    return view('inventory.makesales',compact('product','customer'));
    }
    else if($role ==5){
    	return Redirect()->route('stockin');
    }
    else{
    	// return redirect()->route('home');
    	return view('mh_accounts');
    }
    
})->name('home');

// Route::get('/home', 'HomeController@index')->name('home');

//User Section
Route::get('/users', 'UserController@index')->name('users');
Route::post('add-user', 'UserController@StoreUser');
Route::get('edit-user/{id}', 'UserController@EditUser');
Route::post('/update-user/{id}', 'UserController@UpdateUser');
Route::get('/delete-user/{id}', 'UserController@DeleteUser');

// Customers Section
Route::get('/customers','CustomerController@index')->name('customers');
Route::resource('customers_table','CustomerController');
Route::post('add_customer', 'CustomerController@StoreCustomer');
Route::get('customer_info/{id}/edit/','CustomerController@edit');
Route::post('update_customer', 'CustomerController@updateCustomer');

//MH Scetion
Route::get('/mh','MHController@index')->name('mh');
Route::resource('mhin_table','MHController');
Route::post('add_mh', 'MHController@AddToMH');
Route::get('mhin_info/{id}/edit/','MHController@edit');
Route::post('update_mhin', 'MHController@updateMh');

// OCC Section
Route::get('/occ','OCCController@index')->name('occ');
Route::resource('occ_table','OCCController');
Route::post('add_occ', 'OCCController@StoreOCC');
Route::get('occ_info/{id}/edit/','OCCController@edit');
Route::post('update_occ', 'OCCController@updateOCC');

// OCC View Section
Route::post('/occview','OCCViewController@index')->name('occview');
Route::post('customoccview', 'OCCViewController@index');
Route::post('occ_pay', 'OCCViewController@OCCPay');
Route::post('update_occpay_pay', 'OCCViewController@updateOCCPay');
Route::get('occ_view_info/{id}/edit/','OCCViewController@edit');

// Supply Section
Route::get('/supply','SupplyController@index')->name('supply');
Route::resource('supply_table','SupplyController');
Route::post('add_supply', 'SupplyController@StoreSupply');
Route::get('supply_info/{id}/edit/','SupplyController@edit');
Route::post('update_supply', 'SupplyController@updateSupply');

//Supply View Section
Route::post('/supplyview','SuppliesViewController@index')->name('supplyview');
Route::post('customsuppliesview', 'SuppliesViewController@index');
Route::post('supplies_pay', 'SuppliesViewController@SupplyPay');
Route::post('update_suppliespay_pay', 'SuppliesViewController@updateSupplyPay');
Route::get('supplies_view_info/{id}/edit/','SuppliesViewController@edit');

// CIVIL Section
Route::get('/civil','CivilController@index')->name('civil');
Route::resource('civil_table','CivilController');
Route::post('add_civil', 'CivilController@StoreCivil');
Route::get('civil_info/{id}/edit/','CivilController@edit');
Route::post('update_civil', 'CivilController@updateCivil');

// Civil View Section
Route::post('/civilview','CivilViewController@index')->name('civilview');
Route::post('customcivilview', 'CivilViewController@index');
Route::post('civil_pay', 'CivilViewController@CivilPay');
Route::post('update_civilpay_pay', 'CivilViewController@updateCivilPay');
Route::get('civil_view_info/{id}/edit/','CivilViewController@edit');

// ICT Section
Route::get('/ict','ICTController@index')->name('ict');
Route::resource('ict_table','ICTController');
Route::post('add_ict', 'ICTController@StoreICT');
Route::get('ict_info/{id}/edit/','ICTController@edit');
Route::post('update_ict', 'ICTController@updateICT');

// ICT View Section
Route::post('/ictview','ICTViewController@index')->name('ictview');
Route::post('customictview', 'ICTViewController@index');
Route::post('ict_pay', 'ICTViewController@ICTPay');
Route::post('update_ictpay_pay', 'ICTViewController@updateICTPay');
Route::get('ict_view_info/{id}/edit/','ICTViewController@edit');

// OTHERS Section
Route::get('/others','OthersController@index')->name('others');
Route::resource('others_table','OthersController');
Route::post('add_others', 'OthersController@StoreOthers');
Route::get('others_info/{id}/edit/','OthersController@edit');
Route::post('update_others', 'OthersController@updateOthers');

// Others View Section
Route::post('/othersview','OthersViewController@index')->name('othersview');
Route::post('customothersview', 'OthersViewController@index');
Route::post('others_pay', 'OthersViewController@OthersPay');
Route::post('update_otherspay_pay', 'OthersViewController@updateOthersPay');
Route::get('others_view_info/{id}/edit/','OthersViewController@edit');

// MHOut Section
Route::get('/mhout','MHOutController@index')->name('mhout');
Route::resource('mhout_table','MHOutController');


//Inventory Section--------------------------------------------------------------------------------

// Stockin Section
Route::get('/stockin','StockinController@index')->name('stockin');
Route::resource('stockin_table','StockinController');
Route::post('add_product', 'StockinController@AddProduct');
Route::get('product_info/{id}/edit/','StockinController@edit');
Route::post('update_product', 'StockinController@updateProduct');
Route::post('update_stock', 'StockinController@updateStock');
Route::post('print-barcode', 'StockinController@barcode');

// Add Products with Barcode
Route::get('stockin_barcode', 'AddProductBarcode@index')->name('stockin_barcode');
Route::get('barcodeclear-cart', 'AddProductBarcode@barcodeClearCart')->name('barcodeclear-cart');
Route::get('barcodStockin-cart', 'AddProductBarcode@barcodeUpdateProducts')->name('barcodStockin-cart');
Route::post('/barcodecart-add_barcode', 'AddProductBarcode@BarcodeADD');
Route::post('/barcode_cart-update/{rowId}', 'AddProductBarcode@UpdateCart');
Route::post('/barcode_box-update/{rowId}', 'AddProductBarcode@UpdateBox');

Route::patch('updatebarcode-cart', 'AddProductBarcode@update');
Route::delete('removebarcode-from-cart', 'AddProductBarcode@remove');



// Stockout Section
Route::get('/stockout','StockOutController@index')->name('stockout');
Route::post('/cart-add', 'StockOutController@AddCart');
Route::get('/cart-remove/{rowId}', 'StockOutController@removeCart');
Route::post('/cart-update/{rowId}', 'StockOutController@UpdateCart');
Route::post('/cart-updateprice/{rowId}', 'StockOutController@UpdateCartPrice');
Route::get('clear-cart', 'StockOutController@clearCart')->name('clear-cart');
Route::post('show.invoice', 'StockOutController@PrintBill')->name('show.invoice');

// Stockout Record Section
Route::get('/stockoutrecords','StockOutrecordsController@index')->name('stockoutrecords');
Route::resource('stockout_table','StockOutrecordsController');
Route::get('stockout_info/{id}/edit/','StockOutrecordsController@edit');
Route::post('print-stockout', 'StockOutrecordsController@print');

// Sales Section
Route::get('/makesales','MakeSalesController@index')->name('makesales');
Route::post('/makesalescart-add', 'MakeSalesController@AddCart');
Route::get('/makesalescart-remove/{rowId}', 'MakeSalesController@removeCart');
Route::post('/makesalescart-update/{rowId}', 'MakeSalesController@UpdateCart');
Route::post('/makesalescart-updateprice/{rowId}', 'MakeSalesController@UpdateCartPrice');
Route::get('makesalesclear-cart', 'MakeSalesController@clearCart')->name('makesalesclear-cart');
Route::post('makesalesshow.invoice', 'MakeSalesController@PrintBill')->name('makesalesshow.invoice');
Route::post('/makesalescart-add_barcode', 'MakeSalesController@AddCartBarcode');


//Sales NonApproved Section
Route::get('/salesto','SaleToApproveController@index')->name('salesto');
Route::resource('st_table','SaleToApproveController');
Route::get('st_info/{id}/edit/','SaleToApproveController@edit');
Route::get('sta_info/{id}/edit/','SaleToApproveController@edit');
Route::post('print-st', 'SaleToApproveController@print');

//Approve Section
Route::post('approve-sta', 'approvepercentageController@index');
Route::post('/cart-updatepercentage/{rowId}', 'approvepercentageController@UpdatePercentage');
Route::post('approve.invoice', 'approvepercentageController@ApproveSale')->name('approve.invoice');
Route::get('percent_clear-cart', 'approvepercentageController@clearCart')->name('percent_clear-cart');

//Approved Sales Section
Route::get('/approved_sales','ApprovedSaleController@index')->name('approved_sales');
Route::resource('as_table','ApprovedSaleController');
Route::get('as_info/{id}/edit/','ApprovedSaleController@edit');
Route::post('update_as', 'ApprovedSaleController@updateAS');
Route::post('print-as', 'ApprovedSaleController@print');
Route::post('update-as-payment', 'ApprovedSaleController@updateASPayment');

// Advanced Sales Section
Route::get('/advancedsales','AdvancedSalesController@index')->name('advancedsales');
Route::post('/advancedsalescart-add', 'AdvancedSalesController@AddCart');
Route::get('/advancedsalescart-remove/{rowId}', 'AdvancedSalesController@removeCart');
Route::post('/advancedsalescart-update/{rowId}', 'AdvancedSalesController@UpdateCart');
Route::post('/advancedsalescart-updateprice/{rowId}', 'AdvancedSalesController@UpdateCartPrice');
Route::get('advancedsalesclear-cart', 'AdvancedSalesController@clearCart')->name('advancedsalesclear-cart');
Route::post('advancedsalesshow.invoice', 'AdvancedSalesController@PrintBill')->name('advancedsalesshow.invoice');
Route::post('/advancedsalescart-add_barcode', 'AdvancedSalesController@AddCartBarcode');

//Advanced Sales NonApproved Section
Route::get('/ad_salesto','AdvancedSaleToApproveController@index')->name('ad_salesto');
Route::resource('ad_st_table','AdvancedSaleToApproveController');
Route::get('ad_st_info/{id}/edit/','AdvancedSaleToApproveController@edit');
Route::get('ad_sta_info/{id}/edit/','AdvancedSaleToApproveController@edit');
Route::post('ad_print-st', 'AdvancedSaleToApproveController@print');

//Advanced Approve Section
Route::post('ad_approve-sta', 'advancedPercentageController@index');
Route::post('/ad_cart-updatepercentage/{rowId}', 'advancedPercentageController@UpdatePercentage');
Route::post('ad_approve.invoice', 'advancedPercentageController@ApproveSale')->name('ad_approve.invoice');
Route::get('ad_clear-cart', 'advancedPercentageController@clearCart')->name('ad_clear-cart');

//Approved Advanced Sales Section
Route::get('/ad_approved_sales','ApprovedAdvancedSaleController@index')->name('ad_approved_sales');
Route::resource('ad_as_table','ApprovedAdvancedSaleController');
Route::get('ad_as_info/{id}/edit/','ApprovedAdvancedSaleController@edit');
Route::post('ad_update_as', 'ApprovedAdvancedSaleController@updateAS');
Route::post('ad_print-as', 'ApprovedAdvancedSaleController@print');
Route::post('update-ad_as-payment', 'ApprovedAdvancedSaleController@updateADASPayment');

//Reports Section
Route::get('/reports','ReportController@index')->name('reports');
Route::post('mh_reports', 'ReportController@MHReport');
Route::post('mhin_reports', 'ReportController@MHinReport');
Route::post('mhout_reports', 'ReportController@MHoutReport');
Route::post('occ_reports', 'ReportController@OCCReport');
Route::post('supply_reports', 'ReportController@SupplyReport');
Route::post('civil_reports', 'ReportController@CivilReport');
Route::post('ict_reports', 'ReportController@ICTReport');
Route::post('others_reports', 'ReportController@OthersReport');
Route::post('products_reports', 'ReportController@ProductsReport');
Route::post('productsout_reports', 'ReportController@ProductsReportOut');
Route::post('Approvedsales_reports', 'ReportController@Approvedsales');
Route::post('Advancedsales_reports', 'ReportController@Advancedsales');
Route::post('duesales_reports', 'ReportController@Duesales');
Route::post('customerpurchase_reports', 'ReportController@CustomerPurchase');
Route::get('/all_customers','ReportController@AllCustomers')->name('all_customers');
Route::get('/all_products','ReportController@AllProducts')->name('all_products');
Route::post('profit_reports', 'ReportController@ProfitReport');
Route::post('stockout_reports', 'ReportController@StockoutReport');

//Profits Section
Route::get('profits', 'ReportController@ProfitReports')->name('profits');
Route::post('customHome', 'ReportController@ProfitReports');
Route::get('profitsdetails/{id}','ReportController@ViewDetails');



//Due Sales Section
Route::get('/due_sales','DuesalesController@index')->name('due_sales');
Route::resource('due_table','DuesalesController');
// Route::get('due_info/{id}/edit/','DuesalesController@edit');
// Route::post('update_due', 'DuesalesController@updateAS');
// Route::post('print-due', 'DuesalesController@print');
Route::post('modify-sta', 'DuesalesController@EditDue');
Route::post('/cart-updatedue/{rowId}', 'DuesalesController@UpdateDue');
Route::post('due.invoice', 'DuesalesController@ApproveEdit')->name('due.invoice');
Route::get('due_clear-cart', 'DuesalesController@clearCart')->name('due_clear-cart');

// Suppliers Section
Route::get('/suppliers','SupplierController@index')->name('suppliers');
Route::resource('suppliers_table','SupplierController');
Route::post('add_supplier', 'SupplierController@StoreSupplier');
Route::get('supplier_info/{id}/edit/','SupplierController@edit');
Route::post('update_supplier', 'SupplierController@updateSupplier');


//Product Information Section
Route::get('/productinfo','ProductInfoController@index')->name('productinfo');
Route::post('product_information', 'ProductInfoController@index');

//Product Information Section
Route::get('/dueinfo','DueinfoController@index')->name('dueinfo');
Route::post('dueinfo_information', 'DueinfoController@index');



// employees Section
Route::get('/employees','EmployeesController@index')->name('employees');
Route::resource('employees_table','EmployeesController');
Route::post('add_employees', 'EmployeesController@StoreEmployees');
Route::get('employees_info/{id}/edit/','EmployeesController@edit');
Route::post('update_employees', 'EmployeesController@updateEmployees');



//Quotation Section--------------------------------------
Route::get('/makequotation','QuotationController@index')->name('makequotation');
Route::post('makequotation.invoice', 'QuotationController@PrintBill')->name('makequotation.invoice');
Route::get('quotationclear-cart', 'QuotationController@clearCart')->name('quotationclear-cart');

//Quotation to approve-------------------------------------------
Route::get('/qu_salesto','QuotationtoapproveController@index')->name('qu_salesto');
Route::resource('qu_st_table','QuotationtoapproveController');
Route::get('qu_st_info/{id}/edit/','QuotationtoapproveController@edit');
Route::get('qu_sta_info/{id}/edit/','QuotationtoapproveController@edit');
Route::post('qu_print-st', 'QuotationtoapproveController@print');

//Advanced Approve Section
Route::post('qu_approve-sta', 'QuotationPercentController@index');
Route::post('/qu_cart-updatepercentage/{rowId}', 'QuotationPercentController@UpdatePercentage');
Route::post('qu_approve.invoice', 'QuotationPercentController@ApproveSale')->name('qu_approve.invoice');
Route::get('qu_clear-cart', 'QuotationPercentController@clearCart')->name('qu_clear-cart');

//Approved Quotation Section
Route::get('/qu_approved_sales','ApprovedQuotationController@index')->name('qu_approved_sales');
Route::resource('qu_as_table','ApprovedQuotationController');
Route::get('qu_as_info/{id}/edit/','ApprovedQuotationController@edit');
Route::post('qu_update_as', 'ApprovedQuotationController@updateAS');
Route::post('qu_print-as', 'ApprovedQuotationController@print');
Route::post('update-qu_as-payment', 'ApprovedQuotationController@updateADASPayment');

//Backup Section
Route::get('/our_backup_database', 'BackupInfoController@our_backup_database')->name('our_backup_database');
Route::get('/5058932653', 'BackupInfoController@lol')->name('5058932653');
Route::get('/download', 'BackupInfoController@download')->name('download');