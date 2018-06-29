<?php
/**
 * @Read more button html
 *
 */
if ( ! function_exists('wp_rem_modifiy_post_more_button') ) {

    function wp_rem_modifiy_post_more_button($link) {
        $link = preg_replace('|#more-[0-9]+|', '', $link);
        return $link;
    }

    add_filter('the_content_more_link', 'wp_rem_modifiy_post_more_button');
}
/**
 * @Custom excerpt funciton
 *
 */
if ( ! function_exists('wp_rem_cs_var_the_excerpt') ) {

    function wp_rem_cs_var_the_excerpt() {
        add_filter('excerpt_length', 'wp_rem_cs_var_the_excerpt_length', 30);
        the_excerpt();
    }

}

if ( ! function_exists('wp_rem_cs_var_the_excerpt_length') ) {

    function wp_rem_cs_var_the_excerpt_length($length) {
        global $wp_rem_cs_var_options;
        $default_excerpt_length = isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) ? $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] : '50';
        return $default_excerpt_length;
    }

}

if ( ! function_exists('wp_rem_cs_var_wpdowp_rem_cs_excerpt_more') ) {

    add_filter('excerpt_more', 'wp_rem_cs_var_wpdowp_rem_cs_excerpt_more');

    function wp_rem_cs_var_wpdowp_rem_cs_excerpt_more($more = '...') {
        return '...';
    }

}
/**
 * @Getting child Comments
 *
 */
