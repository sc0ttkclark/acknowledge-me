<?php
/*
 * Plugin Name: Acknowledge Me
 * Description: Shows contributors to a Github repo
 * Version:     0.2.2
 * Author:      Pods Framework Team
 * Author URI:  http://pods.io
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
/**
 * A Community Building Tool By Pods
 *
 * Based on the code for the underscores.me site: https://github.com/Automattic/underscores.me/, which is copyright Automattic, hugobaeta, kovshenin and GPL licensed.
 *
 * This plugin copyright 2015 Pods Foundation LLC. Licensed under the terms of the GPL v2 or later.
 */

/**
 * Output the contributors
 *
 * @since 0.0.1
 *
 * @param string $owner Owner (username or organization name) for repo
 * @param string $repo Repo name
 * @param bool|string $header_text Optional text to output before the contributors
 * @param int $total Optional. Total number of contributors to show. Default is 100.
 *
 * @returns string Rendered output
 */
function acknowledge_me_display( $owner, $repo, $header_text = false, $total = 100 ) {
	$contributors = acknowledge_me_get( $owner, $repo, $total );
	if ( ! is_array( $contributors ) || empty( $contributors ) ) {
		return;
	}

	$out[] =
		'<section id="contribute">
			<div class="wrap">';

	if ( is_string( $header_text ) ) {
		$out[] = sprintf( '<div id="header-text">%1s</div>', $header_text );
	}

	$out[] = '<ul id="team">';
	foreach ( $contributors as $contributor ) {

		$title      = sprintf( '@%s with %d %s', $contributor->login, $contributor->contributions, _n( 'contribution', 'contributions', $contributor->contributions ) );
		$url        = sprintf( 'http://github.com/%s', $contributor->login );
		$avatar_url = add_query_arg( 's', 280, $contributor->avatar_url );
		$avatar_url = add_query_arg( 'd', esc_url_raw( 'https://secure.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=280' ), $avatar_url );
		$out[]      = sprintf( '<li><a title="%1s" href="%2s"><img class="avatar" src="%3s" /></a></li>', esc_attr( $title ), esc_url( $url ), esc_url( $avatar_url ) );
	}
	$out[] = '</ul><!-- #team -->
			</div><!-- .wrap -->
	</section><!-- #contribute -->';

	if ( is_array( $out ) ) {
		return implode( '', $out );

	}

}

/**
 * Get contributors
 *
 * @since 0.0.1
 *
 * @param string $owner Owner (username or organization name) for repo
 * @param string $repo Repo name
 * @param bool|string $header_text Optional text to output before the contributors
 * @param int $total Optional. Total number of contributors to show. Default is 100.
 *
 * @return array|mixed
 */
function acknowledge_me_get( $owner, $repo, $total = 100 ) {
	$transient_key = md5( implode( '_', array( __FUNCTION__, $owner, $repo, $total ) ) );

	$contributors = get_transient( $transient_key );

	if ( false !== $contributors ) {
		return $contributors;
	}

	$url = "https://api.github.com/repos/{$owner}/{$repo}/contributors?per_page={$total}";
	$response = wp_remote_get( $url );
	if ( is_wp_error( $response ) ) {
		return array();

	}

	$contributors = json_decode( wp_remote_retrieve_body( $response ) );
	if ( ! is_array( $contributors ) ) {
		return array();

	}

	set_transient( $transient_key, $contributors, HOUR_IN_SECONDS );

	return (array) $contributors;

}

/**
 * Adds a shortcode for this
 *
 * @since 0.0.1
 */
add_shortcode( 'acknowledge_me', 'acknowledge_me_shortcode' );
function acknowledge_me_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'owner' => 'pods-framework',
		'repo' => 'pods',
		'header_text' => '',
		'total' => '100'
	), $atts, 'acknowledge_me' );

	return acknowledge_me_display( $atts[ 'owner' ], $atts[ 'repo' ], $atts[ 'header_text' ], $atts[ 'total'] );

}

/**
 * Add CSS for this
 *
 * @since 0.0.1
 */
add_action( 'wp_enqueue_scripts', 'acknowledge_me_css' );
function acknowledge_me_css() {
	if ( ! is_admin() ) {
		wp_enqueue_style( 'acknowledge_me', plugins_url( 'acknowledge.css', __FILE__ ) );
	}

}
