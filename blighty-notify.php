<?php
/**
 * Plugin Name: Blighty Notify
 * Plugin URI: http://blighty.net/wordpress-blighty-notify-plugin/
 * Description: Send an email to the blog admin when a page is requested.
 * (C) 2015 Chris Murfin (Blighty)
 * Version: 1.0.0
 * Author: Blighty
 * Author URI: http://blighty.net
 * License: GPLv3 or later
 **/

/**

Copyright (C) 2015 Chris Murfin

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

**/

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');

define('BNO_PLUGIN_NAME', 'Blighty Notify');
define('BNO_PLUGIN_VERSION', '1.0.0');

define('BNO_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));


if ( is_admin() ){ // admin actions
	require_once(BNO_PLUGIN_DIR .'/admin-settings.php');
	add_action( 'admin_menu', 'bno_setup_menu' );
	add_action( 'admin_init', 'bno_init' );
}

add_shortcode( 'bno_notify', 'bno_notify' );

function bno_notify( $atts ) {

	$emailAddress = get_option('bno_email');

  if (empty($emailAddress)) {
    $emailAddress = get_bloginfo('admin_email');
  }

	$headers = 'From: ' .get_bloginfo('name') .' <' .get_bloginfo('admin_email') .'>' . "\r\n";
	$subj = '[' .get_bloginfo('name') .'] Page requested';
	$body = 'The page ' .$_SERVER['REQUEST_URI'] .' has been requested from ' .$_SERVER['REMOTE_ADDR'] .' - '
		.'User agent: ' .$_SERVER['HTTP_USER_AGENT'];
	wp_mail( $emailAddress, $subj, $body, $headers );

}
?>
