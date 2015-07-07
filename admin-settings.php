<?php
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

v1.0.0

**/


function bno_init() {
	register_setting( 'bno_option-settings', 'bno_email', 'bno_email_validate');
}

function bno_setup_menu(){
	add_options_page( 'Blighty Notify', 'Blighty Notify', 'manage_options', 'blighty-notify-plugin', 'bno_admin_settings' );
}

add_filter( 'plugin_action_links_blighty-notify/blighty-notify.php', 'bno_add_action_links' );

function bno_add_action_links ( $links ) {
	$url = '<a href="' . admin_url( 'options-general.php?page=blighty-notify-plugin' ) . '">Settings</a>';
	$mylinks = array( $url );
	return array_merge( $mylinks, $links );
}

function bno_admin_settings(){
?>
	<div class="wrap">
		<h2><?php echo BNO_PLUGIN_NAME; ?> version <?php echo BNO_PLUGIN_VERSION; ?></h2>
			<div id="poststuff" class="metabox-holder has-right-sidebar">
				<div class="inner-sidebar">
					<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
						<div class="postbox">
							<h3>Support This Plugin</h3>
							<div class="inside">
								If you find this plugin useful, please consider supporting it and future development. Thank you.<br /><br />
								<div align="center">
									<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
									<input type="hidden" name="cmd" value="_donations">
									<input type="hidden" name="business" value="2D9PDAS9FDDCA">
									<input type="hidden" name="lc" value="US">
									<input type="hidden" name="item_name" value="Blighty Notify Plugin">
									<input type="hidden" name="item_number" value="BNP001A">
									<input type="hidden" name="button_subtype" value="services">
									<input type="hidden" name="no_note" value="1">
									<input type="hidden" name="no_shipping" value="1">
									<input type="hidden" name="currency_code" value="USD">
									<input type="hidden" name="bn" value="PP-BuyNowBF:btn_donateCC_LG.gif:NonHosted">
									<input type="hidden" name="on0" value="website">
									<input type="hidden" name="os0" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
									<input type="radio" name="amount" value="0.99">$0.99&nbsp;
									<input type="radio" name="amount" value="2">$2&nbsp;
									<input type="radio" name="amount" value="5">$5&nbsp;
									<input type="radio" name="amount" value="10">$10&nbsp;
									<input type="radio" name="amount" value="">Other<br /><br />
									<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
									<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
									</form>
								</div>
							</div>
						</div>
						<div class="postbox">
							<h3>Technical Support</h3>
							<div class="inside">
								If you need technical support or would like to see a new featured implemented, please provide your feedback via the <a href="https://wordpress.org/support/plugin/blighty-notify">WordPress Plugin Forums</a>.
							</div>
						</div>
					</div>
				</div>

				<div id="post-body-content" class="has-sidebar-content">
					<div class="meta-box-sortabless">
						<div class="postbox">
							<h3>Configuration and Usage</h3>
							<div class="inside">
								<ol>
									<li>Use the shortcode <b>[bno_notify]</b> in your post or page. When the page is called, an email will be sent to the WordPress admin email, or an alternate email if specified in the options below.</li>
								</ol>
							</div>
						</div>
					</div>
					<div class="postbox">
						<h3>Options</h3>
						<div class="inside">
							<form method="post" action="options.php">
							<?php

							settings_fields('bno_option-settings');

							echo 'By default, emails are sent to this blog\'s admin email address (' .get_bloginfo('admin_email') .'). You can use an alternate address here for these notifications if you wish. <br /><br />';
							echo '<b>Alternate email address:</b>&nbsp;<input type="text" name="bno_email" value="' .esc_attr( get_option('bno_email') ) .'" />';

							submit_button();

							?>
							</form>
						</div>
					</div>
				</div>

				<?php echo BNO_PLUGIN_NAME; ?> version <?php echo BNO_PLUGIN_VERSION; ?> by <a href="http://blighty.net" target="_blank">Blighty</a>
			</div>

	</div>
<?php
}

function bno_email_validate($email) {

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		add_settings_error( 'bno_option-settings', 'invalid-email', 'You have entered an invalid email address.', "error" );
		return "";
	} else {
		return $email;
	}
}
?>
