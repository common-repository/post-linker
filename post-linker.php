<?php
/*
Plugin Name: Post Linker
Plugin URI: http://dev.pluginstalk.com/post-linker
Description: Post Linker is a simple plugin which interlinks all of your posts automatically. This <strong>keeps your visitors busy</strong> reading articles and will definitely increase <strong>"Time on site"</strong> & maybe your advertisment or affiliate money. You may be using a section like <strong>"You might also like these"</strong> or <strong>"Recommended articles just for you"</strong> into which you must be linking your other relevant posts manually. Post Linker automates your work so that you don't have to worry about recommended articles and <strong>save your time in writing articles</strong>. For more info visit <a href="http://dev.pluginstalk.com/post-linker" target="_blank">Post Linker page</a> or open <a href="http://pluginstalk.com" target="_blank">PluginsTalk.com</a>
Version: 1.1
Author: Sunil
Author URI: http://www.pluginstalk.com
*/
include ( dirname(__FILE__).'/php/includes.php' );
register_activation_hook( __FILE__, 'ptplActivated' );
register_deactivation_hook( __FILE__, 'ptplDeactivated' );
ptplAddActions();
?>