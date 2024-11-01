<?php
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit ();
global $wpdb;
$table_name = $wpdb->prefix."socialwaycpplugin";
$sql = "DROP TABLE ". $table_name;
$wpdb->query($sql);

$sql = "DROP TABLE ". $table_name."_countries";
$wpdb->query($sql);

$sql = "DROP TABLE ". $table_name."_pages";
$wpdb->query($sql);

$sql = "DROP TABLE ". $table_name."_btn";
$wpdb->query($sql);

$sql = "DROP TABLE ". $table_name."_widget";
$wpdb->query($sql);
?>