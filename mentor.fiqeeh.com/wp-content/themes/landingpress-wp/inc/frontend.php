<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function landingpress_get_nav_menu( $args = array() ) {

	if ( !isset( $args['theme_location'] ) )
		return;

	$transient_active = apply_filters( "landingpress_transient", false );

	$args['echo'] = false;

	$transient_name = 'landingpress_menu_'.$args['theme_location'];
	
	$html = $transient_active ? get_transient( $transient_name  ) : false;

	if( false === $html ) {
		if ( has_nav_menu( $args['theme_location'] ) ) {
			$html = wp_nav_menu( $args );
			if ( $transient_active ) {
				set_transient( $transient_name, $html, DAY_IN_SECONDS );
			}
		}
	}

	return $html;
}

add_action( 'excerpt_more', 'landingpress_excerpt_more' );
function landingpress_excerpt_more( $html ) {
	return ' &hellip;';
}

function landingpress_get_paginate_links( $query = '' ) { 

	if ( !$query ) {
		global $wp_query;
		$query = $wp_query;
	}

	if( isset( $query->max_num_pages ) && $query->max_num_pages <= 1 ) 
		return;

	$big = 999999999; // need an unlikely integer
	$links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'type' => 'list',
		'prev_next' => true,
		'prev_text' => esc_html__('&laquo; Previous', 'landingpress-wp'),
		'next_text' => esc_html__('Next &raquo;', 'landingpress-wp'),
	) );

	if ( $links )
		$links = '<nav class="navigation posts-navigation">'.$links.'</nav>';

	$links = str_replace( '/page/1"', '"', $links );
	$links = str_replace( "/page/1'", "'", $links );

	return apply_filters( "landingpress_posts_navigation", $links );
}

function landingpress_get_the_post_navigation() {
	
	$links = get_the_post_navigation();

	$links = str_replace( ' role="navigation"', '', $links );

	return apply_filters( "landingpress_post_navigation", $links );
}


function landingpress_get_entry_meta() {

	$meta = '';

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'landingpress-wp' ) );
		if ( $categories_list ) {
			$categories_list = str_replace( 'rel="category tag"', '', $categories_list );
			$meta .= '<span class="cat-links">' . $categories_list . '</span>';
			$meta .= '<span class="meta-sep">&middot;</span>';
		}
	}

	$time_string = '<span class="time-link"><time class="entry-date published updated" datetime="%1$s">%2$s</time></span>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<span class="time-link"><time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time></span>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$meta .= $time_string;

	if ( get_theme_mod( 'landingpress_post_comment' ) ) {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$meta .= '<span class="meta-sep">&middot;</span>';
			$meta .= '<span class="comments-link">';
			ob_start();
			comments_popup_link( esc_html__( 'Leave a comment', 'landingpress-wp' ), esc_html__( '1 Comment', 'landingpress-wp' ), esc_html__( '% Comments', 'landingpress-wp' ) );
			$meta .= ob_get_clean();
			$meta .= '</span>';
		}
	}

	ob_start();
	edit_post_link( esc_html__( 'Edit', 'landingpress-wp' ), '<span class="meta-sep">&middot;</span><span class="edit-link">', '</span>' );
	$meta .= ob_get_clean();

	return apply_filters( "landingpress_entry_meta", $meta );
}

function landingpress_get_the_term_list( $id, $taxonomy = 'post_tag', $before = '', $sep = '', $after = '' ) {
	$terms = get_the_terms( $id, $taxonomy );

	if ( is_wp_error( $terms ) )
		return $terms;

	if ( empty( $terms ) )
		return false;

	$links = array();

	foreach ( $terms as $term ) {
		$link = get_term_link( $term, $taxonomy );
		if ( is_wp_error( $link ) ) {
			return $link;
		}
		$links[] = '<a href="' . esc_url( $link ) . '">#' . $term->name . '</a>';
	}

	$term_links = apply_filters( "term_links-$taxonomy", $links );

	return $before . join( $sep, $term_links ) . $after;
}

if ( ! function_exists( 'landingpress_link_pages' ) ) :
function landingpress_link_pages() {
	add_filter( 'wp_link_pages_link', 'landingpress_link_pages_link' );
	wp_link_pages( array(
		'before' => '<nav class="page-links"><ul><li class="label">' . esc_html__( 'Pages:', 'landingpress-wp' ) . '</li>',
		'after'  => '</ul></nav>',
	) );
	remove_filter( 'wp_link_pages_link', 'landingpress_link_pages_link' );
}
endif;

if ( ! function_exists( 'landingpress_link_pages_link' ) ) :
function landingpress_link_pages_link( $link ) {
	if ( strpos($link, '</a>') === false ) 
		return '<li class="current"><span>' . $link . '</span></li>';
	else
		return '<li>' . $link . '</li>';
}
endif;

add_action( 'wp_head', 'landingpress_wp_head_seo_meta', 1 );
function landingpress_wp_head_seo_meta() {

	if ( defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') || class_exists('HeadSpace_Plugin') || class_exists('Platinum_SEO_Pack') || class_exists('SEO_Ultimate') )
		return;

	if ( !is_singular() )
		return;

	if ( '0' != get_option('blog_public') ) {
		$meta_index = get_post_meta( get_the_ID(), '_landingpress_meta-index', true );
		if ( !$meta_index ) {
			$meta_index = 'index';
		}
		$meta_follow = get_post_meta( get_the_ID(), '_landingpress_meta-follow', true );
		if ( !$meta_follow ) {
			$meta_follow = 'follow';
		}
		echo '<meta name="robots" content="'.esc_attr($meta_index).','.esc_attr($meta_follow).'"/>'.PHP_EOL;
	}

	$meta_description = get_post_meta( get_the_ID(), '_landingpress_meta-description', true );
	if ( $meta_description ) {
		echo '<meta name="description" content="'.esc_attr($meta_description).'"/>'.PHP_EOL;
	}

	$meta_keywords = get_post_meta( get_the_ID(), '_landingpress_meta-keywords', true );
	if ( $meta_keywords ) {
		echo '<meta name="keywords" content="'.esc_attr($meta_keywords).'"/>'.PHP_EOL;
	}

}

add_filter( 'pre_get_document_title', 'landingpress_document_title_seo_meta' );
function landingpress_document_title_seo_meta( $title ) {
	if ( defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') || class_exists('HeadSpace_Plugin') || class_exists('Platinum_SEO_Pack') || class_exists('SEO_Ultimate') )
		return $title;

	if ( !is_singular() )
		return $title;

	$meta_title = get_post_meta( get_the_ID(), '_landingpress_meta-title', true );
	if ( $meta_title ) {
		return $meta_title;
	}
	return $title;
}

add_action( 'wp_head', 'landingpress_wp_head_facebook_opengraph', 1 );
function landingpress_wp_head_facebook_opengraph() {

	if ( defined('WPSEO_VERSION') ) {
		return;
	}

	if ( defined('RANK_MATH_VERSION') ) {
		return;
	}

	if ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		return;
	}

	if ( get_theme_mod('landingpress_opengraph_disable') ) {
		return;
	}

	$facebook_image_default = get_theme_mod('landingpress_opengraph_image');

	echo '<meta property="og:type" content="website"/>'.PHP_EOL;

	echo '<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name' ) ).'"/>'.PHP_EOL;

	if ( is_singular() ) {

		echo '<meta property="og:url" content="'.get_permalink( get_the_ID() ).'"/>'.PHP_EOL;

		$facebook_image = '';
		$facebook_image_id = get_post_meta( get_the_ID(), '_landingpress_facebook-image', true );
		if ( !$facebook_image_id ) {
			$facebook_image_id = get_post_thumbnail_id();
		}
		if ( $facebook_image_id ) {
			$facebook_image = wp_get_attachment_url( $facebook_image_id );
		}
		if (empty($facebook_image) && !empty($facebook_image_default)) {
			$facebook_image = $facebook_image_default;
		}
		if ( $facebook_image ) {
			echo '<meta property="og:image" content="'.$facebook_image.'"/>'.PHP_EOL;
		}

		$facebook_title = get_post_meta( get_the_ID(), '_landingpress_facebook-title', true );
		if ( $facebook_title ) {
			echo '<meta property="og:title" content="'.esc_attr($facebook_title).'"/>'.PHP_EOL;
		}

		$facebook_description = get_post_meta( get_the_ID(), '_landingpress_facebook-description', true );
		if ( $facebook_description ) {
			echo '<meta property="og:description" content="'.esc_attr($facebook_description).'"/>'.PHP_EOL;
		}

	} 
	else {

		if ( !empty($facebook_image_default) ) {
			echo '<meta property="og:image" content="'.$facebook_image_default.'"/>'.PHP_EOL;
		}

	}

}

