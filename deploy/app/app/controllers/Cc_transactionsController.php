<?php

class Cc_transactionsController extends BaseController {

	/**
	 * Cc_transaction Repository
	 *
	 * @var Cc_transaction
	 */
	protected $cc_transaction;

	public function __construct(Cc_transaction $cc_transaction)
	{
		$this->cc_transaction = $cc_transaction;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cc_transactions = $this->cc_transaction->all();

		return View::make('cc_transactions.index', compact('cc_transactions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cc_transactions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Cc_transaction::$rules);

		if ($validation->passes())
		{
			$this->cc_transaction->create($input);

			return Redirect::route('cc_transactions.index');
		}

		return Redirect::route('cc_transactions.create')
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
		$cc_transaction = $this->cc_transaction->findOrFail($id);

		return View::make('cc_transactions.show', compact('cc_transaction'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cc_transaction = $this->cc_transaction->find($id);

		if (is_null($cc_transaction))
		{
			return Redirect::route('cc_transactions.index');
		}

		return View::make('cc_transactions.edit', compact('cc_transaction'));
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
		$validation = Validator::make($input, Cc_transaction::$rules);

		if ($validation->passes())
		{
			$cc_transaction = $this->cc_transaction->find($id);
			$cc_transaction->update($input);

			return Redirect::route('cc_transactions.show', $id);
		}

		return Redirect::route('cc_transactions.edit', $id)
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
		$this->cc_transaction->find($id)->delete();

		return Redirect::route('cc_transactions.index');
	}

}