<?php
class PTPL_Variables {
	private static $_slug = array( "_main" => "plugins-talk", "_subInfo" => "plugins-talk", "_subPlugin" => "post-linker-pluginstalk" );
	private static $_menu = array( "_main" => "Plugins Talk", "_subInfo" => "About Plugins Talk", "_subPlugin" => "Post Linker" );
	private static $_title = array( "_subInfo" => "Something About Plugins Talk", "_subPlugin" => "Post Linker By Plugins Talk" );
	private static $_function = array( "_subInfo" => "ptplAboutPluginsTalk", "_subPlugin" => "ptplPostLinker" );	

	public static function getVariable ( $name, $type ) {		
		if ( $type == "__SLUG__" ){
			return PTPL_Variables::$_slug[$name];
		} else if ( $type == "__MENU__" ) {
			return PTPL_Variables::$_menu[$name];
		} else if ( $type == "__TITLE__" ) {
			return PTPL_Variables::$_title[$name];
		} else if ( $type == "__FUNCTION__" ) {
			return PTPL_Variables::$_function[$name];
		} else {
			return null;
		}
	}
}
?>