function landingpress_get_related_posts( $post_id ) {
	if ( !$post_id )
		return;

	global $wpdb, $post;

	$transient_active = apply_filters( "landingpress_transient", false );

	$transient_name = 'landingpress_related_' . $post_id;

	$related_posts  = $transient_active ? get_transient( $transient_name ) : false;

	// We want to query related posts if they are not cached
	if ( false === $related_posts ) {

		$number = 10;

		// Related products are found from category and tag
		$tags_array = array(0);
		$cats_array = array(0);
		$tags = '';
		$cats = '';

		// Get tags
		$terms = wp_get_post_terms($post_id, 'post_tag');
		foreach ($terms as $term) {
			$tags_array[] = $term->term_id;
		}
		$tags = implode(',', $tags_array);

		$terms = wp_get_post_terms($post_id, 'category');
		foreach ($terms as $term) {
			$cats_array[] = $term->term_id;
		}
		$cats = implode(',', $cats_array);

		$q = "
			SELECT p.ID
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p
			WHERE 
				p.ID != $post_id
				AND p.post_status = 'publish'
				AND p.post_type = 'post'
				AND
				(
					(
						tt.taxonomy ='category'
						AND tt.term_taxonomy_id = tr.term_taxonomy_id
						AND tr.object_id  = p.ID
						AND tt.term_id IN ($cats)
					)
					OR 
					(
						tt.taxonomy ='post_tag'
						AND tt.term_taxonomy_id = tr.term_taxonomy_id
						AND tr.object_id  = p.ID
						AND tt.term_id IN ($tags)
					)
				)
			GROUP BY tr.object_id
			ORDER BY RAND()
			LIMIT $number;";

		$related_posts = $wpdb->get_col($q);

		if ( $transient_active ) {
			set_transient( $transient_name, $related_posts, DAY_IN_SECONDS );
		}
	}

	return $related_posts;
}

add_action( 'init', 'landingpress_page_search', 99 );
function landingpress_page_search() {
	global $wp_post_types;
	if ( post_type_exists( 'page' ) ) {
		$wp_post_types['page']->exclude_from_search = true;
	}
}

add_filter('wp_nav_menu_items','landingpress_header_searchform', 10, 2);
function landingpress_header_searchform($items, $args) {
	if( get_theme_mod('landingpress_menu_search', '1') && $args->theme_location == 'header' ) {
		$form = get_search_form( false );
		$form = str_replace( ' role="search"', '', $form );
		$items .= '<li class="header-searchform">' . $form . '</li>';
	}
	return $items;
}

add_filter('prepend_attachment', 'landingpress_prepend_image');
function landingpress_prepend_image( $p ) {
	$post = get_post();

	if ( wp_attachment_is( 'image', $post ) ) {
		$p = '<p class="attachment">';
		$p .= wp_get_attachment_link(0, 'post-thumbnail', false);
		$p .= '</p>';
	}

	return $p;
}

function landingpress_get_image( $args = array() ) {
	$defaults = apply_filters( 'landingpress_get_image_defaults', array(
		'post_id' => null,
		'image_id' => null,
		'size' => 'post-thumbnail',
		'fallback' => null,
		'class' => 'entry-image',
		'alt' => null,
		'link' => false,
		'before' => '',
		'after' => '',
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	global $post;

	$html = '';
	$link_to = '';
	$link_class = $class ? $class.'-link' : '';

	$attr = array( 'class' => $class );
	if ( $alt ) {
		$attr['alt'] = $alt;
	}

	if ( !$post_id && $image_id ) {
		$html = wp_get_attachment_image( $image_id, $size, false, $attr );
	}
	else {
		if ( !$post_id ) {
			$post_id = $post->ID;
		}
		$image_id = get_post_thumbnail_id($post_id);
		if ( $image_id ) {
			$html = wp_get_attachment_image( $image_id, $size, false, $attr );
		}
	}

	if ( !$html && get_post_type( $post_id ) == 'post' && $fallback == 'attachment' ) {
		$image_ids = array_keys(
			get_children(
				array(
					'post_parent'    => $post->ID,
					'post_type'	     => 'attachment',
					'post_mime_type' => 'image',
					'orderby'        => 'menu_order',
					'order'	         => 'ASC',
				)
			)
		);
		if ( isset( $image_ids[0] ) ) {
			$image_id = $image_ids[0];
		}

		if ( $image_id ) {
			$html = wp_get_attachment_image( $image_id, $size, false, $attr );

			/* auto featured image */
			// if ( get_post_type() == 'post' ) {
			// 	set_post_thumbnail( $post, $id );
			// }
		}
	}

	if ( $html ) {

		if ( $link ) {
			if ( $link == 'post' ) {
				$link_to = $post_id ? get_permalink( $post_id ) : get_permalink();
			}
			elseif ( $link == 'attachment' ) {
				$link_to = $image_id ? get_permalink( $image_id ) : get_permalink();
			}
			elseif ( $link == 'image' ) {
				if ( $image_id ) {
					$link_to = wp_get_attachment_image_url( $image_id, 'full' );
				}
				elseif ( $post_id ) {
					$link_to = get_the_post_thumbnail_url( $post_id, 'full' );
				}
			}
			else {
				$link_to = esc_url( $link );
			}
		}

		if ( $link_to ) {
			$html = sprintf( '%s<a href="%s" class="%s">%s</a>%s', $before, $link_to, $link_class, $html, $after );
		}
		else {
			$html = sprintf( '%s %s %s', $before, $html, $after );
		}

	}

	return $html;
}

add_filter( 'get_the_archive_title', 'landingpress_get_the_archive_title' );
function landingpress_get_the_archive_title( $output ) {
	$output = str_replace( 'Category: ', '', $output );
	return $output;
}

add_action( 'wp_head', 'landingpress_output_style', 25 );
function landingpress_output_style() {
	$style = apply_filters( "landingpress_style", '' );
	if ( $style ) {
		if ( is_ssl() ) {
			$style = str_replace( 'http://', 'https://', $style );
		}
		echo '<style type="text/css">'.PHP_EOL.$style.PHP_EOL.'</style>'.PHP_EOL;
	}
}

add_filter( 'landingpress_style', 'landingpress_style_custom_background', 5 );
function landingpress_style_custom_background( $output ) {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color ) {
		if ( is_customize_preview() ) {
			echo '<style type="text/css" id="custom-background-css"></style>';
		}
		return;
	}

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = ' background-image: url("' . esc_url_raw( $background ) . '");';

		// Background Position.
		$position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		$position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

		if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
			$position_x = 'left';
		}

		if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
			$position_y = 'top';
		}

		$position = " background-position: $position_x $position_y;";

		// Background Size.
		$size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

		if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
			$size = 'auto';
		}

		$size = " background-size: $size;";

		// Background Repeat.
		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

		if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
			$repeat = 'repeat';
		}

		$repeat = " background-repeat: $repeat;";

		// Background Scroll.
		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

		if ( 'fixed' !== $attachment ) {
			$attachment = 'scroll';
		}

		$attachment = " background-attachment: $attachment;";

		$style .= $image . $position . $size . $repeat . $attachment;
	}

	$output .= 'body { '.trim( $style ).' } ';
	return $output;
}

add_filter( 'landingpress_style', 'landingpress_style_header_image', 5 );
function landingpress_style_header_image( $style ) {
	$placement = get_theme_mod( 'landingpress_header_placement' );
	if ( $placement == 'background_nologo' ) {
		$placement = 'background';
	}
	if ( $placement && 'background' != $placement ) {
		return $style;
	}
	$image = get_header_image();
	if ( $image ) {
		// $image = preg_replace( '#^(://|[^/])+#', '', $image );
		$style .= '.site-branding{background-image:url('.esc_url($image).')}';
	}
	return $style;
}

add_filter( 'landingpress_style', 'landingpress_style_svg_css', 5 );
function landingpress_style_svg_css( $style ) {
	$style .= 'svg { width: 1em; height: 1em; fill: currentColor; display: inline-block; vertical-align: middle; margin-top: -2px; } ';
	return $style;
}

add_action( 'wp_footer', 'landingpress_output_script', 99 );
function landingpress_output_script() {
	$script = apply_filters( "landingpress_script", '' );
	if ( $script ) {
		if ( function_exists( 'landingpress_minify_js' ) ) {
			$script = landingpress_minify_js( $script );
		}
		echo '<script type="text/javascript">'.PHP_EOL.$script.PHP_EOL.'</script>'.PHP_EOL;
	}
}

add_action( 'wp_head', 'landingpress_script_header', 99 );
function landingpress_script_header() {
	if ( !get_theme_mod('landingpress_script_header') )
		return;

	echo get_theme_mod('landingpress_script_header');
}

add_action( 'wp_footer', 'landingpress_script_footer', 99 );
function landingpress_script_footer() {
	if ( !get_theme_mod('landingpress_script_footer') )
		return;
	
	echo get_theme_mod('landingpress_script_footer');
}

