<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\backend\RoleController;
//use App\Http\Controllers\backend\Internal_create_account;

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

// Route::get('/', function () {
    // return view('auth.login');
// });
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('role-create-type');
    }
    return view('auth.login');
});
// frontend

// Route::view('product-detail','frontend/product-detail');
// Route::view('product','frontend/product');
Route::view('/warranty-check-3','frontend/warranty-check-3');
Route::view('/warranty-check-4','frontend/warranty-check-4');
Route::view('/warranty-check-5','frontend/warranty-check-5');
Route::get('warranty-check', "frontend\WarrantyController@index")->name('warranty-check');
Route::get('warranty-check-search', "frontend\WarrantyController@search")->name('warranty-check-search');
Route::get('get-address', "frontend\WarrantyController@getaddress")->name('get-address');
Route::post('insert-warranty', "frontend\WarrantyController@insert")->name('insert-warranty');

Route::get('product', "frontend\HomeController@index")->name('product');
Route::get('product-detail/{name}', "frontend\HomeController@product_detail")->name('product-detail.name');
Route::post('get-quotation', "frontend\HomeController@get_quotation")->name('get-quotation');
Route::get('google-pie-chart', "backend\DashboardController@googlePieChart")->name('google-pie-chart');
// backend

require __DIR__.'/auth.php';
Route::middleware(['auth'])->group(function(){
Route::get('role-create-type', "backend\RoleController@index")->name('role.index');
Route::post('create_role', "backend\RoleController@create_role")->name('role.create_role');

Route::get('/role-all-role',"backend\RoleController@showroles");


Route::get('/edit_role/{id}',"backend\RoleController@edit_roles");
Route::post('/update_role/{id}',"backend\RoleController@update_roles");

Route::get('/delete_role/{id}',"backend\RoleController@destroy_roles");
Route::post('/delete-all-role',"backend\RoleController@deleteallrole");

Route::get('/internal-create-account',"backend\Internal_create_account@index");
Route::post('/internal-account-store',"backend\Internal_create_account@store");
Route::get('/internal-all-account',"backend\Internal_create_account@show");
Route::get('/internal-edit-account/{id}',"backend\Internal_create_account@edit");
Route::put('/change_pass/{id}',"backend\Internal_create_account@change_pass");
Route::put('/internal-update-account/{id}',"backend\Internal_create_account@update");
Route::get('/internal-delete-account/{id}',"backend\Internal_create_account@destroy");
Route::get('/update_status/{id}',"backend\Internal_create_account@update_status");
Route::get('/search',"backend\Internal_create_account@search");
Route::get('/filter',"backend\Internal_create_account@filter");
Route::get('/duplicate/{id}',"backend\RoleController@duplicate");
Route::get('/delete_imgg',"backend\Internal_create_account@delete_img");
Route::put('/delete-all',"backend\Internal_create_account@deleteall");
/***Warehouse***/
Route::get('/warehouse-create-warehouse',"backend\WarehouseController@index");
Route::post('/warehouse-create-store',"backend\WarehouseController@store");
Route::get('/warehouse-all-warehouse',"backend\WarehouseController@show");
Route::get('/warehouse-edit-warehouse/{id}','backend\WarehouseController@edit');
Route::post('/warehouse-update','backend\WarehouseController@update');
Route::get('/warehouse-delete-warehouse/{id}',"backend\WarehouseController@destroy");
Route::get('/warehouse-duplicate-warehouse/{id}',"backend\WarehouseController@duplicate");
Route::view('/warehouse-dashboard','backend.warehouse-dashboard');
Route::post('/delete-all-warehouse',"backend\WarehouseController@deleteallwarehouse");

/***Supplier***/
Route::get('/supplier-create-new-supplier',"backend\SupplierController@index");
Route::post('/create-supplier',"backend\SupplierController@create_supplier");
Route::get('/suppliers',"backend\SupplierController@show");
Route::get('/delete_suppliers/{id}',"backend\SupplierController@delete_suppliers");
Route::get('/edit_supplier/{id}',"backend\SupplierController@edit")->name('edit_supplier');
Route::post('/update-supplier',"backend\SupplierController@update_supplier");

/***Category***/
Route::get('/create-category',"backend\CategoryController@index");
Route::post('/create-new-category',"backend\CategoryController@insert");
Route::get('/all-categories',"backend\CategoryController@show");
Route::get('/edit-category/{id}',"backend\CategoryController@edit");
Route::get('/delete-category/{id}',"backend\CategoryController@delete");
Route::post('/update-category',"backend\CategoryController@update");

/***products***/
Route::get('/product-create-product','backend\ProductController@product_form');
Route::post('/product-store-product','backend\ProductController@store_product')->name('store-product');
Route::get('/product-all-products','backend\ProductController@show')->name('all_products');
Route::get('/change-status/{id}','backend\ProductController@update_status');
Route::get('/delete-product/{id}',"backend\ProductController@destroy");

Route::get('/product-edit-product/{id}','backend\ProductController@edit_product');
Route::post('/update-product/{id}','backend\ProductController@update_product');
Route::get('/delete_img',"backend\ProductController@delete_img");
Route::post('/delete-all-products',"backend\ProductController@deleteallproducts");


/***Inventory***/
Route::get('/inventory-stock',"backend\InventoryController@index");
Route::get('/update-packet',"backend\InventoryController@updatepacket");

/*Purchase Order***/
Route::get('/purchase-order-create-po',"backend\PurchaseOrderController@index");
Route::get('/autocomplete', 'backend\PurchaseOrderController@autocomplete')->name('autocomplete');
Route::get('/get-price', 'backend\PurchaseOrderController@getprice')->name('get-price');
Route::get('/total-price', 'backend\PurchaseOrderController@totalprice')->name('total-price');
Route::post('/insert-purchase-order', 'backend\PurchaseOrderController@insert')->name('insert-purchase-order');
Route::get('/purchase-order-list', 'backend\PurchaseOrderController@show')->name('purchase-order-list');
Route::get('/status-change/{id}','backend\PurchaseOrderController@update_status')->name('status-change.id');
Route::post('/delete-all-orders','backend\PurchaseOrderController@deleteall')->name('deleteall_orders');
Route::get('/delete-order/{id}','backend\PurchaseOrderController@delete')->name('delete-order.id');
Route::get('/edit-purchase-order/{id}','backend\PurchaseOrderController@edit')->name('edit-purchase-order.id');
Route::post('/update-purchase-order/','backend\PurchaseOrderController@update')->name('update-purchase-order');
Route::get('/approval-change/{id}/{approval}','backend\PurchaseOrderController@update_approval')->name('approval-change.id.approval');
Route::get('/print-po/{id}','backend\PurchaseOrderController@print_po')->name('print-po.id');

/*Quotation*/
Route::get('/quotation-create-quotation',"backend\QuotationController@index");
Route::get('/sales-all-quotation',"backend\QuotationController@show")->name('sales-all-quotation');
Route::post('/insert-quotation',"backend\QuotationController@insert");
Route::get('/quotation-status-change/{id}/{approval}','backend\QuotationController@quotation_approval')->name('quotation-status-change.id.approval');
Route::post('/delete-all-quotation','backend\QuotationController@deleteall')->name('deleteall_quotation');
Route::get('/delete-quotation/{id}','backend\QuotationController@delete')->name('delete-quotation.id');
Route::get('/sales-quotation-edit/{id}','backend\QuotationController@edit')->name('sales-quotation-edit.id');
Route::post('/update-quotation','backend\QuotationController@update')->name('update-quotation');
Route::get('/quotation-pdf/{id}','backend\QuotationController@pdf')->name('quotation-pdf.id');
Route::get('/search-supplier','backend\QuotationController@searchsupplier')->name('search-supplier');
Route::get('/attention-to','backend\QuotationController@attention_to')->name('attention-to');
Route::get('/get-details-quotation','backend\QuotationController@getdetails')->name('get-details-quotation');
Route::get('/print-quotation/{id}','backend\QuotationController@print_quotation')->name('print-quotation.id');
Route::get('/get-owners','backend\QuotationController@get_owners')->name('get-owners');

/***Release Order ***/
Route::get('/release-order-create-ro',"backend\ReleaseOrderController@index")->name('release-order-create-ro');
Route::post('/insert-release-order',"backend\ReleaseOrderController@insert")->name('insert-release-order');
Route::get('/release-order-list',"backend\ReleaseOrderController@show")->name('irelease-order-list');
Route::post('/delete-all-ro','backend\ReleaseOrderController@deleteall')->name('delete-all-ro');
Route::get('/delete-ro/{id}','backend\ReleaseOrderController@delete')->name('delete-ro.id');
Route::get('/release-order-edit-ro/{id}',"backend\ReleaseOrderController@edit")->name('release-order-edit-ro.id');
Route::get('/delete_roimg',"backend\ReleaseOrderController@delete_roimg")->name('delete_roimg');
Route::post('/update-ro',"backend\ReleaseOrderController@update")->name('update-ro');
Route::get('/ro-status-change/{id}/{approval}',"backend\ReleaseOrderController@approval")->name('ro-status-change/{id}/{approval}');
Route::get('/ro-pdf/{id}','backend\ReleaseOrderController@pdf')->name('ro-pdf.id');
Route::get('/print-ro/{id}','backend\ReleaseOrderController@print_ro')->name('print-ro.id');

/***Sales Invoice**/
Route::get('/sales-invoice',"backend\InvoiceController@index")->name('sales-invoice');
Route::post('/insert-invoice',"backend\InvoiceController@insert")->name('insert-invoice');
Route::get('/all-invoice',"backend\InvoiceController@show")->name('all-invoice');
Route::post('/delete-all-invoice',"backend\InvoiceController@deleteall")->name('delete-all-invoice');
Route::get('/invoice-status-change/{id}/{approval}','backend\InvoiceController@status_change')->name('invoice-status-change.id.approval');
Route::get('/delete-invoice/{id}','backend\InvoiceController@delete')->name('delete-invoice.id');
Route::get('/invoice-pdf/{id}','backend\InvoiceController@pdf')->name('invoice-pdf.id');
Route::get('/edit-invoice-edit/{id}','backend\InvoiceController@edit')->name('edit-invoice-edit.id');
Route::post('/update-invoice','backend\InvoiceController@update')->name('update-invoice');
Route::get('/get-details','backend\InvoiceController@getdetails')->name('get-details');
Route::get('/search-customer','backend\InvoiceController@searchcustomer')->name('search-customer');
Route::get('/print-invoice/{id}','backend\InvoiceController@print_invoice')->name('print-invoice.id');


/**Jobsheet**/
Route::get('/jobsheet',"backend\JobsheetController@index")->name('jobsheet');
Route::post('/assign-delivery',"backend\JobsheetController@assign_delivery")->name('assign-delivery');
Route::post('/assign-installation',"backend\JobsheetController@assign_installation")->name('assign-installation');
Route::get('/edit-jobsheet/{id}',"backend\JobsheetController@edit")->name('edit-jobsheet.id');
Route::post('/update-jobsheet',"backend\JobsheetController@update")->name('update-jobsheet');
Route::get('/delete-jobsheet/{id}',"backend\JobsheetController@delete")->name('delete-jobsheet.id');
Route::get('/jobsheet_status/{id}/{status}',"backend\JobsheetController@jobsheet_status")->name('jobsheet_status.id.status');
Route::post('/delete-all-sheets',"backend\JobsheetController@deleteall")->name('delete-all-sheets');
Route::get('/create-jobsheet-create',"backend\JobsheetController@create")->name('create-jobsheet-create');
Route::get('/search-ro',"backend\JobsheetController@autocomplete")->name('search-ro');
Route::post('/insert-jobsheet',"backend\JobsheetController@insert")->name('insert-jobsheet');
Route::get('/job-sheet-calendar',"backend\JobsheetController@view_calendar")->name('job-sheet-calendar');
Route::get('/job-sheet-details/{id}',"backend\JobsheetController@view")->name('job-sheet-details.id');
Route::get('/details-pdf/{id}','backend\JobsheetController@pdf')->name('details-pdf.id');
Route::post('/send-reminder','backend\JobsheetController@send_reminder')->name('send-reminder');
Route::get('/reminder_status/{id}','backend\JobsheetController@reminder_status')->name('reminder_status.id');
Route::post('/send-email-reminder','backend\JobsheetController@send_email_reminder')->name('send-email-reminder');
Route::post('/create-invoice','backend\JobsheetController@create_invoice')->name('create-invoice');
Route::get('/print-jobsheet/{id}','backend\JobsheetController@print_jobsheet')->name('print-jobsheet.id');
Route::get('/assigned-next-date','backend\JobsheetController@next_date')->name('assigned-next-date');
Route::get('/assigned-previous-date','backend\JobsheetController@previous_date')->name('assigned-previous-date');
Route::get('/not-next-date','backend\JobsheetController@not_next_date')->name('not-next-date');
Route::get('/not-previous-date','backend\JobsheetController@not_previous_date')->name('not-previous-date');


/***Customer Type***/
Route::get('/customer-create-type','backend\TypeController@index')->name('customer-create-type');
Route::post('/create_type','backend\TypeController@insert')->name('create_type');
Route::get('/customer-all-type','backend\TypeController@show')->name('customer-all-type');
Route::post('/delete-all-types','backend\TypeController@deleteall')->name('delete-all-types');
Route::get('/delete-type/{id}','backend\TypeController@delete')->name('delete-type.id');
Route::get('/customer-edit-create-type/{id}','backend\TypeController@edit')->name('customer-edit-create-type.id');
Route::post('/update-type','backend\TypeController@update')->name('update-type');

/***Customer***/
Route::get('/customer-create-account','backend\CustomerController@index')->name('customer-create-account');
Route::post('/customer-insert-account','backend\CustomerController@insert')->name('customer-insert-account');
Route::get('/customer-all-account','backend\CustomerController@show')->name('customer-all-account');
Route::post('/delete-all-customers','backend\CustomerController@deleteall')->name('delete-all-customers');
Route::get('/delete-customer/{id}','backend\CustomerController@delete')->name('delete-customer.id');
Route::get('/customer-edit-account/{id}','backend\CustomerController@edit')->name('customer-edit-account.id');
Route::post('/customer-update-account','backend\CustomerController@update')->name('customer-update-account');


/***Delivery Order***/
Route::get('/delivery-order-table','backend\DeliveryController@index')->name('delivery-order-table');
Route::post('/delete-all-deliveries','backend\DeliveryController@deleteall')->name('delete-all-deliveries');
Route::get('/delete-delivery/{id}','backend\DeliveryController@delete')->name('delete-delivery.id');
Route::get('/delivery_status/{id}/{status}','backend\DeliveryController@delivery_status')->name('delivery_status.id.status');
Route::get('/delivery-order-calendar','backend\DeliveryController@order_calendar')->name('delivery-order-calendar');
Route::get('/delivery-details','backend\DeliveryController@deliverydetails')->name('delivery-details');
Route::get('/installer_status/{id}/{status}','backend\DeliveryController@installer_status')->name('installer_status.id.status');
Route::get('/del_status/{id}/{status}','backend\DeliveryController@del_status')->name('del_status.id.status');
Route::post('/create-dispute','backend\DeliveryController@create_dispute')->name('create-dispute');
Route::get('/approve-dispute/{id}/{status}','backend\DeliveryController@approve_dispute')->name('approve_dispute.id.status');
Route::get('/delivery-pdf/{id}','backend\DeliveryController@pdf')->name('delivery-pdf.id');
Route::get('/print-delivery-order/{id}','backend\DeliveryController@print_order')->name('print-delivery-order.id');
Route::post('/delivery-update','backend\DeliveryController@delivery_update')->name('delivery-update');
Route::get('/del-next-date','backend\DeliveryController@next_date')->name('del-next-date');
Route::get('/del-previous-date','backend\DeliveryController@previous_date')->name('del-previous-date');


/***Installer Order***/
Route::get('/installer-order-table','backend\InstallerController@index')->name('installer-order-table');
Route::post('/delete-all-installers','backend\InstallerController@deleteall')->name('delete-all-installers');
Route::get('/delete-installer/{id}','backend\InstallerController@delete')->name('delete-installer.id');
Route::get('/installation_status/{id}/{status}','backend\InstallerController@installation_status')->name('installation_status.id.status');
Route::get('/installer-order-calendar','backend\InstallerController@order_calendar')->name('installer-order-calendar');
Route::get('/installation-details','backend\InstallerController@details')->name('installation-details');
Route::get('/installer-pdf/{id}','backend\InstallerController@pdf')->name('installer-pdf.id');
Route::get('/print-installer-order/{id}','backend\InstallerController@print_order')->name('print-installer-order.id');
Route::post('/installer-update','backend\InstallerController@installer_update')->name('installer-update');
Route::get('/next-date','backend\InstallerController@next_date')->name('next-date');
Route::get('/previous-date','backend\InstallerController@previous_date')->name('previous-date');


/** Sales Dashboard**/
Route::get('/sales-dashboard','backend\DashboardController@sales_dashboard')->name('sales-dashboard');
Route::get('/commission','backend\DashboardController@commission')->name('commission');
Route::post('/delete-all-commission','backend\DashboardController@deleteall')->name('deleteall_commission');
Route::get('/delete-commission/{id}','backend\DashboardController@delete')->name('delete-commission.id');
Route::get('/commission-details','backend\DashboardController@details')->name('commission-details');



Route::view('/activity-log','backend.activity-log');
// Route::view('/delivery-order-calendar','backend.delivery-order-calendar');
Route::view('/internal-edit-account','backend.internal-edit-account');
Route::view('/recent-stock-movement','backend.recent-stock-movement');

// Route::view('/sales-dashboard','backend.sales-dashboard');

/* Activity Log*/
Route::get('add-to-log', 'backend\LogController@addtolog');
Route::get('recent-logs', 'backend\LogController@logActivity');
Route::get('/delete-log/{id}','backend\LogController@delete')->name('delete-log.id');
Route::post('/delete-all-logs','backend\LogController@deleteall')->name('delete-all-logs');


Route::get('/cronjob','backend\LogController@cronjob')->name('cronjob');







Route::group(['middleware' => 'authurls'], function(){
    
    /*Route::post('/warehouse-create-store',"backend\WarehouseController@store");
    Route::get('/warehouse-all-warehouse',"backend\WarehouseController@show");
    Route::get('/warehouse-edit-warehouse/{id}','backend\WarehouseController@edit');
    Route::post('/warehouse-update','backend\WarehouseController@update');
    Route::get('/warehouse-delete-warehouse/{id}',"backend\WarehouseController@destroy");
    Route::get('/warehouse-duplicate-warehouse/{id}',"backend\WarehouseController@duplicate");
    Route::view('/warehouse-dashboard','backend.warehouse-dashboard');*/
    
});



});