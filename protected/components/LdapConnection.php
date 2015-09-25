<?php

/**
 * Incapsulate a Ldap Connection.
 * 
 * @property-read resource $conn Ldap connection resource
 * @property-read boolean $binded whether this connection is binded with credentials
 * @property-read string $lastBindError last bind error
 * @property boolean $active The state of the component
 * @property string $dc The dc string
 */
class LdapConnection extends CApplicationComponent {

    const OPT_DIAGNOSTIC_MESSAGE = 0x0032;
    const BIND_PASSWORD_EXPIRED = 532;
    const BIND_PASSWORD_RESET = 773;

    /**
     * Hostname to wich connect
     * @var string 
     */
    public $hostname;

    /**
     * Port to use. Default to 389.
     * @var string 
     */
    public $port = '389';

    /**
     * Domain
     * @var string 
     */
    public $domain = '';

    /**
     * Organizational Unit
     * @var string 
     */
    public $ou = '';

    /**
     * Username used for system bind (for searches)
     * @var string 
     */
    public $username = '';

    /**
     * Password used for system bind (for searches)
     * @var string 
     */
    public $password = '';

    /**
     * Flag to enable/disable secure ldap connection. Defaults to false
     * @var boolean 
     */
    public $tls_on = false;

    /**
     * Users Password duration in days. Defaults to 0, meaning no duration limit
     * @var integer 
     */
    public $passwordDuration = 0;

    /**
     * @var boolean whether the ldap connection should be automatically established
     * the component is being initialized. Defaults to true. Note, this property is only
     * effective when the LdapConnection object is used as an application component.
     */
    public $autoConnect = true;
    private $_dc = '';
    private $_active = false;
    private $_binded = false;
    private $_conn = null;
    private $_lastBindError = null;