function landingpress_get_contact_form() {
	$args = array(
		'email' => get_bloginfo('admin_email'),
		'subject' => esc_html__( 'Message via the contact form', 'landingpress-wp' ),
		'sendcopy' => 'yes',
		'question' => '',
		'answer' => '',
		'button_text' => esc_html__( 'Submit', 'landingpress-wp' )
	);
	extract( $args );
	if( trim($email) == '' )
		$email = get_bloginfo('admin_email');
	
	$html = '';
	$error_messages = array();
	$notification = false;
	$email_sent = false;
	if ( ( count( $_POST ) > 3 ) && isset( $_POST['submitted'] ) ) {
		if ( isset ( $_POST['checking'] ) && $_POST['checking'] != '' )
			$error_messages['checking'] = 1;
		if ( isset ( $_POST['contact-name'] ) && $_POST['contact-name'] != '' )
			$message_name = $_POST['contact-name'];
		else 
			$error_messages['contact-name'] = esc_html__( 'Please enter your name', 'landingpress-wp' );
		if ( isset ( $_POST['contact-email'] ) && $_POST['contact-email'] != '' && is_email( $_POST['contact-email'] ) )
			$message_email = $_POST['contact-email'];
		else 
			$error_messages['contact-email'] = esc_html__( 'Please enter your email address (and please make sure it\'s valid)', 'landingpress-wp' );
		if ( isset ( $_POST['contact-message'] ) && $_POST['contact-message'] != '' )
			$message_body = $_POST['contact-message'] . "\n\r\n\r";
		else 
			$error_messages['contact-message'] = esc_html__( 'Please enter your message', 'landingpress-wp' );
		if ( $question && $answer ) {
			if ( isset ( $_POST['contact-quiz'] ) && $_POST['contact-quiz'] != '' ) {
				$message_quiz = $_POST['contact-quiz']; 
				if ( esc_attr( $message_quiz ) != esc_attr( $answer ) )
					$error_messages['contact-quiz'] = esc_html__( 'Your answer was wrong!', 'landingpress-wp' );
			}
			else {
				$error_messages['contact-quiz'] = esc_html__( 'Please enter your answer', 'landingpress-wp' );
			}
		}
		if ( count( $error_messages ) ) {
			$notification = '<p class="contact-error">' . esc_html__( 'There were one or more errors while submitting the form.', 'landingpress-wp' ) . '</p>';
		} 
		else {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'])
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'])
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$message_body = esc_html__( 'Email:', 'landingpress-wp' ) . ' '. $message_email . "\r\n\r\n" . $message_body;
			$message_body = esc_html__( 'Name:', 'landingpress-wp' ) . ' '. $message_name . "\r\n" . $message_body;
			$message_body = $message_body."\r\n\r\n".esc_html__( 'IP Address:', 'landingpress-wp' ).$ipaddress . "\r\n" . esc_html__( 'User Agent:', 'landingpress-wp' ).$useragent;
			
			$headers = array();
			$headers[] = 'From: '.$message_name.' <' . $email . '>';
			$headers[] = 'Reply-To: '.$message_email;
			$email_sent = wp_mail($email, $subject, $message_body, $headers);
			
			if ( $sendcopy == 'yes' ) {
				// Send a copy of the e-mail to the sender, if specified.
				if ( isset( $_POST['send-copy'] ) && $_POST['send-copy'] == 'true' ) {
					$subject = esc_html__( '[COPY]', 'landingpress-wp' ) . ' ' . $subject;
					$headers = array();
					$headers[] = 'From: '.get_bloginfo('name').' <' . $email . '>';
					$headers[] = 'Reply-To: '.$email;
					$email_sent = wp_mail($message_email, $subject, $message_body, $headers);
				}
			}
			
			if( $email_sent == true ) {
				$notification = '<p class="contact-error">' . esc_html__( 'Your email was successfully sent.', 'landingpress-wp' ) . '</p>';
			}
			else {
				$notification = '<p class="contact-error">' . esc_html__( 'There were technical error while submitting the form. Sorry for the inconvenience.', 'landingpress-wp' ) . '</p>';
			}
	
		}
	}

	if( $email_sent == true ) {
		$html .= $notification;
	}
	else {
	
		$html .= '<div class="contact-form">' . PHP_EOL;
		$html .= $notification;
		if ( $email == '' ) {
			$html .= '<p class="contact-error">' . esc_html__( 'E-mail has not been setup properly. Please add your contact e-mail!', 'landingpress-wp' ) . '</p>';
		} 
		else {
			$html .= '<form action="" id="contact-form" method="post">' . PHP_EOL;
			$html .= '<fieldset class="forms">' . PHP_EOL;
			$contact_name = '';
			if( isset( $_POST['contact-name'] ) ) { $contact_name = $_POST['contact-name']; }
			$contact_email = '';
			if( isset( $_POST['contact-email'] ) ) { $contact_email = $_POST['contact-email']; }
			$contact_message = '';
			if( isset( $_POST['contact-message'] ) ) { $contact_message = stripslashes( $_POST['contact-message'] ); }
			
			$html .= '<p class="field-contact-name">' . PHP_EOL;
			$html .= '<input placeholder="' . esc_html__( 'Your Name', 'landingpress-wp' ) . '" type="text" name="contact-name" id="contact-name" value="' . esc_attr( $contact_name ) . '" class="txt requiredField" />' . PHP_EOL;
			if( array_key_exists( 'contact-name', $error_messages ) ) {
				$html .= '<span class="contact-error">' . $error_messages['contact-name'] . '</span>' . PHP_EOL;
			}
			$html .= '</p>' . PHP_EOL;

			$html .= '<p class="field-contact-email">' . PHP_EOL;
			$html .= '<input placeholder="' . esc_html__( 'Your Email', 'landingpress-wp' ) . '" type="text" name="contact-email" id="contact-email" value="' . esc_attr( $contact_email ) . '" class="txt requiredField email" />' . PHP_EOL;
			if( array_key_exists( 'contact-email', $error_messages ) ) {
				$html .= '<span class="contact-error">' . $error_messages['contact-email'] . '</span>' . PHP_EOL;
			}
			$html .= '</p>' . PHP_EOL;

			$html .= '<p class="field-contact-message">' . PHP_EOL;
			$html .= '<textarea placeholder="' . esc_html__( 'Your Message', 'landingpress-wp' ) . '" name="contact-message" id="contact-message" rows="10" cols="30" class="textarea requiredField">' . esc_textarea( $contact_message ) . '</textarea>' . PHP_EOL;
			if( array_key_exists( 'contact-message', $error_messages ) ) {
				$html .= '<span class="contact-error">' . $error_messages['contact-message'] . '</span>' . PHP_EOL;
			}
			$html .= '</p>' . PHP_EOL;

			if ( $question && $answer ) {
				$html .= '<p class="field-contact-quiz">' . PHP_EOL;
				$html .= $question.'<br/>' . PHP_EOL;
				$html .= '<input placeholder="' . esc_html__( 'Your Answer', 'landingpress-wp' ) . '" type="text" name="contact-quiz" id="contact-quiz" value="" class="txt requiredField quiz" />' . PHP_EOL;
				if( array_key_exists( 'contact-quiz', $error_messages ) ) {
					$html .= '<span class="contact-error">' . $error_messages['contact-quiz'] . '</span>' . PHP_EOL;
				}
				$html .= '</p>' . PHP_EOL;
			}
			
			if ( $sendcopy == 'yes' ) {
				$send_copy = '';
				if(isset($_POST['send-copy']) && $_POST['send-copy'] == true) {
					$send_copy = ' checked="checked"';
				}
				$html .= '<p class="inline"><input type="checkbox" name="send-copy" id="send-copy" value="true"' . $send_copy . ' />&nbsp;&nbsp;<label for="send-copy">' . __( 'Send a copy of this email to you', 'landingpress-wp' ) . '</label></p>' . PHP_EOL;
			}

			$checking = '';
			if(isset($_POST['checking'])) {
				$checking = $_POST['checking'];
			}

			$html .= '<p class="screen-reader-text"><label for="checking" class="screen-reader-text">' . esc_html__('If you want to submit this form, do not enter anything in this field', 'landingpress-wp') . '</label><input type="text" name="checking" id="checking" class="screen-reader-text" value="' . esc_attr( $checking ) . '" /></p>' . PHP_EOL;

			$html .= '<p class="buttons"><input type="hidden" name="submitted" id="submitted" value="true" /><input id="contactSubmit" type="submit" value="' . $button_text . '" /></p>';

			$html .= '</fieldset>' . PHP_EOL;
			$html .= '</form>' . PHP_EOL;

			$html .= '</div><!--/.post .contact-form-->' . PHP_EOL;

		}
	}
	return $html;
}
/**
 * Disable recent comments styling
 * http://www.narga.net/how-to-remove-or-disable-comment-reply-js-and-recentcomments-from-wordpress-header
 */
add_action( 'widgets_init', 'landingpress_remove_recent_comments_style' );
function landingpress_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

add_action( 'landingpress_content_before', 'landingpress_output_page_header' );
function landingpress_output_page_header() {
	if ( is_archive() ) {
		echo landingpress_get_breadcrumb();
		echo '<header class="page-header">';
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
		echo '</header>';
	}
	elseif ( is_search() ) {
		echo landingpress_get_breadcrumb();
		echo '<header class="page-header">';
		echo '<h1 class="page-title">'.sprintf( esc_html__( 'Search Results for: %s', 'landingpress-wp' ), '<span>' . get_search_query() . '</span>' ).'</h1>';
		echo '</header>';
	}
	else {
		echo landingpress_get_breadcrumb();
	}	
}

