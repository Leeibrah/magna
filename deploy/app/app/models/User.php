<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $guarded = array();

	public static $rules = array(
		// 'name' => 'required',
		// 'email' => 'required',
		// 'password' => 'required',
		// 'phone' => 'required',
		// 'city' => 'required',
		// 'neighbourhood' => 'required',
		// 'order_count' => 'required',
		// 'spent_ksh' => 'required',
		// 'spent_dollars' => 'required',
		// 'notes' => 'required'
	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}