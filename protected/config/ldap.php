<?php
// This is the main ldap configuration.
// NOTE: the best practice is to place this file outside htdocs/wwwroot and adapting
// the main configuration file accordingly.
return array(
    'class'=>'application.components.LdapConnection',
    'hostname'=>'192.168.215.10',
    'port'=>389,
    'domain'=>'nad',
    'dc'=>array('nad','local'),
    'ou'=>'Users',
    'username'=>'Admin',
    'password'=>'R0m4gn4!!',
    'tls_on'=>false,
    
);
