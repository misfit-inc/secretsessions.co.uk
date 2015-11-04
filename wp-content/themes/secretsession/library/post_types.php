<?php
/**
 * Custom Post Types
 *
 * @package WordPress
 * @subpackage cebo
 * @since Dream Home 1.0
 */
 
///////////////////////////////////////////////////////////////////////////// Custom Post Type

add_action('init', 'project_items');

function project_items()
{
  $labels = array(
    'name' => _x('Portfolio Item', 'post type general name'),
    'singular_name' => _x('Portfolio Item', 'post type singular name'),
    'add_new' => _x('Add New', 'Portfolio Item'),
    'add_new_item' => __('Add New Portfolio Item'),
    'edit_item' => __('Edit Portfolio Item'),
    'new_item' => __('New Portfolio Item'),
    'view_item' => __('View Portfolio Item'),
    'search_items' => __('Search Portfolio Items'),
    'not_found' =>  __('No Portfolio Item found'),
    'not_found_in_trash' => __('No Portfolio Item found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'portfolio' ),
    'capability_type' => 'post',
    'menu_icon' => get_bloginfo('template_url').'/options/images/icon_project.png',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','custom-fields','editor','author','excerpt','comments','thumbnail')
  );
  register_post_type('project',$args);
}
add_action("manage_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-project_columns", "my_project_columns");

function my_project_columns($columns)
{
$columns = array(
 "cb" => "<input type=\"checkbox\" />",
 "title" => "Project Name",
 "projectthumb" => "Project Quick Look",
 );
 return $columns;
}

function my_custom_columns($column)
{
 global $post;
 $dater = get_post_meta($post->ID, 'cebo_dater');
 $link = get_post_meta($post->ID, 'cebo_link');
  $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full");
 if ("ID" == $column) echo $post->ID;
 elseif ("projectthumb" == $column) echo '<img src="' . $imgsrc[0] . '" width="150px"';
 elseif ("dater" == $column) echo $dater[0];
 elseif ("link" == $column) echo $link[0];
}


//create taxonomy for project type

create_type_taxonomies();

include(TEMPLATEPATH . '/options/secondary-panel.php'); 

function create_type_taxonomies()
{
  // Taxonomy for Location
  $labels = array(
    'name' => _x( 'Portfolio Item Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Portfolio Item Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Portfolio Item Types' ),
    'all_items' => __( 'All Portfolio Item Types' ),
    'parent_item' => __( 'Parent Portfolio Item Type' ),
    'parent_item_colon' => __( 'Parent Portfolio Item Type:' ),
    'edit_item' => __( 'Edit Portfolio Item Type' ),
    'update_item' => __( 'Update Portfolio Item Type' ),
    'add_new_item' => __( 'Add New Portfolio Item Type' ),
    'new_item_name' => __( 'New Portfolio Item Type Name' ),
  ); 	

  register_taxonomy('type', array('project'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'portfolio-type' ),
  ));

}


$parent_term = term_exists('type' ); // array is returned if taxonomy is given
$parent_term_id = $parent_term['term_id']; // get numeric term id
wp_insert_term(
  'Uncategorized', // the term 
  'type', // the taxonomy
  array(
    'description'=> 'uncategorized',
    'slug' => 'uncategorized',
    'parent'=> $parent_term_id
  )
);

add_action( 'init', 'creates_post_types' );
function creates_post_types() {
  register_post_type( 'slides',
    array(
      'labels' => array(
        'name' => __( 'Slides' ),
        'singular_name' => __( 'Slides' )
      ),
      'public' => true,
      'rewrite' => array('slug' => 'slides'),
      'menu_icon' => get_bloginfo('template_url').'/options/images/icon_team.png',
      'supports' => array('title','custom-fields','editor','category','author','thumbnail')
    )
  );
}

?>