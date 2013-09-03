<?php

class Payment extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		// 'order_id' => 'required',
		// 'order_cost' => 'required',
		// 'payment_type' => 'required',
		// 'payment_amount' => 'required',
		// 'balance' => 'required',
		// 'notes' => 'required'
	);
}