add_action( 'landingpress_entry_header_post_after', 'landingpress_output_share_social', 10 );
add_action( 'landingpress_entry_header_page_after', 'landingpress_output_share_social', 10 );
add_action( 'landingpress_entry_header_attachment_after', 'landingpress_output_share_social', 10 );
add_action( 'landingpress_entry_content_post_after', 'landingpress_output_share_social', 20 );
add_action( 'landingpress_entry_content_page_after', 'landingpress_output_share_social', 20 );
add_action( 'landingpress_entry_content_attachment_after', 'landingpress_output_share_social', 20 );
function landingpress_output_share_social() {

	$filter = current_filter();

	$show = false;
	if ( 'landingpress_entry_header_post_after' == $filter && get_theme_mod('landingpress_post_share_before', '0') ) {
		$show = true;
	}
	elseif ( 'landingpress_entry_content_post_after' == $filter && get_theme_mod('landingpress_post_share_after', '1') ) {
		$show = true;
	}
	elseif ( 'landingpress_entry_header_page_after' == $filter && get_theme_mod('landingpress_page_share_before', '0') ) {
		$show = true;
	}
	elseif ( 'landingpress_entry_content_page_after' == $filter && get_theme_mod('landingpress_page_share_after', '0') ) {
		$show = true;
	}
	elseif ( 'landingpress_entry_header_attachment_after' == $filter && get_theme_mod('landingpress_attachment_share_before', '0') ) {
		$show = true;
	}
	elseif ( 'landingpress_entry_content_attachment_after' == $filter && get_theme_mod('landingpress_attachment_share_after', '0') ) {
		$show = true;
	}

	if ( !$show ) {
		return;
	}

	$share_url = get_permalink();
	$share_title = get_the_title();
	$share_via = get_bloginfo( 'name' );
	$share_image = get_the_post_thumbnail_url( null, 'full' );

	echo '<div class="share-social">';
	echo '<span class="share-label">'.__( 'Share this', 'landingpress-wp' ).' <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M313.941 216H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h301.941v46.059c0 21.382 25.851 32.09 40.971 16.971l86.059-86.059c9.373-9.373 9.373-24.569 0-33.941l-86.059-86.059c-15.119-15.119-40.971-4.411-40.971 16.971V216z"/></svg></span>';
	echo '<a class="share-link share-facebook" rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.esc_url($share_url).'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg> Facebook</a>';
	echo '<a class="share-link share-twitter" rel="nofollow" target="_blank" href="https://twitter.com/intent/tweet?text='.urlencode($share_title).'&amp;url='.esc_url($share_url).'&amp;via='.urlencode($share_via).'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg> Twitter</a>';
	echo '<a class="share-link share-whatsapp" rel="nofollow" target="_blank" href="https://api.whatsapp.com/send?text='.rawurlencode($share_title.' '.$share_url).'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg> WhatsApp</a>';
	if ( $share_image ) {
		echo '<a class="share-link share-pinterest" rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/button/?url='.esc_url($share_url).'&amp;media='.esc_url($share_image).'&amp;description='.urlencode($share_title).'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg> Pin It</a>';
	}
	// echo '<a class="share-link share-buffer" rel="nofollow" target="_blank" href="https://bufferapp.com/add?url='.esc_url($share_url).'&amp;text='.urlencode($share_title).'">Buffer</a>';
	echo '</div>';
}

add_action( 'landingpress_entry_post_after', 'landingpress_output_related', 10 );
add_action( 'landingpress_entry_attachment_after', 'landingpress_output_related', 10 );
function landingpress_output_related() {
	if ( get_theme_mod( 'landingpress_'.get_post_type().'_related', '1' ) ) {
		get_template_part( 'related' );
	}
}

add_action( 'landingpress_entry_post_after', 'landingpress_output_comments_on', 20 );
function landingpress_output_comments_on() {
	if ( !landingpress_is_comments_active() )
		return;
	if ( get_theme_mod( 'landingpress_'.get_post_type().'_comments', '1' ) ) {
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}

add_action( 'landingpress_entry_page_after', 'landingpress_output_comments_off', 20 );
add_action( 'landingpress_entry_attachment_after', 'landingpress_output_comments_off', 20 );
function landingpress_output_comments_off() {
	if ( !landingpress_is_comments_active() )
		return;
	if ( get_theme_mod( 'landingpress_'.get_post_type().'_comments' ) ) {
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}

add_action( 'landingpress_site_content_before', 'landingpress_output_ads', 10 );
add_action( 'landingpress_site_content_after', 'landingpress_output_ads', 10 );
add_action( 'landingpress_entry_content_post_before', 'landingpress_output_ads', 10 );
add_action( 'landingpress_entry_content_post_after', 'landingpress_output_ads', 10 );
add_action( 'landingpress_entry_after_row1', 'landingpress_output_ads', 10 );
add_action( 'landingpress_entry_after_row2', 'landingpress_output_ads', 10 );
add_action( 'landingpress_entry_after_row3', 'landingpress_output_ads', 10 );
function landingpress_output_ads() {

	$output = '';
	$class = 'marketing-unit';
	$filter = current_filter();

	if ( 'landingpress_site_content_before' == $filter ) {
		$output = get_theme_mod('landingpress_ad_site_content_before');
		$class .= ' marketing-site-content-top';
	}
	elseif ( 'landingpress_site_content_after' == $filter ) {
		$output = get_theme_mod('landingpress_ad_site_content_after');
		$class .= ' marketing-site-content-bottom';
	}
	elseif ( 'landingpress_entry_content_post_before' == $filter ) {
		$output = get_theme_mod('landingpress_ad_post_content_before');
		$class .= ' marketing-post-content-top';
	}
	elseif ( 'landingpress_entry_content_post_after' == $filter ) {
		$output = get_theme_mod('landingpress_ad_post_content_after');
		$class .= ' marketing-post-content-bottom';
	}
	elseif ( 'landingpress_entry_after_row1' == $filter && !is_search() ) {
		$output = get_theme_mod('landingpress_ad_archive_row1_after');
		$class .= ' marketing-post-row';
	}
	elseif ( 'landingpress_entry_after_row2' == $filter && !is_search() ) {
		$output = get_theme_mod('landingpress_ad_archive_row2_after');
		$class .= ' marketing-post-row';
	}
	elseif ( 'landingpress_entry_after_row3' == $filter && !is_search() ) {
		$output = get_theme_mod('landingpress_ad_archive_row3_after');
		$class .= ' marketing-post-row';
	}

	if ( $output ) {
		printf( '<div class="%s">%s</div>', $class, $output );
	}

}

add_filter( 'post_class', 'landingpress_post_class', 50 );
function landingpress_post_class( $classes ) {
	if ( in_array( 'hentry', $classes ) ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		$classes[] = 'entry';
	}
	$image_opt = get_theme_mod( 'landingpress_archive_image', 'featured' );
	$content_opt = get_theme_mod( 'landingpress_archive_content' );	
	if ( !is_singular() && ( 'thumb-left' == $image_opt || 'thumb-right' == $image_opt ) && 'excerpt' == $content_opt ) {
		$classes[] = 'entry-summary';
	}
	return $classes;
}

add_action( 'wp', 'landingpress_simple_postviews_hits' );
function landingpress_simple_postviews_hits() {
 	if ( class_exists('AJAX_Hits_Counter') )
 		return;
 	if ( !is_singular() )
 		return;
	$post_ID = get_the_ID(); 	
    $count_key = 'hits'; 
    $count = get_post_meta($post_ID, $count_key, true);
    if ( '' == $count ){
        $count = 0;
        delete_post_meta($post_ID, $count_key);
        add_post_meta($post_ID, $count_key, '0');
    }
    else {
        $count++;
        update_post_meta($post_ID, $count_key, $count);
    }
}

function landingpress_is_sidebar_active() {
	return apply_filters( 'landingpress_is_sidebar_active', true );
}

function landingpress_is_header_active() {
	return apply_filters( 'landingpress_is_header_active', true );
}

function landingpress_is_menu_active() {
	return apply_filters( 'landingpress_is_menu_active', true );
}

function landingpress_is_footerwidgets_active() {
	return apply_filters( 'landingpress_is_footerwidgets_active', true );
}

function landingpress_is_footer_active() {
	return apply_filters( 'landingpress_is_footer_active', true );
}

function landingpress_is_breadcrumb_active() {
	return apply_filters( 'landingpress_is_breadcrumb_active', true );
}

function landingpress_is_title_active() {
	return apply_filters( 'landingpress_is_title_active', true );
}

function landingpress_is_comments_active() {
	return apply_filters( 'landingpress_is_comments_active', true );
}

add_action( 'body_class', 'landingpress_body_class_page_layout' );
function landingpress_body_class_page_layout( $classes ) {
	$page_layout = '';
	if ( get_theme_mod('landingpress_page_layout') == 'fullwidth' ) {
		$page_layout = 'page-landingpress-full-hf';
	}
	$page_layout = apply_filters( "landingpress_page_layout_class", $page_layout );
	if ( $page_layout ) {
		$classes[] = $page_layout;
	}
	if ( ! landingpress_is_sidebar_active() ) {
		$classes[] = 'page-sidebar-inactive';
	}
	return $classes;
}

add_action( 'body_class', 'landingpress_body_class_element_active' );
function landingpress_body_class_element_active( $classes ) {
	$classes[] = landingpress_is_header_active() ? 'header-active' : 'header-inactive';
	if ( landingpress_is_menu_active() && has_nav_menu( 'header' ) ) {
		$classes[] = 'header-menu-active';
		if ( get_theme_mod( 'landingpress_menu_sticky', '1' ) ) {
			$classes[] = 'header-menu-sticky';
		}
		if ( get_theme_mod( 'landingpress_menu_placement' ) == 'before' ) {
			$classes[] = 'header-menu-before';
		}
		else {
			$classes[] = 'header-menu-after';
		}
	}
	$classes[] = landingpress_is_footer_active() ? 'footer-active' : 'footer-inactive';
	return $classes;
}

add_action( 'wp', 'landingpress_page_layout_filter' );
function landingpress_page_layout_filter() {
	if ( is_admin() )
		return;
	if ( is_singular('post') || is_singular('page') ) {
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_sidebar', true ) ) {
			add_filter('landingpress_is_sidebar_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_header', true ) ) {
			add_filter('landingpress_is_header_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_menu', true ) ) {
			add_filter('landingpress_is_menu_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_footerwidgets', true ) ) {
			add_filter('landingpress_is_footerwidgets_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_footer', true ) ) {
			add_filter('landingpress_is_footer_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_breadcrumb', true ) ) {
			add_filter('landingpress_is_breadcrumb_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_title', true ) ) {
			add_filter('landingpress_is_title_active', '__return_false');
		}
		if ( 'yes' == get_post_meta( get_the_ID(), '_landingpress_hide_comments', true ) ) {
			add_filter('landingpress_is_comments_active', '__return_false');
		}
	}
	if ( get_theme_mod( 'landingpress_sidebar_hide' ) ) {
		add_filter('landingpress_is_sidebar_active', '__return_false');
	}
	if ( get_theme_mod( 'landingpress_header_hide' ) ) {
		add_filter('landingpress_is_header_active', '__return_false');
	}
	if ( get_theme_mod( 'landingpress_menu_hide' ) ) {
		add_filter('landingpress_is_menu_active', '__return_false');
	}
	if ( get_theme_mod( 'landingpress_footer_hide' ) ) {
		add_filter('landingpress_is_footer_active', '__return_false');
	}
}

add_action( 'template_redirect', 'landingpress_singular_redirect_url', 20 );
function landingpress_singular_redirect_url() {
	if ( ! is_singular() )
		return;
	$page_id = get_the_ID();
	$redirect = get_post_meta( $page_id, '_landingpress_redirect', true );
	if ( ! empty( $redirect ) ) {
		$redirect_type = get_post_meta( $page_id, '_landingpress_redirect_type', true );
		if ( !$redirect_type || $redirect_type == '301' ) {
			wp_redirect( esc_url_raw( $redirect ), 301 );
			exit;
		}
		elseif ( $redirect_type == '302' ) {
			wp_redirect( esc_url_raw( $redirect ), 302 );
			exit;
		}
	}
}

add_filter( 'template_include', 'landingpress_singular_redirect_template', 99 );
function landingpress_singular_redirect_template( $template ) {
	if ( ! is_singular() )
		return $template;
	$page_id = get_the_ID();
	$redirect = get_post_meta( $page_id, '_landingpress_redirect', true );
	if ( ! empty( $redirect ) ) {
		$redirect_type = get_post_meta( $page_id, '_landingpress_redirect_type', true );
		if ( in_array( $redirect_type, array( 'meta', 'javascript', 'iframe' ) ) ) {
			$new_template = locate_template( array( 'page_redirect.php' ) );
			if ( !empty( $new_template ) ) {
				return $new_template;
			}
		}
	}
	return $template;
}

add_action( 'body_class', 'landingpress_body_class_image_header_active' );
function landingpress_body_class_image_header_active( $classes ) {
	if ( get_theme_mod('landingpress_header_hide') ) {
		return $classes;
	}
	$header_background = get_theme_mod('landingpress_header_background');
	$header_image = get_header_image();
	$header_placement = get_theme_mod( 'landingpress_header_placement', 'background' );
	if ( $header_placement == 'background_nologo' ) {
		$header_placement = 'background';
	}
	if ( $header_image || $header_background ) {
		$classes[] = 'header-image-active';
	}
	return $classes;
}

add_action( 'landingpress_body_before', 'landingpress_body_skip_link' );
function landingpress_body_skip_link() {
?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'landingpress-wp' ); ?></a>
<?php 
}

