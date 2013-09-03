<?php

class Order_totalsController extends BaseController {

	/**
	 * Order_total Repository
	 *
	 * @var Order_total
	 */
	protected $order_total;

	public function __construct(Order_total $order_total)
	{
		$this->order_total = $order_total;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$order_totals = $this->order_total->all();

		return View::make('order_totals.index', compact('order_totals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('order_totals.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Order_total::$rules);

		if ($validation->passes())
		{
			$this->order_total->create($input);

			return Redirect::route('order_totals.index');
		}

		return Redirect::route('order_totals.create')
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
		$order_total = $this->order_total->findOrFail($id);

		return View::make('order_totals.show', compact('order_total'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$order_total = $this->order_total->find($id);

		if (is_null($order_total))
		{
			return Redirect::route('order_totals.index');
		}

		return View::make('order_totals.edit', compact('order_total'));
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
		$validation = Validator::make($input, Order_total::$rules);

		if ($validation->passes())
		{
			$order_total = $this->order_total->find($id);
			$order_total->update($input);

			return Redirect::route('order_totals.show', $id);
		}

		return Redirect::route('order_totals.edit', $id)
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
		$this->order_total->find($id)->delete();

		return Redirect::route('order_totals.index');
	}

}