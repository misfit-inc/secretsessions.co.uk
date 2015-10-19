<?php
/**
 * Dashboard Administration Screen
 *
 * @package WordPress
 * @subpackage Administration
 */
/** Load WordPress Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
$action		=	@$_GET['action'];
$page		=	@$_GET['pager'];
$vid		=	@$_GET['vid'];
$table		=	'videos';
switch ($action) {
    case 'delete':
		$where['id']	=	$vid;
		$wpdb->delete($table,$where);
		$_SESSION['msg']	=	'Video deleted seccessfully';
        break;
    case 'feature':
		$data['is_featured']	=	1;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video added in new videos seccessfully';
        break;
    case 'rfeature':
		$data['is_featured']	=	0;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video removed from new videos seccessfully';
        break;
    case 'liked':
		$data['is_liked']	=	1;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video make most liked seccessfully';
        break;
    case 'rliked':
		$data['is_liked']	=	0;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video removed from most liked seccessfully';
        break;
    default:
	wp_redirect(get_admin_url().'videos.php?pager='.$page); exit; 
}

	wp_redirect(get_admin_url().'videos.php?pager='.$page); exit; 