function landingpress_facebook_pixel_set_ids( $ids = array() ) {
	global $landingpress_facebook_pixel_ids;
	$landingpress_facebook_pixel_ids = $ids;
}

function landingpress_facebook_pixel_get_ids() {
	global $landingpress_facebook_pixel_ids;
	return apply_filters( 'landingpress_facebook_pixel_ids', $landingpress_facebook_pixel_ids );
}

function landingpress_facebook_pixel_set_events( $events = array() ) {
	global $landingpress_facebook_pixel_events;
	if ( !is_array( $landingpress_facebook_pixel_events ) ) {
		$landingpress_facebook_pixel_events = array();
	}
	if ( is_array( $events ) && !empty( $events ) ) {
		$landingpress_facebook_pixel_events = array_merge( $landingpress_facebook_pixel_events, $events );
	}
}

function landingpress_facebook_pixel_get_events() {
	global $landingpress_facebook_pixel_events;
	return $landingpress_facebook_pixel_events;
}

function landingpress_facebook_pixel_remove_events() {
	global $landingpress_facebook_pixel_events;
	$landingpress_facebook_pixel_events = array();
}

add_action( 'wp_head', 'landingpress_wp_head_facebook_pixels_config', 5 );
function landingpress_wp_head_facebook_pixels_config() {

	$fb_pixel_ids = array();

	$fb_pixel_id = trim( get_theme_mod('landingpress_facebook_pixel_id') );
	if ( $fb_pixel_id ) {
		$fb_pixel_ids[$fb_pixel_id] = $fb_pixel_id;
	}

	for ($i=1; $i <= 5 ; $i++) { 
		$fb_pixel_id = trim( get_theme_mod('landingpress_facebook_pixel_id_'.$i) );
		if ( $fb_pixel_id ) {
			$fb_pixel_ids[$fb_pixel_id] = $fb_pixel_id;
		}
	}

	if ( is_singular() ) {
		$pixels = get_post_meta( get_the_ID(), '_landingpress_facebook-pixels', false );
		if ( !empty($pixels) && is_array($pixels) ) {
			foreach ($pixels as $pixel) {
				$fb_pixel_id = trim( $pixel['pixel_id'] );
				if ( $fb_pixel_id ) {
					$fb_pixel_ids[$fb_pixel_id] = $fb_pixel_id;
				}
			}
		}
	}

	landingpress_facebook_pixel_set_ids( $fb_pixel_ids );

	$fb_events = array();
	$fb_event = 'PageView';
	$fb_custom_event = '';
	$fb_data = array();
	if ( is_singular('post') || is_singular('page') ) {
		$fb_event_singular = get_post_meta( get_the_ID(), '_landingpress_facebook-event', true );
		if ( $fb_event_singular ) {
			$fb_event = $fb_event_singular;
		}
		$fb_data['source'] = 'landingpress-'.get_post_type();
		$fb_data['version'] = LANDINGPRESS_THEME_VERSION;
		$fb_data['campaign_url'] = get_queried_object()->post_name;
		$fb_data['content_name'] = get_the_title();
		$fb_event = apply_filters( 'landingpress_facebook_pixel_event', $fb_event );
		if ( $fb_event != '' && $fb_event != 'PageView' ) {
			$fb_value = get_post_meta( get_the_ID(), '_landingpress_facebook-param-value', true );
			if ( !$fb_value ) {
				$fb_value = '0.00';
			}
			$fb_currency = get_post_meta( get_the_ID(), '_landingpress_facebook-param-currency', true );
			if ( !$fb_currency ) {
				$fb_currency = 'IDR';
			}
			$fb_data['value'] = trim( $fb_value );
			$fb_data['currency'] = trim( $fb_currency );
			$fb_content_name = get_post_meta( get_the_ID(), '_landingpress_facebook-param-content_name', true );
			if ( trim( $fb_content_name ) ) {
				$fb_data['content_name'] = trim( $fb_content_name );
			}
			$fb_content_ids = get_post_meta( get_the_ID(), '_landingpress_facebook-param-content_ids', true );
			if ( trim( $fb_content_ids ) ) {
				$fb_content_type = get_post_meta( get_the_ID(), '_landingpress_facebook-param-content_type', true );
				if ( !$fb_content_type ) {
					$fb_content_type = 'product';
				}
				$fb_data['content_ids'] = array_map( 'trim', explode( ',', $fb_content_ids ) );
				$fb_data['content_type'] = trim( $fb_content_type );
			}
			$fb_custom_params = get_post_meta( get_the_ID(), '_landingpress_facebook-custom-params', false );
			if ( !empty($fb_custom_params) && is_array($fb_custom_params) ) {
				foreach ($fb_custom_params as $fb_custom_param) {
					$fb_custom_param_key = trim( $fb_custom_param['custom_param_key'] );
					$fb_custom_param_value = trim( $fb_custom_param['custom_param_value'] );
					if ( $fb_custom_param_key && $fb_custom_param_value ) {
						$fb_data[$fb_custom_param_key] = $fb_custom_param_value;
					}
				}
			}
		}
		if ( $fb_event != '' && $fb_event == 'custom' ) {
			$fb_custom_event_singular = get_post_meta( get_the_ID(), '_landingpress_facebook-custom-event', true );
			if ( trim( $fb_custom_event_singular ) ) {
				$fb_custom_event = trim( $fb_custom_event_singular );
			}
		}
	}

	$fb_events = array();

	$fb_events[] = array( 
		'event' => $fb_event,
		'custom_event' => $fb_custom_event,
		'data' => $fb_data,
	);

	landingpress_facebook_pixel_set_events( $fb_events );
}

