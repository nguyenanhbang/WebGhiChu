<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = '127.0.0.1';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'ql_ghichu';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'minh';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'Minh1234';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'minh';
    const MAIL_DOMAIN = 'smtp.gmail.com';
    const MAIL_USER = 'Your_email';
    const MAIL_PASSWORD = 'Your_password';
    
    const SESSION_REMEMBER_USER_ID = 'user_id';
    const SESSION_REMEMBER_PAGE = 'return_to';
    const SESSION_REMEMBER_TOKEN = 'remember_me';
    const SESSION_REMEMBER_FLASH = 'flash_notifications';
}
