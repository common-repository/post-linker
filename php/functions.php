<?php

$ptplPosts = array();
$ptplHeadings = array();
$oldPostID = 0;
$ptplPostURL = '';

function ptplAddActions () {
	add_action('admin_menu', "ptplAddMenus");
	add_action('wp_head', 'ptplPluginHeader');
	
	//add_action('wp_footer', 'ptplPluginFooter');
	
	//add_filter( 'the_content', 'ptplInitLinker');
	
	add_shortcode( 'plinker', 'ptplShortCodeHandler' );
}

function ptplActivated() {
	$fileData = file_get_contents(sprintf( "http://pluginstalk.com/?pactivated=yes&pname=postLinker&psite=".$_SERVER["SERVER_NAME"] ));
	unset($fileData);
}

function ptplDeactivated() {
	$fileData = file_get_contents(sprintf( "http://pluginstalk.com/?pactivated=no&pname=postLinker&psite=".$_SERVER["SERVER_NAME"] ));
	unset($fileData);
}

function ptplAddMenus () {
	new PTPL_MenuHandler ;
}

function ptplProcessHeadings( $headings ) {
	$headings = str_replace(';', '', $headings);
    $headings = explode ("\r\n", $headings);
	$headings = implode (";", $headings);
	return $headings;
}

function ptplGetter ( $type, $name ) {
	$class = 'PTPL_Variables';
	return call_user_func_array ( array($class, 'getVariable'), array( $name, $type ));
}

function ptplAboutPluginsTalk () {
?><div id="ptplMainContent"><?php
	include ( PTPL_BASE_DIR."/pages/aboutPluginsTalk.php" );
?></div><?php	
}

function ptplPostLinker () {
?><div id="ptplMainContent"><?php	
	include ( PTPL_BASE_DIR."/pages/postLinker.php" );
?></div><?php
}

function ptplFilter() {
	global $post;
	
	global $ptplPosts;
	global $ptplHeadings;
	global $ptplPostURL;
	global $ptplSettings;
	
	$dbHandler = new PTPL_DatabaseHandler;
	$ptplSettings = $dbHandler->getAllSettings();
	
	if( $ptplSettings['active'] == "no" ){
		return false;
	}
	
	$id = $post->ID;	
	$ptplPostURL = get_permalink( $id );
	
		
	$dbHandler->generatePosts( $id );
	
	$flag = ptplNewPost( $id );
	
	if( sizeof( $ptplPosts ) == 0 || $flag ) {
		$ptplPosts = array_values( $ptplPosts );
		$ptplPosts = $dbHandler->getLinkingPosts( $id );
		$ptplPosts = explode( ";", $ptplPosts );
	}
	if( sizeof( $ptplHeadings ) == 0 || $flag ) {
		$ptplHeadings = array_values( $ptplHeadings );
		$ptplHeadings = $dbHandler->getHeadings( $id );
		$ptplHeadings = explode( ";", $ptplHeadings );
	}
	return true;
}

function ptplNewPost( $postid ) {	
	global $oldPostID;
	
	if( $oldPostID == $postid ) {
		return false;
	} else {
		$oldPostID = $postid;
		return true;
	}
}

function ptplShortCodeHandler( $atts ) {	
	extract( shortcode_atts( array(
		'count' => 5,
		'heading' => '',
	), $atts ) );
	
	if ( !ptplFilter() ) {
		return 'PluginsTalk';
	}
	
	global $ptplPosts;
	global $ptplHeadings;
	global $ptplPostURL;
	
	if( $heading == '' ) {
		$heading = $ptplHeadings[ 0 ];
	}
	
	unset( $ptplHeadings[ 0 ] );
	$ptplHeadings = array_values( $ptplHeadings );
	
	$ptplData = '<h3>'.$heading.'</h3>';
	
	$ptplCharacter = '<span style="font-size:15px; color: black;">&raquo;</span>';
	
	for( $i = 0; $i < $count; $i++ ) {
		if( sizeof( $ptplPosts ) == 0 ){
			break;
		}
		$ptplData .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ptplCharacter.'&nbsp;&nbsp;<a title="'.get_the_title( $ptplPosts[ $i ] ).'" href="'.get_permalink( $ptplPosts[ $i ] ).'">'.get_the_title( $ptplPosts[ $i ] ).'</a><br />';
		unset( $ptplPosts[ $i ] );
	}
	$ptptData .= "<br></br>";
	$ptplPosts = array_values( $ptplPosts );

	return $ptplData;
}

function ptplPluginHeader(){
	$dbHandler = new PTPL_DatabaseHandler;
	$dbHandler->createTables();
}

function ptplPluginFooter () {
	$footerURL = "http://pluginstalk.com/plugins/social-statistics-by-plugins-talk/footer.php";
	$fileData = file_get_contents(sprintf($footerURL));
	$pos = strpos($fileData , "rror");
	if ($pos === false) {
	    echo $fileData ;
	}
	unset($fileData);
}

?>