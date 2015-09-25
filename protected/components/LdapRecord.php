<?php

/**
 *
 *
 */
class LdapRecord extends CModel
{

    /**
	 * @var LdapConnection the default database connection for all ldap record classes.
	 * By default, this is the 'ldap' application component.
	 * @see getLdapConnection
	 */
	public static $ldap=null;
    
    private static $_models=array();
    
    private static $_baseUserFilter="(&(objectClass=user)(objectCategory=person))";
    
    private static $_specificUsernameFilter="(&(&(objectClass=user)(objectCategory=person))(samaccountname=%s))";
    
    private static $_partialUsernameFilter="(&(&(objectClass=user)(objectCategory=person))(samaccountname=*%s*))";
    
    private static $_specificFullnameFilter="(&(&(objectClass=user)(objectCategory=person))(cn=%s))";
    
    private static $_partialFullnameFilter="(&(&(objectClass=user)(objectCategory=person))(cn=*%s*))";

    /**
	 * Returns the static model of the specified LR class.
	 * The model returned is a static instance of the LR class.
	 * It is provided for invoking class-level methods (something similar to static class methods.)
	 *
	 * EVERY derived LR class must override this method as follows,
	 * <pre>
	 * public static function model($className=__CLASS__)
	 * {
	 *     return parent::model($className);
	 * }
	 * </pre>
	 *
	 * @param string $className ldap record class name.
	 * @return LdapRecord active record model instance
     * 
     * @param string $className
     * @return LdapRecord className
     */
    public static function model($className=__CLASS__)
	{
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className(null);
			$model->attachBehaviors($model->behaviors());
			return $model;
		}
	}

    /**
	 * Returns the ldap connection used by active record.
	 * By default, the "db" application component is used as the database connection.
	 * You may override this method if you want to use a different database connection.
	 * @return CDbConnection the database connection used by active record.
	 */
	public function getLdapConnection()
	{
		if(self::$ldap!==null)
			return self::$ldap;
		else
		{
			self::$ldap=Yii::app()->ldap;
			if(self::$ldap instanceof LdapConnection)
				return self::$ldap;
			else
				throw new CException(Yii::t('yii','Ldap Record requires a "ldap" LdapConnection application component.'));
		}
	}

    public function attributeLabels()
	{
		return array();
	}
    
    /**
	 * Returns the list of all attribute names of the model.
	 * This would return all attribute names of the table associated with this LR class.
	 * @return array list of attribute names.
	 */
    public function attributeNames() {
        return array_keys($this->attributeLabels());
    }
    
    /**
     * Find all users based on the input criteria.
     * @param mixed $condition CDbCriteria or string. If criteria is not provided, it returns all users.
     * If criteria is provided, it must contains a samaccountname compare condition or a
     * fullname compare condition, or only a single order condition (ignored)
     * @param array $params
     * @return array
     * @throws CException if contition provided is not supported
     */
    public function findAll($condition='',$params=array()) {

        // default condition and order
        $ldapCondition=self::$_baseUserFilter;
        $orderField='cn';
        
        // conversion from CDbCriteria to ldap filter
        // order based on filter used
        if($condition!='' && is_a($condition, 'CDbCriteria') && count($condition->params)>0) {
            /* @var $condition CDbCriteria */
            if(strstr($condition->condition,'samaccountname')) {
                $ldapCondition=self::$_partialUsernameFilter;
                $orderField='samaccountname';
            }
            else
                if(strstr($condition->condition,'cn')) {
                    $ldapCondition=self::$_partialFullnameFilter;
                    $orderField='cn';
                }
                else throw new CException('LdapRecord: Not supported contidion');
            $param=array_values($condition->params);
            $ldapCondition=sprintf($ldapCondition,str_replace('%','',$param[0]));
        }
                
        $attributes=$this->attributeNames();
        $entries=$this->getLdapConnection()->search($ldapCondition,$attributes,$orderField);
        
        $models=array();
        $class=get_class($this);        
        
        // @todo scorporare hidration
        for($i=0; $i<$entries["count"]; $i++) {
//            echo $entries[$i]["cn"][0]."||".$entries[$i]["samaccountname"][0]."||".$entries[$i]["mail"][0]."<br/>";
            $model=new $class(null);
            foreach($attributes as &$a) {
                if($entries[$i][$a]['count']>1) {
                    $model->{$a}=$entries[$i][$a];
                }
                else {   
                    $model->{$a}=$entries[$i][$a][0];
                }
            }
            $models[]=$model;
        }

        return $models;
    }
    
    /**
     * 
     * @param string $pk
     * @return self
     */
    public function findByPk($pk) {

        $attributes=$this->attributeNames();
        $entries=$this->getLdapConnection()->search(sprintf(self::$_specificUsernameFilter,$pk), $attributes);
        
        $class=get_class($this);
        
        if($entries['count']>0) {
            $model=new $class(null);
            foreach($attributes as &$a) {
                if($entries[0][$a]['count']>1) {
                    $model->{$a}=$entries[0][$a];
                }
                else {   
                    $model->{$a}=$entries[0][$a][0];
                }
            }
        }
        else $model=null;

        return $model;
    }
    
    public function findDn($value) {
        $attributes=$this->attributeNames();
        $res=$this->getLdapConnection()->search(sprintf(self::$_specificUsernameFilter,$value), $attributes,'', true);
        $conn=$this->getLdapConnection()->conn;
        $user_entry = ldap_first_entry($conn, $res);
        $user_dn = ldap_get_dn($conn, $user_entry);
        return $user_dn;
    }
    
}