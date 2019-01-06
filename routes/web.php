<?php

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
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/products', function () {
    return view('products');
});
Route::get('/contact', function () {
    return view('contact');
});

Auth::routes();



Route::get('/isendSms','ISendSmsController@iSchedule')->middleware('auth');


Route::get('/set/biz','AdminController@bizId')->middleware('auth');
Route::get('admin','AdminController@index')->middleware('auth');
Route::get('plan-entry','PlanEntryController@index')->middleware('auth');
Route::get('/create/plan','PlanEntryController@store')->middleware('auth');
Route::get('plan/amount','PlanEntryController@plan_amount');

Route::get('/retailer','RetailerController@index')->middleware('auth');
Route::get('/password_reset','RetailerController@password_reset')->middleware('auth');
Route::get('/sender_id','RetailerController@sender_id')->middleware('auth');
Route::get('/create/customer','CustomerController@store')->middleware('auth');
Route::post('/create/customer','CustomerController@store')->middleware('auth');
Route::get('/get/customer','CustomerController@customer')->middleware('auth');
Route::get('/create/message','MessageController@store')->middleware('auth');
Route::post('/create/message','MessageController@store')->middleware('auth');
Route::get('/message_center','MessageController@message_center')->middleware('auth');
Route::post('/message_center','MessageController@message_center')->middleware('auth');
Route::get('/message_history','MessageController@message_history')->middleware('auth');
Route::post('/message_history','MessageController@message_history')->middleware('auth');

Route::get('/mc_category_values','MessageController@mc_category_values')->middleware('auth');
Route::post('/mc_category_values','MessageController@mc_category_values')->middleware('auth');




Route::get('/customer_retailer_report','ReportController@customer_retailer_report')->middleware('auth');
Route::post('/customer_retailer_report','ReportController@customer_retailer_report')->middleware('auth');


Route::get('/payment_retailer_report','ReportController@payment_retailer_report')->middleware('auth');
Route::post('/payment_retailer_report','ReportController@payment_retailer_report')->middleware('auth');

Route::post('/sms_retailer_report','ReportController@sms_retailer_report')->middleware('auth');
Route::get('/sms_retailer_report','ReportController@sms_retailer_report')->middleware('auth');


Route::get('/create/categories','CategoryConfigController@store')->middleware('auth');
Route::get('/category/config','CategoryConfigController@index')->middleware('auth');
Route::post('/category/config','CategoryConfigController@cat_value')->middleware('auth');

Route::get('/reload/categories','CategoryConfigController@reload')->middleware('auth');

Route::get('/retailer/registration','RetailerRegistrationController@registration');
Route::get('/registration-sign-up','RetailerRegistrationController@index');
Route::get('/get/retailer/payment','RetailerRegistrationController@show');

Route::get('/get/retailer','RetailerRegistrationController@retailer');


Route::get('makePayment','PaymentController@payment');
Route::post('payment-success','PaymentController@paymentsuccess');
Route::post('payment-failure','PaymentController@paymentfailure');

Route::get('retailer-payment-for','RetailerPaymentController@retailerPaymentFor');
Route::get('retailer-payment','RetailerPaymentController@retailerPayment')->middleware('auth');

Route::get('/test/sms','SmsController@index');
Route::get('/sms/status','SmsController@status');

Route::get('/message/approval','MessageController@msgModerator');

Route::get('retailer_reponse','RetailerController@retailer_reponse');


Route::get('/configuration/panel','CategoryConfigController@index')->middleware('auth');

Route::get('/mc/panel','MessageController@message_center')->middleware('auth');

Route::get('select/work_order','WorkOrderController@work_order');




Route::post('import', 'CustomerController@import')->name('import');

Route::get('/download-xls', 'CustomerController@getDownload');


Route::get('/download-tpl', 'CustomerController@downloadTpl');

Route::get('/customer/approval', 'CustomerController@customerApproval');


Route::get('/profile', 'AdminController@profile')->middleware('auth');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
