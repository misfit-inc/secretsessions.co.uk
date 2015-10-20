<?php
/**
 * Secret Session back compat functionality
 *
 * Prevents Secret Session from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */

/**
 * Prevent switching to Secret Session on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @author  shakir blouch
 */
function secretsession_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'secretsession_upgrade_notice' );
}
add_action( 'after_switch_theme', 'secretsession_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Secret Session on WordPress versions prior to 4.1.
 *
 * @author  shakir blouch
 */
function secretsession_upgrade_notice() {
	$message = sprintf( __( 'Secret Session requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'secretsession' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @author  shakir blouch
 */
function secretsession_customize() {
	wp_die( sprintf( __( 'Secret Session requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'secretsession' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'secretsession_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @author  shakir blouch
 */
function secretsession_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Secret Session requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'secretsession' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'secretsession_preview' );
