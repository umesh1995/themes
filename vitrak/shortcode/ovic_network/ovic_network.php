<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Network"
 * @version 1.0.0
 */
class Shortcode_Ovic_Network extends Ovic_Addon_Shortcode
{
    /**
     * Shortcode name.
     *
     * @var  string
     */
    public $shortcode = 'ovic_network';
    public $default   = array(
        'style' => 'style-01',
    );

    public function get_image( $atts, $data_response, $class_item )
    {
        if ( empty( $data_response ) ) {
            return;
        }
        $class_item[] = "social-item {$atts['image_source']}-item";
        $class_wrap   = "thumb-{$atts['image_source']} popup-social";
        $class_img    = "img-{$atts['image_source']}";
        $default      = array(
            'url'    => '',
            'src'    => '',
            'width'  => '',
            'height' => '',
            'alt'    => '',
            'detail' => array(
                'user_url'    => '',
                'user_name'   => '',
                'avatar'      => '',
                'title'       => '',
                'date'        => '',
                'photo'       => '',
                'likes'       => '0',
                'comments'    => '0',
                'description' => '',
                'effect'      => 'mfp-zoom-in',
            ),
        );
        $image        = wp_parse_args( $data_response, $default );
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $class_item ) ); ?>">
            <a href="<?php echo esc_url( $image[ 'url' ] ) ?>"
               data-elementor-lightbox-slideshow="<?php echo esc_attr( $atts[ 'popup_id' ] ); ?>"
               data-detail="<?php echo esc_attr( json_encode( $image[ 'detail' ] ) ); ?>"
               class="<?php echo esc_attr( $class_wrap ); ?>">
                <figure>
                    <img class="<?php echo esc_attr( $class_img ); ?>" src="<?php echo esc_url( $image[ 'src' ] ); ?>"
                        <?php echo image_hwstring( $image[ 'width' ], $image[ 'height' ] ); ?>
                         alt="<?php echo esc_attr( $image[ 'alt' ] ); ?>"/>
                </figure>
            </a>
        </div>
        <?php
    }

    public function source_gallery( $image_gallery )
    {
        $data_response = array();
        if ( !empty( $image_gallery ) ) {
            $image_gallery = is_array( $image_gallery ) ? $image_gallery : explode( ',', $image_gallery );
            foreach ( $image_gallery as $image ) {
                $image_id = is_array( $image ) ? $image[ 'id' ] : $image;
                list( $src, $width, $height ) = wp_get_attachment_image_src( $image_id, 'full' );
                $data_response[] = array(
                    'url'    => $src,
                    'src'    => $src,
                    'width'  => $width,
                    'height' => $height,
                    'detail' => array(
                        'user_url'    => get_home_url( '/' ),
                        'user_name'   => get_bloginfo( 'name' ),
                        'avatar'      => get_avatar_url( false ),
                        'title'       => sprintf( '%s %s',
                            get_bloginfo( 'name' ),
                            esc_html__( 'Gallery', 'ecotech' )
                        ),
                        'date'        => get_the_date(),
                        'photo'       => $src,
                        'likes'       => '0',
                        'comments'    => '0',
                        'description' => '',
                        'effect'      => 'mfp-zoom-in',
                    ),
                );
            }
        }

        return $data_response;
    }

    public function api_flickr( $atts )
    {
        $default       = array(
            'flickr_resolution' => 't',
            'id_flickr'         => '',
            'items_limit'       => '6',
        );
        $atts          = wp_parse_args( $atts, $default );
        $data_response = array();
        $id_flickr     = trim( $atts[ 'id_flickr' ] );
        $items_limit   = trim( $atts[ 'items_limit' ] );
        $resolution    = trim( $atts[ 'flickr_resolution' ] );

        $key_flickr = md5( "ovic_flickr_cache_{$id_flickr}_{$items_limit}_{$resolution}" );
        $flickr     = get_transient( $key_flickr );

        if ( intval( $id_flickr ) === 0 ) {
            echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                esc_html__( 'Warning!', 'ecotech' ),
                esc_html__( 'No user ID specified.', 'ecotech' )
            );
        }
        if ( empty( $flickr ) || $flickr === false && $id_flickr ) {
            $protocol   = is_ssl() ? 'https' : 'http';
            $flickr_api = add_query_arg(
                array(
                    'id'     => $id_flickr,
                    'lang'   => 'en-us',
                    'format' => 'php_serial',
                ),
                "{$protocol}://api.flickr.com/services/feeds/photos_public.gne"
            );
            $response   = wp_remote_get( $flickr_api );
            if ( !is_wp_error( $response ) ) {
                $response_code = wp_remote_retrieve_response_code( $response );
                if ( $response_code != 200 ) {
                    echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                        esc_html__( 'Warning!', 'ecotech' ),
                        esc_html__( 'User ID do not match. Please check again.', 'ecotech' )
                    );
                } else {
                    $response = maybe_unserialize( wp_remote_retrieve_body( $response ) );
                    if ( !empty( $response[ 'items' ] ) ) {
                        $limit = 0;
                        foreach ( $response[ 'items' ] as $item ) {
                            if ( $limit <= $items_limit ) {
                                $limit++;
                                switch ( $resolution ) {
                                    case 's':
                                        $width  = 75;
                                        $height = 75;
                                        break;
                                    case 'q':
                                        $width  = 150;
                                        $height = 150;
                                        break;
                                    case 'n':
                                        $width  = 320;
                                        $height = 240;
                                        break;
                                    case 'c':
                                        $width  = 800;
                                        $height = 600;
                                        break;
                                    case 'b':
                                        $width  = 1024;
                                        $height = 768;
                                        break;
                                    case 'o':
                                        $width  = 2400;
                                        $height = 1800;
                                        break;
                                    default:
                                        $width  = 100;
                                        $height = 75;
                                }
                                $src   = str_replace( ".jpg", "_{$resolution}.jpg", $item[ 'l_url' ] );
                                $image = wp_remote_get( $src );
                                $code  = wp_remote_retrieve_response_code( $image );
                                if ( $code != 200 ) {
                                    $src = $item[ 'photo_url' ];
                                }
                                $data_response[] = array(
                                    'url'    => $item[ 'url' ],
                                    'src'    => $src,
                                    'width'  => $width,
                                    'height' => $height,
                                    'alt'    => $item[ 'description_raw' ],
                                    'detail' => array(
                                        'user_url'    => $item[ 'author_url' ],
                                        'user_name'   => $item[ 'author_name' ],
                                        'avatar'      => $item[ 'author_icon' ],
                                        'title'       => $item[ 'title' ],
                                        'date'        => $item[ 'date_taken_nice' ],
                                        'photo'       => $item[ 'photo_url' ],
                                        'likes'       => '0',
                                        'comments'    => '0',
                                        'description' => '',
                                        'effect'      => 'mfp-zoom-in',
                                    ),
                                );
                            }
                        }
                    }
                }
                set_transient( $key_flickr, $data_response, 12 * HOUR_IN_SECONDS );
            } elseif ( isset( $response->errors ) && !empty( $response->errors ) ) {
                delete_transient( $key_flickr );
                foreach ( $response->errors as $errors ) {
                    if ( !empty( $errors ) ) {
                        foreach ( $errors as $error ) {
                            echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                                esc_html__( 'Warning!', 'ecotech' ),
                                esc_html( $error )
                            );
                        }
                    }
                }
            }
        } else {
            $data_response = $flickr;
        }

        return $data_response;
    }

    public function api_instagram( $atts )
    {
        $default       = array(
            'instagram_resolution' => 'thumbnail',
            'id_instagram'         => '',
            'token'                => '',
            'items_limit'          => '6',
        );
        $atts          = wp_parse_args( $atts, $default );
        $data_response = array();
        $id_instagram  = trim( $atts[ 'id_instagram' ] );
        $token         = trim( $atts[ 'token' ] );
        $items_limit   = trim( $atts[ 'items_limit' ] );
        $resolution    = trim( $atts[ 'instagram_resolution' ] );
        $key_instagram = md5( "ovic_instagram_cache_{$id_instagram}_{$token}_{$items_limit}_{$resolution}" );
        $instagram     = get_transient( $key_instagram );

        if ( intval( $id_instagram ) === 0 || intval( $token ) === 0 ) {
            echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                esc_html__( 'Warning!', 'ecotech' ),
                esc_html__( 'No user ID specified.', 'ecotech' )
            );
        }
        if ( empty( $instagram ) || $instagram === false && $atts[ 'id_instagram' ] && $atts[ 'token' ] ) {
            $protocol      = is_ssl() ? 'https' : 'http';
            $instagram_api = add_query_arg(
                array(
                    'access_token' => $token,
                    'limit'        => $items_limit,
                ),
                "{$protocol}://graph.instagram.com/{$id_instagram}/media?fields=media_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url,comments_count,like_count}"
            );
            $response      = wp_remote_get( $instagram_api );
            if ( !is_wp_error( $response ) ) {
                $response_code = wp_remote_retrieve_response_code( $response );
                if ( $response_code != 200 ) {
                    echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                        esc_html__( 'Warning!', 'ecotech' ),
                        esc_html__( 'User ID and access token do not match. Please check again.', 'ecotech' )
                    );
                } else {
                    $response_body    = json_decode( wp_remote_retrieve_body( $response ), true );
                    $items_as_objects = $response_body[ 'data' ];
                    if ( !empty( $items_as_objects ) ) {
                        foreach ( $items_as_objects as $item ) {
                            $image           = $item[ 'images' ][ $resolution ];
                            $data_response[] = array(
                                'url'    => $item[ 'link' ],
                                'src'    => $image[ 'url' ],
                                'width'  => $image[ 'width' ],
                                'height' => $image[ 'height' ],
                                'alt'    => $item[ 'caption' ][ 'text' ],
                                'detail' => array(
                                    'user_url'    => "{$protocol}://instagram.com/{$item['user']['username']}",
                                    'user_name'   => $item[ 'user' ][ 'full_name' ],
                                    'avatar'      => $item[ 'user' ][ 'profile_picture' ],
                                    'title'       => $item[ 'caption' ][ 'text' ],
                                    'date'        => date( 'm/j/Y g:i:s', $item[ 'created_time' ] ),
                                    'photo'       => $item[ 'images' ][ 'standard_resolution' ][ 'url' ],
                                    'likes'       => $item[ 'likes' ][ 'count' ],
                                    'comments'    => $item[ 'comments' ][ 'count' ],
                                    'description' => $item[ 'caption' ][ 'text' ],
                                    'effect'      => 'mfp-zoom-in',
                                ),
                            );
                        }
                    }
                }
                set_transient( $key_instagram, $data_response, 12 * HOUR_IN_SECONDS );
            } elseif ( isset( $response->errors ) && !empty( $response->errors ) ) {
                delete_transient( $key_instagram );
                foreach ( $response->errors as $errors ) {
                    if ( !empty( $errors ) ) {
                        foreach ( $errors as $error ) {
                            echo sprintf( '<div class="alert alert-warning"><strong>%s</strong> %s</div>',
                                esc_html__( 'Warning!', 'ecotech' ),
                                esc_html( $error )
                            );
                        }
                    }
                }
            }
        } else {
            $data_response = $instagram;
        }

        return $data_response;
    }

    public function content( $atts, $content = null )
    {
        $css_class    = $this->main_class( $atts, array(
            'ovic-social-network',
            $atts[ 'style' ],
            $atts[ 'slides_rows_space' ]
        ) );
        $owl_settings = '';
        $source_data  = array();
        $class_item   = array( 'social-network' );
        $class_list   = array( 'content-social-network' );
        if ( !empty( $atts[ 'slides_to_show' ] ) ) {
            $class_list[] = 'owl-slick';
            $owl_settings = $this->generate_carousel( $atts );
        }
        if ( $atts[ 'image_source' ] == 'local' ) {
            $class_list[] = 'ovic-gallery-image';
            $source_data  = $this->source_gallery( $atts[ 'image_gallery' ] );
        } elseif ( $atts[ 'image_source' ] == 'instagram' ) {
            $source_data = $this->api_instagram( $atts );
        } elseif ( $atts[ 'image_source' ] == 'flickr' ) {
            $source_data = $this->api_flickr( $atts );
        }
        ob_start();
        ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <div class="widget">
                <?php
                if ( !empty( $atts[ 'title' ] ) ) {
                    echo '<h3 class="widget-title">' . esc_html( $atts[ 'title' ] ) . '</h3>';
                }
                if ( !empty( $source_data ) ): ?>
                    <div class="<?php echo implode( ' ', $class_list ); ?>" <?php echo esc_attr( $owl_settings ); ?>>
                        <?php
                        $atts[ 'popup_id' ] = 'network-gallery-' . uniqid();
                        foreach ( $source_data as $item ) {
                            $this->get_image( $atts, $item, $class_item );
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}