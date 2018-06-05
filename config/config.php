<?php

header('Charset=UTF-8');

// Defines.
defined("LOCAL_HOST" )         ||      define( "LOCAL_HOST","127.0.0.1" )                             or die;
defined("LOGIN_NAME" )         ||      define( "LOGIN_NAME","id" )                                  or die;
defined("PASS_WORD" )          ||      define( "PASS_WORD","password" )                                   or die;
defined("DATA_BASE" )          ||      define( "DATA_BASE","databasename" )                              or die;
defined("OLD_PREFIX" )         ||      define( "OLD_PREFIX",'OldPrefix_' )                               or die;
defined("NEW_PREFIX" )         ||      define( 'NEW_PREFIX','NewTamft_' )                                or die;

// Please don't touche these configuration :
defined("OLD_PREFIX_LENGTH" )  ||      define( "OLD_PREFIX_LENGTH", strlen( OLD_PREFIX ) )      or die;
defined("DIR_SQL" )            ||      define( "DIR_SQL", "sql" )                                     or die;
defined("PERMISION" )          ||      define( "PERMISION", 0777 )                                    or die;
defined("SEPARATOR" )          ||      define( "SEPARATOR", DIRECTORY_SEPARATOR )                     or die;
defined("MODE" )               ||      define( "MODE", "w" )                                          or die;
defined("EXTENSION" )          ||      define( "EXTENSION", ".sql" )                                  or die;


