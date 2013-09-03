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

Route::post('cart', 'ItemsController@store');//accept items
Route::post('cart/', 'ItemsController@store');//accept items
Route::post('beta/checkout', 'OrdersController@checkout');//accept and update orders and orders-totals
Route::post('beta/order', 'OrdersController@order');//update orders for user_id
Route::post('beta/check', 'OrdersController@check');
Route::post('mpesa', 'M_tsController@store');//accept mpesa payments
Route::post('iverilite', 'OrdersController@iveri');

// Route::get('delete/{id}', 'ItemsController@delete', compact('id'));//custom delete via get request

Route::get('cart', function()	//display cart in style
{
	return View::make('cart');
});

Route::get('beta/cart', function()	//display cart in style
{
	return View::make('cart');
});

Route::get('beta/checkout', function()	
{
	return View::make('checkout');
});

Route::get('beta/order', function()	
{
	return View::make('checkout');
});

Route::get('beta/orders', function()	
{
	return View::make('orders.index');
})->before('auth');

Route::get('beta/check', function()	
{
	return View::make('orders.check');
});


Route::any('{resource}/{id}/edit', function($resource_name, $id)
{
   if(Auth::user()):
		$user_id = Auth::user()->id;
		$item = DB::table($resource_name)->where('id', $id)->first();
		if ($item->user_id != $user_id && !User::adminCheck()):
			return View::make('owner_filter');
		endif;
		if ($resource_name == 'items'):
			return View::make('404');
		endif;
		
		$item = (array) $item;
		return View::make($resource_name.'/edit', compact('item'))->with('id', $id);
	endif;
	return View::make('owner_filter');
});

Route::resource('items', 'ItemsController');
//--fields="session_id:string, ip_address:string, user_id:string, order_id:string, md5:string, merchant_id:integer, item_id:string, name:string, quantity:integer, link:string, image:string, designer:string, color:string, size:integer, package:string, print_on_demand:string, front_logo:string, custom_back_number:string, custom_back_name:string, part_number:string, price_usd:string, price_ksh:string, status:string, notes:text"

Route::resource('orders', 'OrdersController');
//--fields="user_id:string, city:string, neighbourhood:string, amount:integer, order_status:string, notes:text"


Route::get('beta/orders/{id}', function($id)	
{
	return View::make('orders.status')->with('id', $id);
})->where('id', '[0-9]+');

Route::get('beta/orders/{id}/edit', function($id)	
{
	return View::make('orders.edit')->with('id', $id);
})->where('id', '[0-9]+');

Route::post('beta/orders/{id}/edit', array('as' => 'id', 'uses' => 'OrdersController@update'));
// Route::put('beta/items/{id}', array('as' => 'id', 'uses' => 'ItemsController@update'));


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
Route::get('beta/template', function()
{
	return View::make('template');
});

Route::get('login', 'UserController@getLogin');
Route::get('logout', 'UserController@getLogout');
Route::post('login', 'UserController@postLogin');
Route::get('register', 'UserController@getRegister');
Route::post('register', 'UserController@postRegister');
// Route::get('accounts', 'UserController@getIndex');
// Route::get('account', 'UserController@getIndex');
// Route::get('users', 'UserController@getIndex');

Route::filter('admin', function()
{
	if (!User::adminCheck()):
		return View::make('admin_filter');
		// return Redirect::back()->with('warning', 'You have to be an admin to do that');
	endif;
});

Route::group(array('before' => 'admin'), function()
{

	Route::resource('order_totals', 'Order_totalsController');
	//--fields="order_id:string, sub_total:string, custom_import:string, shipping:string, vat:string, total:string, notes:text"

	Route::resource('m_ts', 'M_tsController');
	//--fields="order_id:integer, ipn_id:string, orig:string, dest:string, tstamp:string, text:string, customer_id:string, user:string, pass:string, routemethod_id:string, routemethod_name:string, mpesa_code:string, mpesa_acc:string, mpesa_msisdn:string, mpesa_trx_date:string, mpesa_trx_time:string, mpesa_amt:string, mpesa_sender:string, notes:text"
	
	Route::resource('cc_transactions', 'Cc_transactionsController');
	//--fields="order_id:integer, provider:string, number:integer, ccv:integer, name:string, expiry_date:date, amount:string, notes:text"

	Route::resource('payments', 'PaymentsController');
	//--fields="order_id:integer, order_cost:string, payment_type:string, payment_amount:string, balance:string, notes:text"

	Route::resource('merchants', 'MerchantsController');
	//--fields="name:string, url:string, about:string, logo:string, agents:text, notes:text"

	Route::resource('locations', 'LocationsController');
	//--fields="country:string, city:string, neighbourhood:string, agents:text, notes:text"

	Route::resource('users', 'UsersController');
	//--fields="name:string, email:string, password:string, phone:string, city:string, neighbourhood:string, order_count:integer, spent_ksh:float, spent_dollars:float, notes:text"

});


Route::filter('auth', function()
{
    if (Auth::guest())
        return View::make('beta');
});


Route::get('login', array('as' => 'login', function () {
    return View::make('account/login');
}));

Route::get('register', array('as' => 'register', function () {
    return View::make('account/register');
}));

Route::get('logout', array('as' => 'logout', function () {
    Auth::logout();
    return Redirect::back();
}))->before('auth');


Route::get('profile', array('as' => 'profile', function () { 
    return View::make('orders.index');
}))->before('auth');

Route::get('account', array('as' => 'account', function () { 
    return View::make('orders.index');
}))->before('auth');
