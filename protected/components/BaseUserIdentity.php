<?php

/**
 * BaseUserIdentity adds an error code needed for password expiration.
 */
class BaseUserIdentity extends CUserIdentity
{

    const ERROR_PASSWORD_EXPIRED=101;

}