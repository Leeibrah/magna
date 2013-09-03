<?php

class PaymentsController extends BaseController {

	/**
	 * Payment Repository
	 *
	 * @var Payment
	 */
	protected $payment;

	public function __construct(Payment $payment)
	{
		$this->payment = $payment;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = $this->payment->all();

		return View::make('payments.index', compact('payments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('payments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Payment::$rules);

		if ($validation->passes())
		{
			$this->payment->create($input);

			return Redirect::route('payments.index');
		}

		return Redirect::route('payments.create')
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
		$payment = $this->payment->findOrFail($id);

		return View::make('payments.show', compact('payment'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = $this->payment->find($id);

		if (is_null($payment))
		{
			return Redirect::route('payments.index');
		}

		return View::make('payments.edit', compact('payment'));
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
		$validation = Validator::make($input, Payment::$rules);

		if ($validation->passes())
		{
			$payment = $this->payment->find($id);
			$payment->update($input);

			return Redirect::route('payments.show', $id);
		}

		return Redirect::route('payments.edit', $id)
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
		$this->payment->find($id)->delete();

		return Redirect::route('payments.index');
	}

}