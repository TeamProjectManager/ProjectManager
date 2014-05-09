<?php
/**************************************************************
* *
* Provides a notification to the user every time *
* your WordPress theme is updated *
* *
* *
**************************************************************/
global $it_data;

// Constants for the theme name, folder and remote XML url
define( 'NOTIFIER_THEME_NAME', 'ProjectPress' ); // The theme name
define( 'NOTIFIER_THEME_SHORTNAME', 'projectpress' ); // The theme name
define( 'NOTIFIER_XML_FILE', 'http://www.icarusthemes.com/updates/projectpress.xml' ); // The remote notifier XML file containing the latest version of the theme and change log
define( 'NOTIFIER_CACHE_INTERVAL', 21600 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)
define ('it_UPDATE_PAGE_NAME', 'theme-update-notifier');

// Adds an update notification to the WordPress Dashboard menu
function update_notifier_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string function isn't available
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_themes(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css
		
		if (isset($xml->latest)) { $latest = explode('.',$xml->latest); }
		if (isset($theme_data['Version'])) { $current= explode('.',$theme_data['Version']); }

		$newversion=false;
		if (isset($latest)) {
		for($i=0; $i<sizeof($latest); $i++){
			if (isset($current)){
			if((int)$current[$i]<(int)$latest[$i]){
				$newversion=true;
				break;
			}
			}//end if isset
		}
		
		}
		
		$count = (isset($_GET['it_update']) &&  $_GET['it_update']=='true')?'':'<span class="update-plugins count-1"><span class="update-count">1</span></span>';
		if($newversion) { // Compare current theme version with the remote XML version
			add_theme_page( NOTIFIER_THEME_NAME . ' Theme Updates', NOTIFIER_THEME_NAME . ' Update '.$count, 'administrator', it_UPDATE_PAGE_NAME, 'update_notifier');
		} 
	}
}

add_action('admin_menu', 'update_notifier_menu');

// Adds an update notification to the WordPress 3.1+ Admin Bar
function update_notifier_bar_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string function isn't available
		global $wp_admin_bar, $wpdb;
		
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_themes(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css
		
		if (isset($xml->latest) && isset($theme_data['Version'])) {
		
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . NOTIFIER_THEME_NAME . ' <span id="ab-updates">New Updates</span></span>', 'href' => get_admin_url() . 'index.php?page=theme-update-notifier' ) );
		}
		
		}
	}
}
add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );



