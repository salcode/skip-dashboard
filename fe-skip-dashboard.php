<?php
/**
 * Plugin Name: Iron Code Skip Dashboard
 * Plugin URI: http://salferrarello.com/skip-dashboard-wordpress-plugin/
 * Description: On login, users with access load the the backend wp-admin Posts list instead of the dashboard.  Those users who do not have access to that page (e.g. subscribers), load the dashboard as they always have.
 * Version: 0.1.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * Text Domain: skip-dashboard
 * Domain Path: /languages
 *
 * @package skip-dashboard
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'login_redirect', 'fe_skip_dashboard_login_redirect', 10, 3 );

if ( ! function_exists( 'fe_skip_dashboard_login_redirect' ) ) {
	/**
	 * Change the login redirect to the backend admin post listing page.
	 *
	 * @param string $url URL to redirect to.
	 * @param string $request URL the user is coming from.
	 * @param object $user Logged user's data.
	 *
	 * @return string $url - the URL to the backend admin post listing page.
	 */
	function fe_skip_dashboard_login_redirect( $url, $request, $user ) {

		if ( ! $user || is_wp_error( $user ) ) {
			return $url;
		}

		$required_capability = apply_filters( 'fe_skip_dashboard_required_capability', 'edit_posts' );
		$new_url = apply_filters( 'fe_skip_dashboard_new_url', admin_url( 'edit.php' ) );

		if ( user_can( $user, $required_capability ) ) {
			return $new_url;
		}

		return $url;
	}
}
