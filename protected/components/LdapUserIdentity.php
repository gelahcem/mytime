<?php

/**
 * LdapUserIdentity represents the data needed to identify a user.
 * 
 * Authentication is done against configured ldap, using {@link LdapConnection}, {@link LdapRecord}, {@link LdapUser}
 */
class LdapUserIdentity extends BaseUserIdentity
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
            $this->_id=$this->username;
            $this->username=$this->username;
            $profile=LdapUser::model()->findByPk($this->username);
            $this->_profile=$profile;
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
    
    /**
     * Obtain user ldap profile obtained from active directory
     * @return LdapUser the profile of the user
     */
    public function getProfile()
    {
        return $this->_profile;
    }
    
}