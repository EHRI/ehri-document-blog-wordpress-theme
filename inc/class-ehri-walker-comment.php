<?php
/**
 * EHRI comment walker.
 *
 * @package ehri-wp-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Class Name: EHRI Comment Walker
*/

/* Check if Class Exists. */
if ( ! class_exists( 'Ehri_Walker_Comment' ) ) {
	/**
	 * Ehri_Walker_Comment
	 *
	 * @extends Walker_Comment
	 */
	class Ehri_Walker_Comment extends Walker_Comment {
		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			$commenter = wp_get_current_commenter();
			if ( $commenter['comment_author_email'] ) {
				$moderation_note = __( 'Your comment is awaiting moderation.' );
			} else {
				$moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.' );
			}

			?>
			<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<?php
				if ( 0 !== $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'] );}
				?>

				<div class="comment-content">
					<div class="comment-tab"></div>
					<?php
					echo get_comment_reply_link(
						array_merge(
							$args,
							array(
								'reply_text' => '<i class="material-icons" aria-hidden="true">reply</i>',
								'add_below'  => 'div-comment',
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
								'before'     => '<div class="reply">',
								'after'      => '</div>',
							)
						)
					);
					?>
					<div class="comment-meta">
						<h2 class="comment-author vcard">

							<?php echo get_comment_author_link( $comment ); ?>

						</h2><!-- .comment-author -->

						<div class="comment-metadata">
							<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php
									/* translators: 1: comment date, 2: comment time */
									printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
									?>
								</time>
							</a>
							<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .comment-metadata -->

						<?php if ( '0' === $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
						<?php endif; ?>
					</div><!-- .comment-meta -->
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
			<?php
		}
	}
}
