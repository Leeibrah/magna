<?php

class Order extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		// 'user_id' => 'required',
		// 'city' => 'required',
		// 'neighbourhood' => 'required',
		// 'amount' => 'required',
		// 'order_status' => 'required',
		// 'notes' => 'required'
	);
}