add_action( 'wp_head', 'landingpress_wp_head_facebook_pixels', 100 );
function landingpress_wp_head_facebook_pixels() {
	$events = landingpress_facebook_pixel_get_events();
	landingpress_facebook_pixel_base_script( $events );
	landingpress_facebook_pixel_remove_events();
}

add_action( 'wp_footer', 'landingpress_wp_footer_facebook_pixels', 100 );
function landingpress_wp_footer_facebook_pixels() {
	landingpress_facebook_pixel_base_noscript();
	$events = landingpress_facebook_pixel_get_events();
	landingpress_facebook_pixel_inject_events( $events );
	landingpress_facebook_pixel_remove_events();
}

function landingpress_facebook_pixel_base_script( $events = array() ) {
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
<?php foreach ( $fb_pixel_ids as $fb_pixel_id ) : ?>
fbq('init', '<?php echo esc_attr( $fb_pixel_id ); ?>');
<?php endforeach; ?>
fbq('track', 'PageView', {
	"source": "landingpress",
	"version": "<?php echo LANDINGPRESS_THEME_VERSION; ?>"
});
<?php 
if ( !empty($events) ) :
	foreach ( $events as $key => $event ) :
		$fb_event = $event['event'];
		$fb_custom_event = $event['custom_event'];
		$fb_data = $event['data'];
		if ( $fb_event && $fb_event != 'PageView' ) :
			if ( $fb_event == 'custom' && $fb_custom_event ) :
?>
fbq('trackCustom', <?php echo landingpress_facebook_pixel_event_script( $fb_custom_event, $fb_data ); ?>);
<?php else : ?>
fbq('track', <?php echo landingpress_facebook_pixel_event_script( $fb_event, $fb_data ); ?>);
</script>
<?php 
			endif;
		endif;
	endforeach;
endif;
?>
</script>
<!-- End Facebook Pixel Code -->
<?php 
}

function landingpress_facebook_pixel_base_noscript() {
	if ( !get_theme_mod( 'landingpress_facebook_pixel_noscript', '1' ) ) {
		return;
	}
	$fb_pixel_ids = landingpress_facebook_pixel_get_ids();
	if ( empty( $fb_pixel_ids ) ) {
		return;
	}
	foreach ( $fb_pixel_ids as $fb_pixel_id ) {
?>
<!-- Facebook Pixel Code -->
<noscript><img height="1" width="1" alt="fbpx" style="display:none" src="https://www.facebook.com/tr?id=<?php echo esc_attr( $fb_pixel_id ); ?>&ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->
<?php 
	}
}

function landingpress_facebook_pixel_event_script( $fb_event = 'PageView', $fb_data = array() ) {
	if ( $fb_event == 'Purchase' && !isset( $fb_data['value'] ) ) {
		$fb_data['value'] = '0.00';
		$fb_data['currency'] = 'USD';
	}
	$fb_event_script = '"'.$fb_event.'"';
	if ( !empty( $fb_data ) && is_array( $fb_data ) ) {
		$fb_data_js = json_encode( $fb_data );
		$fb_data_js = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $fb_data_js);
		$fb_event_script .= ', '.$fb_data_js;
	}
	return $fb_event_script;
}

function landingpress_facebook_pixel_inject_events( $events ) {
	if ( empty($events) ) {
		return;
	}
	foreach ( $events as $key => $event ) {
		$fb_event = $event['event'];
		$fb_custom_event = $event['custom_event'];
		$fb_data = $event['data'];
		if ( $fb_event && $fb_event != 'PageView' ) {
			if ( $fb_event == 'custom' && $fb_custom_event ) {
?>
<script>
if ( typeof(fbq) != 'undefined' ) { 
	fbq('trackCustom', <?php echo landingpress_facebook_pixel_event_script( $fb_custom_event, $fb_data ); ?>);
}
</script>
<?php 
			}
			else {
?>
<script>
if ( typeof(fbq) != 'undefined' ) { 
	fbq('track', <?php echo landingpress_facebook_pixel_event_script( $fb_event, $fb_data ); ?>);
}
</script>
<?php 
			}
		}
	}
}

function landingpress_tiktok_pixel_set_ids( $ids = array() ) {
	global $landingpress_tiktok_pixel_ids;
	$landingpress_tiktok_pixel_ids = $ids;
}

function landingpress_tiktok_pixel_get_ids() {
	global $landingpress_tiktok_pixel_ids;
	return apply_filters( 'landingpress_tiktok_pixel_ids', $landingpress_tiktok_pixel_ids );
}

function landingpress_tiktok_pixel_set_events( $events = array() ) {
	global $landingpress_tiktok_pixel_events;
	if ( !is_array( $landingpress_tiktok_pixel_events ) ) {
		$landingpress_tiktok_pixel_events = array();
	}
	if ( is_array( $events ) && !empty( $events ) ) {
		$landingpress_tiktok_pixel_events = array_merge( $landingpress_tiktok_pixel_events, $events );
	}
}

function landingpress_tiktok_pixel_get_events() {
	global $landingpress_tiktok_pixel_events;
	return $landingpress_tiktok_pixel_events;
}

function landingpress_tiktok_pixel_remove_events() {
	global $landingpress_tiktok_pixel_events;
	$landingpress_tiktok_pixel_events = array();
}

add_action( 'wp_head', 'landingpress_wp_head_tiktok_pixels_config', 5 );
function landingpress_wp_head_tiktok_pixels_config() {

	$tt_pixel_ids = array();

	$tt_pixel_id = trim( get_theme_mod('landingpress_tiktok_pixel_id') );
	if ( $tt_pixel_id ) {
		$tt_pixel_ids[$tt_pixel_id] = $tt_pixel_id;
	}

	for ($i=1; $i <= 5 ; $i++) { 
		$tt_pixel_id = trim( get_theme_mod('landingpress_tiktok_pixel_id_'.$i) );
		if ( $tt_pixel_id ) {
			$tt_pixel_ids[$tt_pixel_id] = $tt_pixel_id;
		}
	}

	if ( is_singular() ) {
		$pixels = get_post_meta( get_the_ID(), '_landingpress_tiktok-pixels', false );
		if ( !empty($pixels) && is_array($pixels) ) {
			foreach ($pixels as $pixel) {
				$tt_pixel_id = trim( $pixel['pixel_id'] );
				if ( $tt_pixel_id ) {
					$tt_pixel_ids[$tt_pixel_id] = $tt_pixel_id;
				}
			}
		}
	}

	landingpress_tiktok_pixel_set_ids( $tt_pixel_ids );

	$tt_events = array();
	$tt_event = 'PageView';
	$tt_data = array();
	if ( is_singular('post') || is_singular('page') ) {
		$tt_event_singular = get_post_meta( get_the_ID(), '_landingpress_tiktok-event', true );
		if ( $tt_event_singular ) {
			$tt_event = $tt_event_singular;
		}
		$tt_event_with_params = ['ViewContent', 'AddToCart', 'InitiateCheckout', 'PlaceAnOrder', 'CompletePayment'];
		$tt_event = apply_filters( 'landingpress_tiktok_pixel_event', $tt_event );
		if ( $tt_event != '' && $tt_event != 'PageView' && in_array($tt_event, $tt_event_with_params) ) {
			$tt_value = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-value', true );
			$tt_value = floatval($tt_value);
			if ($tt_value > 0) {
				$tt_currency = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-currency', true );
				if ( !$tt_currency ) {
					$tt_currency = 'IDR';
				}
				$tt_data['value'] = $tt_value;
				$tt_data['currency'] = $tt_currency;
			}
			$tt_price = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-price', true );
			$tt_price = floatval($tt_price);
			if ($tt_price > 0) {
				$tt_quantity = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-quantity', true );
				$tt_quantity = intval($tt_quantity);
				if ( $tt_quantity < 1 ) {
					$tt_quantity = 1;
				}
				$tt_data['price'] = $tt_price;
				$tt_data['quantity'] = $tt_quantity;
			}
			$tt_content_name = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-content_name', true );
			if ( !empty( $tt_content_name ) ) {
				$tt_data['content_name'] = trim( $tt_content_name );
			}
			$tt_content_id = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-content_id', true );
			if ( !empty( $tt_content_id ) ) {
				$tt_data['content_id'] = trim( $tt_content_id );
			}
			$tt_content_type = get_post_meta( get_the_ID(), '_landingpress_tiktok-param-content_type', true );
			if ( !empty( $tt_content_type ) ) {
				$tt_data['content_type'] = trim( $tt_content_type );
			}
			// $tt_custom_params = get_post_meta( get_the_ID(), '_landingpress_tiktok-custom-params', false );
			// if ( !empty($tt_custom_params) && is_array($tt_custom_params) ) {
			// 	foreach ($tt_custom_params as $tt_custom_param) {
			// 		$tt_custom_param_key = trim( $tt_custom_param['custom_param_key'] );
			// 		$tt_custom_param_value = trim( $tt_custom_param['custom_param_value'] );
			// 		if (in_array($tt_custom_param_key, array('value', 'price'))) {
			// 			$tt_custom_param_value = floatval($tt_custom_param_value);
			// 		}
			// 		if ( $tt_custom_param_key && $tt_custom_param_value ) {
			// 			$tt_data[$tt_custom_param_key] = $tt_custom_param_value;
			// 		}
			// 	}
			// }
		}
	}

	$tt_events = array();

	$tt_events[] = array( 
		'event' => $tt_event,
		'data' => $tt_data,
	);

	landingpress_tiktok_pixel_set_events( $tt_events );
}

