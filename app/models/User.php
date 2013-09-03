<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $guarded = array();

	// public static $rules = array(
	// 	// 'name' => 'required',
	// 	// 'email' => 'required',
	// 	// 'password' => 'required',
	// 	// 'phone' => 'required',
	// 	// 'city' => 'required',
	// 	// 'neighbourhood' => 'required',
	// 	// 'order_count' => 'required',
	// 	// 'spent_ksh' => 'required',
	// 	// 'spent_dollars' => 'required',
	// 	// 'notes' => 'required'
	// );
	public static $register_rules = array(
		'name'          	 	=> 'required',
		'email'                 => 'required|email|unique:users',
		'phone'            		=> 'required|unique:users',
		'password'              => 'required|confirmed',
		'password_confirmation' => 'required',
		'city' 					=> 'required',
		'neighbourhood' 		=> 'required'
	);
	
	public static $login_rules = array(
		'login_email'    => 'required|email',
		'login_password' => 'required'
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

	/**
	 * Get the user full name.
	 *
	 * @access   public
	 * @return   string
	 */

	public function name()
	{
		return $this->name;
	}
	public function nameLink()
	{
		return '<a href="'.URL::to('user/'.$this->id).'">'.$this->name().'</a>';
	}

	public function email()
	{
		return $this->email;
	}
	public function mailto()
	{
		return '<a href="mailto:'.$this->email.'">'.$this->email.'</a>';
	}

	public function phone(){
		return $this->phone;
	}

	public function id(){
		return $this->id;
	}
	public static function adminCheck()
	{
		if(Auth::user()):
			$id = Auth::user()->id;
			$admin = array(27, 34,35);

			if (in_array(Auth::user()->id, $admin) == TRUE):
				return true;
			endif;
		else:
			return false;
		endif;
		
	}
	public static function ownerCheck($resource, $item_id)
	{
		if(Auth::user()):
			$user_id = Auth::user()->id;
			$resource = DB::table($resource)->where('id', $item_id)->first();
			// return $resource->user_id;
			// return $user_id;
			if ($resource->user_id != $user_id):
				// return $user_id;
				return false;
			endif;
		else:
			return false;
		endif;
		
	}
	public static function editButton($ownerid, $context, $itemid)
	{
		if(!Auth::user()){
			echo "";
		}
		elseif(Auth::user()->id != $ownerid){
			echo "";
		}
		else{
			return link_to_route($context.'.edit', 'Edit', array($itemid), array('class' => 'btn btn-info'));
			//link_to_route('bookshelf.edit', 'Edit', array($bookshelf->id), array('class' => 'btn btn-info'));
		}
		
	}
	public static function deleteButton($ownerid, $context, $itemid)
	{
		if(!Auth::user()){
			echo "";
		}
		elseif(Auth::user()->id != $ownerid){
			echo "";
		}
		else{
			echo Form::open(array('method' => 'DELETE', 'route' => array($context.'.destroy', $itemid)));
			echo Form::submit('Delete', array('class' => 'btn btn-danger'));
			echo Form::close();
			//link_to_route('bookshelf.edit', 'Edit', array($bookshelf->id), array('class' => 'btn btn-info'));
			// {{ Form::open(array('method' => 'DELETE', 'route' => array('wishlist.destroy', $wishlist->id))) }}
            //	{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
            //{{ Form::close() }}
		}
		
	}
	public static function addBook($ownerid, $context) //context = wishlist/bookshelf
	{
		if(!Auth::user()){
			echo "";
		}
		elseif(Auth::user()->id != $ownerid){
			echo "";
		}
		else{
			return link_to_route($context.'.create', 'Add a book to your '.$context, null, array('class' => 'btn btn-primary addbook'));
			// link_to_route('wishlist.create', 'Add a Book to your Wishlist');
		}
		
	}


}