    /**
     * 
     * @param string $hostname
     * @param int $port
     * @param string domain
     * @param array dc
     * @param string $username
     * @param string $password
     */
    public function __construct($hostname = '', $port = 389, $domain = '', $dc = array(), $ou = '', $username = '', $password = '') {
        $this->hostname = $hostname;
        $this->port = $port;
        $this->domain = $domain;
        // this is a property, some preprocessing is executed by the setter
        $this->dc = $dc;
        $this->ou = $ou;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Initializes the component.
     * This method is required by {@link IApplicationComponent} and is invoked by application
     * when the LdapConnection is used as an application component.
     * If you override this method, make sure to call the parent implementation
     * so that the component can be marked as initialized.
     */
    public function init() {
        parent::init();
        if ($this->autoConnect)
            $this->setActive(true);
    }

    /**
     * 
     * @return resource
     */
    public function getConn() {
        return $this->_conn;
    }

    /**
     * Returns whether the Ldap connection is established.
     * @return boolean whether the Ldap connection is established
     */
    public function getActive() {
        return $this->_active;
    }

    /**
     * Open or close the Ldap connection.
     * @param boolean $value whether to open or close Ldap connection
     * @throws CException if connection fails
     */
    public function setActive($value) {
        if ($value != $this->_active) {
            if ($value)
                $this->open();
            else
                $this->close();
        }
    }

    /**
     * Returns whether the Ldap connection is established.
     * @return boolean whether the Ldap connection is established
     */
    public function getBinded() {
        return $this->_binded;
    }

    /**
     * 
     * @param array $value
     */
    public function setDc($value) {
        $this->_dc = "DC=" . implode(",DC=", $value);
    }

    /**
     * 
     * @param array $value
     */
    public function getDc() {
        return $this->_dc;
    }

    public function getLastBindError() {
        return $this->_lastBindError;
    }

    /**
     * Bind to validate user credentials.
     * @param string $username the username
     * @param string $password the password
     * @return boolean success or failure
     * @throws CException if credentials are empty
     */
    public function bind($username, $password) {
        if ($username == '' || $password == '') {
            throw new CException('LDAP: login credentials cannot be empty');
        }
        // if already binded unbinds
        if ($this->_binded)
            $this->unbind();

        $this->_binded = @ldap_bind($this->_conn, "{$this->domain}\\$username", $password);
        if (!$this->_binded) {
            ldap_get_option(Yii::app()->ldap->conn, self::OPT_DIAGNOSTIC_MESSAGE, $this->_lastBindError);
            $this->_lastBindError = explode(',', $this->_lastBindError)[2];
            $this->_lastBindError = explode(' ', $this->_lastBindError)[2];
            $this->_lastBindError = intval($this->_lastBindError);
        } else {
            $this->_lastBindError = null;
        }
        return $this->_binded;
    }

    /**
     * System bind for search purposes.
     * @throws CException if system credentials are empty or wrong
     */
    public function bindForSearch() {

        // use this instance credentials if not passed
        if ($this->username == '' || $this->password == '') {
            throw new CException('LDAP: system credentials cannot be empty');
        }
        // if already binded unbinds
        if ($this->_binded)
            $this->unbind();

        $this->_binded = @ldap_bind($this->_conn, "{$this->domain}\\{$this->username}", $this->password);
        if (!$this->_binded)
            throw new CException('LDAP: system credentials are wrong');
    }

    /**
     * Executes unbind.
     * @return boolean true on unbind success, false on failure
     */
    public function unbind() {
        $result = ldap_unbind($this->_conn);
        if ($result)
            $this->_binded = false;
        return $result;
    }

    /**
     * Perform ldap search on current connection
     * @param string $filter the filter to be used
     * @param array $attributes list of attributes required in output
     * @param string $orderfield [optional] field to use for sorting
     * @param boolean $asResource [optional] defaults to false. If true, the ldap resource is returned
     * @return array structured ldap results. If $asResource is true, the ldap resource is returned
     * @throws CException if bad parameters are used
     */
    public function search($filter, $attributes, $orderField = '', $asResource = false) {
        $this->beforeSearch();

        // parameters validation
        if (!is_string($filter) || $filter == '' ||
                !is_array($attributes) || count($attributes) == 0 || !is_string($orderField)
        )
            throw new CException('LDAP: Bad parameters.');

        $result = @ldap_search(
                        $this->conn, $this->dc, $filter, $attributes
        );

        if ($result === false)
            throw new CException('LDAP: Bad filter used.');

        if ($orderField != '')
            if (!@ldap_sort($this->conn, $result, $orderField))
                throw new CException('LDAP: Bad order field used.');

        // return directly the resource
        if ($asResource)
            return $result;

        $entries = ldap_get_entries($this->conn, $result);
        return $entries;
    }

    /**
     * Opens Ldap connection.
     * @throws CException if connection fails:
     * - bad connections parameters
     * - connection failed
     * - unsupported ldap protocol
     */
    protected function open() {
        if ($this->_conn === null) {
            if (empty($this->hostname))
                throw new CException('LDAP: Hostname cannot be empty.');
            if (empty($this->port))
                throw new CException('LDAP: Port cannot be empty.');
            try {
                Yii::trace('Opening LDAP connection', 'LdapConnection');
                $this->_conn = ldap_connect($this->hostname, $this->port);
                if (!$this->_conn)
                    throw new CException('LDAP: Could not connect to ldap');
                if (!ldap_set_option($this->_conn, LDAP_OPT_PROTOCOL_VERSION, 3))
                    throw new CException('LDAP: Could not set ldap protocol to level 3');
                if (!ldap_set_option($this->_conn, LDAP_OPT_REFERRALS, 0))
                    throw new CException('LDAP: Could not set ldap opt referrals');
                if ($this->tls_on) {
                    if (!ldap_start_tls($this->_conn))
                        throw new CException('LDAP: Could not set secure LDAP Connection.');
                }
                $this->_active = true;
            } catch (CException $e) {
                if (YII_DEBUG) {
                    throw $e;
                } else {
                    Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'exception.CException');
                    throw $e;
                }
            }
        }
    }

    /**
     * Closes the currently active Ldap connection.
     * It does nothing if the connection is already closed.
     */
    protected function close() {
        Yii::trace('Closing LDAP connection', 'LdapConnection');
        $this->_conn = null;
        $this->_active = false;
        $this->_binded = false;
    }

    /**
     * Executed before search.
     */
    protected function beforeSearch() {
        if (!$this->_binded)
            $this->bindForSearch();
    }

}
