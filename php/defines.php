<?php
//Set Plugin Name
define('PTPL_PLUGIN_NAME','post-linker');
//Set Plugin Version
define ( 'PTPL_PLUGIN_VERSION', '1.0.0', TRUE );
//Set User Capability
define ( 'PTPL_USER_CAPABILITY', 'publish_posts', TRUE );
//Set Base Prefix
global $wpdb;
define ( 'PTPL_TABLE_PREFIX', $wpdb->base_prefix, TRUE );
//Set Table Names
define ( 'PTPL_TABLE_NAME', PTPL_TABLE_PREFIX.'pluginsTalkPLinker', TRUE );
define ( 'PTPL_TABLE_NAME_SETTINGS', PTPL_TABLE_PREFIX.'pluginsTalkPLinkerOptions', TRUE );
//Set My Number
define ( 'PT_MY_NUMBER', '99.000000000179', TRUE );
//Set Base dir
define( 'PTPL_BASE_DIR', realpath(dirname(__FILE__).'/..' ), TRUE);
//Set Base URL
define( 'PTPL_BASE_URL',WP_PLUGIN_URL.'/'.PTPL_PLUGIN_NAME , TRUE );
?>