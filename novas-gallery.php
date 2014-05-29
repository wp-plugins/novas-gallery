<?php
/**
 * Plugin Name: Nova's Gallery
 * Plugin URI: http://wordpress.org/plugins/novas-gallery/
 * Description: Nova's Gallery places your photos from scocial networks into your website. This saves hosting space and bandwith. You can also use the media library built into Wordpress.
 * Version: 1.3.8
 * Author: elrond1369
 * Author URI: http://profiles.wordpress.org/elrond1369/
 * License: GPL2
 */ 
$NGDir = plugins_url().'/novas-gallery';
global $wpdb;
register_uninstall_hook($NGDir.'/uninstall.php', 'hello');
$table_name = $wpdb->prefix."NGFeeds";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	$sql = "CREATE TABLE $table_name (
		id int(55) NOT NULL AUTO_INCREMENT,
		feed varchar(55),
		type varchar(55),
		exclude varchar(55),
		UNIQUE KEY id (id)
	);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sqlText = dbDelta( $sql );
}
$table_name = $wpdb->prefix."NGLocal";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	$sql = "CREATE TABLE $table_name (
		id int(55) NOT NULL AUTO_INCREMENT,
		url varchar(255),
		UNIQUE KEY id (id)
	);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sqlText = dbDelta( $sql );
}
function NGAdminEnqueue($hook) {
	if ('toplevel_page_NGAdmin' != $hook) {
		return;
	}
	wp_enqueue_style('NGAdmin', plugins_url().'/novas-gallery/admin.css');
	wp_enqueue_script('NGAdmin', plugins_url().'/novas-gallery/admin.js');
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'NGAdminEnqueue');

function NGAdminPage() {
	global $wpdb;
	echo '<h2>Nova&#39s Gallery</h2><form id="donate" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<div id="overlay"><div id="NGstatus" class="NGstatus">Please Wait...</div></div>';
	require_once('admin-local.php');
	require_once('admin-feeds.php');
}
function NGAdminMenu() {
	add_menu_page("Nova's Gallery", "Nova's Gallery", 'read', 'NGAdmin.php', 'NGAdminPage');
}
add_action('admin_menu', 'NGAdminMenu');

function NGLoad($attr) {
	global $wpdb;
	$NGDir = plugins_url().'/novas-gallery/';
	$output = '';
	if ($attr['id']=="local") {
		$table_name = $wpdb->prefix."NGLocal";
		$results = $wpdb->get_results("SELECT * FROM $table_name");
		$selection = '';
		foreach ($results as $results) {
			$selection .= $results->url.',';
			
		}
		$selection = substr($selection, 0, strlen($selection)-1);
		wp_enqueue_script('jquery');
		wp_enqueue_style('gallery.css', $NGDir.'gallery.css');
		wp_enqueue_script('local.js', $NGDir.'local.js');
			$output .= '<div id="gallery" feedid="'.$selection.'"></div>';
			return $output;
	} else {
	$table_name = $wpdb->prefix."NGFeeds";
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($results as $results) {
		if($results->id==$attr['id']) {
			wp_enqueue_script('jquery');
			wp_enqueue_style('gallery.css', $NGDir.'gallery.css');
			wp_enqueue_script('feed.js', $NGDir.$results->type.'.js');
			$output .= '<div id="gallery" feedid="'.$results->feed.'" exclude="'.$results->exclude.'"></div>';
		}
	}
	return $output;
	}
}
add_shortcode('NG', 'NGload');