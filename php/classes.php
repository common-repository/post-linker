<?php
class PTPL_MenuHandler {
	private function _checkMenu($handle, $sub = false) {
		if(!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
			return false;
		}
		global $menu, $submenu;
		$check_menu = $sub ? $submenu : $menu;
		if(empty($check_menu)) {
			return false;
		}
		foreach ($check_menu as $k => $item) {
			if ($sub) {
				foreach($item as $sm) {
				  if($handle == $sm[2]) {
				    return true;
				  }
				}
			} else {
				if($handle == $item[2]) {
				  return true;
				}
			}
		}
		return false;
	}
	
	function __construct() {
		if ( !$this->_checkMenu( ptplGetter ( "__SLUG__" , "_main" ) ) ) {
			add_menu_page("Top Heading Menu", ptplGetter ( "__MENU__" , "_main" ), PTPL_USER_CAPABILITY, ptplGetter ( "__SLUG__" , "_main" ), ptplGetter ( "__FUNCTION__" , "_subInfo" ), PTPL_BASE_URL.'/images/logo_16.png' , PT_MY_NUMBER);
		}
	
		if ( !$this->_checkMenu( ptplGetter ( "__SLUG__" , "_subInfo" ) , true ) ) {
			add_submenu_page( ptplGetter ( "__SLUG__" , "_main" ), ptplGetter ( "__TITLE__" , "_subInfo" ), ptplGetter ( "__MENU__" , "_subInfo" ), PTPL_USER_CAPABILITY, ptplGetter ( "__SLUG__" , "_subInfo" ), ptplGetter ( "__FUNCTION__" , "_subInfo" ) );
		}
		if ( !$this->_checkMenu( ptplGetter ( "__SLUG__" , "_subPlugin" ) , true ) ) {
			add_submenu_page( ptplGetter ( "__SLUG__" , "_main" ), ptplGetter ( "__TITLE__" , "_subPlugin" ), ptplGetter ( "__MENU__" , "_subPlugin" ), PTPL_USER_CAPABILITY, ptplGetter ( "__SLUG__" , "_subPlugin" ), ptplGetter ( "__FUNCTION__" , "_subPlugin" ) );
		}
		
	}
}

class PTPL_DatabaseHandler {
	
