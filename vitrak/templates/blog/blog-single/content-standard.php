<?php while ( have_posts() ): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-item single-post' ); ?>>
        <div class="post-inner">
            <?php
            if ( has_post_thumbnail() ) {
                ecotech_post_formats();
            }
            ?>
            <?php
            ecotech_get_term_list();
            ecotech_post_title( false );
            ecotech_post_meta();
            ecotech_post_content();
            echo get_the_term_list( get_the_ID(), 'post_tag',
                '<div class="tag-list"><span class="icon fa fa-tags"></span>',
                '',
                '</div>'
            );
            ?>
            <?php ecotech_post_share(); ?>
        </div>
        <?php
        ecotech_pagination_post();
        ecotech_related_post();
        /*If comments are open or we have at least one comment, load up the comment template.*/
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    </article>
<?php endwhile;