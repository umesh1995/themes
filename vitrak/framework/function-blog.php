<?php
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 *
 * TEMPLATES FUNCTION
 **/
if ( !function_exists( 'ecotech_post_thumbnail' ) ) {
    function ecotech_post_thumbnail( $args )
    {
        $default = array(
            'width'       => false,
            'height'      => false,
            'date'        => false,
            'placeholder' => true,
            'effect'      => 'effect background-zoom',
        );
        $args    = wp_parse_args( $args, $default );
        $width   = apply_filters( 'ecotech_post_thumbnail_width', $args['width'] );
        $height  = apply_filters( 'ecotech_post_thumbnail_height', $args['height'] );

        if ( !$args['placeholder'] && !has_post_thumbnail() ) {
            return;
        }
        $thumbnail_id = get_post_thumbnail_id();
        ?>
        <div class="post-thumb">
            <a href="<?php echo ecotech_post_link(); ?>"
               class="thumb-link <?php echo esc_attr( $args['effect'] ); ?>">
                <figure>
                    <?php echo ecotech_resize_image( $thumbnail_id, $width, $height, true, true )['img']; ?>
                </figure>
            </a>
            <?php if ( $args['date'] ): ?>
                <div class="post-date">
                    <a href="<?php echo ecotech_post_link( 'date' ); ?>">
                        <span class="icon"></span>
                        <?php echo get_the_date( 'F d, Y' ); ?>
                    </a>
                </div>
            <?php endif; ?>
            <?php do_action( 'ecotech_post_thumbnail_inner' ); ?>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_post_author' ) ) {
    function ecotech_post_author( $icon = true, $avatar = false, $text = false )
    {
        $author_id = get_the_author_meta( 'ID' );
        ?>
        <div class="post-author">
            <a href="<?php echo ecotech_post_link( 'auth' ); ?>">
                <?php if ( $icon ): ?>
                    <span class="icon"></span>
                <?php endif; ?>
                <?php if ( $avatar ): ?>
                    <span class="avatar"><?php echo get_avatar( $author_id, 50 ); ?></span>
                <?php endif; ?>
                <?php if ( $text ): ?>
                    <span class="text"><?php echo esc_html( $text ); ?></span>
                <?php endif; ?>
                <span class="name"><?php the_author(); ?></span>
            </a>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_post_comment' ) ) {
    function ecotech_post_comment( $icon = true )
    {
        ?>
        <div class="post-comment">
            <a href="<?php echo ecotech_post_link(); ?>#comments">
                <?php if ( $icon ): ?>
                    <span class="icon"></span>
                <?php endif; ?>
                <?php comments_number(
                    esc_html__( 'No comments', 'ecotech' ),
                    esc_html__( '1 comment', 'ecotech' ),
                    esc_html__( '% comments', 'ecotech' )
                );
                ?>
            </a>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_get_term_list' ) ) {
    function ecotech_get_term_list( $taxonomy = 'category' )
    {
        echo get_the_term_list( get_the_ID(), $taxonomy,
            '<div class="cat-list">',
            ', ',
            '</div>'
        );
    }
}
if ( !function_exists( 'ecotech_post_link' ) ) {
    function ecotech_post_link( $type = 'post', $id = 0 )
    {
        global $post;

        switch ( $type ) {
            case 'date':
                $archive_year  = get_the_time( 'Y' );
                $archive_month = get_the_time( 'm' );
                $archive_day   = get_the_time( 'd' );
                $permalink     = get_day_link( $archive_year, $archive_month, $archive_day );
                break;
            case 'auth':

                if ( $id == 0 ) {
                    $id = get_the_author_meta( 'ID' );
                }
                $permalink = get_author_posts_url( $id );
                break;
            default:

                if ( $id == 0 ) {
                    $id = get_the_ID();
                }
                $permalink = get_the_permalink( $id );
                break;
        }

        return apply_filters( 'ovic_loop_post_link', esc_url( $permalink ), $post );
    }
}
if ( !function_exists( 'ecotech_post_formats' ) ) {
    function ecotech_post_formats()
    {
        $data      = '';
        $default   = 'standard';
        $format    = get_post_format();
        $post_meta = get_post_meta( get_the_ID(), '_custom_metabox_post_options', true );
        if ( !empty( $post_meta['post_formats'][ $format ] ) ) {
            $default = $format;
            $data    = $post_meta['post_formats'][ $format ];
        }
        ecotech_get_template(
            "templates/blog/blog-formats/format-{$default}.php",
            array(
                'data' => $data,
            )
        );
    }
}
if ( !function_exists( 'ecotech_post_pagination' ) ) {
    function ecotech_post_pagination()
    {
        $args = array(
            'screen_reader_text' => '&nbsp;',
            'before_page_number' => '',
            'prev_text'          => esc_html__( 'Prev', 'ecotech' ),
            'next_text'          => esc_html__( 'Next', 'ecotech' ),
            'type'               => 'list',
            'end_size'           => 1,
            'mid_size'           => 1,
        );

        $pagination = ecotech_get_option( 'blog_pagination', 'pagination' );
        $blog_style = ecotech_get_option( 'blog_list_style', 'standard' );
        $animate    = '';
        if ( $blog_style != 'creative' ) {
            $animate = 'fadeInUp';
        }

        if ( function_exists( 'ovic_custom_pagination' ) ) : ?>
            <div class="pagination-wrap">
                <?php
                ovic_custom_pagination( array(
                    'pagination'    => $pagination,
                    'class'         => 'button',
                    'animate'       => $animate,
                    'text_loadmore' => esc_html__( 'Load more', 'ecotech' ),
                    'text_infinite' => esc_html__( 'Loading', 'ecotech' ),
                ), $args );
                ?>
            </div>
        <?php else: ?>
            <div class="pagination-wrap">
                <nav class="woocommerce-pagination">
                    <?php echo paginate_links( $args ); ?>
                </nav>
            </div>
        <?php endif;
    }
}
if ( !function_exists( 'ecotech_related_post' ) ) {
    function ecotech_related_post()
    {
        $enable = ecotech_get_option( 'enable_related_post' );
        if ( $enable == 1 ) {
            get_template_part( 'templates/blog/blog-content/content', 'related' );
        }
    }
}
if ( !function_exists( 'ecotech_post_title' ) ) {
    function ecotech_post_title( $link = true )
    {
        if ( get_the_title() ) {
            if ( $link == true ) {
                echo '<h2 class="post-title"><a href="' . ecotech_post_link() . '">' . get_the_title() . '</a></h2>';
            } else {
                echo '<h2 class="post-title"><span>' . get_the_title() . '</span></h2>';
            }
        }
    }
}
if ( !function_exists( 'ecotech_post_readmore' ) ) {
    function ecotech_post_readmore( $text = '' )
    {
        ?>
        <div class="post-readmore">
            <a href="<?php echo ecotech_post_link(); ?>" class="main-color">
                <?php
                if ( !empty( $text ) ) {
                    echo esc_html( $text );
                } else {
                    echo esc_html__( 'Read More', 'ecotech' );
                }
                ?>
            </a>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_callback_comment' ) ) {
    /**
     * Ocolus comment template
     *
     * @param  object $comment the comment array.
     * @param  array $args the comment args.
     * @param  int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function ecotech_callback_comment( $comment, $args, $depth )
    {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

        $commenter = wp_get_current_commenter();
        if ( $commenter['comment_author_email'] ) {
            $moderation_note = esc_html__( 'Your comment is awaiting moderation.', 'ecotech' );
        } else {
            $moderation_note = esc_html__( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.',
                'ecotech' );
        }
        ?>
        <<?php echo wp_specialchars_decode( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? 'parent' : '',
        $comment ); ?>>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <?php if ( 0 != $args['avatar_size'] ): ?>
                <div class="comment-avatar">
                    <figure><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></figure>
                </div>
            <?php endif; ?>
            <div class="comment-info">
                <div class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        /* translators: %s: comment author link */
                        printf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) );
                        ?>
                    </div>
                    <div class="comment-date">
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf( esc_html__( '%1$s at %2$s', 'ecotech' ),
                                    get_comment_date( '', $comment ),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                    </div>
                    <?php
                    edit_comment_link(
                        esc_html__( 'Edit', 'ecotech' ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>',
                    ) ) );
                    ?>
                </div><!-- .comment-meta -->
                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
                <?php endif; ?>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->
            </div>
        </div><!-- .comment-body -->
        <?php
    }
}
if ( !function_exists( 'ecotech_post_excerpt' ) ) {
    function ecotech_post_excerpt( $count = 35 )
    {
        ?>
        <div class="post-excerpt">
            <?php
            if ( $count == null ) {
                echo apply_filters( 'the_excerpt', get_the_excerpt() );
            } else {
                echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), $count,
                    esc_html__( '...', 'ecotech' ) );
            }
            ?>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_post_content' ) ) {
    function ecotech_post_content()
    {
        if ( !is_search() ):
            ?>
            <div class="post-content">
                <?php
                /* translators: %s: Name of current post */
                the_content( sprintf(
                    esc_html__( 'Continue reading %s', 'ecotech' ),
                    the_title( '<span class="screen-reader-text">', '</span>', false )
                ) );
                wp_link_pages( array(
                    'before'      => '<div class="post-pagination"><span class="title">' . esc_html__( 'Pages:',
                            'ecotech' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
                ?>
            </div>
        <?php
        endif;
    }
}
if ( !function_exists( 'ecotech_time_ago' ) ) {
    function ecotech_time_ago( $type = 'post' )
    {
        $current_time = current_time( 'timestamp' );
        $time         = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
        $time_diff    = human_time_diff( $time( 'U' ), $current_time );

        echo sprintf( '<p class="time-post">%s %s</p>',
            $time_diff,
            esc_html__( 'ago', 'ecotech' )
        );
    }
}
if ( !function_exists( 'ecotech_post_meta' ) ) {
    function ecotech_post_meta()
    {
        ?>
        <div class="post-meta">
            <?php ecotech_post_author( false, true,
                esc_html__( 'by', 'ecotech' )
            ); ?>
            <div class="post-comment">
                <a href="<?php echo ecotech_post_link(); ?>#comments">
                    <span class="icon"></span>
                    <?php comments_number(
                        esc_html__( 'No comments', 'ecotech' ),
                        esc_html__( '1 comment', 'ecotech' ),
                        esc_html__( '% comments', 'ecotech' )
                    );
                    ?>
                </a>
            </div>
        </div>
        <?php
    }
}
if ( !function_exists( 'ecotech_pagination_post' ) ) {
    function ecotech_pagination_post()
    {
        $enable    = ecotech_get_option( 'enable_pagination_post' );
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        if ( $enable == 1 ):
            ?>
            <nav class="pagination-thumb">
                <div class="container">
                    <div class="pagination-inner">
                        <?php if ( !empty( $prev_post ) ): ?>
                            <div class="other-post prev">
                                <a class="link" href="<?php echo ecotech_post_link( 'post', $prev_post->ID ); ?>">
                                    <?php if ( has_post_thumbnail( $prev_post->ID ) ): ?>
                                        <span class="thumb">
                                            <?php echo ecotech_resize_image( get_post_thumbnail_id( $prev_post->ID ), 90, 90, true, true )['img']; ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="content">
                                        <span class="text">
                                            <span class="icon main-icon-back-2"></span><?php echo esc_html__( 'Previous Post', 'ecotech' ); ?>
                                        </span>
                                        <span class="title"><?php echo esc_html( $prev_post->post_title ) ?></span>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ( !empty( $next_post ) ): ?>
                            <div class="other-post next">
                                <a class="link" href="<?php echo ecotech_post_link( 'post', $next_post->ID ); ?>">
                                    <span class="content">
                                        <span class="text"><?php echo esc_html__( 'Next Post', 'ecotech' ); ?>
                                            <span class="icon main-icon-next-2"></span>
                                        </span>
                                        <span class="title"><?php echo esc_html( $next_post->post_title ) ?></span>
                                    </span>
                                    <?php if ( has_post_thumbnail( $next_post->ID ) ): ?>
                                        <span class="thumb">
                                            <?php echo ecotech_resize_image( get_post_thumbnail_id( $next_post->ID ), 90, 90, true, true )['img']; ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        <?php
        endif;
    }
}
/**
 * COMMENT FIELDS
 */
if ( !function_exists( 'ecotech_comment_field_to_bottom' ) ) {
    function ecotech_comment_field_to_bottom( $fields )
    {
        if ( class_exists( 'WooCommerce' ) && is_product() ) {
            return $fields;
        }
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;

        return $fields;
    }

    add_filter( 'comment_form_fields', 'ecotech_comment_field_to_bottom' );
}
/**
 *
 * SINGLE SHARE
 */
if ( !function_exists( 'ecotech_post_share' ) ) {
    function ecotech_post_share()
    {
        if ( ecotech_get_option( 'enable_share_post' ) == 1 ) : ?>
            <div class="share">
                <span class="title"><?php echo esc_html__( 'Share', 'ecotech' ); ?></span>
                <?php ecotech_share_social(); ?>
            </div>
        <?php endif;
    }
}