<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	 
	public function __construct() {
		$user = new User;
		$notifications = $user->getNotifications();
		
		View::share('notifications', $notifications);
	}
	 
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{	
			$this->layout = View::make($this->layout);
		}
	}

}