// The notifier page
function update_notifier() {
	$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$theme_data = wp_get_themes(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css
	$options_url= admin_url('index.php?page='.it_UPDATE_PAGE_NAME.'&it_update=true'); ?>

	<script type="text/javascript">
	var ppUpdateData = {
		optionsLink: "<?php echo $options_url; ?>",
		envatoDetails: <?php if (isset($it_data['_tf_username']) && isset($it_data['_tf_api_key'])) { echo "true"; } else { echo "false" ; } ?>
	};
	</script>

	<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2><?php echo NOTIFIER_THEME_NAME ?> Theme Updates</h2>

	<?php if(!(isset($_GET['it_update']) &&  $_GET['it_update']=='true')){ ?>
	<div id="message" class="updated below-h2"><p><strong><?php if (isset($xml->message)) { echo $xml->message; } ?></strong> You have version <?php if (isset($theme_data['Version'])) { echo $theme_data['Version']; } ?> installed. Please update to version <?php if (isset($xml->latest)) { echo $xml->latest; } ?>.</p></div>


	<div id="instructions">

	<div class="two-columns">
	<h3>Automatic Update Instructions</h3>
	<b>Important: </b><i>Please note that with the automatic theme update any code modifications done in the theme's code will be lost, so please
			 make sure you have a backup copy of the theme files before you update the theme. </i>
	<p>In order to use this functionality, you have to:<br/>
	1. Go to <strong>"Appearance", "<?php echo NOTIFIER_THEME_NAME; ?>", "Theme Update"</strong> section and insert your Envato Marketplace username and API Key. <br/>
    2. Make sure that the name of the folder that contains the theme files is called "<?php echo NOTIFIER_THEME_NAME; ?>". This is the default folder name, so if you haven't modified it manually, the name of the folder on your server should be called "<?php echo NOTIFIER_THEME_NAME; ?>".</p>

	<div id="confirm-update" title="Theme Update">Are you sure you want to update the theme and replace all your current theme files with the new updated files?</div>
	<div id="no-details" title="Almost There">You haven't inserted your Marketplace username and API Key - please go to the <?php echo NOTIFIER_THEME_NAME; ?> Options page and populate the required data in the "Theme Update" section.</div>
	
	<a href="" class="button-primary" id="update-btn">Automatically Update Theme</a>
	</div>

		<div class="two-columns no-margin">
	<h3>Manual Update Instructions</h3>
	<p>It is recommended to manually install the update if you have done some modifications to the theme's code. If so, first create
		a backup copy of the current theme you have installed and modified and then you can proceed with installing the update.</p>
	<div id="manual-instructions" title="Manual Update Instructions">
	<p>To download the latest update of the theme, login to ThemeForest, head over to your <strong>Downloads</strong> section and re-download the theme like you did when you bought it.</p>
	<p>There are two main ways of installing an update manually:</p>
	<ol>
	<li><i><b>By uploading the theme as a new theme (recommended)</b></i>- this is an easier way to accomplish this. You just have to upload
	the updated theme zip file via the built in WordPress theme uploader as a new theme from the Appearance &raquo; Themes &raquo; Install Themes &raquo; Upload section.

	<div class="note_box">
			 <b>Note: </b><i>Please note that with the activating of the new theme it is possible your menu setting not to
			 be saved for the new theme. If so, you just have to go to Appearance &raquo; Menus &raquo; Theme Locations, select the menu (it will be
			 still there) and press the "Save" button</i>.
			</div>
	</li>
	<li><i><b>Via FTP</b></i> - you have to first unzip the zipped theme file and then you can use an FTP client (such as FileZilla) and replace all the theme files with the
	updated ones.

	<div class="note_box">
			 <b>Note: </b><i>Please note that with the file replacing all the code changes you have made to the files 
			 (if you have made any) will be lost, so please
			 make sure you have a backup copy of the theme files before you do the replacement. All the settings that
			 you have made from the admin panel won't be lost- they will be still available.</i>
			</div>

			</li>
	</ol>
	</div>
</div>
	<div class="clear"></div>
	<p>For more information about the updates, please refer to the "Updates" section of the documentation included.</p>
	<br />
	</div>
	<?php } ?>
	<div class="icon32 icon32-posts-page" id="icon-edit-pages"><br></div><h2 class="title" id="changes-title">Update Changes</h2>
		<div id="changelog">
	<?php if (isset($xml->changelog)) { echo $xml->changelog; } ?>
	</div>
	</div>
<?php 
}






// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function get_latest_theme_version($interval) {
	$notifier_file_url = NOTIFIER_XML_FILE;
	$db_cache_field = 'notifier-cache-'.NOTIFIER_THEME_SHORTNAME;
	$db_cache_field_last_updated = 'notifier-cache-last-updated-'.NOTIFIER_THEME_SHORTNAME;
	$last = get_option( $db_cache_field_last_updated );
	$now = time();

	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
			
		$res = wp_remote_get( $notifier_file_url );
		$cache=wp_remote_retrieve_body($res);
		
		if ($cache) {
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}

	
	// Let's see if the $xml data was returned as we expected it to.
	// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down

	if( strpos((string)$notifier_data, '<notifier>') === false ) {
		$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>4.0</latest><changelog></changelog></notifier>';
	}
	
	// Load the remote XML data into a variable and return it
	$xml = simplexml_load_string($notifier_data);
	return $xml;
}

/*-------------------------------------------------------------
AUTOMATIC UPDATE FUNCTIONALITY
--------------------------------------------------------------*/

add_action('admin_init', 'it_set_update_functionality');

function it_set_update_functionality(){
	// include the library
	get_template_part('library/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php');
	
	$theme_data = wp_get_themes(TEMPLATEPATH . '/style.css');
	if(isset($theme_data['Name'])) { $theme_name = $theme_data['Name']; }
	if (isset($it_data['_tf_username'])) { $tf_username = $it_data['_tf_username']; } else $tf_username = '';
	if (isset($it_data['_tf_api_key'])) { $tf_api_key = $it_data['_tf_api_key']; } else $tf_username = '';
	$allow_cache=true;
	
	if($tf_username && $tf_api_key){
		global $it_data;
		

		if(isset($_GET['it_update']) &&  $_GET['it_update']=='true'){
			if (in_array  ('curl', get_loaded_extensions())){
				//cURL is enabled, the Envato Toolkit uses cURL, so the update can be performed
				$upgrader = new Envato_WordPress_Theme_Upgrader( $tf_username, $tf_api_key );
				$upgrader->check_for_theme_update($theme_name, $allow_cache);
				$res = $upgrader->upgrade_theme($theme_name, $allow_cache);
				$success = $res->success;
				$it_data->theme_updated = $success;
			}else{
				$it_data->curl_disabled = true;
			}
		}
	}
}


add_action('admin_notices', 'it_update_notice' );

function it_update_notice(){
	global $it_data;
	$message_type="updated";
	
	if(isset($it_data->theme_updated)){
		if($it_data->theme_updated){
			$message = 'The theme has been updated successfully';
		}else{
			$message = 'An error occurred, the theme has not been updated. Please try again later or install the update manually.';
			$message_type = "error";
		}
	}elseif(isset($it_data->curl_disabled) && $it_data->curl_disabled){
		$message = 'Error: The theme was not updated, because the cURL extension is not enabled on your server. In order to update the theme automatically, the Envato Toolkit Library requires cURL to be enabled on your server. You can contact your hosting provider to enable this extension for you.';
		$message_type = "error";
	}

	if(isset($message)){
		echo '<div class="'.$message_type.'"><p>'.$message.'</p></div>';
	}
}


?>