<?php

class M_tsController extends BaseController {

	/**
	 * M_t Repository
	 *
	 * @var M_t
	 */
	protected $m_t;

	public function __construct(M_t $m_t)
	{
		$this->m_t = $m_t;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$m_ts = $this->m_t->all();

		return View::make('m_ts.index', compact('m_ts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('m_ts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$in = Input::all();

			// ipn structure:			
			// https://www.vitumob.com/mpesa?
			// id=2970&
			// orig=MPESA&
			// dest=254700733153&
			// tstamp=2011-07-06 22:48:56.0&
			// text=BM46ST941 Confirmed.on 6/7/11 ...New balance is Ksh6,375,223.00&
			// customer_id=2&
			// user=123&
			// pass=123&
			// routemethod_id=2&
			// routemethod_name=HTTP&
			// mpesa_code=BM46ST941&
			// mpesa_acc=5FML59-01&
			// mpesa_msisdn=254722291067&
			// mpesa_trx_date=6/7/11&
			// mpesa_trx_time=10:49 PM&
			// mpesa_amt=8723.0&
			// mpesa_sender=RONALD NDALO

		// $table->increments('id');
		// $table->integer('order_id');
		// $table->string('ipn_id');
		// $table->string('orig');
		// $table->string('dest');
		// $table->string('tstamp');
		// $table->string('text');
		// $table->string('customer_id');
		// $table->string('user');
		// $table->string('pass');
		// $table->string('routemethod_id');
		// $table->string('routemethod_name');
		// $table->string('mpesa_code');
		// $table->string('mpesa_acc');
		// $table->string('mpesa_msisdn');
		// $table->string('mpesa_trx_date');
		// $table->string('mpesa_trx_time');
		// $table->string('mpesa_amt');
		// $table->string('mpesa_sender');
		// $table->text('notes');
		
		// $input['id']    = '';
		// $input['order_id']    = $input['id'];
		// $input['ipn_id']  = $input['mpesa_code'];
		$input['notes']  = json_encode($in);

		$validation = Validator::make($input, M_t::$rules);
		if ($validation->passes())
		{
			$this->m_t->create($input);

			// return Redirect::route('m_ts.index');
		}

		// return Redirect::route('m_ts.create')
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
		$m_t = $this->m_t->findOrFail($id);

		return View::make('m_ts.show', compact('m_t'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_t = $this->m_t->find($id);

		if (is_null($m_t))
		{
			return Redirect::route('m_ts.index');
		}

		return View::make('m_ts.edit', compact('m_t'));
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
		$validation = Validator::make($input, M_t::$rules);

		if ($validation->passes())
		{
			$m_t = $this->m_t->find($id);
			$m_t->update($input);

			return Redirect::route('m_ts.show', $id);
		}

		return Redirect::route('m_ts.edit', $id)
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
		$this->m_t->find($id)->delete();

		return Redirect::route('m_ts.index');
	}

}