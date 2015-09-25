<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $options = Yii::app()->params['ldap'];
        $connection = ldap_connect($options['host'], $options['port']);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);

        if ($connection) {
            try {
                @$bind = ldap_bind($connection, $options['domain'] . "\\" . $this->username, $this->password);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            if (!$bind)
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else
                $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

}
