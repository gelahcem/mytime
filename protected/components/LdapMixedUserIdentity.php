<?php

/**
 * LdapMixedUserIdentity represents the data needed to identify a user.
 * 
 * Authentication is done against configured ldap using {@link LdapConnection}, {@link LdapRecord}, {@link LdapUser},
 * but user infos are getted from mapper {@link User}.
 */
class LdapMixedUserIdentity extends BaseUserIdentity
{
    
    private $_id;
    /**
     *
     * @var LdapUser the user ldap profile 
     */
    private $_profile;
    
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $bind=Yii::app()->ldap->bind($this->username,$this->password);
        
        if(!$bind) {
            if(in_array(Yii::app()->ldap->lastBindError, array(LdapConnection::BIND_PASSWORD_EXPIRED, LdapConnection::BIND_PASSWORD_RESET))) {
                $this->errorCode=self::ERROR_PASSWORD_EXPIRED;
            }
            else {
                $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
            }
        }
		else
		{
            $user=User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
            if(!$user) throw new Exception('Missing user '.$this->username.' info');
            $this->_id=$user->id;
            $this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
        
		return $this->errorCode == self::ERROR_NONE;
	}

    /**
     * Overrides getId() parent method, returning the id instead of the username
     * @return int the id of the user
     */
    public function getId()
    {
        return $this->_id;
    }

}