add_action( 'wp_head', 'landingpress_wp_head_tiktok_pixels', 100 );
function landingpress_wp_head_tiktok_pixels() {
	$events = landingpress_tiktok_pixel_get_events();
	landingpress_tiktok_pixel_base_script($events);
	landingpress_tiktok_pixel_remove_events();
}

add_action( 'wp_footer', 'landingpress_wp_footer_tiktok_pixels', 100 );
function landingpress_wp_footer_tiktok_pixels() {
	$events = landingpress_tiktok_pixel_get_events();
	landingpress_tiktok_pixel_inject_events( $events );
	landingpress_tiktok_pixel_remove_events();
}

function landingpress_tiktok_pixel_base_script( $events = array() ) {
	$tt_pixel_ids = landingpress_tiktok_pixel_get_ids();
	if ( empty( $tt_pixel_ids ) ) {
		return;
	}
?>
<!-- Tiktok Pixel Code -->
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
<?php foreach ( $tt_pixel_ids as $tt_pixel_id ) : ?>
ttq.load('<?php echo esc_attr( $tt_pixel_id ); ?>');
<?php endforeach; ?>
ttq.page();
<?php 
if (!empty($events)) :
	foreach ( $events as $key => $event ) :
		$tt_event = $event['event'];
		$tt_data = $event['data'];
		if ( $tt_event && $tt_event != 'PageView' ) : 
?>
ttq.track(<?php echo landingpress_tiktok_pixel_event_script( $tt_event, $tt_data ); ?>);
<?php 
		endif;
	endforeach;
endif;
?>
}(window, document, 'ttq');
</script>
<!-- Tiktok Pixel Code -->
<?php 
}

function landingpress_tiktok_pixel_event_script( $tt_event = 'PageView', $tt_data = array() ) {
	$tt_event_script = '"'.$tt_event.'"';
	if ( !empty( $tt_data ) && is_array( $tt_data ) ) {
		$tt_data_js = json_encode( $tt_data );
		$tt_data_js = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $tt_data_js);
		$tt_event_script .= ', '.$tt_data_js;
	}
	return $tt_event_script;
}

function landingpress_tiktok_pixel_inject_events( $events ) {
	if ( empty($events) ) {
		return;
	}
	foreach ( $events as $key => $event ) {
		$tt_event = $event['event'];
		$tt_data = $event['data'];
		if ( $tt_event && $tt_event != 'PageView' ) {
?>
<script>
if ( typeof(ttq) != 'undefined' ) { 
  ttq.track(<?php echo landingpress_tiktok_pixel_event_script( $tt_event, $tt_data ); ?>);
}
</script>
<?php 
		}
	}
}

function landingpress_adwords_set_ids( $ids = array() ) {
	global $landingpress_adwords_ids;
	$landingpress_adwords_ids = $ids;
}

function landingpress_adwords_get_ids() {
	global $landingpress_adwords_ids;
	return apply_filters( 'landingpress_adwords_ids', $landingpress_adwords_ids );
}

function landingpress_adwords_set_events( $events = array() ) {
	global $landingpress_adwords_events;
	if ( !is_array( $landingpress_adwords_events ) ) {
		$landingpress_adwords_events = array();
	}
	if ( is_array( $events ) && !empty( $events ) ) {
		$landingpress_adwords_events = array_merge( $landingpress_adwords_events, $events );
	}
}

function landingpress_adwords_get_events() {
	global $landingpress_adwords_events;
	return $landingpress_adwords_events;
}

function landingpress_adwords_remove_events() {
	global $landingpress_adwords_events;
	$landingpress_adwords_events = array();
}

add_action( 'wp_head', 'landingpress_wp_head_adwords_config', 5 );
function landingpress_wp_head_adwords_config() {

	$adwords_ids = array();
	$adwords_events = array();

	$adwords_id = trim( get_theme_mod('landingpress_adwords_global_site_tag_id') );
	if ( $adwords_id ) {
		if ( strpos( $adwords_id, 'AW-' ) === false ) {
			$adwords_id = 'AW-'.$adwords_id;
		}
		$adwords_ids[$adwords_id] = $adwords_id;
	}

	for ($i=1; $i <= 5 ; $i++) { 
		$adwords_id = trim( get_theme_mod('landingpress_adwords_global_site_tag_id_'.$i) );
		if ( $adwords_id ) {
			if ( strpos( $adwords_id, 'AW-' ) === false ) {
				$adwords_id = 'AW-'.$adwords_id;
			}
			$adwords_ids[$adwords_id] = $adwords_id;
		}
	}

	if ( is_singular() ) {
		$adwords_conversions = get_post_meta( get_the_ID(), '_landingpress_adwords-conversions', false );
		if ( !empty($adwords_conversions) && is_array($adwords_conversions) ) {
			foreach ($adwords_conversions as $adwords_conversion) {
				if ( isset($adwords_conversion['send_to']) && $adwords_conversion['send_to'] ) {
					$send_to = $adwords_conversion['send_to'];
					$send_to2 = explode( '/', $send_to );
					if ( isset( $send_to2[0] ) && strpos($send_to2[0], 'AW-') !== false ) {
						$adwords_ids[$send_to2[0]] = trim( $send_to2[0] );
						$adwords_events[$send_to] = $adwords_conversion;
					}						
				}
			}
		}
	}

	landingpress_adwords_set_ids( $adwords_ids );
	landingpress_adwords_set_events( $adwords_events );
}

add_action( 'wp_head', 'landingpress_wp_head_adwords', 100 );
function landingpress_wp_head_adwords() {
	landingpress_adwords_base_script();
	$events = landingpress_adwords_get_events();
	landingpress_adwords_inject_events( $events );
	landingpress_adwords_remove_events();
}

add_action( 'wp_footer', 'landingpress_wp_footer_adwords', 100 );
function landingpress_wp_footer_adwords() {
	$events = landingpress_adwords_get_events();
	landingpress_adwords_inject_events( $events );
	landingpress_adwords_remove_events();
}

function landingpress_adwords_base_script() {
	$adwords_base_id = '';
	$analytics_id = '';

	$analytics_id = get_theme_mod('landingpress_google_analytics_id');
	$analytics_id = trim( $analytics_id );
	if ( !empty( $analytics_id )  ) {
		$analytics_tag = get_theme_mod('landingpress_google_analytics_tag', 'new');
		if ( substr( $analytics_id, 0, 2 ) === "G-" ) {
			$analytics_tag = 'new';
		}
		if ( 'old' != $analytics_tag ) {
			$adwords_base_id = $analytics_id;
		}
	}

	$adwords_ids = landingpress_adwords_get_ids();
	if ( !$adwords_base_id && !empty( $adwords_ids ) ) {
		foreach ( $adwords_ids as $adwords_id ) {
			$adwords_base_id = $adwords_id;
			break;
		}
	}

	if ( !$adwords_base_id ) {
		return;
	}
?>
<!-- Global site tag (gtag.js) - Google Ads (AdWords) & Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $adwords_base_id ); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo esc_attr( $adwords_base_id ); ?>');
<?php 
if ( !empty( $adwords_ids ) ) {
	foreach ( $adwords_ids as $adwords_id ) {
		if ( $adwords_id != $adwords_base_id ) {
?>
  gtag('config', '<?php echo esc_attr( $adwords_id ); ?>');
<?php 
		}
	}
}
?>
</script>
<!-- End Global site tag (gtag.js) - Google Ads (AdWords) & Analytics -->
<?php
}

