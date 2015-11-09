<?php
	/**
	 * Secret Session functions and definitions
	 *
	 * Set up the theme and provides some helper functions, which are used in the
	 * theme as custom template tags. Others are attached to action and filter
	 * hooks in WordPress to change core functionality.
	 *
	 * When using a child theme you can override certain functions (those wrapped
	 * in a function_exists() call) by defining them first in your child theme's
	 * functions.php file. The child theme's functions.php file is included before
	 * the parent theme's file, so the child theme functions would be used.
	 *
	 * @link       https://codex.wordpress.org/Theme_Development
	 * @link       https://codex.wordpress.org/Child_Themes
	 *
	 * Functions that are not pluggable (not wrapped in function_exists()) are
	 * instead attached to a filter or action hook.
	 *
	 * For more information on hooks, actions, and filters,
	 * {@link https://codex.wordpress.org/Plugin_API}
	 *
	 * @package    WordPress
	 * @subpackage Secret Session
	 * @author     shakir blouch
	 */
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * @author  shakir blouch
	 */

	if ( !isset($content_width)) {
		$content_width = 661;
	}
	/**
	 * Secret Session only works in WordPress 4.1 or later.
	 */
	if (version_compare($GLOBALS['wp_version'], '4.1-alpha', '<')) {
		require get_template_directory().'/inc/back-compat.php';
	}
	if ( !function_exists('secretsession_setup')) : /**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @author  shakir blouch
	 */ {
		function secretsession_setup() {
			/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on secretsession, use a find and replace
         * to change 'secretsession' to the name of your theme in all the template files
         */
			load_theme_textdomain('secretsession', get_template_directory().'/languages');
			// Add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');
			/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
			add_theme_support('title-tag');
			/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
			add_theme_support('post-thumbnails');
			set_post_thumbnail_size(825, 510, TRUE);
			// This theme uses wp_nav_menu() in two locations.
			register_nav_menus(array( 'primary' => __('Primary Menu', 'secretsession'), 'social' => __('Social Links Menu', 'secretsession'), ));
			/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
			add_theme_support('html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ));
			/*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
			add_theme_support('post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat' ));
			$color_scheme  = secretsession_get_color_scheme();
			$default_color = trim($color_scheme[0], '#');
			// Setup the WordPress core custom background feature.
			add_theme_support('custom-background', apply_filters('secretsession_custom_background_args', array( 'default-color' => $default_color, 'default-attachment' => 'fixed', )));
			/*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
			add_editor_style(array( 'css/editor-style.css', 'genericons/genericons.css', secretsession_fonts_url() ));
		}
	}
	endif; // secretsession_setup
	add_action('after_setup_theme', 'secretsession_setup');
	/**
	 * Register widget area.
	 *
	 * @author  shakir blouch
	 *
	 * @link    https://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	function secretsession_widgets_init() {
		register_sidebar(array( 'name' => __('Widget Area', 'secretsession'), 'id' => 'sidebar-1', 'description' => __('Add widgets here to appear in your sidebar.', 'secretsession'), 'before_widget' => '<aside id="%1$s" class="widget %2$s">', 'after_widget' => '</aside>', 'before_title' => '<h2 class="widget-title">', 'after_title' => '</h2>', ));
	}

	add_action('widgets_init', 'secretsession_widgets_init');
	if ( !function_exists('secretsession_fonts_url')) : /**
	 * Register Google fonts for Secret Session.
	 *
	 * @author  shakir blouch
	 *
	 * @return string Google fonts URL for the theme.
	 */ {
		function secretsession_fonts_url() {
			$fonts_url = '';
			$fonts     = array();
			$subsets   = 'latin,latin-ext';
			/* translators: If there are characters in your language that are not supported by Noto Sans, translate this to 'off'. Do not translate into your own language. */
			if ('off' !== _x('on', 'Noto Sans font: on or off', 'secretsession')) {
				$fonts[] = 'Noto Sans:400italic,700italic,400,700';
			}
			/* translators: If there are characters in your language that are not supported by Noto Serif, translate this to 'off'. Do not translate into your own language. */
			if ('off' !== _x('on', 'Noto Serif font: on or off', 'secretsession')) {
				$fonts[] = 'Noto Serif:400italic,700italic,400,700';
			}
			/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
			if ('off' !== _x('on', 'Inconsolata font: on or off', 'secretsession')) {
				$fonts[] = 'Inconsolata:400,700';
			}
			/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
			$subset = _x('no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'secretsession');
			if ('cyrillic' == $subset) {
				$subsets .= ',cyrillic,cyrillic-ext';
			} elseif ('greek' == $subset) {
				$subsets .= ',greek,greek-ext';
			} elseif ('devanagari' == $subset) {
				$subsets .= ',devanagari';
			} elseif ('vietnamese' == $subset) {
				$subsets .= ',vietnamese';
			}
			if ($fonts) {
				$fonts_url = add_query_arg(array( 'family' => urlencode(implode('|', $fonts)), 'subset' => urlencode($subsets), ), '//fonts.googleapis.com/css');
			}

			return $fonts_url;
		}
	}
	endif;
	/**
	 * Enqueue scripts and styles.
	 *
	 * @author  shakir blouch
	 */
	function secretsession_scripts() {
		// Add custom fonts, used in the main stylesheet.
		wp_enqueue_style('secretsession-fonts', secretsession_fonts_url(), array(), NULL);
		// Add Genericons, used in the main stylesheet.
		wp_enqueue_style('genericons', get_template_directory_uri().'/genericons/genericons.css', array(), '3.2');
		// Load our main stylesheet.
		wp_enqueue_style('secretsession-style', get_stylesheet_uri());
		// Load the Internet Explorer specific stylesheet.
		wp_enqueue_style('secretsession-ie', get_template_directory_uri().'/css/ie.css', array( 'secretsession-style' ), '20141010');
		wp_style_add_data('secretsession-ie', 'conditional', 'lt IE 9');
		// Load the Internet Explorer 7 specific stylesheet.
		wp_enqueue_style('secretsession-ie7', get_template_directory_uri().'/css/ie7.css', array( 'secretsession-style' ), '20141010');
		wp_style_add_data('secretsession-ie7', 'conditional', 'lt IE 8');
		wp_enqueue_script('secretsession-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array(), '20141010', TRUE);
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
		if (is_singular() && wp_attachment_is_image()) {
			wp_enqueue_script('secretsession-keyboard-image-navigation', get_template_directory_uri().'/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010');
		}
		wp_enqueue_script('secretsession-script', get_template_directory_uri().'/js/functions.js', array( 'jquery' ), '20141212', TRUE);
		wp_localize_script('secretsession-script', 'screenReaderText', array( 'expand' => '<span class="screen-reader-text">'.__('expand child menu', 'secretsession').'</span>', 'collapse' => '<span class="screen-reader-text">'.__('collapse child menu', 'secretsession').'</span>', ));
	}

	add_action('wp_enqueue_scripts', 'secretsession_scripts');
	/**
	 * Add featured image as background image to post navigation elements.
	 *
	 * @author  shakir blouch
	 *
	 * @see     wp_add_inline_style()
	 */
	function secretsession_post_nav_background() {
		if ( !is_single()) {
			return;
		}
		$previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(FALSE, '', TRUE);
		$next     = get_adjacent_post(FALSE, '', FALSE);
		$css      = '';
		if (is_attachment() && 'attachment' == $previous->post_type) {
			return;
		}
		if ($previous && has_post_thumbnail($previous->ID)) {
			$prevthumb = wp_get_attachment_image_src(get_post_thumbnail_id($previous->ID), 'post-thumbnail');
			$css .= '
			.post-navigation .nav-previous { background-image: url('.esc_url($prevthumb[0]).'); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
		}
		if ($next && has_post_thumbnail($next->ID)) {
			$nextthumb = wp_get_attachment_image_src(get_post_thumbnail_id($next->ID), 'post-thumbnail');
			$css .= '
			.post-navigation .nav-next { background-image: url('.esc_url($nextthumb[0]).'); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
		}
		wp_add_inline_style('secretsession-style', $css);
	}

	add_action('wp_enqueue_scripts', 'secretsession_post_nav_background');
	/**
	 * Display descriptions in main navigation.
	 *
	 * @author  shakir blouch
	 *
	 * @param string $item_output The menu item output.
	 * @param WP_Post $item       Menu item object.
	 * @param int $depth          Depth of the menu.
	 * @param array $args         wp_nav_menu() arguments.
	 *
	 * @return string Menu item with possible description.
	 */
	function secretsession_nav_description( $item_output, $item, $depth, $args ) {
		if ('primary' == $args->theme_location && $item->description) {
			$item_output = str_replace($args->link_after.'</a>', '<div class="menu-item-description">'.$item->description.'</div>'.$args->link_after.'</a>', $item_output);
		}

		return $item_output;
	}

	add_filter('walker_nav_menu_start_el', 'secretsession_nav_description', 10, 4);
	/**
	 * Add a `screen-reader-text` class to the search form's submit button.
	 *
	 * @author  shakir blouch
	 *
	 * @param string $html Search form HTML.
	 *
	 * @return string Modified search form HTML.
	 */
	function secretsession_search_form_modify( $html ) {
		return str_replace('class="search-submit"', 'class="search-submit screen-reader-text"', $html);
	}

	add_filter('get_search_form', 'secretsession_search_form_modify');
	function auto_login_new_user( $user_id ) {
		wp_set_current_user($user_id);
		wp_set_auth_cookie($user_id);
		// You can change home_url() to the specific URL,such as
		//wp_redirect( 'http://www.wpcoke.com' );
		wp_redirect(get_page_link(39));
		exit;
	}

	add_action('user_register', 'auto_login_new_user');
	function secretsession_get_gener( $data ) {
		$return      = '';
		$gener_array = array( 'POP', 'FOLK', 'ROCK', 'INDIE', 'ELECTRONIC', 'URBAN', 'ACOUSTIC', 'JAZZ', 'WORLD' );
		foreach ($gener_array as $row) {
			if ($data[$row] == 'YES') {
				$return .= ucfirst(strtolower($row)).',';
			}
		}

		return rtrim($return, ',');
	}

	function get_cimyFieldValue_fun( $field_name ) {
		global $wpdb, $wpdb_data_table, $wpdb_fields_table;
		$sql_field_value = "";
		if (( !isset($field_name))) {
			return NULL;
		}
		if ($field_name) {
			$field_name = strtoupper($field_name);
			$field_name = esc_sql($field_name);
		}
		$sql        = "SELECT efields.LABEL, efields.TYPE, efields.ID FROM ".$wpdb_fields_table." as efields WHERE efields.NAME='".$field_name."'";
		$field_data = $wpdb->get_results($sql, ARRAY_A);
		if (isset($field_data)) {
			if ($field_data != NULL) {
				$field_data = $field_data;
			}
		} else {
			return NULL;
		}
		if (($field_name)) {
			if (isset($field_data[0]['ID'])) {
				$field_data = $field_data[0]['ID'];
			} else {
				$field_data = "";
			}
		}

		return $field_data;
	}

	#get extra field data
	function secretsession_set_cimyFieldValue( $user_id, $field_name, $field_value ) {
		global $wpdb, $wpdb_data_table, $wpdb_fields_table;
		$users     = array();
		$results   = array();
		$radio_ids = array();
		if (empty($field_name)) {
			return $results;
		}
		$field_name = esc_sql(strtoupper($field_name));
		$sql        = "SELECT ID, TYPE, LABEL FROM $wpdb_fields_table WHERE NAME='$field_name'";
		$efields    = $wpdb->get_results($sql, ARRAY_A);
		if ($efields == NULL) {
			return $results;
		}
		$type = $efields[0]['TYPE'];
		if ($type == "radio") {
			foreach ($efields as $ef) {
				if ($ef['LABEL'] == $field_value) {
					$field_value = "selected";
					$field_id    = $ef['ID'];
				} else {
					$radio_ids[] = $ef['ID'];
				}
			}
			// if there are no radio fields with that label abort
			if ($field_value != "selected") {
				return $results;
			}
		} else {
			if ($type == "checkbox") {
				if (($field_value == "YES")) {
					$field_value = "YES";
				} else {
					$field_value = "NO";
				}
				$field_id = $efields[0]['ID'];
			} else {
				$field_id = $efields[0]['ID'];
			}
		}
		if ($user_id) {
			$user_id   = intval($user_id);
			$user_info = get_userdata($user_id);
			if ( !$user_info) {
				return $results;
			}
		} else {
			$sql   = "SELECT ID FROM $wpdb->users";
			$users = $wpdb->get_results($sql, ARRAY_A);
		}
		if (empty($users)) {
			$users[]["ID"] = $user_id;
		}
		$field_value = esc_sql($field_value);
		foreach ($users as $user) {
			if ( !current_user_can('edit_user', $user["ID"])) {
				continue;
			}
			$sql   = "SELECT ID FROM $wpdb_data_table WHERE FIELD_ID=$field_id AND USER_ID=".$user["ID"];
			$exist = $wpdb->get_var($sql);
			if ($exist == NULL) {
				$sql = "INSERT INTO $wpdb_data_table SET USER_ID=".$user["ID"].", VALUE='$field_value', FIELD_ID=$field_id";
			} else {
				$sql = "UPDATE $wpdb_data_table SET VALUE='$field_value' WHERE FIELD_ID=$field_id AND USER_ID=".$user["ID"];
			}
			$add_field_result = $wpdb->query($sql);
			if ($add_field_result > 0) {
				$results[]["USER_ID"] = $user["ID"];
			}
			if ($type == "radio") {
				if ( !empty($radio_ids)) {
					foreach ($radio_ids as $r_id) {
						$sql2        = "UPDATE $wpdb_data_table SET VALUE='' WHERE FIELD_ID=$r_id AND USER_ID=".$user["ID"];
						$result_sql2 = $wpdb->query($sql2);
					}
				}
			}
		}

		return $results;
	}

	#get other artist
	function    secretsession_get_other_artist( $user_id, $genre = '' ) {
		global $wpdb;
		//$genre	=	'';
		$users       = array();
		$user_id_1   = array();
		$user_id_2   = array();
		$users_1     = array();
		$users_2     = array();
		$users_3     = array();
		$user_id_all = array();
		if ($genre == '') {
			$sql     = "SELECT ID FROM wp_users where ID!=$user_id order by wp_users.ID limit 0,5";
			$users_3 = $wpdb->get_results($sql, ARRAY_A);
			if (count($users_3) > 0) {
				foreach ($users_3 as $key => $val) {
					$users[] = $val['ID'];
				}
			}
		} else {
			$genre   = explode(',', $genre);
			$genre_1 = $genre[0];
			$genre_1 = get_cimyFieldValue_fun(strtoupper($genre_1));
			$sql     = "SELECT USER_ID FROM wp_cimy_uef_data where (FIELD_ID=$genre_1 and VALUE='YES' ) ";
			$users_1 = $wpdb->get_results($sql, ARRAY_A);
			if (count($users_1) > 0) {
				foreach ($users_1 as $key => $val) {
					$user_id_1[] = $val['USER_ID'];
				}
			}
			if (count($genre) > 1) {
				$genre_2 = $genre[1];
				$genre_2 = get_cimyFieldValue_fun(strtoupper($genre_2));
				$sql     = "SELECT USER_ID FROM wp_cimy_uef_data where (FIELD_ID=$genre_2 and VALUE='YES' )";
				$users_2 = $wpdb->get_results($sql, ARRAY_A);
				if (count($users_2) > 0) {
					foreach ($users_2 as $key => $val) {
						$user_id_2[] = $val['USER_ID'];
					}
				}
				$user_id_all = array_intersect($user_id_1, $user_id_2);
			}
			$users = $user_id_all;
			if (count($users) < 5) {
				$users      = array_merge($users, $user_id_1);
				$user_count = count($users);
				if (count($users) < 5) {
					$users = array_merge($users, $user_id_2);
				}
				$users = array_unique($users);
				if (count($users) < 5) {
					$sql     = "SELECT ID FROM wp_users where ID!=$user_id order by wp_users.ID limit 0,5";
					$users_3 = $wpdb->get_results($sql, ARRAY_A);
					if (count($users_3 > 0)) {
						foreach ($users_3 as $key => $val) {
							$users[] = $val['ID'];
						}
					}
				}
				$users = array_unique($users);
			}
		}
		if (($key = array_search($user_id, $users)) !== FALSE) {
			unset($users[$key]);
		}
		$i = 0;
		if (count($users) > 0) {
			foreach ($users as $row) {
				$user = $wpdb->get_results("SELECT wp_cimy_uef_data.*,wp_cimy_uef_fields.NAME FROM wp_cimy_uef_data JOIN wp_cimy_uef_fields ON wp_cimy_uef_fields.ID=wp_cimy_uef_data.FIELD_ID where USER_ID=".$row);
				foreach ($user as $key => $val) {
					$user_data[$row][$val->NAME] = $val->VALUE;
				}
				if ($i == 4) {
					break;
				}
				$i++;
			}
		}

		return $user_data;
	}

	/* PHP */
	/**
	 * Images scaling
	 *
	 * @param string $ini_path  Path to initial image.
	 * @param string $dest_path Path to save new image.
	 * @param array $params     [optional] Must be an associative array of params
	 *                          $params['width'] int New image width.
	 *                          $params['height'] int New image height.
	 *                          $params['constraint'] array.$params['constraint']['width'],
	 *                          $params['constraint'][height] If specified the $width and $height params will be
	 *                          ignored. New image will be resized to specified value either by width or height.
	 *                          $params['aspect_ratio'] bool If false new image will be stretched to specified values.
	 *                          If true aspect ratio will be preserved an empty space filled with color $params['rgb']
	 *                          It has no sense for $params['constraint'].
	 *                          $params['crop'] bool If true new image will be cropped to fit specified dimensions. It
	 *                          has no sense for $params['constraint'].
	 *                          $params['rgb'] Hex code of background color. Default 0xFFFFFF.
	 *                          $params['quality'] int New image quality (0 - 100). Default 100.
	 *
	 * @return bool True on success.
	 */
	function img_resize( $ini_path, $dest_path, $params = array() ) {
		$width        = !empty($params['width']) ? $params['width'] : NULL;
		$height       = !empty($params['height']) ? $params['height'] : NULL;
		$constraint   = !empty($params['constraint']) ? $params['constraint'] : FALSE;
		$rgb          = !empty($params['rgb']) ? $params['rgb'] : 0xFFFFFF;
		$quality      = !empty($params['quality']) ? $params['quality'] : 100;
		$aspect_ratio = isset($params['aspect_ratio']) ? $params['aspect_ratio'] : TRUE;
		$crop         = isset($params['crop']) ? $params['crop'] : TRUE;
		if ( !file_exists($ini_path)) {
			return FALSE;
		}
		if ( !is_dir($dir = dirname($dest_path))) {
			mkdir($dir);
		}
		$img_info = getimagesize($ini_path);
		if ($img_info === FALSE) {
			return FALSE;
		}
		$ini_p = $img_info[0] / $img_info[1];
		if ($constraint) {
			$con_p  = $constraint['width'] / $constraint['height'];
			$calc_p = $constraint['width'] / $img_info[0];
			if ($ini_p < $con_p) {
				$height = $constraint['height'];
				$width  = $height * $ini_p;
			} else {
				$width  = $constraint['width'];
				$height = $img_info[1] * $calc_p;
			}
		} else {
			if ( !$width && $height) {
				$width = ($height * $img_info[0]) / $img_info[1];
			} else {
				if ( !$height && $width) {
					$height = ($width * $img_info[1]) / $img_info[0];
				} else {
					if ( !$height && !$width) {
						$width  = $img_info[0];
						$height = $img_info[1];
					}
				}
			}
		}
		preg_match('/\.([^\.]+)$/i', basename($dest_path), $match);
		$ext           = $match[1];
		$output_format = ($ext == 'jpg') ? 'jpeg' : $ext;
		$format        = strtolower(substr($img_info['mime'], strpos($img_info['mime'], '/') + 1));
		$icfunc        = "imagecreatefrom".$format;
		$iresfunc      = "image".$output_format;
		if ( !function_exists($icfunc)) {
			return FALSE;
		}
		$dst_x = $dst_y = 0;
		$src_x = $src_y = 0;
		$res_p = $width / $height;
		if ($crop && !$constraint) {
			$dst_w = $width;
			$dst_h = $height;
			if ($ini_p > $res_p) {
				$src_h = $img_info[1];
				$src_w = $img_info[1] * $res_p;
				$src_x = ($img_info[0] >= $src_w) ? floor(($img_info[0] - $src_w) / 2) : $src_w;
			} else {
				$src_w = $img_info[0];
				$src_h = $img_info[0] / $res_p;
				$src_y = ($img_info[1] >= $src_h) ? floor(($img_info[1] - $src_h) / 2) : $src_h;
			}
		} else {
			if ($ini_p > $res_p) {
				$dst_w = $width;
				$dst_h = $aspect_ratio ? floor($dst_w / $img_info[0] * $img_info[1]) : $height;
				$dst_y = $aspect_ratio ? floor(($height - $dst_h) / 2) : 0;
			} else {
				$dst_h = $height;
				$dst_w = $aspect_ratio ? floor($dst_h / $img_info[1] * $img_info[0]) : $width;
				$dst_x = $aspect_ratio ? floor(($width - $dst_w) / 2) : 0;
			}
			$src_w = $img_info[0];
			$src_h = $img_info[1];
		}
		$isrc  = $icfunc($ini_path);
		$idest = imagecreatetruecolor($width, $height);
		if (($format == 'png' || $format == 'gif') && $output_format == $format) {
			imagealphablending($idest, FALSE);
			imagesavealpha($idest, TRUE);
			imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
			imagealphablending($isrc, TRUE);
			$quality = 0;
		} else {
			imagefill($idest, 0, 0, $rgb);
		}
		imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		$res = $iresfunc($idest, $dest_path, $quality);
		imagedestroy($isrc);
		imagedestroy($idest);

		return $res;
	}

	# cleanup input
	function cleanInput( $input ) {
		$search = array( '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);
		$output = preg_replace($search, '', $input);

		return $output;
	}

	# Xss cleaning for input
	function sanitize( $input ) {
		if (is_array($input)) {
			foreach ($input as $var => $val) {
				$output[$var] = sanitize($val);
			}
		} else {
			if (get_magic_quotes_gpc()) {
				$input = stripslashes($input);
			}
			$output = cleanInput($input);
			// $output = mysql_real_escape_string($input);
		}

		return $output;
	}

	#get youtube video id from youtube url
	function    get_vido_data( $id = '' ) {
		global $wpdb;
		$return = FALSE;
		if ( !empty($id)) {
			$video_data = $wpdb->get_row($wpdb->prepare("select * from videos where id=%d", $id));
			if ($video_data) {
				$return  = $video_data;
				$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
				preg_match($pattern, $return->video_link, $matches);
				$return->vid_id = (isset($matches[1])) ? $matches[1] : FALSE;
			}
		}

		return $return;
	}

	#get video is liked or not
	function    get_video_like( $vid = '' ) {
		global $wpdb;
		//    $ip = get_client_ip();
		$return = 0;
		if ( !empty($vid)) {
			$return = $wpdb->get_row($wpdb->prepare("select count(id) as like_count from video_like where video_id=$vid", array( $vid )));
		}

		return $return;
	}

	function    get_video_like_with_ip( $vid = '' ) {
		global $wpdb;
		$ip = get_client_ip();
		$return = 0;
		if ( !empty($vid)) {
			$return = $wpdb->get_row($wpdb->prepare("select count(id) as like_count from video_like where video_id=%d and user_ip=%s", array( $vid,$ip)));
		}
		return $return;
	}



	#Chack if video is liked by his ip or not
	function    is_video_liked( $vid = '' ) {
		global $wpdb;
		$return = FALSE;
		$ip     = get_client_ip();
		if ( !empty($vid)) {
			$like_data = $wpdb->get_row($wpdb->prepare("select count(id) as like_count from video_like where user_ip=%s and video_id=$vid", array( $ip, $vid )));
			if ($like_data->like_count > 0) {
				$return = TRUE;
			}
		}

		return $return;
	}

	#Like functionlity for video
	function    do_like( $vid ) {
		global $wpdb;
		$ip        = get_client_ip();
		$like_data = $wpdb->get_row($wpdb->prepare("select count(id) as like_count from video_like where user_ip=%s and video_id=$vid", array( $ip, $vid )));
		if ($like_data->like_count > 0) {
			$return = TRUE;
		} else {
			$query = "INSERT INTO video_like (user_ip, video_id,timedate) VALUES ('%s','%d','%d')";
			$query = $wpdb->prepare("$query ", array( $ip, $vid, time() ));
			$wpdb->query($query);
		}
	}

	# get field id from extra field plugin
	function    get_field_id( $name = '' ) {
		global $wpdb;
		$field = $wpdb->get_row($wpdb->prepare("select id from wp_cimy_uef_fields where NAME=%s", array( strtoupper($name) )));
		if (count($field) > 0) {
			$return = $field->id;
		} else {
			$return = 0;
		}

		return $return;
	}

	#get gener to showunder the iser profile image
	function    get_gener( $id = '' ) {
		global $wpdb;
		$gener_array = array( 'POP', 'FOLK', 'ROCK', 'INDIE', 'ELECTRONIC', 'URBAN', 'ACOUSTIC', 'JAZZ', 'WORLD' );
		$return      = FALSE;
		if ( !empty($id)) {
			$i = 0;
			foreach ($gener_array as $row) {
				$gener = get_cimyFieldValue($id, $row);
				if ($gener == "YES") {
					$return .= ucfirst(strtolower($row)).',';
					$i++;
				}
				if ($i == 2) {
					break;
				}
			}
		}

		return rtrim($return, ',');
	}

	#ger clint IP address for vieo like
	function get_client_ip() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP']) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				if ($_SERVER['HTTP_X_FORWARDED']) {
					$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
				} else {
					if ($_SERVER['HTTP_FORWARDED_FOR']) {
						$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
					} else {
						if ($_SERVER['HTTP_FORWARDED']) {
							$ipaddress = $_SERVER['HTTP_FORWARDED'];
						} else {
							if ($_SERVER['REMOTE_ADDR']) {
								$ipaddress = $_SERVER['REMOTE_ADDR'];
							} else {
								$ipaddress = 'UNKNOWN';
							}
						}
					}
				}
			}
		}

		return $ipaddress;
	}

	#get twitter count using twitter count
	function getTweetCount( $url ) {
		$url             = urlencode($url);
		$twitterEndpoint = "http://urls.api.twitter.com/1/urls/count.json?url=%s";
		$fileData        = file_get_contents(sprintf($twitterEndpoint, $url));
		$json            = json_decode($fileData, TRUE);
		unset($fileData); // free memory
		return $json['count'];
	}

	#Search artist for discove page
	function ss_search_artist( $page = 0, $limit = 6 ) {
		global $wpdb;
		$profile_field_id = get_field_id('PROFILE_PHOTO');
		$query            = "select wp_users.ID as USER_ID from wp_users JOIN wp_cimy_uef_data ON wp_users.ID = wp_cimy_uef_data.USER_ID where FIELD_ID=$profile_field_id and VALUE!=''  order by wp_users.ID desc limit $page,$limit";
		if (isset($_POST['search_field']) && ( !empty($_POST['search_field']))) {
			$field_id = get_field_id('NAME');
			$query    = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID=$field_id and VALUE like '%%%s%%' limit $page,$limit", $_POST['search_field']);
		}
		if (isset($_GET['genre']) && ( !empty($_GET['genre']))) {
			if (strtolower($_GET['genre']) != 'all') {
				$field_id = get_field_id($_GET['genre']);
				$query    = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID='%d' and VALUE='YES' limit $page,$limit", strtoupper($field_id));
			}
		}
		if (isset($_GET['alpha']) && ( !empty($_GET['alpha']))) {
			if (strtolower($_GET['alpha']) != 'all') {
				$field_id = get_field_id('NAME');
				$query    = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID=$field_id and VALUE like '%s' limit $page,$limit", $_GET['alpha'].'%');
			}
		}
		if (isset($_GET['shuffle'])) {
			if (($_GET['shuffle'] == 1)) {
//				$query = "select id as USER_ID from wp_users order by RAND() limit $page,$limit";
				$query  = "select wp_users.ID as USER_ID from wp_users JOIN wp_cimy_uef_data ON wp_users.ID = wp_cimy_uef_data.USER_ID where FIELD_ID=$profile_field_id and VALUE!='' order by RAND() limit $page,$limit";
			} else {
				$field_id = get_field_id('NAME');
				$query    = $wpdb->prepare("select USER_ID from wp_cimy_uef_data where FIELD_ID='%d'  order by VALUE ASC limit $page,$limit", $field_id);
			}
		}
		$artsits = $wpdb->get_results($query);

		return $artsits;
	}

	#Search video for discover page
	function ss_search_video( $page = 0, $limit = 6 ) {
		global $wpdb;
		$query    = "select * from videos order by id desc limit $page,$limit";
		$field_id = get_field_id('NAME');
		if (isset($_POST['search_field']) && ( !empty($_POST['search_field']))) {
			$query = $wpdb->prepare("SELECT * from videos where user_id in (select wp_cimy_uef_data.USER_ID from wp_cimy_uef_data  where FIELD_ID='%d' and `VALUE` like '%%%s%%' group by wp_cimy_uef_data.USER_ID ) OR video_title like '%%%s%%' OR  ss_artist_name like '%%%s%%' limit $page,$limit", array( $field_id, $_POST['search_field'].'%', $_POST['search_field'].'%', $_POST['search_field'].'%' ));
		}
		if (isset($_GET['genre']) && ( !empty($_GET['genre']))) {
			if (strtolower($_GET['genre']) != 'all') {
				$sql      = "select id from wp_cimy_uef_fields  where NAME='%s'";
				$genre_id = $wpdb->get_row($wpdb->prepare("$sql ", array( strtoupper($_GET['genre']) )));
				$genre_id = $genre_id->id;
				$query    = "SELECT * from videos where user_id in (select wp_cimy_uef_data.USER_ID from wp_cimy_uef_data  where FIELD_ID='%d' and `VALUE`= '%s' group by wp_cimy_uef_data.USER_ID ) limit $page,$limit";
				$query    = $wpdb->prepare("$query ", array( $genre_id, 'YES' ));
			}
		}
		if (isset($_GET['alpha']) && ( !empty($_GET['alpha']))) {
			if (strtolower($_GET['alpha']) != 'all') {
				$query = $wpdb->prepare("SELECT * from videos where user_id in (select wp_cimy_uef_data.USER_ID from wp_cimy_uef_data  where FIELD_ID='%d' and `VALUE` like '%s' group by wp_cimy_uef_data.USER_ID ) OR video_title like '%s' OR  ss_artist_name like '%s' limit $page,$limit", array( $field_id, $_GET['alpha'].'%', $_GET['alpha'].'%', $_GET['alpha'].'%' ));
				//$query = $wpdb->prepare( "select * from videos  where video_title like '%s' limit $page,$limit" , $_GET[ 'alpha' ].'%' );
			}
		}
		if (isset($_GET['shuffle'])) {
			if (($_GET['shuffle'] == 1)) {
				$query = "select * from videos order by RAND() limit $page,$limit";
			} else {
				$query = "select * from videos order by video_title ASC limit $page,$limit";
			}
		}
		$videos = $wpdb->get_results($query);

		return $videos;
	}

	# Remove column from users listin from admin panel
	add_action('manage_users_columns', 'remove_user_posts_column');
	function remove_user_posts_column( $column_headers ) {
		unset($column_headers['posts']);
		unset($column_headers['name']);

		return $column_headers;
	}

	# Add new column in admin panel users lisitng
	add_filter('manage_users_columns', 'new_modify_user_table');
	function new_modify_user_table( $column ) {
		$column['name_by_plugin'] = 'Name';
		$column['tweet']          = 'Tweet Count';
		$column['share']          = 'Share Count';

		return $column;
	}

	#get data fro one row for user listing in admin panel
	add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);
	function new_modify_user_table_row( $val, $column_name, $user_id ) {
		$user = get_userdata($user_id);
		switch ($column_name) {
			case 'tweet' :
				$tweet = get_cimyFieldValue($user_id, 'TWEET_COUNT');
				if ($tweet) {
					return $tweet;
				} else {
					return 0;
				}
				break;
			case 'share' :
				$share = get_cimyFieldValue($user_id, 'FB_COUNT');
				if ($share) {
					return $share;
				} else {
					return 0;
				}
				break;
			case 'name_by_plugin' :
				$share = get_cimyFieldValue($user_id, 'NAME');
				if ($share) {
					return $share;
				} else {
					return '<center>0</center>';
				}
				break;
			default:
		}

		return $return;
	}

	#Soritng by custom column in admin panel user listing
	add_action('pre_user_query', 'wpse_27518_pre_user_query');
	function wpse_27518_pre_user_query( $user_search ) {
		global $wpdb, $current_screen, $query_string;
		if ('users' != $current_screen->id) {
			return;
		}
		$vars = $user_search->query_vars;
		if ('tweet' == $vars['orderby']) {
			$table = 'wp_cimy_uef_data';
			$user_search->query_from .= " LEFT JOIN {$table} m1 ON {$wpdb->users}.ID=m1.USER_ID AND (m1.FIELD_ID='20')";
			$user_search->query_orderby = ' ORDER BY (m1.VALUE)+0 '.$vars['order'];
		} elseif ('share' == $vars['orderby']) {
			$table = 'wp_cimy_uef_data';
			$user_search->query_from .= " LEFT JOIN {$table} m1 ON {$wpdb->users}.ID=m1.USER_ID AND (m1.FIELD_ID='21')";
			$user_search->query_orderby = ' ORDER BY (m1.VALUE)+0 '.$vars['order'];
		}
	}

	# Make culomn sortable in users listing
	add_filter('manage_users_sortable_columns', 'user_sortable_columns');
	function user_sortable_columns( $columns ) {
		$columns['tweet'] = 'tweet';
		$columns['share'] = 'share';

		return $columns;
	}

	#redirection after sent email from contact us page
	add_action('wpcf7_mail_sent', 'ip_wpcf7_mail_sent');
	function ip_wpcf7_mail_sent( $wpcf7 ) {
		wp_redirect(get_permalink(get_page_by_path('contact-thank-you')));
		exit;
	}

	#check for errors user profile update
	function    secret_session_validate_user_data() {
		$allowed = array( 'gif', 'png', 'jpg', 'jpeg' );
		$error   = '';
		if (  ! isset( $_POST['name_of_nonce_field'] ) || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) ) {
			$error .= '<p class="error">Sorry, your nonce did not verify.</p>';
		} 
		if (empty($_POST['artist_name'])) {
			$error .= '<p class="error"><b>Error</b>:Name field is empty.</p>';
		}
		if (empty($_POST['DESCRIPTION_USER'])) {
			$error .= '<p class="error"><b>Error</b>:Bio Text field is empty.</p>';
		}
		if (isset($_FILES['cover_photo']) && ( !empty($_FILES['cover_photo']['name']))) {
			$filename = $_FILES['cover_photo']['name'];
			$size     = $_FILES['cover_photo']['size'];
			$ext      = pathinfo($filename, PATHINFO_EXTENSION);
			$filename = $_FILES['cover_photo']['tmp_name'];
			list($width, $height) = getimagesize($filename);
			if ( !in_array(strtolower($ext), $allowed)) {
				$error .= '<p class="error"><b>Error</b>:Uploaded file type not allowed.</p>';
			} elseif ($size > 2097152) {
				$error .= '<p class="error"><b>Error</b>:Uploaded file is more the 2mb.</p>';
			} elseif ($width < 1100) {
				$error .= '<p class="error"><b>Error</b>:your image needs to be at least 1100 pixels wide.</p>';
			}
		}
		if (isset($_FILES['profile_photo']) && ( !empty($_FILES['profile_photo']['name']))) {
			$filename = $_FILES['profile_photo']['tmp_name'];
			list($width, $height) = getimagesize($filename);
			$filename = $_FILES['profile_photo']['name'];
			$ext      = pathinfo($filename, PATHINFO_EXTENSION);
			if ( !in_array(strtolower($ext), $allowed)) {
				$error .= '<p class="error"><b>Error</b>:Uploaded file type not allowed.</p>';
			} elseif ($size > 2097152) {
				$error .= '<p class="error"><b>Error</b>:Uploaded file is more the 2mb.</p>';
			} elseif ($width < 220) {
				$error .= '<p class="error"><b>Error</b>:your image needs to be at least 220 pixels wide.</p>';
			}
		} else {
			if ( !isset($_POST['profile_photo_set'])) {
				$error .= '<p class="error"><b>Error</b>:Profile photo is required.</p>';
			}
		}
		$video_link_count  = count(array_filter($_POST['youtube']));
		$video_title_count = count(array_filter($_POST['title']));
		if (($video_link_count > 0) || ($video_title_count > 0)) {
			$vider_error_index = 0;
			foreach ($_POST['youtube'] as $key => $val) {
				if (empty($val)) {
					$vider_error_index = 1;
					$error .= '<p class="error"><b>Error</b>:Video link is required for all the videos.</p>';
				}
				if (empty($_POST['title'][$key])) {
					$vider_error_index = 1;
					$error .= '<p class="error"><b>Error</b>:Video title is required for all the videos.</p>';
				}
				if (empty($_FILES['videoImage']['name'][$key])) {
					$vider_error_index = 1;
					$error .= '<p class="error"><b>Error</b>:Video image is required for all the videos.</p>';
				}
				if (filter_var($val, FILTER_VALIDATE_URL)) {
					$parse = parse_url($val);
					if ($parse['host'] != 'www.youtube.com') {
						$vider_error_index = 1;
						$error .= '<p class="error"><b>Error</b>:Only youtube url is allowed for video</p>';
					}
				} else {
					$vider_error_index = 1;
					$error .= '<p class="error"><b>Error</b>:Only youtube link is allowed for video</p>';
				}
				if ($vider_error_index == 1) {
					break;
				}
			}
		}
		if (isset($_POST['twitter']) && ( !empty($_POST['twitter']))) {
			$twitter = $_POST['twitter'];
			if (filter_var($twitter, FILTER_VALIDATE_URL)) {
				$parse = parse_url($twitter);
				if ($parse['host'] != 'twitter.com') {
					$error .= '<p class="error"><b>Error</b>:Only valid twitter link allowed</p>';
				}
			} else {
				$error .= '<p class="error"><b>Error</b>:Only valid twitter link allowed</p>';
			}
		}
		if (isset($_POST['soundcloud']) && ( !empty($_POST['soundcloud']))) {
			$soundcloud = $_POST['soundcloud'];
			if (filter_var($soundcloud, FILTER_VALIDATE_URL)) {
				$parse = parse_url($soundcloud);
				if ($parse['host'] != 'soundcloud.com') {
					$error .= '<p class="error"><b>Error</b>:Only valid soundcloud link allowed</p>';
				}
			} else {
				$error .= '<p class="error"><b>Error</b>:Only valid soundcloud link allowed</p>';
			}
		}
		if ( !isset($_POST['genre'])) {
			$error .= '<p class="error"><b>Error</b>: Please select at least one genre</p>';
		}

		return $error;
	}


	/* Determine how many words are in an excerpt and what the (Read More) link looks like */

	function new_excerpt_length($length) {
		return 70;
	}
	add_filter('excerpt_length', 'new_excerpt_length');

	function new_excerpt_more($post) {
		return '...';
	}
	add_filter('excerpt_more', 'new_excerpt_more');

	function excerpt($limit) {
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	  if (count($excerpt)>=$limit) {
	    array_pop($excerpt);
	    $excerpt = implode(" ",$excerpt).'...';
	  } else {
	    $excerpt = implode(" ",$excerpt);
	  }	
	  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  return $excerpt;
	}

	function check_user_ulr( $name = '', $i = 0 ,$user_id='' ) {
		global $current_user, $wp_roles, $wpdb;
		$name    = character_limiter($name, 15);
		if($user_id==''){
			$user_id = $current_user->data->ID;// Get user Id
		}
		$str     = strtolower($name);
		#remove special characters
		$str = preg_replace('/[^a-zA-Z0-9]/i', ' ', $str);
		#remove white space characters from both side
		$str = trim($str);
		#remove double or more space repeats between words chunk
		$str = preg_replace('/\s+/', ' ', $str);
		#fill spaces with hyphens
		$name          = preg_replace('/\s+/', '-', $str);
		$field_id      = get_cimyFieldValue_fun('URL_NAME');
		$url_set       = $wpdb->get_row("SELECT count(ID) as num,VALUE FROM wp_cimy_uef_data where FIELD_ID=$field_id and USER_ID=$user_id");
		$url_set_count = $url_set->num;
		if ($url_set_count == 0) {
			$result = $wpdb->get_row("SELECT count(ID) as num FROM wp_cimy_uef_data where FIELD_ID=$field_id and VALUE LIKE '%$name%'");
			$count  = $result->num;
			if ($count > 0) {
				$i++;

				return check_user_ulr($name.$i);
			} else {
				return $name;
			}
		} else {
			if($url_set->VALUE==''){

				$result = $wpdb->get_row("SELECT count(ID) as num FROM wp_cimy_uef_data where FIELD_ID=$field_id and VALUE LIKE '%$name%'");
				$count  = $result->num;
				if ($count > 0) {
					$i++;
	
					return check_user_ulr($name.$i);
				} else {
					return $name;
				}

			}
			
			return $url_set->VALUE;
		}
	}

	/**
	 *update frontend user data
	 */
	function    secret_session_save_user_data() {
		global $current_user, $wp_roles, $wpdb;
		if ( !function_exists('wp_handle_upload')) {
			require_once(ABSPATH.'wp-admin/includes/file.php');
		}
		get_currentuserinfo();// get user Info
		$gener   = array();
		$user_id = $current_user->data->ID;// Get user Id
		$result  = $wpdb->get_results("SELECT * FROM wp_cimy_uef_fields");
		foreach ($result as $print) {
			$extra_field[$print->NAME] = $print->ID;
		}
		if ( !empty($_POST['artist_name'])) {
			$extra_data['VALUE'][]    = $_POST['artist_name'];
			$extra_data['FIELD_ID'][] = $extra_field['NAME'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		$name_url                 = check_user_ulr($_POST['artist_name']);
		$extra_data['VALUE'][]    = $name_url;
		$extra_data['FIELD_ID'][] = $extra_field['URL_NAME'];
		$extra_data['USER_ID'][]  = $user_id;
		if ( !empty($_POST['DESCRIPTION_USER'])) {
			$extra_data['VALUE'][]    = $_POST['DESCRIPTION_USER'];
			$extra_data['FIELD_ID'][] = $extra_field['DESCRIPTION_USER'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		if (isset($_FILES['cover_photo']) && ( !empty($_FILES['cover_photo']['name']))) {
			$uploadedfile             = $_FILES['cover_photo'];
			$upload_overrides         = array( 'test_form' => FALSE );
			$cover_photo              = wp_handle_upload($uploadedfile, $upload_overrides);
			$extra_data['VALUE'][]    = $cover_photo['url'];
			$extra_data['FIELD_ID'][] = $extra_field['COVER_PHOTO'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = $cover_photo['file'];
			$extra_data['FIELD_ID'][] = $extra_field['IMAGE_PATH_COVER'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		if (isset($_FILES['profile_photo']) && ( !empty($_FILES['profile_photo']['name']))) {
			$uploadedfile     = $_FILES['profile_photo'];
			$upload_overrides = array( 'test_form' => FALSE );
			$PROFILE_PHOTO    = wp_handle_upload($uploadedfile, $upload_overrides);
			$arg1             = pathinfo($PROFILE_PHOTO['file']);         // $file is set to "index.php"
			$new_path         = $arg1['dirname'].'/thumb_pro_'.$arg1['basename'];
			$params           = array( 'width' => 220, 'height' => 220, 'aspect_ratio' => TRUE, 'rgb' => '0x000000', 'crop' => TRUE );
			img_resize($PROFILE_PHOTO['file'], $new_path, $params);
			$pars_url                 = parse_url($PROFILE_PHOTO['url']);
			$pars_name                = pathinfo($pars_url['path']);
			$save_image               = $pars_url['scheme'].'://'.$pars_url['host'].$pars_name['dirname'].'/thumb_pro_'.$pars_name['basename'];
			$extra_data['VALUE'][]    = $save_image;
			$extra_data['FIELD_ID'][] = $extra_field['PROFILE_PHOTO'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = $PROFILE_PHOTO['file'];
			$extra_data['FIELD_ID'][] = $extra_field['IMAGE_PATH_PROFILE'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		$video_link_count  = count(array_filter($_POST['youtube']));
		$video_title_count = count(array_filter($_POST['title']));
		if (($video_link_count > 0) || ($video_title_count > 0)) {
			foreach ($_FILES['videoImage']['tmp_name'] as $key => $tmp_name) {
				$upload_overrides         = array( 'test_form' => FALSE );
				$uploadedfile['name']     = $_FILES['videoImage']['name'][$key];
				$uploadedfile['type']     = $_FILES['videoImage']['type'][$key];
				$uploadedfile['tmp_name'] = $_FILES['videoImage']['tmp_name'][$key];
				$uploadedfile['error']    = $_FILES['videoImage']['error'][$key];
				$uploadedfile['size']     = $_FILES['videoImage']['size'][$key];
				$video_image              = wp_handle_upload($uploadedfile, $upload_overrides);
				$url                      = $video_image['url'];
				$parts                    = parse_url($url);
				$str                      = $parts['path'];
				$rootPath                 = $_SERVER['DOCUMENT_ROOT'];
				$image_path               = $rootPath.$str;
				$arg1                     = pathinfo($image_path);
				$new_path                 = $arg1['dirname'].'/show_video_small_'.$arg1['basename'];
				if ( !file_exists($new_path)) {
					$params = array( 'width' => 380, 'height' => 214, 'aspect_ratio' => TRUE, 'rgb' => '0x000000', 'crop' => TRUE );
					img_resize($image_path, $new_path, $params);
				}
				$video['title'][]      = $_POST['title'][$key];
				$video['link'][]       = $_POST['youtube'][$key];
				$video['image'][]      = $video_image['url'];
				$video['image_path'][] = $video_image['file'];
				$video['user_id'][]    = $user_id;
			}
		}
		if (isset($_POST['twitter'])) {
			$twitter                  = $_POST['twitter'];
			$extra_data['VALUE'][]    = htmlspecialchars($twitter);
			$extra_data['FIELD_ID'][] = $extra_field['TWITTER_EMDED_CODE'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		if (isset($_POST['soundcloud'])) {
			$soundcloud               = $_POST['soundcloud'];
			$extra_data['VALUE'][]    = htmlspecialchars($soundcloud);
			$extra_data['FIELD_ID'][] = $extra_field['SOUNDCLOUD_EMBED'];
			$extra_data['USER_ID'][]  = $user_id;
		}
		if ((isset($video['link'])) && ($error == '')) {
			$values        = array();
			$place_holders = array();
			$time          = time();
			$query         = "INSERT INTO videos (user_id, video_link, video_image,video_title,image_path,timedate) VALUES ";
			foreach ($video['link'] as $key => $vid) {
				$youtube_url = $video['link'][$key];
				array_push($values, $video['user_id'][$key], $video['link'][$key], $video['image'][$key], $video['title'][$key], $video['image_path'][$key], $time);
				$place_holders[] = "('%d', '%s','%s','%s','%s','%s')";
			}
			$query .= implode(', ', $place_holders);
			$vider_query = $wpdb->prepare("$query ", $values);
			$wpdb->query($vider_query);
		}
		$gener = @$_POST['genre'];
		if (count($gener) > 0) {
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['POP'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['FOLK'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['ROCK'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['INDIE'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['ELECTRONIC'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['URBAN'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['ACOUSTIC'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['JAZZ'];
			$extra_data['USER_ID'][]  = $user_id;
			$extra_data['VALUE'][]    = "NO";
			$extra_data['FIELD_ID'][] = $extra_field['WORLD'];
			$extra_data['USER_ID'][]  = $user_id;
			foreach ($gener as $gen) {
				$extra_data['VALUE'][]    = "YES";
				$extra_data['FIELD_ID'][] = $extra_field[$gen];
				$extra_data['USER_ID'][]  = $user_id;
			}
		}
		
		foreach ($extra_data['VALUE'] as $key => $val) {
			$field_name = array_search($extra_data['FIELD_ID'][$key], $extra_field);
			secretsession_set_cimyFieldValue($user_id, $field_name, $extra_data['VALUE'][$key]);
		}
		wp_redirect(home_url().'/artist/'.$name_url);
		//wp_redirect(get_permalink(get_page_by_path('user-profile-view')));
		exit;
	}

	add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
	function custom_wp_mail_from_name( $original_email_from ) {
		return 'Secret Sessions';
	}

	add_filter('wp_mail_from', 'new_mail_from');
	function new_mail_from( $old ) {
		return 'info@secretsessions.co.uk';
	}

	function character_limiter( $str, $n = 15, $end_char = '&#8230;' ) {
		if (strlen($str) < $n) {
			return $str;
		}
		$str = preg_replace("/\s+/", ' ', str_replace(array( "\r\n", "\r", "\n" ), ' ', $str));
		if (strlen($str) <= $n) {
			return $str;
		}
		$out = "";
		foreach (explode(' ', trim($str)) as $val) {
			$out .= $val.' ';
			if (strlen($out) >= $n) {
				$out = trim($out);

				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}
		}
	}

	function custom_rewrite_tag() {
		add_rewrite_tag('%urlname%', '([^&]+)');
		//  add_rewrite_tag('%variety%', '([^&]+)');
	}

	add_action('init', 'custom_rewrite_tag', 10, 0);
	function custom_rewrite_rule() {
		add_rewrite_rule('^artist/([^/]*)/?', 'index.php?page_id=70&urlname=$matches[1]', 'top'); //&variety=$matches[2] ///([^/]*)
	}

	add_action('init', 'custom_rewrite_rule', 10, 0);
	/*function custom_rewrite_basic() {
	  add_rewrite_rule('^artists/([a-zA-Z0-9_-]+)/?', 'index.php?page_id=70&url_name=$matches[1]', 'top');
	}
	add_action('init', 'custom_rewrite_basic');
	function custom_rewrite_tag() {
	  add_rewrite_tag('%url_name%', '([^&]+)');
//	  add_rewrite_tag('%variety%', '([^&]+)');
	}
	add_action('init', 'custom_rewrite_tag', 10, 0);*/
	function wpse_remove_edit_post_link( $link ) {
		return '';
	}

	add_filter('edit_post_link', 'wpse_remove_edit_post_link');
	/**
	 * Implement the Custom Header feature.
	 *
	 * @author  shakir blouch
	 */
	require get_template_directory().'/inc/custom-header.php';
	/**
	 * Custom template tags for this theme.
	 *
	 * @author  shakir blouch
	 */
	require get_template_directory().'/inc/template-tags.php';
	/**
	 * Customizer additions.
	 *
	 * @author  shakir blouch
	 */
	require get_template_directory().'/inc/customizer.php';

function tt($image,$width,$height){
	return bloginfo('template_url') . "/library/thumb.php?src=$image&w=$width&h=$height";
}

/* ................. CUSTOM POST TYPES .................... */
/* Below is an include to a default custom post type.*/
include(TEMPLATEPATH . '/library/post_types.php');