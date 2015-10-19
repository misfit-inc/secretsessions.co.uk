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
		$_SESSION['msg']	=	'Video deleted successfully';
        break;
    case 'ssfeature':
		$data['ss_featured']	=	1;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video successfully made featured';
        break;
    case 'rssfeature':
		$data['ss_featured']	=	0;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'video remove from featured successfully';
        break;
    case 'feature':
		$data['is_featured']	=	1;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video successfully made featured';
        break;
    case 'rfeature':
		$data['is_featured']	=	0;
		$where['id']			=	$vid;
		$wpdb->update( $table, $data, $where );
		$_SESSION['msg']	=	'Video remove from featured successfully';
        break;
    default:
	wp_redirect(get_admin_url().'secret-sessions.php?pager='.$page); exit; 
}

	wp_redirect(get_admin_url().'secret-sessions.php?pager='.$page); exit; 
