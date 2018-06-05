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
    'icagenda_category',
    'icagenda_customfields',
    'icagenda_events',
    'icagenda_registration',
    'kunena_categories',
    'kunena_users',
    'menu_types',
    'neorecruit_applications',
    'neorecruit_offers',
    'neorecruit_settings',
    'phocagallery',
    'phocagallery_categories'
];

/**
 *
 */
$uselessTableLike = OLD_PREFIX . 'finder%';

/**
 *
 */
$uselessTables = [
    'ucm_history',
    'session',
    'extensions',
    'assets',
    'languages',
    'modules',
    'modules_menu',
    'schemas',
    'session',
    'template_styles',
    'update_sites',
    'update_sites_extensions',
    'redirect_links',
    'icagenda',
    'kunena_ranks',
    'kunena_smileys',
    'kunena_topics',
    'kunena_version',
    'phocagallery_styles',
    'postinstall_messages',
    'tags'
];