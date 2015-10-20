<?php
/**
 *
 * Allow users to update their profiles from Frontend.
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Secret Session
 * @author  shakir blouch
 */
require_once('../../../wp-config.php');
global $current_user, $wp_roles, $wpdb;
$user_id		=	$_POST['user_id'];
$shares_count	=	$_POST['shares_count'];
set_cimyFieldValue($user_id, 'FB_COUNT', $shares_count);
return true;
	