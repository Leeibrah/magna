<?php

class Mpesa_transactionsController extends BaseController {

	/**
	 * Mpesa_transaction Repository
	 *
	 * @var Mpesa_transaction
	 */
	protected $mpesa_transaction;

	public function __construct(Mpesa_transaction $mpesa_transaction)
	{
		$this->mpesa_transaction = $mpesa_transaction;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$mpesa_transactions = $this->mpesa_transaction->all();

		return View::make('mpesa_transactions.index', compact('mpesa_transactions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('mpesa_transactions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Mpesa_transaction::$rules);

		if ($validation->passes())
		{
			$this->mpesa_transaction->create($input);

			return Redirect::route('mpesa_transactions.index');
		}

		return Redirect::route('mpesa_transactions.create')
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
		$mpesa_transaction = $this->mpesa_transaction->findOrFail($id);

		return View::make('mpesa_transactions.show', compact('mpesa_transaction'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$mpesa_transaction = $this->mpesa_transaction->find($id);

		if (is_null($mpesa_transaction))
		{
			return Redirect::route('mpesa_transactions.index');
		}

		return View::make('mpesa_transactions.edit', compact('mpesa_transaction'));
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
		$validation = Validator::make($input, Mpesa_transaction::$rules);

		if ($validation->passes())
		{
			$mpesa_transaction = $this->mpesa_transaction->find($id);
			$mpesa_transaction->update($input);

			return Redirect::route('mpesa_transactions.show', $id);
		}

		return Redirect::route('mpesa_transactions.edit', $id)
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
		$this->mpesa_transaction->find($id)->delete();

		return Redirect::route('mpesa_transactions.index');
	}

}