function landingpress_adwords_inject_events( $events ) {
	if ( empty($events) ) {
		return;
	}
	foreach ( $events as $send_to => $event ) {
		foreach ( $event as $key => $value ) {
			if ( $key == 'value' ) {
				$event[$key] = (float)$value;
			}
		}
?>
<!-- Event snippet for Conversion Tracking -->
<script>
  gtag('event', 'conversion', <?php echo json_encode($event,JSON_UNESCAPED_SLASHES); ?>);
</script>
<!-- End Event snippet for Conversion Tracking -->
<?php 
	}
}

add_action( 'wp_head', 'landingpress_wp_head_google_analytics_old', 107 );
function landingpress_wp_head_google_analytics_old() {
	$ga_id = get_theme_mod('landingpress_google_analytics_id');
	if ( !$ga_id )
		return;
	$ga_id = trim( $ga_id );
	$ga_type = get_theme_mod('landingpress_google_analytics_tag', 'new');
	if ( substr( $ga_id, 0, 2 ) === "G-" ) {
		$ga_type = 'new';
	}
	if ( 'old' != $ga_type )
		return; 
?>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', '<?php echo esc_attr( $ga_id ); ?>', 'auto');
  ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<?php
}

add_action( 'wp_head', 'landingpress_wp_head_google_tag_manager', 105 );
function landingpress_wp_head_google_tag_manager() {
	$gtm_id = get_theme_mod('landingpress_google_tag_manager_id');
	if ( !$gtm_id )
		return;
	$gtm_id = trim( $gtm_id );
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_attr( $gtm_id ); ?>');</script>
<!-- End Google Tag Manager -->
<?php
}

add_action( 'landingpress_body_before', 'landingpress_body_google_tag_manager', 5 );
function landingpress_body_google_tag_manager() {
	if ( ! get_theme_mod('landingpress_google_tag_manager_noscript') ) {
		return;
	}
	$gtm_id = get_theme_mod('landingpress_google_tag_manager_id');
	if ( !$gtm_id )
		return;
	$gtm_id = trim( $gtm_id );
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
}

if ( class_exists('djv_landingpro') ) {
	add_action( 'parse_request', 'landingpress_landingpro_parse_request' );
}
function landingpress_landingpro_parse_request() {
	add_filter('parse_query', 'landingpress_landingpro_parse_query');
}
function landingpress_landingpro_parse_query( $query ) {
	if ( $query->query_vars['post_type'] == 'page' && $query->is_page == false && $query->is_single == true ) {
		$query->is_page = true;
		$query->is_single = false;
	} 
	return $query;
}

add_filter( 'comment_form_fields', 'landingpress_comment_form_fields', 99 );
function landingpress_comment_form_fields( $fields ) {
	if ( get_theme_mod('landingpress_comment_url_hide') && isset( $fields['url'] ) ) {
		unset( $fields['url'] );
	}
	if ( get_theme_mod('landingpress_comment_textarea_reverse') && isset( $fields['comment'] ) ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
	}
	return $fields;
}

add_action( 'wp_footer', 'landingpress_footer_backtotop' );
function landingpress_footer_backtotop() {
	if ( get_theme_mod('landingpress_backtotop_hide') ) 
		return;
	echo '<div id="back-to-top"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z"/></svg></div>';
}

add_action( 'wp_head', 'landingpress_wp_head_singular_script', 100 );
function landingpress_wp_head_singular_script() {
	if ( ! is_singular() )
		return;
	if ( $script = get_post_meta( get_the_ID(), '_landingpress_header_script', true ) ) {
		echo $script;
	}
}

add_action( 'wp_footer', 'landingpress_wp_footer_singular_script', 100 );
function landingpress_wp_footer_singular_script() {
	if ( ! is_singular() )
		return;
	if ( $script = get_post_meta( get_the_ID(), '_landingpress_footer_script', true ) ) {
		echo $script;
	}
}

add_action( 'wp_footer', 'landingpress_wp_footer_adwords_remarketing_old', 100 );
function landingpress_wp_footer_adwords_remarketing_old() {
	$adwords = get_theme_mod( 'landingpress_adwords_remarketing_id' );
	$adwords = trim( $adwords );
	if ( $adwords ) {
?>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = <?php echo $adwords; ?>;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo $adwords; ?>/?guid=ON&amp;script=0"/>
</div>
</noscript>
<?php 		
	}
}

add_filter( 'landingpress_style', 'landingpress_style_page_and_sidebar_width', 101 );
function landingpress_style_page_and_sidebar_width( $style ) {
	$sidebar_width = get_theme_mod( 'landingpress_sidebar_width' );
	$sidebar_width = intval( $sidebar_width );
	if ( $sidebar_width > 10 ) {
		$content_width = 100 - $sidebar_width;
	}
	$pagewidth = get_theme_mod( 'landingpress_page_width' );
	if ( is_singular('post') || is_page() ) {
		$id = get_the_ID();
		$template = get_post_meta( $id, '_wp_page_template', true );
		if ( !$template || $template == 'default' ) {
			$pagewidth_page = get_post_meta( $id, '_landingpress_page_width', true );
			if ( $pagewidth_page >= 500 ) {
				$pagewidth = $pagewidth_page;
			} 
		}
	}
	$pagewidth = intval( $pagewidth );
	if ( $pagewidth >= 500 ) {
		$style .= ' .container, .site-header, .site-inner, .main-navigation, .page-landingpress-full-hf .site-header .container, .page-landingpress-full-hf .main-navigation .container, .page-landingpress-full-hf .site-footer-widgets .container { max-width: '.intval($pagewidth).'px; }';
	}
	if ( $pagewidth >= 500 || $sidebar_width > 10 ) {
		if ( $pagewidth >= 500 ) {
			$breakpoint = $pagewidth;
			$breakpoint_responsive = $pagewidth - 1;
		}
		else {
			$breakpoint = 769;
			$breakpoint_responsive = 768;
		}
		if ( $sidebar_width < 10 ) {
			$content_width = '64.51612903';
			$sidebar_width = '35.48387097';
		}
		$sidebar_position = get_theme_mod( 'landingpress_sidebar_position', 'right' );
		if ( $sidebar_position == 'left' ) {
			$sidebar_float = 'left';
			$content_float = 'right';
		}
		else {
			$sidebar_float = 'right';
			$content_float = 'left';
		}
		$style .= ' @media (min-width: '.$breakpoint.'px) {';
		$style .= ' .site-content .content-area { float: '.$content_float.'; width: '.$content_width.'%; }';
		$style .= ' .site-content .widget-area { float: '.$sidebar_float.'; width: '.$sidebar_width.'%; }';
		$style .= ' }';
		$style .= ' @media (max-width: '.$breakpoint_responsive.'px) {';
		$style .= ' .site-content .content-area { float:none; width:100%; }';
		$style .= ' .site-content .widget-area { float:none; width:100%; }';
		$style .= ' }';
	}
	return $style;
}

add_filter( 'landingpress_style', 'landingpress_style_page_width', 102 );
function landingpress_style_page_width( $style ) {
	if ( is_singular('post') || is_page() ) {
		$id = get_the_ID();
		$template = get_post_meta( $id, '_wp_page_template', true );
		if ( !$template || $template == 'default' || $template == 'page_landingpress_boxed.php' || $template == 'page_landingpress_boxed_hf.php' ) {
			$pagewidth = get_post_meta( $id, '_landingpress_page_width', true );
			$pagewidth = intval( $pagewidth );
			if ( $template == 'page_landingpress_boxed.php' ) {
				$prefix = '.page-landingpress-boxed ';
			}
			elseif ( $template == 'page_landingpress_boxed_hf.php' ) {
				$prefix = '.page-landingpress-boxed-hf ';
			}
			else {
				$prefix = '';
			}
			if ( $pagewidth >= 500 ) {
				$style .= ' '.$prefix.'.site-inner, '.$prefix.'.site-header, '.$prefix.'.container, '.$prefix.'.main-navigation { max-width: '.intval($pagewidth).'px; }';
			}
		}
		elseif ( $template == 'page_landingpress_hf.php' ) {
			if ( did_action( 'elementor/loaded' ) ) {
				$pagewidth = get_option('elementor_container_width');
				if ( !$pagewidth ) {
					$pagewidth = 1140;
				}
				$style .= ' .page-landingpress-full-hf .site-header .container, .page-landingpress-full-hf .main-navigation .container, .page-landingpress-full-hf .site-footer-widgets .container { max-width: '.intval($pagewidth).'px; }';
			}
		}
	}
	return $style;
}
