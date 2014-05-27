<?php
/**
 * Plugin Name: Nova's Gallery
 * Plugin URI: http://plugins.svn.wordpress.org/novas-gallery/
 * Description: Nova's Gallery places your photos from scocial networks into your website. This saves hosting space and bandwith. You can also use the media library built into Wordpress.
 * Version: 1.3.8
 * Author: Jacob Sommerfeld
 * Author URI: http://profiles.wordpress.org/elrond1369
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
		page varchar(55),
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

function NGAdminPage() {
	global $wpdb;
	$NGDir = plugins_url().'/novas-gallery';
	wp_enqueue_media();
	wp_enqueue_script('NGUploader', $NGDir.'/admin.js');
	echo '<h2>Nova&#39s Gallery</h2>';
	require_once('admin-local.php');
	require_once('admin-feeds.php');
}
function NGAdminMenu() {
	$NGDir = plugins_url().'/novas-gallery';
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
		$output .= '<link rel="stylesheet" href="'.$NGDir.'/gallery.css">';
			$output .= '<script src="'.$NGDir.'/local.js"></script><div id="gallery"></div>';
			$output .= "<script>gallery(id='".$selection."')</script>";
			echo $output;
	} else {
	$table_name = $wpdb->prefix."NGFeeds";
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($results as $results) {
		if($results->id==$attr['id']) {
			$output .= '<link rel="stylesheet" href="'.$NGDir.'/gallery.css">';
			$output .= '<script src="'.$NGDir.'/'.$results->type.'.js"></script><div id="gallery"></div>';
			$output .= "<script>gallery(id='".$results->feed."', exclude='".$results->exclude."')</script>";
		}
	}
	echo $output;
	}
}
add_shortcode('NG', 'NGload');