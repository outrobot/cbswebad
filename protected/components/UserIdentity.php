<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	public function authenticate()
	{
		$user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user===null || $user->status == 0)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!password_verify($this->password, $user->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->setState('lastLogin', date("m/d/y g:i A", strtotime($user->last_login_time)));
			$user->saveAttributes(array(
				'last_login_time'=>date("Y-m-d H:i:s", time()),
			));
			$this->errorCode=self::ERROR_NONE;
                        $this->setState('lastlogin', $user->last_login_time);
                        //$this->setState('roles', $user->role);
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getID()
	{
		return $this->_id;
	}
}