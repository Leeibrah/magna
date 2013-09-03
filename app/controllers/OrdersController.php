<?php

class OrdersController extends AuthorizedController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$orders = $this->order->all();

		return View::make('orders.index', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('orders.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		  // $input["session_id"]= session_id();
		  // $input["user_id"]= '';
		  // $input["city"]= 
		  // $input["neighbourhood"]= 
		  // $input["amount"]= 
		  // $input["order_status"]= 
		  // $input["notes"]=

		var_dump($input);
		// $validation = Validator::make($input, Order::$rules);

		// if ($validation->passes())
		// {
		// 	$this->order->create($input);

		// 	return Redirect::route('orders.index');
		// }

		// return Redirect::route('orders.create')
		// 	->withInput()
		// 	->withErrors($validation)
		// 	->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$order = $this->order->findOrFail($id);

		return View::make('orders.show', compact('order'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$order = $this->order->find($id);

		if (is_null($order))
		{
			return Redirect::route('orders.index');
		}

		return View::make('orders.edit', compact('order'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Order::$rules);

		if ($validation->passes())
		{
			$order = $this->order->find($id);
			$order->update($input);

			return Redirect::to('beta/orders/'.$id);
		}

		return Redirect::to('beta/orders/'.$id.'/edit')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// $this->order->find($id)->delete();

		$this->order->find($id)->update(array('order_status' => 'deleted'));
		return Redirect::to('beta/orders');
	}
	public function check(){
		$input = Input::all();
		// var_dump($input);

		$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : Auth::user()->email; 
		$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : 'unset'; 
		$id =  isset($_REQUEST['id']) ? $_REQUEST['id'] : 'unset';

		if($id != 'unset'):
			$user =  DB::table('users')
				->where('email', $email)
				->orWhere('phone', $phone)
				// ->orWhere('phone', $_REQUEST['phone'])
				->first();
			// var_dump($id);

			$order =  DB::table('orders')->where('id', $id)->first();
			if(!isset($order)):
				return Redirect::to('beta/check')
				->with('warning', '<h4>That order does not exist. Please check your form</h4>');
			endif;
				return Redirect::to(URL::to('beta/orders/'.$order->id));
		endif;
	}

	function checkout(){
				
		$input = Input::all();

		$totals['order_id'] = session_id();
		$totals['sub_total'] = $input['sub_total_usd'];
		$totals['custom_import'] = $input['customs_usd'];
		$totals['shipping'] = $input['shipping_usd'];
		$totals['vat'] = $input['vat_usd'];
		$totals['total'] = $input['total_usd'];
		$totals['notes'] = 'checkout';

		if(DB::table('order_totals')->where('order_id', session_id())->first()):
			DB::table('order_totals')->where('order_id', session_id())->update($totals);
		else:
			DB::table('order_totals')->insert($totals);
		endif;

		$total_ksh = $input['total_ksh'];
			return View::make('checkout')
				->with('total_ksh', $total_ksh);
	}

	public function order()
	{

		function createOrder()
		{
			$input = Input::all();
			// var_dump($input);

			$totals = DB::table('order_totals')->where('order_id', session_id())->first();

			if(isset($totals)){

				$order['user_id'] = Auth::user()->id;
				$order['city'] = $input['city'];
				$order['neighbourhood'] = $input['neighbourhood'];
				$order['amount'] = $totals->total;
				$order['order_status'] = 'shipping';
			

				$payment["payment_type"] = $input["payment_type"];
				$payment["submitorder"] = $input["submitorder"];
				$payment["Lite_Merchant_ApplicationID"] = $input["Lite_Merchant_ApplicationID"];
				$payment["Ecom_BillTo_Postal_Name_First"] = $input["Ecom_BillTo_Postal_Name_First"];
				$payment["Ecom_BillTo_Postal_Name_Last"] = $input["Ecom_BillTo_Postal_Name_Last"];
				$payment["Ecom_BillTo_Telecom_Phone_Number"] = $input["Ecom_BillTo_Telecom_Phone_Number"];
				$payment["Ecom_BillTo_Online_Email"] = $input["Ecom_BillTo_Online_Email"];
				$payment["Lite_Order_Amount"] = $input["Lite_Order_Amount"];
				$payment["Lite_Order_Terminal"] = $input["Lite_Order_Terminal"];
				$payment["Lite_ConsumerOrderID_PreFix"] = $input["Lite_ConsumerOrderID_PreFix"];
				$payment["Lite_On_Error_Resume_Next"] = $input["Lite_On_Error_Resume_Next"];
				$payment["Lite_Order_LineItems_Product_1"] = $input["Lite_Order_LineItems_Product_1"];
				$payment["Lite_Order_LineItems_Quantity_1"] = $input["Lite_Order_LineItems_Quantity_1"];
				$payment["Lite_Order_LineItems_Amount_1"] = $input["Lite_Order_LineItems_Amount_1"];
				$payment["Ecom_Payment_Card_Protocols"] = $input["Ecom_Payment_Card_Protocols"];
				$payment["Lite_Version_"] = $input["Lite_Version_"];
				$payment["Ecom_ConsumerOrderID"] = $input["Ecom_ConsumerOrderID"];
				$payment["Ecom_TransactionComplete"] = $input["Ecom_TransactionComplete"];
				$payment["Lite_Website_Successful_url"] = $input["Lite_Website_Successful_url"];
				$payment["Lite_Website_Fail_url"] = $input["Lite_Website_Fail_url"];
				$payment["Lite_Website_TryLater_url"] = $input["Lite_Website_TryLater_url"];
				$payment["Lite_Website_Error_url"] = $input["Lite_Website_Error_url"];


				// var_dump($payment);
				$validator = Validator::make($input, Order::$rules);

				if ($validator->passes())
				{
					$order_id = DB::table('orders')->insertGetId($order);

					//save items to order
					DB::table('items')->where('session_id', session_id())->update(array(
						'user_id' => Auth::user()->id, 
						'order_id' => $order_id,
						'status' => 'ordered',
					));

					//update $totals->order_id
					DB::table('order_totals')->where('order_id', session_id())->update(array('order_id' => $order_id));

				}
				else{
					return $validator;
				}
				

			}
			else{
				$validator_array = array('message' => 'order not found');
				$validator = json_decode(json_encode($validator_array), FALSE);

				return $validator;
			}
			
		}
		function postLogin()
		{
			$email    = Input::get('login_email');
			$password = Input::get('login_password');
			$validator = Validator::make(Input::all(), User::$login_rules);

			if ($validator->passes())
			{
				if (Auth::attempt(array('email' => $email, 'password' => $password)))
				{
					$id = Auth::user()->id;
					createOrder();
				}
				else{
					$validator_array = array('message' => 'Email/password invalid.');
					$validator = json_decode(json_encode($validator_array), FALSE);//casting to object

					return $validator;
				}					

			}else{
				return $validator;
			}
				

		}
		function postRegister()
		{

			// Validate the inputs.
			//
			$input = Input::all();
			$validator = Validator::make($input, User::$register_rules);

			if ($validator->passes())
			{
				// Create the user.
				//
				$user = new User;
				$user->name  = $input['name'];
				$user->email     = $input['email'];
				$user->phone  = $input['phone'];
				$user->password  = Hash::make($input['password']);
				$user->city = $input['city'];
				$user->neighbourhood = $input['neighbourhood'];

				$user->save();

				$user = User::where('email', '=', $user->email)->first();

				Auth::login($user);
				$id = Auth::user()->id;

				createOrder();		

			}
			else{
				return $validator;
			}
		}
			
		//logic starts...

		$input = Input::all();
		$validator = "";

		if(isset($input['login_email'])):
			if($input['login_email'] != null):
				$validator = postLogin();
			elseif($input['email'] != null):
				$validator = postRegister();
			endif;
		else:
			$validator = createOrder();
		endif;

		if(isset($validator)):
			return Redirect::back()->withInput($input)->withErrors($validator);
		else:
			return Redirect::to('beta/orders');
		endif;
		
	
	}


}