	private function _createTableMain( ) {		
		$tableName = PTPL_TABLE_NAME;
		$sql = "CREATE TABLE $tableName  (
		  blogid INTEGER NOT NULL,
		  postid INTEGER NOT NULL,
		  posts varchar(1000) NOT NULL,
		  headings varchar(1000) NOT NULL,
		  PRIMARY KEY (blogid, postid)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	private function _createTableSettings( ) {		
		$tableName = PTPL_TABLE_NAME_SETTINGS;
		$sql = "CREATE TABLE $tableName  (
		  blogid INTEGER NOT NULL,
		  pkey varchar(300) NOT NULL,
		  pvalue varchar(1000),
		  UNIQUE(blogid,pkey)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	public function generatePosts( $postid ) {		
		
		if ( !$this->_getStatus( $postid ) ) {
			return;
		}
		$categories = $this->_getCategories();
		$headings = $this->_getHeadings();
		$catids = explode(";", $categories );
		$catids = array_unique($catids);
		
		$posts = array();
		$size = sizeof($posts);
		$postcount = wp_count_posts();
		$postcount = $postcount->publish;
		
		for( $i=1; $i <= 2; $i++ ) {
			$tempArray = array ();
			$tempArray = array_values( $tempArray );
			
			foreach( $catids as $catid ) {
				if( !in_category( $catid, $postid ) && $i == 1 ){
					continue;
				}
				$rand_posts = get_posts('cat='.$catid);
				foreach( $rand_posts as $post ) :
					$tempArray[] = $post->ID;
				endforeach;
			}
			
			$tempArray = array_unique($tempArray);
			shuffle($tempArray);
			$posts = array_merge( $posts,$tempArray );
			$posts = array_unique($posts);
			
			$size = sizeof( $posts );
			if( $size > 50) {
				$posts = array_slice($posts, 0, 50);
				break;
			} else if ( $size == $postcount ) {
				break;
			} else {				
				$catids = get_all_category_ids();
			}  
		}
		
		
		if ( !$this->_storePosts( $posts,$postid,$headings ) ) {
			echo 'oops';
		}
		
	}
	
	private function _storePosts( $posts,$postid,$headings ) {
		$posts = implode( ';' , $posts );
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "INSERT INTO ".PTPL_TABLE_NAME."(blogid,postid,posts,headings) VALUES($blog_id,$postid,'".$posts."','".$headings."')";
		if ( $wpdb->query( $sql ) ) {
			return true;
		} else {
			return false;
		}		
	}
	
	private function _getHeadings() {
		global $wpdb;
		global $ptplSettings;
		
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT pvalue FROM ".PTPL_TABLE_NAME_SETTINGS." WHERE blogid = $blog_id AND pkey = 'defaultHeadings'";
		$headings = $wpdb->get_var ( $sql );
		
		trim($headings, ";");
		if( $headings == "" ) {
			$headings = "You might also like;Recommended for you;Must reads";			
		}
		
		if( $ptplSettings['shuffled'] == "yes" ) {
			$tempArray = explode( ";",$headings );
			shuffle( $tempArray );
			$headings = implode( ";",$tempArray );
		}
		return $headings;
	}
	
	private function _getCategories() {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT pvalue FROM ".PTPL_TABLE_NAME_SETTINGS." WHERE blogid = $blog_id AND pkey = 'filterCategories'";
		$categories = $wpdb->get_var ( $sql );		
		return $categories;
	}
	
	private function _getStatus( $postid ) {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT COUNT(*) FROM ".PTPL_TABLE_NAME." WHERE blogid = $blog_id AND postid = $postid ";
		$count = $wpdb->get_var ( $sql );
		if( $count == 0 ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function createTables( ) {
		$this->_createTableMain ( );
		$this->_createTableSettings ( );
	}
	
	public function getLinkingPosts( $postid ) {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT posts FROM ".PTPL_TABLE_NAME." WHERE blogid = $blog_id AND postid = $postid";
		$linkingPosts = $wpdb->get_var ( $sql );		
		return $linkingPosts;
	}
	
	public function getHeadings( $postid ) {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT headings FROM ".PTPL_TABLE_NAME." WHERE blogid = $blog_id AND postid = $postid";
		$headings = $wpdb->get_var ( $sql );		
		return $headings;
	}
	
	public function getAllSettings() {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		$sql = "SELECT pkey,pvalue FROM ".PTPL_TABLE_NAME_SETTINGS." WHERE blogid = $blog_id";
		$results = $wpdb->get_results ( $sql );
		$return = array();
		foreach( $results as $row ) :
			if( $row->pkey == "activate" )
				$return['active'] = $row->pvalue;
			else if ( $row->pkey == "filterMenuID" )
				$return['menuid'] = $row->pvalue;
			else if ( $row->pkey == "defaultHeadings" )
				$return['headings'] = $row->pvalue;
			else if ( $row->pkey == "shuffleHeadings" )
				$return['shuffled'] = $row->pvalue;
		endforeach;
		return $return;
	}
	
	public function saveAllSettings( $activate,$selectedMenu,$selectedMenuData,$defaultHeadings,$shuffleHeadings ) {
		global $wpdb;
		$blog_id = $_SESSION['ptblogid'];
		
		$sql = "UPDATE ".PTPL_TABLE_NAME_SETTINGS." SET pvalue = '".$activate."' WHERE blogid = $blog_id AND pkey = 'activate' ";
		if( !$wpdb->query( $sql ) ){
			$sql = "INSERT INTO ".PTPL_TABLE_NAME_SETTINGS."(blogid,pkey,pvalue) VALUES($blog_id,'activate','".$activate."')";
			$wpdb->query( $sql );
		}
		
		$sql = "UPDATE ".PTPL_TABLE_NAME_SETTINGS." SET pvalue = '".$selectedMenu."' WHERE blogid = $blog_id AND pkey = 'filterMenuID' ";
		if( !$wpdb->query( $sql ) ){
			$sql = "INSERT INTO ".PTPL_TABLE_NAME_SETTINGS."(blogid,pkey,pvalue) VALUES($blog_id,'filterMenuID','".$selectedMenu."')";
			$wpdb->query( $sql );
		}
		
		$sql = "UPDATE ".PTPL_TABLE_NAME_SETTINGS." SET pvalue = '".$selectedMenuData."' WHERE blogid = $blog_id AND pkey = 'filterCategories' ";
		if( !$wpdb->query( $sql ) ){
			$sql = "INSERT INTO ".PTPL_TABLE_NAME_SETTINGS."(blogid,pkey,pvalue) VALUES($blog_id,'filterCategories','".$selectedMenuData."')";
			$wpdb->query( $sql );
		}
		
		$sql = "UPDATE ".PTPL_TABLE_NAME_SETTINGS." SET pvalue = '".$defaultHeadings."' WHERE blogid = $blog_id AND pkey = 'defaultHeadings' ";
		if( !$wpdb->query( $sql ) ){
			$sql = "INSERT INTO ".PTPL_TABLE_NAME_SETTINGS."(blogid,pkey,pvalue) VALUES($blog_id,'defaultHeadings','".$defaultHeadings."')";
			$wpdb->query( $sql );
		}
		
		$sql = "UPDATE ".PTPL_TABLE_NAME_SETTINGS." SET pvalue = '".$shuffleHeadings."' WHERE blogid = $blog_id AND pkey = 'shuffleHeadings' ";
		if( !$wpdb->query( $sql ) ){
			$sql = "INSERT INTO ".PTPL_TABLE_NAME_SETTINGS."(blogid,pkey,pvalue) VALUES($blog_id,'shuffleHeadings','".$shuffleHeadings."')";
			$wpdb->query( $sql );
		}	
	}
	
	function __construct () {		
		if ( is_multisite() ) {
			global $blog_id;
			$_SESSION['ptblogid'] = $blog_id;
		} else {
			$_SESSION['ptblogid'] = 0;
		}		
	}
}
?>