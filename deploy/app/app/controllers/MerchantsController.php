<?php

class MerchantsController extends BaseController {

	/**
	 * Merchant Repository
	 *
	 * @var Merchant
	 */
	protected $merchant;

	public function __construct(Merchant $merchant)
	{
		$this->merchant = $merchant;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$merchants = $this->merchant->all();

		return View::make('merchants.index', compact('merchants'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('merchants.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Merchant::$rules);

		if ($validation->passes())
		{
			$this->merchant->create($input);

			return Redirect::route('merchants.index');
		}

		return Redirect::route('merchants.create')
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
		$merchant = $this->merchant->findOrFail($id);

		return View::make('merchants.show', compact('merchant'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$merchant = $this->merchant->find($id);

		if (is_null($merchant))
		{
			return Redirect::route('merchants.index');
		}

		return View::make('merchants.edit', compact('merchant'));
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
		$validation = Validator::make($input, Merchant::$rules);

		if ($validation->passes())
		{
			$merchant = $this->merchant->find($id);
			$merchant->update($input);

			return Redirect::route('merchants.show', $id);
		}

		return Redirect::route('merchants.edit', $id)
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
		$this->merchant->find($id)->delete();

		return Redirect::route('merchants.index');
	}

}