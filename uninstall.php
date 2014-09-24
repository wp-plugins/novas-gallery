<?php
global $wpdb;
$table_name = $wpdb->prefix.'NGLocal';
$wpdb->query("DROP TABLE IF EXISTS $table_name");
$table_name = $wpdb->prefix.'NGFeeds';
$wpdb->query("DROP TABLE IF EXISTS $table_name");