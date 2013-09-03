<?php

class ItemsController extends BaseController {

	/**
	 * Item Repository
	 *
	 * @var Item
	 */
	protected $item;

	public function __construct(Item $item)
	{
		$this->item = $item;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$items = $this->item->all();

		return View::make('items.index', compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('items.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//originally json
		// unpack bundle from the extension:

		$str_encoded = $_POST["bundle"];
		$decoded_bundle = urldecode($str_encoded);
		$bundle= json_decode($decoded_bundle, TRUE);

		// print_r($bundle['host']);

		if(!is_array($bundle['items'])){
			$bundle['items'] = json_decode($bundle['items'], TRUE);
		}

		foreach ($bundle['items'] as $key => $itemarray) {

			$exchange_rate=Functions::exchRate();//RATE_ADJUST not set
			// $knownmerchant = DB::table('merchants')->where('url', 'like', $bundle['host'])->first();
			$knownmerchant = DB::select('SELECT `id` FROM merchants where `url` like "%'.$bundle['host'].'%"');
			// var_dump($knownmerchant);

			$input = array();
			$input['session_id'] = session_id();
			$input['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$input['order_id'] = 0;
			$input['user_id'] = 0;
			$input['merchant_id'] = isset($knownmerchant) ? $knownmerchant['0']->id : '';
			($bundle['host'] == 'neimanmarcus.com') ? $input['item_id'] = isset($itemarray['id2']) ? $itemarray['id2'] : 'no id2' : //neimanmarcus id2 is unique, 1d, id3 not
			$input['item_id'] = isset($itemarray['id']) ? $itemarray['id'] : '';
			$input['name'] = isset($itemarray[addslashes('name')]) ? $itemarray[addslashes('name')] : $itemarray[addslashes('name2')];
			$input['quantity'] = isset($itemarray['quantity']) ? $itemarray['quantity'] : 0;
			$input['link'] = isset($itemarray[addslashes('link')]) ? $itemarray[addslashes('link')] : '';
			$input['image'] = isset($itemarray[addslashes('image')]) ? $itemarray[addslashes('image')] : '';
			$input['designer'] = isset($itemarray[addslashes('designer')]) ? $itemarray[addslashes('designer')] : '';
			$input['color'] = isset($itemarray[addslashes('color')]) ? $itemarray[addslashes('color')] : '';
			$input['size'] = isset($itemarray['size']) ? $itemarray['size'] : '';
			$input['package'] = isset($itemarray[addslashes('package')]) ? $itemarray[addslashes('package')] : '';
			$input['print_on_demand'] = isset($itemarray[addslashes('printondemand')]) ? $itemarray[addslashes('printondemand')] : '';
			$input['front_logo'] = isset($itemarray[addslashes('front.logo')]) ? $itemarray[addslashes('front.logo')] : '';
			$input['custom_back_number'] = isset($itemarray[addslashes('custombacknumber')]) ? $itemarray[addslashes('custombacknumber')] : '';
			$input['custom_back_name'] = isset($itemarray[addslashes('custombackname')]) ? $itemarray[addslashes('custombackname')] : '';
			$input['part_number'] = isset($itemarray[addslashes('part_number')]) ? $itemarray[addslashes('part_number')] : '';
			$input['price_usd'] = isset($itemarray['price']) ? floor($itemarray['price'] * 100) / 100 : 0;
			$input['price_ksh'] = floor($input['price_usd']*$exchange_rate * 100) / 100;
			$input['status'] = 'cart';

			//for reducing redundancy...
			$input1 = $input;
			unset($input1['quantity']);
			unset($input1['price_usd']);//changes when u change quantity
			unset($input1['price_ksh']);
			unset($input1['link']);//changes smtimes when u change quantity
			$input['md5'] = md5(implode("|",$input1));

			// $input = Input::all();
			// print_r($input1);
			// echo '<br/>';
			// print_r($input);
			// echo '<br/>';


			$validation = Validator::make($input, Item::$rules);

			if ($validation->passes())
			{
				$exists = DB::table('items')->where('md5', 'like', $input['md5'])->first();
				if($exists):
					// print_r($exists);
					$item = $this->item->find($exists->id);
					$item->update($input);
				else:
					// print_r($input);
					$this->item->create($input);
				endif;
				
			}
		}
	
		return Redirect::to('cart');

			return Redirect::route('items.create')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = $this->item->findOrFail($id);

		return View::make('items.show', compact('item'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$item = $this->item->find($id);

		if (is_null($item))
		{
			return Redirect::route('items.index');
		}

		return View::make('items.edit', compact('item'));
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
		// return json_encode($input);
		$validation = Validator::make($input, Item::$rules);
		if ($validation->passes()):

				$item = $this->item->find($id);
				$item->update($input);
				return json_encode($arrayName = array('success' => 1));
		else:
			return json_encode((array) $validation->messages());

		endif;
	}
	// public function delete($id)
	// {
	// 	$input = array_except(Input::all(), '_method');

	// 	$validation = Validator::make($input, Item::$rules);
	// 	// print_r($input);
	// 	if ($validation->passes()):
	// 		// if($input['quantity'] == '0'):
	// 		// 	return Redirect::to(URL::to('cart'));
	// 		// else
	// 		if($input['status'] == 'changing'):
	// 			$input['status'] = 'changed';
	// 			$item = $this->item->find($id);
	// 			$item->update($input);
	// 			return json_encode($arrayName = array('success' => 1));
	// 		else:
	// 			$item = $this->item->find($id);
	// 			$item->update($input);
	// 			return Redirect::route('items.show', $id);
	// 		endif;
	// 	else:
	// 		// return Redirect::route('items.edit', $id)
	// 		// 	->withInput()
	// 		// 	->withErrors($validation)
	// 		// 	->with('message', 'There were validation errors.');
	// 		print_r($validation);

	// 	endif;
	// }
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->item->find($id)->delete();
		// return Redirect::route('items.index');
		// return Redirect::to("http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); //== http://localhost/vml4/public/vml4/public/items/63

	}


}