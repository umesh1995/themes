<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'ecotech' ); ?></h2>
<div class="no-results not-found">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
        <p><?php printf( '%2$s <a href="%1$s">%3$s</a>.', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Ready to publish your first post?', 'ecotech' ), esc_html__( 'Get started here', 'ecotech' ) ); ?></p>
	<?php elseif ( is_search() ) : ?>
        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ecotech' ); ?></p>
		<?php get_search_form(); ?>
	<?php else : ?>
        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ecotech' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div><!-- .no-results -->