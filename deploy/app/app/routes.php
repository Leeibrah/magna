<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('', function()
{
	return View::make('home');
});
Route::get('beta', function()
{
	return View::make('beta');
});
Route::get('beta/cart', 'ItemsController@index');//function()	//display cart in style
// {
// 	return View::make('items.index');
// });
Route::get('cart', function()	//display cart in style
{
	return View::make('cart');
});
// Route::post('cart', 'ItemsController@update');//accept items
Route::post('orderz', 'OrdersController@store');//accept orders

Route::get('beta/faq', function()
{
	return View::make('faq');
});
Route::get('beta/privacy', function()
{
	return View::make('privacy');
});
Route::get('beta/returns', function()
{
	return View::make('returns');
});
Route::get('beta/contacts', function()
{
	return View::make('contacts');
});


Route::resource('users', 'UsersController');
//--fields="name:string, email:string, password:string, phone:string, city:string, neighbourhood:string, order_count:integer, spent_ksh:float, spent_dollars:float, notes:text"

Route::resource('items', 'ItemsController');
//--fields="session_id:string, ip_address:string, merchant_id:integer, item_id:string, name:string, quantity:integer, link:string, image:string, designer:string, color:string, size:integer, package:string, print_on_demand:string, front_logo:string, custom_back_number:string, custom_back_name:string, price_usd:string, price_ksh:string, status:string, notes:text"

Route::resource('orders', 'OrdersController');
//--fields="session_id:string, user_id:string, city:string, neighbourhood:string, amount:integer, order_status:string, notes:text"

Route::resource('mpesa_transactions', 'Mpesa_transactionsController');
//--fields="order_id:integer, ipn_id:string, ipn_orig:string, ipn_dest:string, ipn_tstamp:string, ipn_text:string, ipn_user:string, ipn_pass:string, mpesa_code:string, mpesa_acc:string, mpesa_msisdn:string, mpesa_trx_date:string, mpesa_trx_time:string, mpesa_amt:string, mpesa_sender:string, notes:text"

Route::resource('cc_transactions', 'Cc_transactionsController');
//--fields="order_id:integer, provider:string, number:integer, ccv:integer, name:string, expiry_date:date, amount:string, notes:text"

Route::resource('payments', 'PaymentsController');
//--fields="order_id:integer, order_cost:string, payment_type:string, payment_amount:string, balance:string, notes:text"

Route::resource('order_totals', 'Order_totalsController');
//--fields="order_id:integer, sub_total:string, custom_import:string, shipping:string, vat:string, total:string, notes:text"

Route::resource('merchants', 'MerchantsController');
//--fields="name:string, url:string, about:string, logo:string, orders_count:integer, orders_worth:string, notes:text"

Route::resource('locations', 'LocationsController');
//--fields="country:string, city:string, neighbourhood:string, agents:text, contacts:text, notes:text"
