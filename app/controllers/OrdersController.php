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

		$email = isset($input['email']) ? $input['email'] : Auth::user()->email; 
		$phone = isset($input['phone']) ? $input['phone'] : 'unset'; 
		$id =  isset($input['id']) ? $input['id'] : 'unset';

		if($id != 'unset'):
			$user =  DB::table('users')
				->where('email', $email)
				->orWhere('phone', $phone)
				// ->orWhere('phone', $input['phone'])
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
				$order['order_status'] = 'To pay';
			


				// var_dump($payment);
				$validator = Validator::make($input, Order::$rules);

				if ($validator->passes())
				{
					$order_id = DB::table('orders')->insertGetId($order);

					//save items to order
					DB::table('items')
						->where('session_id', session_id())
						->where('status', 'cart')
						->update(array(
							'user_id' => Auth::user()->id, 
							'order_id' => $order_id,
							'status' => 'ordered',
					));

					//update $totals->order_id
					DB::table('order_totals')->where('order_id', session_id())->update(array('order_id' => $order_id));

					return $order_id;

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
				$user->email  = $input['email'];
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
			
		function ccMpesa(){

		$input = Input::all();
		$validator = "";

		if(Auth::user()):
			$validator = createOrder();
		else:

			if($input['login_email'] == null && $input['email'] == null):
				return Redirect::back()->with('info', 'Please Log in or register to check out');
			endif;

			if($input['login_email'] != null):
				$validator = postLogin();
			elseif($input['email'] != null):
				$validator = postRegister();
			endif;

		endif;

		if(isset($validator->message)):
			return Redirect::back()->withInput($input)->withErrors($validator);
		endif;

		

		// form submitted and order created successfully, $validator returned as the order id

			if($input['payment_type'] == "m-pesa"){
				// return Redirect::to('beta/orders');
				return Redirect::to('beta/orders/'.$validator)
				->with('success', 'Thank you for making that order. Check instructions at the bottom to pay with M-Pesa');
			}

		}
		// else{

		// iveri start
		// if($input['payment_type'] == "cc"):
			//return redirect to iveri checkout url
			// return Redirect::URl('');
			

		// define variables

		$order_id = $validator;
		$name = Auth::user()->name;
		$email = addslashes($input['email']);
		$phone = $input['phone'];
		$city = addslashes($input['city']);
		$neighbourhood = addslashes($input['neighbourhood']);
		$payment_type = $input['payment_type'];
		$cc_num = isset($input["cc-num"]) ? $input["cc-num"] : 'unspecified';
		$cc_month = $input['cc-month'];
		$cc_year = $input['cc-year'];
		$cc_ccv = isset($input["cc-ccv"]) ? $input["cc-ccv"] : 'unspecified';
		$cc_provider = isset($input["Ecom_Payment_Card_Type"]) ? $input["Ecom_Payment_Card_Type"] : 'unspecified';

		$expdate = $cc_month."/".$cc_year;

		$namearr = explode(" ",$name);
		$fname = $namearr[0];
		$lname = $namearr[1];

		$totals = DB::table('order_totals')->where('order_id', $order_id)->first();
		$amount = $totals->total;

		// create transaction db entry
		$cc['order_id'] = $order_id;
		$cc['provider'] = $cc_provider;
		$cc['number'] = $cc_num;
		$cc['ccv'] = $cc_ccv;
		$cc['name'] = $name;
		$cc['expiry_date'] = $expdate;
		$cc['amount'] = $amount;
		$cc['notes'] = 'new';

		// Uncomment the below to run the seeder
		// DB::table('order_totals')->insert($order_totals);

		// record transaction
		$cc_tid = DB::table('cc_transactions')->insertGetId($cc);

		// do payment
		// from form to array post
		// fetch items arr

		// $payment["payment_type"] = $input["payment_type"];
		// $payment["payment_type"] = $input["payment_type"];
		// $payment["payment_type"] = $input["payment_type"];
		// $payment["payment_type"] = $input["payment_type"];
		// $payment["submitorder"] = $input["submitorder"];

		// $payment["Lite_Merchant_ApplicationID"] = $input["Lite_Merchant_ApplicationID"];
		// $payment["Ecom_BillTo_Postal_Name_First"] = $input["Ecom_BillTo_Postal_Name_First"];
		// $payment["Ecom_BillTo_Postal_Name_Last"] = $input["Ecom_BillTo_Postal_Name_Last"];
		// $payment["Ecom_BillTo_Telecom_Phone_Number"] = $input["Ecom_BillTo_Telecom_Phone_Number"];
		// $payment["Ecom_BillTo_Online_Email"] = $input["Ecom_BillTo_Online_Email"];
		// $payment["Lite_Order_Amount"] = $input["Lite_Order_Amount"];
		// $payment["Lite_Order_Terminal"] = $input["Lite_Order_Terminal"];
		// $payment["Lite_ConsumerOrderID_PreFix"] = 'order';
		// $payment["Lite_On_Error_Resume_Next"] = $input["Lite_On_Error_Resume_Next"];
		// $payment["Lite_Order_LineItems_Product_1"] = $input["Lite_Order_LineItems_Product_1"];
		// $payment["Lite_Order_LineItems_Quantity_1"] = $input["Lite_Order_LineItems_Quantity_1"];
		// $payment["Lite_Order_LineItems_Amount_1"] = $input["Lite_Order_LineItems_Amount_1"];
		// $payment["Ecom_Payment_Card_Protocols"] = $input["Ecom_Payment_Card_Protocols"];
		// $payment["Lite_Version_"] = $input["Lite_Version_"];
		// $payment["Ecom_ConsumerOrderID"] = $order_id;
		// $payment["Ecom_TransactionComplete"] = $input["Ecom_TransactionComplete"];
		// $payment["Lite_Website_Successful_url"] = $input["Lite_Website_Successful_url"];
		// $payment["Lite_Website_Fail_url"] = $input["Lite_Website_Fail_url"];
		// $payment["Lite_Website_TryLater_url"] = $input["Lite_Website_TryLater_url"];
		// $payment["Lite_Website_Error_url"] = $input["Lite_Website_Error_url"];
		var_dump($amount);
		kill('here');
			// this was commented
		echo "<form name='creditformiveriform' action='https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx' method='post'>
				<input type='hidden' id='Lite_Order_Amount' name='Lite_Order_Amount' value='".$amount."'>";
		// 		<input type='hidden' id='Lite_Order_Terminal' name='Lite_Order_Terminal' value='Web'>
		// 		<input type='hidden' id='Lite_Order_AuthorisationCode' name='Lite_Order_AuthorisationCode' value=''>
		// 		<input type='hidden' id='Lite_Order_BudgetPeriod' name='Lite_Order_BudgetPeriod' value='0'>
		// 		<input type='hidden' id='Lite_Website_TextColor' name='Lite_Website_TextColor' value='#ffffff'>
		// 		<input type='hidden' id='Lite_Website_BGColor' name='Lite_Website_BGColor' value='#86001B'>
		// 		<input type='hidden' id='Lite_ConsumerOrderID_PreFix' name='Lite_ConsumerOrderID_PreFix' value='".$order_id."'>
		// 		<input type='hidden' id='Lite_On_Error_Resume_Next' name='Lite_On_Error_Resume_Next' value='True'>
		// 		<input type='hidden' id='Ecom_BillTo_Postal_Name_First' name='Ecom_BillTo_Postal_Name_First' value='".$fname."'>
		// 		<input type='hidden' id='Ecom_BillTo_Postal_Name_Last' name='Ecom_BillTo_Postal_Name_Last' value='".$lname."'>
		// 		<input type='hidden' id='Ecom_ShipTo_Online_Email' name='Ecom_ShipTo_Online_Email' value='".$email."'>
		// 		<input type='hidden' id='Ecom_ShipTo_Telecom_Phone_Number' name='Ecom_ShipTo_Telecom_Phone_Number' value='".$phone."'>
		// 		<input type='hidden' id='Ecom_ShipTo_Postal_City' name='Ecom_ShipTo_Postal_City' value='".$city."'>
		// 		<input type='hidden' id='Ecom_Payment_Card_Type' name='Ecom_Payment_Card_Type' value='".$cc_type."'>
		// 		<input type='hidden' id='Ecom_Payment_Card_Number' name='PEcom_ayment_Card_Number' value='".$cc_num."'>
		// 		<input type='hidden' id='Ecom_Payment_Card_ExpDate_Month' name='Ecom_Payment_Card_ExpDate_Month' value='".$cc_month."'>
		// 		<input type='hidden' id='Ecom_Payment_Card_ExpDate_Year' name='Ecom_Payment_Card_ExpDate_Year' value='".$cc_year."'>";
				
				$items =  DB::table('items')
				->where('order_id', $order_id)
				->where('quantity', '>', 0)->get();
				$i=1;
				// foreach ($items as $item) {
				// {
				// 	echo "<input type='hidden' id='Lite_Order_LineItems_Product_".$i."' name='Lite_Order_LineItems_Product_".$i."' value='".$rowProduct['name']."'>
				// 	<input type='hidden' id='Lite_Order_LineItems_Quantity_".$i."' name='Lite_Order_LineItems_Quantity_".$i."' value='".$rowProduct['quantity']."'>
				// 	<input type='hidden' id='Lite_Order_LineItems_Amount_".$i."' name='Lite_Order_LineItems_Amount_".$i."' value='".$rowProduct['item_price_usd']."'>";
				// 	$i++;
				// };
				
				
				
				echo "<input type='hidden' ID='Lite_Website_Successful_url' NAME='Lite_Website_Successful_url' VALUE='http://localhost/vitumob/VituMob_code_and_other_files/order_status.php?orderid=".$order_id."'>
					<input type='hidden' ID='Lite_Website_Fail_url' NAME='Lite_Website_Fail_url' VALUE='http://www.vitumob.com/fail.php'>
					<input type='hidden' ID='Lite_Website_TryLater_url' NAME='Lite_Website_TryLater_url' VALUE='http://www.vitumob.com/trylater.php'>
					<input type='hidden' ID='Lite_Website_Error_url' NAME='Lite_Website_Error_url' VALUE='http://www.vitumob.com/error.php'>
					</form>
					<script>document.creditformiveriform.submit()</script>";

				// payment details -> db

				//end of iveri   -- This was commented

						// endif;
	
			}
		// }
}