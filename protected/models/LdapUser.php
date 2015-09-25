<?php

/**
 *
 * @property string $samaccountname the username
 * @property string $cn the fullname
 * @property string $givenname firstname
 * @property string $sn lastname
 * @property string $memberof groups
 * @property string $mail the email
 * @property string $useraccountcontrol account flags
 * @property integer $pwdlastset last password change
 * @property-read string $pwdlastsetDateTime last password change datetime
 * @property-read boolean $passworExpired
 * @property-read string $userstatelist user state list
 *
 */
class LdapUser extends LdapRecord
{
    
    /**
     * full values are as follows
     *  'SCRIPT'=>1,
        'ACCOUNTDISABLE'=>2,
        'HOMEDIR_REQUIRED'=>8,
        'LOCKED'=>16,
        'PASSWD_NOTREQD'=>32,
        'PASSWD_CANT_CHANGE'=>64,
        'ENCRYPTED_TEXT_PWD_ALLOWED'=>128,
        'TEMP_DUPLICATE_ACCOUNT'=>256,
        'NORMAL_ACCOUNT'=>512,
        'INTERDOMAIN_TRUST_ACCOUNT'=>2048,
        'WORKSTATION_TRUST_ACCOUNT'=>4096,
        'SERVER_TRUST_ACCOUNT'=>8192,
        'DONT_EXPIRE_PASSWORD'=>65536,
        'MNS_LOGON_ACCOUNT'=>131072,
        'SMARTCARD_REQUIRED'=>262144,
        'TRUSTED_FOR_DELEGATION'=>524288,
        'NOT_DELEGATED'=>1048576,
        'USE_DES_KEY_ONLY'=>2097152,
        'DONT_REQ_PREAUTH'=>4194304,
        'PASSWORD_EXPIRED'=>8388608,
        'TRUSTED_TO_AUTH_FOR_DELEGATION'=>16777216,
        'PARTIAL_SECRETS_ACCOUNT'=>67108864,
     * @var array arrays of uac flags.
     * Only some are included
     */    
    private static $_uacFlags=array(
        'ACCOUNTDISABLE'=>2,
        'LOCKED'=>16,
        'NORMAL_ACCOUNT'=>512,
        'DONT_EXPIRE_PASSWORD'=>65536,
        'PASSWORD_EXPIRED'=>8388608,
    );

    private $_samaccountname;
    private $_cn;
    private $_givenname;
    private $_sn;
    private $_memberof;
    private $_mail;
    private $_useraccountcontrol;
    private $_pwdlastset;
    
    private $_pwdlastsetDateTime;
    private $_passwordExpired;
    private $_userstatelist;
    
    /**
     * Override of behaviors
     * @return array
     */
    public function behaviors() {
        return array(
            'modelNameBehavior'=>'ModelNameBehavior',
        );
    }
    
    /**
     * 
     * @return array
     */
    public function attributeNames() {
        return parent::attributeNames();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * Returns field used as primary key.
     * @return string
     */
    public static function getKeyField() {
        return 'samaccountname';
    }
    
    /**
     * 
     * @return array
     */
    public static function getUacFlags() {
        return self::$_uacFlags;
    }
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samaccountname, cn, givenname, sn, memberof, mail, useraccountcontrol', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'samaccountname'=>Yii::t('user', 'Username'),
			'cn'=>Yii::t('user', 'Fullname'),
            'givenname'=>Yii::t('user', 'First Name'),
            'sn'=>Yii::t('user', 'Last Name'),
            'memberof'=>Yii::t('user', 'Groups'),
            'mail'=>Yii::t('user', 'Email'),
            'useraccountcontrol'=>Yii::t('user', 'State'),
            'pwdlastset'=>Yii::t('user', 'Pwd Last Set'),
		);
	}
    
    public function getSamaccountname() {
        return $this->_samaccountname;
    }
    
    public function getCn() {
        return $this->_cn;
    }
    
    public function getGivenname() {
        return $this->_givenname;
    }

    public function getSn() {
        return $this->_sn;
    }

    public function getMemberof() {
        return $this->_memberof;
    }
        
    public function getMail() {
        return $this->_mail;
    }
    
    public function getUseraccountcontrol() {
        return $this->_useraccountcontrol;
    }
    
    public function getPwdlastset() {
        return $this->_pwdlastset;
    }
    
    public function getPwdlastsetDateTime() {
        if(isset($this->_pwdlastsetDateTime))
            return $this->_pwdlastsetDateTime->format('Y-m-d H:i:s');
        else return null;
    }
    
    public function getPasswordExpired() {
        return $this->_passwordExpired;
    }
    
    public function getUserstatelist() {
        return $this->_userstatelist;
    }

    public function setSamaccountname($value) {
        $this->_samaccountname=$value;
    }
    
    public function setCn($value) {
        $this->_cn=$value;
    }
    
    public function setGivenname($value) {
        $this->_givenname = $value;
    }
    
    public function setSn($value) {
        $this->_sn = $value;
    }
    
    public function setMemberof($value) {
        $tmp=$value;
        if(isset($tmp['count'])) {
            unset($tmp['count']);
            foreach($tmp as $k=>$v) {
                $tmp[$k]=explode(',', $v,2);
                $tmp[$k]=str_replace('CN=',"",$tmp[$k][0]);
            }
            $tmp=implode(',', $tmp);
        }
        else {
            $tmp=explode(',',$tmp,2);
            $tmp=str_replace('CN=',"",$tmp[0]);
        }
        $this->_memberof=$tmp;
    }

    public function setMail($value) {
        $this->_mail=$value;
    }
    
    public function setUseraccountcontrol($value) {
        $this->_useraccountcontrol=$value;
        
        foreach(self::$_uacFlags as $key=>$val) {
            if($value & $val)
                $this->_userstatelist.=$key.",";
        }
        
        if(strlen($this->_userstatelist)>0)
            $this->_userstatelist=substr($this->_userstatelist,0,-1);
    }
    
    public function setPwdlastset($value) {
        $this->_pwdlastset=$value;
        if($this->_pwdlastset!=0) {
            // conversion from ldap timestamp to unix epoch (from 1601-01-01 to 1970-01-01)
            $this->_pwdlastsetDateTime=new DateTime(date('Y-m-d H:i:s',(($value/10000000)-11644473600)));
        }
        $this->_passwordExpired=false;
        
        $passwordCanExpire=!strpos($this->userstatelist,'DONT_EXPIRE_PASSWORD') && $this->getLdapConnection()->passwordDuration!=0;
        
        if($passwordCanExpire) {
            if($this->_pwdlastset==0) {
                $this->_passwordExpired=true;
            }
            else {
                $now=new DateTime();
                $interval=$now->diff($this->_pwdlastsetDateTime);
                if($interval->d>=$this->getLdapConnection()->passwordDuration) {
                    $this->_passwordExpired=true;
                }
            }
        }
    }
    
    public function changePassword($newPassword) {

        $this->getLdapConnection()->setActive(false);
        $this->getLdapConnection()->setActive(true);
        $user_dn=$this->findDn($this->samaccountname);
        // create the unicode password 
        $newPassword="\"".$newPassword."\""; 
        $newPassword=mb_convert_encoding($newPassword, "UTF-16LE"); 

        $entry=array();
        $entry["unicodePwd"]=$newPassword;

        return ldap_mod_replace($this->getLdapConnection()->conn,$user_dn,$entry);
    }
    
}