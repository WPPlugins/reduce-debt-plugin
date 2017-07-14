<?php
/*
Plugin Name: Reduce Debt
Description: Mobilize your BuddyPress network to reduce debt.  This plugin allows BuddyPress users to input their loan amounts in order to chart their progress, receive Encourages from friends, earn Awards, receive monthly reminders to update their loan amounts, and determine their Debt Independence Day.

Version: 1.01 | By <a href="http://wordpress.org/extend/plugins/profile/beatingdebt">beatingdebt</ a> | <a href="http://reducedebtplugin.wordpress.com/">Visit Plugin Site</a>
*/

function my_plugin_init() {
    require( dirname( __FILE__ ) . '/debt.php' );
}
add_action( 'bp_include', 'my_plugin_init' );

$plugin_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
 
/* If you have code that does not need BuddyPress to run, then add it here. */
?>