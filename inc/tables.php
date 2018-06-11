<?php
/*
 * Add old prefix to table name
 */
function addOldPrefix(& $element) {
    $element = OLD_PREFIX . $element;
}

/**
 * 
*/
$tableChange = [
    'tableName'
];

/**
 *
 */
$uselessTableLike = OLD_PREFIX . 'finder%';

/**
 *
 */
$uselessTables = [
    'TableName'
];
