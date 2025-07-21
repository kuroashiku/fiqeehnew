<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$fb_comment = get_theme_mod('landingpress_comment_fb_show');
if ( $fb_comment ) {
	$fb_app_id = get_theme_mod('landingpress_comment_fb_app_id');
	$fb_app_id = trim( $fb_app_id );
	if ( !$fb_app_id ) {
		$fb_app_id = '289006448233273';
	}
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=<?php echo $fb_app_id; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-comments" data-href="<?php echo wp_get_shortlink(); ?>" data-numposts="5" data-width="100%"></div>
<?php 
}

if ( get_theme_mod('landingpress_comment_hide_default') ) {
	return;
}

$text_name = esc_html__( 'Your Name', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_name') ) {
	$text_name = get_theme_mod('landingpress_comment_form_name');
}
$text_email = esc_html__( 'Your Email', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_email') ) {
	$text_email = get_theme_mod('landingpress_comment_form_email');
}
$text_website = esc_html__( 'Your Website', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_website') ) {
	$text_website = get_theme_mod('landingpress_comment_form_website');
}
$text_comment = esc_html__( 'Your Comment', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_comment') ) {
	$text_comment = get_theme_mod('landingpress_comment_form_comment');
}
$text_required = esc_html__('Required fields are marked %s', 'landingpress-wp');
if ( get_theme_mod('landingpress_comment_form_required') ) {
	$text_required = get_theme_mod('landingpress_comment_form_required');
}
$text_notes = esc_html__( 'Your email address will not be published.', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_notes') ) {
	$text_notes = get_theme_mod('landingpress_comment_form_notes');
}
$text_titlereply = esc_html__( 'Leave a Reply', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_title_reply') ) {
	$text_titlereply = get_theme_mod('landingpress_comment_form_title_reply');
}
$text_titlereplyto = esc_html__( 'Leave a Reply to %s', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_title_reply_to') ) {
	$text_titlereplyto = get_theme_mod('landingpress_comment_form_title_reply_to');
}
$text_cancelreply = esc_html__( 'Cancel reply', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_cancel_reply_link') ) {
	$text_cancelreply = get_theme_mod('landingpress_comment_form_cancel_reply_link');
}
$text_submit = esc_html__( 'Post Comment', 'landingpress-wp' );
if ( get_theme_mod('landingpress_comment_form_label_submit') ) {
	$text_submit = get_theme_mod('landingpress_comment_form_label_submit');
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'landingpress-wp' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'landingpress-wp' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'landingpress-wp' ) ); ?></div>
		</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'			=> 'ol',
				'avatar_size'	=> 50,
				'short_ping'	=> true,
			) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'landingpress-wp' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'landingpress-wp' ) ); ?></div>
		</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		echo '<p class="no-comments">'.esc_html__( 'Comments are closed.', 'landingpress-wp' ).'</p>';
	endif;

	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' ) ? true : false;
	$fields   =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html( $text_name ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input placeholder="' . esc_attr( $text_name ) . ( $req ? ' *' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . esc_html( $text_email ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input placeholder="' . esc_attr( $text_email ) . ( $req ? ' *' : '' ) . '" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . esc_html( $text_website ) . '</label> ' .
		            '<input placeholder="' . esc_attr( $text_website ) . '" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);
	$required_text = sprintf( ' ' . $text_required, '<span class="required">*</span>' );
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$args = array(
		'fields'               => $fields,
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html( $text_comment ) . '</label> <textarea placeholder="' . esc_attr( $text_comment ) . '" id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
		'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . $text_notes . '</span>'. ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '',
		'title_reply'          => $text_titlereply,
		'title_reply_to'       => $text_titlereplyto,
		'cancel_reply_link'    => $text_cancelreply,
		'label_submit'         => $text_submit,
	);
	
	comment_form( $args ); 
	?>
</div>