if ( ! function_exists('wp_rem_cs_var_comment') ):

    function wp_rem_cs_var_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        global $wpdb, $wp_rem_cs_var_static_text;
        $wp_rem_cs_var_childs = $wpdb->get_var($wpdb->prepare("SELECT COUNT(comment_parent) FROM $wpdb->comments WHERE comment_parent = %d", $comment->comment_ID));
        $GLOBALS['comment'] = $comment;
        $args['reply_text'] = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_reply') . '<span><em>' . wp_rem_cs_allow_special_char($wp_rem_cs_var_childs) . '</em>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_comments') . '</span>';
        $args['after'] = '';
        switch ( $comment->comment_type ) :
            case '' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">



                    <div class="thumb-list" id="comment-<?php comment_ID(); ?>">
                        <div class="img-holder">
                            <figure><?php echo get_avatar($comment, 59); ?></figure>
                        </div>
                        <div class="text-holder">

                            <h6><?php comment_author(); ?></h6>
                            <span class="post-date"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_ago'); ?></span>

                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <p><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_comment_awaiting')); ?></p>
                            <?php endif; ?>
                            <?php comment_text(); ?>
                            <?php comment_reply_link(array_merge($args, array( 'depth' => $depth, 'reply_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_reply'), ))); ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'pingback' :
                case 'trackback' :
                    ?>
                <li class="post pingback">
                    <p><?php comment_author_link(); ?><?php edit_comment_link(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit'), ' '); ?></p>
                    <?php
                    break;
            endswitch;
        }

    endif;


    /**
     * @Replacing Reply Link Classes
     *
     */
    if ( ! function_exists('replace_reply_link_class') ) {


        function replace_reply_link_class($class) {
            $class = str_replace("class='comment-reply-link", "class='reply-btn text-color", $class);

            return $class;
        }

        add_filter('comment_reply_link', 'replace_reply_link_class');
    }

    /**
     * @Generating Random String
     *
     */
    if ( ! function_exists('wp_rem_cs_generate_random_string') ) {

        function wp_rem_cs_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ( $i = 0; $i < $length; $i ++ ) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }


    if ( ! function_exists('wp_rem_cs_section') ) {

        function wp_rem_cs_section($class, $title, $csheading) {
            if ( $title <> '' ) {
                $wp_rem_cs_html = '';
                $wp_rem_cs_html .= '<div class="' . $class . '">
                    <h' . $csheading . '>' . esc_html($title) . '</h' . $csheading . '>
                    <div class="stripe-line"></div>
                </div>';
                return $wp_rem_cs_html;
            }
        }

    }

    /**
     * @Getting Image Source by Post
     *
     */
    if ( ! function_exists('wp_rem_cs_get_post_img_src') ) {

        function wp_rem_cs_get_post_img_src($post_id, $width, $height, $fixed_size = true) {
            global $post;
            if ( has_post_thumbnail() ) {
                $image_id = get_post_thumbnail_id($post_id);
                $image_url = wp_get_attachment_image_src($image_id, array( $width, $height ), true);
                if ( ( $image_url[1] == $width and $image_url[2] == $height ) || true !== $fixed_size ) {
                    return $image_url[0];
                } else {
                    $image_url = wp_get_attachment_image_src($image_id, "full", true);
                    return $image_url[0];
                }
            }
        }

    }
    /**
     * @Getting Attachment Source by ID
     *
     */
    if ( ! function_exists('wp_rem_cs_attachment_image_src') ) {

        function wp_rem_cs_attachment_image_src($attachment_id, $width, $height) {
            $image_url = wp_get_attachment_image_src($attachment_id, array( $width, $height ), true);
            if ( $image_url[1] == $width and $image_url[2] == $height )
                return $image_url[0];
            else
                $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
            $parts = explode('/uploads/', $image_url[0]);
            if ( count($parts) > 1 )
                return $image_url[0];
        }

    }

    /**
     * @Comment Form Submit Button Filter
     *
     */
    if ( ! function_exists('awesome_comment_form_submit_button') ) {

        function awesome_comment_form_submit_button($button) {


            $button = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="field-holder comment-form-btn-loader"><input name="submit" type="submit" class="bgcolor submit-btn wp-rem-comment-form" tabindex="5" value="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_comment_submit_button') . '" />
                            </div>
                    </div>';
            return $button;
        }

        add_filter('comment_form_submit_button', 'awesome_comment_form_submit_button');
    }

    /**
     * @Social Media Sharing Function
     *
     */
    if ( ! function_exists('wp_rem_cs_social_share_blog') ) {

        function wp_rem_cs_social_share_blog($default_icon = 'false', $title = 'true', $post_social_sharing_text = '') {

            global $wp_rem_cs_var_options;
            $html = '';
            $wp_rem_cs_var_twitter = isset($wp_rem_cs_var_options['wp_rem_cs_var_twitter_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_twitter_share'] : '';
            $wp_rem_cs_var_facebook = isset($wp_rem_cs_var_options['wp_rem_cs_var_facebook_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_facebook_share'] : '';
            $wp_rem_cs_var_google_plus = isset($wp_rem_cs_var_options['wp_rem_cs_var_google_plus_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_google_plus_share'] : '';
            $wp_rem_cs_var_tumblr = isset($wp_rem_cs_var_options['wp_rem_cs_var_tumblr_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_tumblr_share'] : '';
            $wp_rem_cs_var_dribbble = isset($wp_rem_cs_var_options['wp_rem_cs_var_dribbble_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_dribbble_share'] : '';
            $wp_rem_cs_var_share = isset($wp_rem_cs_var_options['wp_rem_cs_var_stumbleupon_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_stumbleupon_share'] : '';
            $wp_rem_cs_var_stumbleupon = isset($wp_rem_cs_var_options['wp_rem_cs_var_stumbleupon_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_stumbleupon_share'] : '';
            $wp_rem_cs_var_sharemore = isset($wp_rem_cs_var_options['wp_rem_cs_var_share_share']) ? $wp_rem_cs_var_options['wp_rem_cs_var_share_share'] : '';
            wp_rem_cs_addthis_script_init_method();
            $html = '';

            $single = false;
            if ( is_single() ) {
                $single = true;
            }

            $path = trailingslashit(get_template_directory_uri()) . "include/assets/images/";
            if ( $wp_rem_cs_var_twitter == 'on' or $wp_rem_cs_var_facebook == 'on' or $wp_rem_cs_var_google_plus == 'on' or $wp_rem_cs_var_tumblr == 'on' or $wp_rem_cs_var_dribbble == 'on' or $wp_rem_cs_var_share == 'on' or $wp_rem_cs_var_stumbleupon == 'on' or $wp_rem_cs_var_sharemore == 'on' ) {

                if ( isset($wp_rem_cs_var_facebook) && $wp_rem_cs_var_facebook == 'on' ) {
                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_facebook" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_facebook') . '"><i class="icon-facebook3"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_facebook" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_facebook') . '"><i class="icon-facebook3"></i></a></li>';
                    }
                }
                if ( isset($wp_rem_cs_var_twitter) && $wp_rem_cs_var_twitter == 'on' ) {

                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_twitter"  data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter') . '"><i class="icon-twitter3"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_twitter"  data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter') . '"><i class="icon-twitter3"></i></a></li>';
                    }
                }
                if ( isset($wp_rem_cs_var_google_plus) && $wp_rem_cs_var_google_plus == 'on' ) {

                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_google" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_google_plus') . '"><i class="icon-google"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_google" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_google_plus') . '"><i class="icon-google"></i></a></li>';
                    }
                }
                if ( isset($wp_rem_cs_var_tumblr) && $wp_rem_cs_var_tumblr == 'on' ) {

                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_tumblr" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tumbler') . '"><i class="icon-tumblr3"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_tumblr" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tumbler') . '"><i class="icon-tumblr3""></i></a></li>';
                    }
                }

                if ( isset($wp_rem_cs_var_dribbble) && $wp_rem_cs_var_dribbble == 'on' ) {
                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_dribbble" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dribble') . '"><i class="icon-dribbble3"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_dribbble" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dribble') . '"><i class="icon-dribbble3"></i></a></li>';
                    }
                }
                if ( isset($wp_rem_cs_var_stumbleupon) && $wp_rem_cs_var_stumbleupon == 'on' ) {
                    if ( $single == true ) {
                        $html .='<li><a class="addthis_button_stumbleupon" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_stumbleupon') . '"><i class="icon-stumbleupon"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_stumbleupon" data-original-title="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_stumbleupon') . '"><i class="icon-stumbleupon"></i></a></li>';
                    }
                }
                if ( isset($wp_rem_cs_var_sharemore) && $wp_rem_cs_var_sharemore == 'on' ) {

                    $html .='<li><a class="cs-more addthis_button_compact"><i class="icon-share"></i></a></li>';
                }
            }
            echo balanceTags($html, true);
        }

    }

    /**
     * @Getting Attachment ID by URL
     *
     */
    if ( ! function_exists('wp_rem_cs_var_get_image_id') ) {

        function wp_rem_cs_var_get_image_id($attachment_url) {
            global $wpdb;
            $attachment_id = false;
            //  If there is no url, return. 
            if ( '' == $attachment_url )
                return;
            // Get the upload wp_rem_cs paths 
            $upload_dir_paths = wp_upload_dir();
            if ( false !== strpos($attachment_url, $upload_dir_paths['baseurl']) ) {
                //  If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                // Remove the upload path base wp_rem_cs from the attachment URL 
                $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

                $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
            }
            return $attachment_id;
        }

    }




    /*
     * @ Post Likes Counter
     */
    if ( ! function_exists('wp_rem_post_likes_count') ) {

        function wp_rem_post_likes_count() {
            $wp_rem_like_counter = get_post_meta($_POST['post_id'], "wp_rem_post_like_counter", true);
            if ( ! isset($_COOKIE["wp_rem_post_like_counter" . $_POST['post_id']]) ) {
                setcookie("wp_rem_post_like_counter" . $_POST['post_id'], 'true', time() + 86400, '/');
                update_post_meta($_POST['post_id'], 'wp_rem_post_like_counter', $wp_rem_like_counter + 1);
            }
            $wp_rem_like_counter = get_post_meta($_POST['post_id'], "wp_rem_post_like_counter", true);
            if ( ! isset($wp_rem_like_counter) or empty($wp_rem_like_counter) )
                $wp_rem_like_counter = 0;
            if ( isset($_POST['view']) && 'blog_views' === $_POST['view'] ) {
                echo '<i class="icon-heart2"></i>';
            }
            die(0);
        }

        add_action('wp_ajax_wp_rem_post_likes_count', 'wp_rem_post_likes_count');
        add_action('wp_ajax_nopriv_wp_rem_post_likes_count', 'wp_rem_post_likes_count');
    }

    if ( ! function_exists('wp_rem_get_cookie') ) {

        /**
         * Return an input variable from $_COOKIE if exists else default.
         *
         * @param	string $name name of the variable.
         * @param string $default default value.
         * @return string
         */
        function wp_rem_get_cookie($name, $default = null) {
            return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
        }

    }

    /*
     * Element title 
     * Element sub title
     * Element Alignment
     */
    if ( ! function_exists('wp_rem_title_sub_align') ) {

        function wp_rem_title_sub_align($title, $subtitle, $align, $title_style = '', $separator = '') {

            $element_title = isset($title) ? $title : '';
            $element_subtitle = isset($subtitle) ? $subtitle : '';
            $element_align = isset($align) ? $align : '';
            if ( ! empty($title_style) ) {
                $title_style = ' style="color:' . $title_style . ' ! important;"';
            }
            $element_html = '';
            if ( ! empty($element_title) || ! empty($element_subtitle) ) {
                $element_html .= '<div class="element-title ' . $align . ' ">';
                if ( ! empty($element_title) ) {
                    $element_html .= '<h2' . $title_style . '>' . $element_title . '</h2>';
                }
                if ( ! empty($element_subtitle) ) {
                    $element_html .= '<p>' . $element_subtitle . '</p>';
                }
                if ( ! empty($separator) ) {
                    if ( $separator == 'classic' ) {
                        $element_html .='<div class="classic-separator ' . $align . '"><span></span></div>';
                    }
                    if ( $separator == 'zigzag' ) {
                        $element_html .='<div class="separator-zigzag ' . $align . '">
                                            <figure><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/zigzag-img1.png" alt=""/></figure>
                                        </div>';
                    }
                }
                $element_html .= '</div>';
            }
            return $element_html;
        }

    }

    /**
     * Clients List
     */
    if ( ! function_exists('wp_rem_clients') ) {

        function wp_rem_clients() {
            global $wp_rem_cs_var_options;
            if ( ! isset($wp_rem_cs_var_options['wp_rem_cs_var_enable_clients']) || $wp_rem_cs_var_options['wp_rem_cs_var_enable_clients'] != 'on' ) {
                return;
            }
            $clients_images = isset($wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array']) ? $wp_rem_cs_var_options['wp_rem_cs_var_clients_image_array'] : '';
            $clients_title = isset($wp_rem_cs_var_options['wp_rem_clients_title']) ? $wp_rem_cs_var_options['wp_rem_clients_title'] : '';
            $clients_url = isset($wp_rem_cs_var_options['wp_rem_clients_url']) ? $wp_rem_cs_var_options['wp_rem_clients_url'] : '';
            $html = '';

            if ( ! empty($clients_images) ) {

                $html .='<div class="company-logo-holder">';
                $html .='<div class="company-logo">';
                $html .='<ul>';

                foreach ( $clients_images as $key => $image ) {
                    $url = isset($clients_url[$key]) ? $clients_url[$key] : '#';
                    $title = isset($clients_title[$key]) ? $clients_title[$key] : '';
                    $html .= '<li><figure><a href="' . esc_url($url) . '"><img src="' . esc_url($image) . '" alt="" title="' . esc_html($title) . '"></a></figure></li>';
                }

                $html .='</ul>';
                $html .='</div>';
                $html .='</div>';
            }
            echo force_balance_tags($html);
        }

    }
	
	if ( ! function_exists('wp_rem_cs_var_custom_upload_mimes') ) {
		function wp_rem_cs_var_custom_upload_mimes( $existing_mimes ) {
			$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
			$existing_mimes['otf'] = 'application/x-font-otf';
			$existing_mimes['svg'] = 'image/svg+xml';
			$existing_mimes['ttf'] = 'application/x-font-ttf';
			$existing_mimes['woff'] = 'application/x-font-woff';
			$existing_mimes['svgz'] = 'svg+xml';
			return $existing_mimes;
		}
		add_filter( 'mime_types', 'wp_rem_cs_var_custom_upload_mimes' );
	}
	
    /*
     * For Extra File Types Upload
     */
    if ( ! function_exists('wp_rem_cs_var_extra_mimes') ) {

        function wp_rem_cs_var_extra_mimes( $info, $tmpfile, $filename, $mimes ) {
			// extra checks to handle situations where "finfo mimetype" is different from "user mimetype"
			$extra_mimes = array (
				'eot' => 'application/vnd.ms-fontobject',
				'otf' => 'application/x-font-otf',
				'svg' => 'image/svg+xml',
				'ttf' => 'application/x-font-ttf',
				'woff' => 'application/x-font-woff',
				'svgz' => 'svg+xml',
			);

			$ret = array('ext'=>'','type'=>'','proper_filename'=>'');
			foreach ($info as $k => $v) {
				if ( $v!=='' ) {
					$ret[$k] = $v;
				}
			}
			$parts = explode('.',$filename);
			$ext   = array_pop($parts);
			$ext   = strtolower($ext);

			if (isset($extra_mimes[$ext])) {
				$ret['ext']  = $ext;
				$ret['type'] = $extra_mimes[$ext];
				$ret['proper_filename'] = $filename;
			}
			return $ret;
		}
		add_filter('wp_check_filetype_and_ext', 'wp_rem_cs_var_extra_mimes', 10, 4);
    }

    if ( class_exists('RevSlider') && ! class_exists('wp_rem_cs_var_RevSlider') ) {

        class wp_rem_cs_var_RevSlider extends RevSlider {
            /*
             * Get sliders alias, Title, ID
             */

            public function getAllSliderAliases() {
                $where = "";
                $response = $this->db->fetch(GlobalsRevSlider::$table_sliders, $where, "id");
                $arrAliases = array();
                $slider_array = array();
                foreach ( $response as $arrSlider ) {
                    $arrAliases['id'] = $arrSlider["id"];
                    $arrAliases['title'] = $arrSlider["title"];
                    $arrAliases['alias'] = $arrSlider["alias"];
                    $slider_array[] = $arrAliases;
                }
                return($slider_array);
            }

        }

    }
    /*
     * start function for custom pagination
     */


    if ( ! function_exists('wp_rem_default_pagination') ) {

        /**
         * Display navigation to next/previous set of posts when applicable.
         * Based on paging nav function from Twenty Fourteen
         */
        function wp_rem_default_pagination() {
            // Don't print empty markup if there's only one page.
            if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
                return;
            }

            $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
            $pagenum_link = html_entity_decode(get_pagenum_link());
            $query_args = array();
            $url_parts = explode('?', $pagenum_link);

            if ( isset($url_parts[1]) ) {
                wp_parse_str($url_parts[1], $query_args);
            }

            $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
            $pagenum_link = trailingslashit($pagenum_link) . '%_%';
            $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

            // Set up paginated links.
            $links = paginate_links(array(
                'base' => $pagenum_link,
                'format' => $format,
                'total' => $GLOBALS['wp_query']->max_num_pages,
                'current' => $paged,
                'mid_size' => 3,
                'add_args' => array_map('urlencode', $query_args),
                'prev_text' => '<i class="icon-angle-left"></i>',
                'next_text' => '<i class="icon-angle-right"></i>',
                'type' => 'list',
            ));
            if ( $links ) :
                ?>
                <nav class="page-navigation navigation default-pagination" role="navigation">
                    <?php echo force_balance_tags($links); ?>
                </nav><!-- navigation -->
                <?php
            endif;
        }

    }

    /*
      password form
     */
    if ( ! function_exists('wp_rem_cs_password_form') ) {

        function wp_rem_cs_password_form() {
            global $post, $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields;
            $cs_password_opt_array = array(
                'std' => '',
                'id' => '',
                'classes' => '',
                'extra_atr' => ' size="20"',
                'cust_id' => 'password_field',
                'cust_name' => 'post_password',
                'return' => true,
                'required' => false,
                'cust_type' => 'password',
            );

            $cs_submit_opt_array = array(
                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_submit'),
                'id' => '',
                'classes' => 'bgcolr',
                'extra_atr' => '',
                'cust_id' => '',
                'cust_name' => 'Submit',
                'return' => true,
                'required' => false,
                'cust_type' => 'submit',
            );
            $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
            $o = '<div class="password_protected">
                <div class="protected-icon"><a href="#"><i class="icon-unlock-alt icon-4x"></i></a></div>
                <h3>' . wp_rem_cs_var_theme_text_srt('wp_rem_post_pass_protected') . '</h3>';
            $o .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post"><label>'
                    . $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($cs_password_opt_array)
                    . '</label>'
                    . $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($cs_submit_opt_array)
                    . '</form>
            </div>';
            return $o;
        }

    }


    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('widget', 'wp_rem_cs_widget_shortcode');
    }

    if ( ! function_exists('wp_rem_cs_widget_shortcode') ) {

        function wp_rem_cs_widget_shortcode($atts) {
            $a = shortcode_atts(array(
                'name' => 'something',
                    ), $atts);

            echo esc_html($a['name']);
            $params = array( $a['name'] );
            dynamic_sidebar($a['name']);
            the_widget('WP_Widget_Archives');
        }

    }

    /*
     * Wordpress default gallery customization
     */
    if ( ! function_exists('wp_rem_cs_custom_format_gallery') ) {
        add_filter('post_gallery', 'wp_rem_cs_custom_format_gallery', 10, 2);

        function wp_rem_cs_custom_format_gallery($string, $attr) {
            $output = "";

            $col_class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
            if ( isset($attr['columns']) && $attr['columns'] != '' ) {
                $number_col = 12 / $attr['columns'];
                $number_col_sm = 12;
                $number_col_xs = 12;
                if ( $number_col == 2 ) {
                    $number_col_sm = 4;
                    $number_col_xs = 6;
                }
                if ( $number_col == 3 ) {
                    $number_col_sm = 6;
                    $number_col_xs = 12;
                }
                if ( $number_col == 4 ) {
                    $number_col_sm = 6;
                    $number_col_xs = 12;
                }
                if ( $number_col == 6 ) {
                    $number_col_sm = 12;
                    $number_col_xs = 12;
                }
                $col_class = 'col-lg-' . $number_col . ' col-md-' . $number_col . ' col-sm-' . $number_col_sm . ' col-xs-' . $number_col_xs . '';
            }

            if ( isset($attr['ids']) ) {
                $output = " <div class='post-gallery'> ";
                $posts = get_posts(array( 'include' => $attr['ids'], 'post_type' => 'attachment' ));
                foreach ( $posts as $imagePost ) {
                    $output .=' <div class="' . $col_class . '"> <div class="media-holder"> <figure> <img src="' . wp_get_attachment_image_src($imagePost->ID, 'wp_rem_cs_media_3')[0] . '" alt=""> </figure> </div> </div> ';
                }
                $output .= " </div> ";
            }
            return $output;
        }

    }


    if ( ! function_exists('wp_rem_cs_var_get_pagination') ) {

        function wp_rem_cs_var_get_pagination($total_pages = 1, $page = 1, $shortcode_paging) {
            global $wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            $query_string = $_SERVER['QUERY_STRING'];
            $base = get_permalink() . '?' . remove_query_arg($shortcode_paging, $query_string) . '%_%';
            $wp_rem_cs_var_pagination = paginate_links(array(
                'base' => @add_query_arg($shortcode_paging, '%#%'),
                'format' => '&' . $shortcode_paging . '=%#%', // this defines the query parameter that will be used, in this case "p"
                'prev_text' => '<i class="icon-long-arrow-left"></i> ' . esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_prev')), // text for previous page
                'next_text' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_next')) . ' <i class="icon-long-arrow-right"></i>', // text for next page
                'total' => $total_pages, // the total number of pages we have
                'current' => $page, // the current page
                'end_size' => 1,
                'mid_size' => 2,
                'type' => 'array',
            ));
            $wp_rem_cs_var_pages = '';
            if ( is_array($wp_rem_cs_var_pagination) && sizeof($wp_rem_cs_var_pagination) > 0 ) {
                $wp_rem_cs_var_pages .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                $wp_rem_cs_var_pages .= '<nav>';
                $wp_rem_cs_var_pages .= '<ul class="pagination">';
                foreach ( $wp_rem_cs_var_pagination as $wp_rem_cs_var_link ) {
                    if ( strpos($wp_rem_cs_var_link, 'current') !== false ) {
                        $wp_rem_cs_var_pages .= '<li><a class="active">' . preg_replace("/[^0-9]/", "", $wp_rem_cs_var_link) . '</a></li>';
                    } else {
                        $wp_rem_cs_var_pages .= '<li>' . $wp_rem_cs_var_link . '</li>';
                    }
                }
                $wp_rem_cs_var_pages .= '</ul>';
                $wp_rem_cs_var_pages .= ' </nav>';
                $wp_rem_cs_var_pages .= '</div>';
            }
            echo force_balance_tags($wp_rem_cs_var_pages);
        }

    }

    if ( ! function_exists('wp_rem_cs_get_posts_ajax_callback') ) {

        function wp_rem_cs_get_posts_ajax_callback() {
            $category = isset($_POST['category']) ? $_POST['category'] : '';
            $posts = array();
            if ( $category != '' ) {
                
            }
            echo json_encode(array( 'status' => true, 'posts' => $posts ));
            wp_die();
        }

        add_action("wp_ajax_wp_rem_cs_get_posts", 'wp_rem_cs_get_posts_ajax_callback');
    }
    if ( ! function_exists('wp_rem_cs_var_get_attachment_id') ) {

        function wp_rem_cs_var_get_attachment_id($attachment_url) {
            global $wpdb;
            $attachment_id = false;
            // If there is no url, return.
            if ( '' == $attachment_url )
                return;
            // Get the upload wp_rem_cs paths 
            $upload_dir_paths = wp_upload_dir();
            if ( false !== strpos($attachment_url, $upload_dir_paths['baseurl']) ) {
                // If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                // Remove the upload path base wp_rem_cs from the attachment URL 
                $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

                $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
            }
            return $attachment_id;
        }

    }

    /*
     * Posts title limit count
     */

    if ( ! function_exists('wp_rem_cs_get_post_excerpt') ) {

        function wp_rem_cs_get_post_excerpt($string, $wordslength = '') {
            global $post;
            if ( $wordslength == '' ) {
                $wordslength = '500';
            }
            $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', $string));
            $excerpt_new = wp_trim_words($excerpt, $wordslength, ' ...');
            return $excerpt_new;
        }

    }
    if ( ! function_exists('wp_rem_cs_get_excerpt') ) {

        function wp_rem_cs_get_excerpt($wordslength = '', $readmore = 'true', $readmore_text = 'Read More') {
            global $post, $wp_rem_cs_var_options;
            if ( $wordslength == '' ) {
                $wordslength = $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] ? $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] : '30';
            }
            $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_content()));

            if ( $readmore == 'true' ) {
                $more = ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="read-more">' . esc_html($readmore_text) . '</a>';
            } else {
                $more = '...';
            }
            $excerpt_new = wp_trim_words($excerpt, $wordslength, $more);
            return $excerpt_new;
        }

    }


    /**
     * Social Networks Detail
     *
     * @param string $icon_type Icon Size.
     * @param string $tooltip Description.
     *
     */
    if ( ! function_exists('wp_rem_cs_social_network') ) {

        function wp_rem_cs_social_network($header9, $icon_type = '', $tooltip = '', $ul_class = '', $no_title = true) {
            global $wp_rem_cs_var_options;
            $html = '';
            $tooltip_data = '';
            if ( $icon_type == 'large' ) {
                $icon = 'icon-2x';
            } else {

                $icon = '';
            }
            if ( isset($tooltip) && $tooltip <> '' ) {
                $tooltip_data = 'data-placement-tooltip="tooltip"';
            }
            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) and count($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) > 0 ) {
                $i = 0;

                $html .= '<ul class="' . $ul_class . '">';
                if ( is_array($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) ):
                    foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_social_net_url'] as $val ) {
                        if ( '' !== $val ) {
                            if ( $no_title == false ) {
                                $data_original_title = '';
                            } else {
                                $data_original_title = $wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i];
                            }
                            $html .= '<li>';
                            $html .= '<a href="' . $val . '" data-original-title="' . $data_original_title . '" data-placement="top" ' . balanceTags($tooltip_data, false) . ' class="colrhover"  target="_blank">';
                            if ( $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i] <> '' && isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i]) ) {
                                $html .= '<i class="fa ' . $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i] . $icon . '"></i>';
                            } else {
                                $html .= '<img title="' . $wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i] . '" src="' . $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array'][$i] . '" alt="' . $wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i] . '" />';
                            }
                            $html .= '</a>
                            </li>';
                        }
                        $i ++;
                    }
                endif;
                $html .= '</ul>';
            }
            if ( $header9 == 1 ) {
                return $html;
            } else {
                echo force_balance_tags($html);
            }
        }

    }
    /**
     * @Get sidebar name id
     *
     */
    if ( ! function_exists('wp_rem_cs_get_sidebar_id') ) {

        function wp_rem_cs_get_sidebar_id($wp_rem_cs_page_sidebar_left = '') {

            return sanitize_title($wp_rem_cs_page_sidebar_left);
        }

    }

    /**
     * Start Function Allow Special Character
     */
    if ( ! function_exists('wp_rem_cs_allow_special_char') ) {

        function wp_rem_cs_allow_special_char($input = '') {
            $output = $input;
            return $output;
        }

    }
    /**
     * @Custom CSS
     *
     */
    if ( ! function_exists('wp_rem_cs_write_stylesheet_content') ) {

        function wp_rem_cs_write_stylesheet_content() {
            global $wp_filesystem, $wp_rem_cs_var_options;
            require_once get_template_directory() . '/include/frontend/cs-theme-styles.php';
            $wp_rem_cs_export_options = wp_rem_cs_var_custom_style_theme_options();
            $fileStr = $wp_rem_cs_export_options;
            $regex = array(
                "`^([\t\s]+)`ism" => '',
                "`^\/\*(.+?)\*\/`ism" => "",
                "`([\n\A;]+)\/\*(.+?)\*\/`ism" => "$1",
                "`([\n\A;\s]+)//(.+?)[\n\r]`ism" => "$1\n",
                "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
            );
            $newStr = preg_replace(array_keys($regex), $regex, $fileStr);
            $wp_rem_cs_option_fields = $newStr;
            $backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
            if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
                return true;
            }
            if ( ! WP_Filesystem($creds) ) {
                request_filesystem_credentials($backup_url, '', true, false, array());
                return true;
            }
            $wp_rem_cs_upload_dir = get_template_directory() . '/assets/frontend/css/';
            $wp_rem_cs_filename = trailingslashit($wp_rem_cs_upload_dir) . 'default-element.css';
			if ( ! $wp_filesystem->put_contents($wp_rem_cs_filename, $wp_rem_cs_option_fields, FS_CHMOD_FILE) ) {
                
            }
        }

    }

    /**
     * @Breadcrumb Function
     *
     */
    if ( ! function_exists('wp_rem_cs_breadcrumbs') ) {

        function wp_rem_cs_breadcrumbs($wp_rem_cs_border = '') {
            global $wp_query, $wp_rem_cs_var_options, $post, $wp_rem_cs_var_static_text;
            /* === OPTIONS === */
            $wp_rem_cs_var_current_page = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_current_page');
            $wp_rem_cs_var_error_404 = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_404');
            $wp_rem_cs_var_home = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_home');
            $text['home'] = esc_html($wp_rem_cs_var_home); // text for the 'Home' link
            $text['category'] = '%s'; // text for a category page
            $text['search'] = '%s'; // text for a search results page
            $text['tag'] = '%s'; // text for a tag page
            $text['author'] = '%s'; // text for an author page
            $text['404'] = esc_attr($wp_rem_cs_var_error_404); // text for the 404 page
            $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
            $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
            $delimiter = ''; // delimiter between crumbs
            $before = '<li class="active">'; // tag before the current crumb
            $after = '</li>'; // tag after the current crumb
            /* === END OF OPTIONS === */
            $current_page = $wp_rem_cs_var_current_page;
            $homeLink = home_url() . '/';
            $linkBefore = '<li>';
            $linkAfter = '</li>';
            $linkAttr = '';
            $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
            $linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
            $wp_rem_cs_border_style = $wp_rem_cs_border != '' ? ' style="border-top: 1px solid ' . $wp_rem_cs_border . ';"' : '';
            if ( is_home() || is_front_page() ) {
                if ( $showOnHome == "1" )
                    echo '<ul class="breadcrumbs">' . wp_rem_cs_allow_special_char($before) . '<a href="' . esc_url($homeLink) . '">' . esc_html($text['home']) . '</a>' . wp_rem_cs_allow_special_char($after) . '</ul>';
            } else {
                echo '<ul class="breadcrumbs">' . sprintf($linkhome, $homeLink, $text['home']) . wp_rem_cs_allow_special_char($delimiter);
                if ( is_category() ) {
                    $thisCat = get_category(get_query_var('cat'), false);
                    if ( $thisCat->parent != 0 ) {
                        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        echo force_balance_tags($cats);
                    }
                    echo wp_rem_cs_allow_special_char($before) . sprintf($text['category'], single_cat_title('', false)) . wp_rem_cs_allow_special_char($after);
                } elseif ( is_search() ) {
                    echo wp_rem_cs_allow_special_char($before) . sprintf($text['search'], get_search_query()) . wp_rem_cs_allow_special_char($after);
                } elseif ( is_day() ) {
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . wp_rem_cs_allow_special_char($delimiter);
                    echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . wp_rem_cs_allow_special_char($delimiter);
                    echo wp_rem_cs_allow_special_char($before) . get_the_time('d') . wp_rem_cs_allow_special_char($after);
                } elseif ( is_month() ) {
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . wp_rem_cs_allow_special_char($delimiter);
                    echo wp_rem_cs_allow_special_char($before) . get_the_time('F') . wp_rem_cs_allow_special_char($after);
                } elseif ( is_year() ) {
                    echo wp_rem_cs_allow_special_char($before) . get_the_time('Y') . wp_rem_cs_allow_special_char($after);
                } elseif ( is_single() && ! is_attachment() ) {
                    if ( function_exists("is_shop") && get_post_type() == 'product' ) {
                        $wp_rem_cs_shop_page_id = woocommerce_get_page_id('shop');
                        $current_page = get_the_title(get_the_id());
                        $wp_rem_cs_shop_page = "<li><a href='" . esc_url(get_permalink($wp_rem_cs_shop_page_id)) . "'>" . get_the_title($wp_rem_cs_shop_page_id) . "</a></li>";
                        echo wp_rem_cs_allow_special_char($wp_rem_cs_shop_page);
                        if ( $showCurrent == 1 )
                            echo wp_rem_cs_allow_special_char($before) . esc_html($current_page) . wp_rem_cs_allow_special_char($after);
                    }
                    else if ( get_post_type() != 'post' ) {
                        $post_type = get_post_type_object(get_post_type());
                        $current_page = get_the_title(get_the_id());
                        $slug = $post_type->rewrite;
                        if ( $showCurrent == 1 )
                            echo wp_rem_cs_allow_special_char($delimiter) . wp_rem_cs_allow_special_char($before) . esc_html($current_page) . wp_rem_cs_allow_special_char($after);
                    } else {
                        $cat = get_the_category();
                        $cat = $cat[0];
                        $current_page = get_the_title(get_the_id());
                        $cats = get_category_parents($cat, TRUE, $delimiter);
                        if ( $showCurrent == 0 )
                            $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                        echo wp_rem_cs_allow_special_char($cats);
                        if ( $showCurrent == 1 )
                            echo wp_rem_cs_allow_special_char($before) . esc_html($current_page) . wp_rem_cs_allow_special_char($after);
                    }
                } elseif ( ! is_single() && ! is_page() && get_post_type() <> '' && get_post_type() != 'post' && ! is_404() ) {
                    $post_type = get_post_type_object(get_post_type());
                    echo wp_rem_cs_allow_special_char($before) . $post_type->labels->singular_name . wp_rem_cs_allow_special_char($after);
                } elseif ( isset($wp_query->query_vars['taxonomy']) && ! empty($wp_query->query_vars['taxonomy']) ) {
                    $taxonomy = $taxonomy_category = '';
                    $taxonomy = $wp_query->query_vars['taxonomy'];
                    echo wp_rem_cs_allow_special_char($before) . esc_html($taxonomy) . wp_rem_cs_allow_special_char($after);
                } elseif ( is_page() && ! $post->post_parent ) {
                    if ( $showCurrent == 1 )
                        echo wp_rem_cs_allow_special_char($before) . get_the_title() . wp_rem_cs_allow_special_char($after);
                } elseif ( is_page() && $post->post_parent ) {

                    $parent_id = $post->post_parent;
                    $breadcrumbs = array();
                    while ( $parent_id ) {
                        $page = get_page($parent_id);
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                        $parent_id = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    for ( $i = 0; $i < count($breadcrumbs); $i ++ ) {
                        echo wp_rem_cs_allow_special_char($breadcrumbs[$i]);
                        if ( $i != count($breadcrumbs) - 1 )
                            echo wp_rem_cs_allow_special_char($delimiter);
                    }
                    if ( $showCurrent == 1 )
                        echo wp_rem_cs_allow_special_char($delimiter . $before . get_the_title() . $after);
                } elseif ( is_tag() ) {

                    echo wp_rem_cs_allow_special_char($before) . sprintf($text['tag'], single_tag_title('', false)) . wp_rem_cs_allow_special_char($after);
                } elseif ( is_author() ) {
                    global $author;
                    $userdata = get_userdata($author);
                    echo wp_rem_cs_allow_special_char($before) . sprintf($text['author'], $userdata->display_name) . wp_rem_cs_allow_special_char($after);
                } elseif ( is_404() ) {
                    echo wp_rem_cs_allow_special_char($before) . esc_html($text['404']) . wp_rem_cs_allow_special_char($after);
                }
                echo '</ul>';
            }
        }

    }

    /**
     * Start Function how to Set Post Views
     */
    if ( ! function_exists('wp_rem_post_views_count') ) {

        function wp_rem_post_views_count($postID) {
            $cs_views_counter = get_post_meta($postID, "wp_rem_post_views_counter", true);
            if ( ! isset($_COOKIE["wp_rem_post_views_counter" . $postID]) ) {
                setcookie("wp_rem_post_views_counter" . $postID, time() + 86400);
                update_post_meta($postID, 'wp_rem_post_views_counter', $cs_views_counter + 1);
            }
        }

    }

    /*
     * Google Api Key render function
     */
    if ( ! function_exists('wp_rem_cs_enqueue_google_map') ) {

        function wp_rem_cs_enqueue_google_map($google_api = '') {
            $google_api_key = '';
            if ( isset($google_api) && $google_api != '' ) {
                $google_api_key = '?key=' . $google_api . '&libraries=places,drawing';
            } else {
                $google_api_key = '?libraries=places,drawing';
            }
            wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js' . $google_api_key, '', '', true);
        }

    }
    /*
     * Encoding and Decoding [ ] for map style snizzy map
     */

    if ( ! function_exists('rem_custom_shortcode_encode') ) {

        function rem_custom_shortcode_encode($sh_content = '') {
            $sh_content = str_replace(array( '[', ']' ), array( 'rem_open', 'rem_close' ), $sh_content);
            return $sh_content;
        }

    }
    if ( ! function_exists('rem_custom_shortcode_decode') ) {

        function rem_custom_shortcode_decode($sh_content = '') {
            $sh_content = str_replace(array( 'rem_open', 'rem_close' ), array( '[', ']' ), $sh_content);
            return $sh_content;
        }

    }
