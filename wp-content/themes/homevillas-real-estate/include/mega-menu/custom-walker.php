<?php

/**
 * Custom Walker
 * @access      public
 * @since       1.0 
 * @return      void
 */
class wp_rem_cs_mega_menu_walker extends Walker_Nav_Menu {

    private $CurrentItem, $CategoryMenu, $menu_style;
    public $parent_menu_item_id = 0;
    public $child_items_count = 0;
    public $child_menu_item_id = 0;
    public $view = '';

    function __Construct( $view = '' ) {
        $this->view = $view;
    }

    // Start function for Mega menu
    function cs_menu_start() {
        $sub_class = $last = '';
        $count_menu_posts = 0;
        $mega_menu_output = '';
    }

    // Start function For Mega menu level
    function start_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
        $indent = str_repeat( "\t", $depth );

        $output .= $this->cs_menu_start();
        $columns_class = $this->CurrentItem->columns;

        $cs_parent_id = $this->CurrentItem->menu_item_parent;

        $parent_nav_mega = get_post_meta( $cs_parent_id, '_menu_item_megamenu', true );

        $parent_nav_mega_view = get_post_meta( $cs_parent_id, '_menu_item_view', true );

        if ( $parent_nav_mega_view == 'cat-view-1' || $parent_nav_mega_view == 'cat-view-3' ) {
            $mega_dropdown_class = 'mega-dropdown-post';
        } else if ( $parent_nav_mega_view == 'cat-view-2' ) {
            $mega_dropdown_class = 'mega-dropdown-category';
        } else {
            $mega_dropdown_class = 'has-border';
        }

        if ( $this->CurrentItem->megamenu == 'on' && $depth == 0 ) {
			$output .= '
			<script>
			var site_header_el = document.getElementById("header");
			site_header_el.className += " has-mega-menu";
			</script>';
            $output .= "\n$indent<ul class=\"mega-dropdown-lg $mega_dropdown_class\">\n";
        } else {
            if ( $this->view === 'main' && $parent_nav_mega == 'on' && $parent_nav_mega_view == 'simple' && $depth == 1 ) {
                $output .= "\n$indent<ul id=\"menulist" . $this->parent_menu_item_id . $this->child_menu_item_id . "\">\n";
            } else {
                $output .= "\n$indent<ul>\n";
            }
        }
    }

    // Start function For Mega menu level end 

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        global $wp_rem_cs_var_static_text;
        $cs_parent_id = $this->CurrentItem->menu_item_parent;
        $parent_nav_mega = get_post_meta( $this->parent_menu_item_id, '_menu_item_megamenu', true );
        $parent_nav_mega_view = get_post_meta( $this->parent_menu_item_id, '_menu_item_view', true );

        $indent = str_repeat( "\t", $depth );
        $output .= $indent . "</ul> <!--End Sub Menu -->\n";
		
		$item_id = $this->parent_menu_item_id . $this->child_menu_item_id;
    }

    // Start function For Mega menu items

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        global $wp_query;
        $this->CurrentItem = $item;

        $parent_nav_mega = 'off';
        $parent_item_mega_view = '';

        //// show more/less more variables 
        $li_style = '';
        if ( $depth == 2 ) {
            $this->child_items_count ++;
        } else {
            $this->child_items_count = 0;
        }

        if ( $depth == 0 ) {
            $this->parent_menu_item_id = $item->ID;
        }
        if ( $depth == 1 ) {
            $this->child_menu_item_id ++;
        } else if ( $depth == 0 ) {
            $this->child_menu_item_id = 0;
        }
        //// end show more/less more

        if ( $depth == 1 ) {
            $parent_menu_id = $item->menu_item_parent;
            $parent_nav_mega = get_post_meta( $parent_menu_id, '_menu_item_megamenu', true );
            $parent_item_mega_view = get_post_meta( $parent_menu_id, '_menu_item_view', true );
        }

        if ( empty( $args ) ) {
            $args = new stdClass();
        }

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        if ( $depth == 0 ) {
            $class_names = $value = '';
            $mega_menu = '';
        } else if ( $args->has_children ) {
            $class_names = $value = '';
            $mega_menu = '';
        } else {
            $class_names = $value = $mega_menu = '';
        }
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( " $mega_menu ", apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        if ( $this->CurrentItem->megamenu == 'on' && $args->has_children && $depth == 0 ) {
            $class_names = ' class="' . esc_attr( $class_names ) . ' mega-menu"';
        } else if ( $this->CurrentItem->megamenu == 'on' && $this->CurrentItem->view != 'simple' && ! $args->has_children && $depth == 0 ) {
            $class_names = ' class="' . esc_attr( $class_names ) . ' menu-item-has-children mega-menu"';
        } else if ( $parent_nav_mega == 'on' ) {
            if ( $depth == 1 && $parent_item_mega_view == 'simple' ) {
                $class_names = ' class="col-lg-2 col-md-2 col-sm-4 col-xs-12 mega-menu-categories"';
            } else {
                $class_names = ' class="col-lg-2 col-md-2 col-sm-4 col-xs-12"';
            }
        } else {
            $class_names = ' class="' . esc_attr( $class_names ) . '"';
        }

        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

        $attributes = isset( $item->attr_title ) && $item->attr_title != '' ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= isset( $item->target ) && $item->target != '' ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= isset( $item->xfn ) && $item->xfn != '' ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= isset( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $item_output = isset( $args->before ) ? $args->before : '';

        if ( $parent_nav_mega == 'on' && $depth == 1 ) {
            $item_output .= '<div class="mega-menu-title"><span>';
        } else {
            $item_output .= '<a' . $attributes . '>';
        }
        $cs_link_before = isset( $args->link_before ) ? $args->link_before : '';
        $item_output .= $cs_link_before . apply_filters( 'the_title', $item->title, $item->ID );
        if ( $this->CurrentItem->subtitle != '' ) {
            $item_output .= '<span>' . $this->CurrentItem->subtitle . '</span>';
        }
        $cs_link_after = isset( $args->link_before ) ? $args->link_before : '';
        $item_output .= $cs_link_after;
        if ( $parent_nav_mega == 'on' && $depth == 1 ) {
            $item_output .= '</span></div>';
        } else {
            $item_output .= '</a>';
        }

        if ( $this->view === 'main' && $this->CurrentItem->megamenu == 'on' && $this->CurrentItem->view != 'simple' && $depth == 0 ) {
            $this_menu_view = isset( $this->CurrentItem->view ) ? $this->CurrentItem->view : 'cat-view-1';
            $this_menu_categories = isset( $this->CurrentItem->categories ) ? $this->CurrentItem->categories : '';

            $item_output .= $this->categories_view( $this_menu_view, $this_menu_categories, $item->ID );
        }

        $item_output .= isset( $args->after ) ? $args->after : '';
        if ( ! empty( $mega_menu ) && empty( $args->has_children ) && $this->CurrentItem->megamenu == 'on' ) {
            $item_output .= $this->cs_menu_start();
        }
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
    }

    // Start function For Mega menu display elements

    function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // categories views
    function categories_view( $view = '', $categories = '', $item_id = '' ) {
        $html = '';
        if ( $view == 'cat-view-2' ) {
            $menu_title = get_post_meta( $item_id, '_menu_item_cat_title', true );
            $html = '
			<ul class="mega-dropdown-lg mega-dropdown-category">';

            if ( $menu_title != '' ) {
                $html .= '
				<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="mega-menu-title"><span>' . $menu_title . '</span></div>
				</li>';
            }
            if ( is_array( $categories ) && sizeof( $categories ) > 0 ) {
                foreach ( $categories as $category ) {

                    $category = get_term_by( 'slug', $category, 'category' );

                    if ( is_object( $category ) ) {
                        $cat_meta = get_term_meta( $category->term_id, 'cat_meta_data', true );
                        $cat_color = isset( $cat_meta['cat_color'] ) ? $cat_meta['cat_color'] : '';
                        $cat_icon = isset( $cat_meta['cat_icon'] ) ? $cat_meta['cat_icon'] : '';
                        $category_icon = $icon_style = '';
                        if ( '' !== $cat_color ) {
                            $icon_style = 'style="color:' . $cat_color . ' !important;"';
                        }
                        if ( '' !== $cat_icon ) {
                            $category_icon = '<i ' . $icon_style . ' class="' . esc_attr( $cat_icon ) . '"></i>';
                        }
                        $html .= '
						<li class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
							<div class="category-list">
								<a href="' . get_category_link( $category->term_id ) . '">
									' . $category_icon . '
									<span>' . $category->name . '</span>
								</a>
							</div>
						</li>';
                    }
                }
            }
            $html .= '
			</ul>';
        } else if ( $view == 'cat-view-3' ) {
            if ( is_array( $categories ) && sizeof( $categories ) > 0 ) {
                $html = '<ul class="mega-dropdown-lg mega-dropdown-post">
					<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="widget-post vertical-tab">
							<div class="row">';
                
                $html .= '<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
						<ul class="nav nav-tabs">';
                $cat_counter = 0;
                foreach ( $categories as $category ) {
                    $active_class = '';
                    if ( $cat_counter == 0 ) {
                        $active_class = ' class="active"';
                    }
                    $category = get_term_by( 'slug', $category, 'category' );
                    if ( is_object( $category ) ) {
                        $html .= '<li' . $active_class . '><a data-toggle="tab" href="#view-3-category-' . $category->term_id . '">' . $category->name . '</a></li>';
                    }
                    $cat_counter ++;
                }
                $html .= '</ul>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
						<div class="tab-content">';
                $cat_counter = 0;
                foreach ( $categories as $category ) {
                    $active_class = '';
                    if ( $cat_counter == 0 ) {
                        $active_class = ' in active';
                    }
                    $category = get_term_by( 'slug', $category, 'category' );
                    if ( is_object( $category ) ) {

                        $html .= '					
						<div id="view-3-category-' . $category->term_id . '" class="tab-pane fade' . $active_class . '">';
                        if ( $category->count > 4 ) {
                            $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <a class="view-all" href="' . esc_url( get_term_link( $category->term_id ) ) . '">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_view_all') . ' <i class="icon-angle-double-right"></i></a> </div>';
                        }
                        $html .= '<div class="widget widget-video">
						<ul>';
                        $posts_array = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 4, 'post_status' => 'publish', 'category' => 'category', 'category_name' => $category->slug ) );

                        foreach ( $posts_array as $menu_post ) {
                            $post_media = '';
                            $post_thumbnail_id = get_post_thumbnail_id( $menu_post->ID );
                            if ( $post_thumbnail_id != '' ) {
                                $post_thumbnail_url = wp_get_attachment_image_src( $post_thumbnail_id, 'wp_rem_cs_media_4' );
                                $post_media = '<div class="cs-media">
									<figure> <a href="' . esc_url( get_permalink( $menu_post->ID ) ) . '"><img src="' . (isset( $post_thumbnail_url[0] ) ? $post_thumbnail_url[0] : '') . '" alt="" /></a> </figure>
								</div>';
                            }
                            $post_title = wp_rem_cs_get_post_excerpt( $menu_post->post_title, 6 );
                            $html .= '<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								' . $post_media . '
								<div class="cs-text"> <a href="' . esc_url( get_permalink( $menu_post->ID ) ) . '">' . $post_title . '</a> </div>
							</li>';
                        }
                        wp_reset_postdata();
                        $html .= '</ul>
						</div>
						</div>';
                        $cat_counter ++;
                    }
                }
                $html .= '</div>
						</div>
						</div>
						</div>
					</li>
				</ul>';
            }
        } else {
            if ( is_array( $categories ) && sizeof( $categories ) > 0 ) {
                $html = '
				<ul class="mega-dropdown-lg mega-dropdown-post">
					<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="widget-post horizontal-tab">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<ul class="nav nav-tabs">';
                $cat_counter = 0;
                foreach ( $categories as $category ) {
                    $active_class = '';
                    if ( $cat_counter == 0 ) {
                        $active_class = ' class="active"';
                    }
                    $category = get_term_by( 'slug', $category, 'category' );
                    if ( is_object( $category ) ) {
                        $html .= '<li' . $active_class . '><a data-toggle="tab" href="#category-' . $category->term_id . '">' . $category->name . '</a></li>';
                    }
                    $cat_counter ++;
                }
                $html .= '</ul>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="tab-content">';
                $cat_counter = 0;
                foreach ( $categories as $category ) {
                    $active_class = '';
                    if ( $cat_counter == 0 ) {
                        $active_class = ' in active';
                    }
                    $category = get_term_by( 'slug', $category, 'category' );
                    if ( is_object( $category ) ) {

                        $html .= '<div id="category-' . $category->term_id . '" class="tab-pane fade' . $active_class . '">
						<div class="widget widget-video">
						<ul class="widget-post-slider">';
                        $posts_array = get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'publish', 'category' => 'category', 'category_name' => $category->slug ) );

                        foreach ( $posts_array as $menu_post ) {
                            $post_media = '';
                            $post_thumbnail_id = get_post_thumbnail_id( $menu_post->ID );
                            if ( $post_thumbnail_id != '' ) {
                                $post_thumbnail_url = wp_get_attachment_image_src( $post_thumbnail_id, 'wp_rem_cs_media_4' );
                                $post_media = '
								<div class="cs-media">
									<figure> <a href="' . esc_url( get_permalink( $menu_post->ID ) ) . '"><img src="' . (isset( $post_thumbnail_url[0] ) ? $post_thumbnail_url[0] : '') . '" alt="" /></a> </figure>
								</div>';
                            }
                            $post_title = wp_rem_cs_get_post_excerpt( $menu_post->post_title, 6 );
                            $html .= '
							<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								' . $post_media . '
								<div class="cs-text"> <a href="' . esc_url( get_permalink( $menu_post->ID ) ) . '">' . $post_title . '</a> </div>
							</li>';
                        }
                        wp_reset_postdata();
                        $html .= '
						</ul>
						</div>
						</div>';
                        $cat_counter ++;
                    }
                }
                $html .= '
						</div>
						</div>
						</div>
						</div>
					</li>
				</ul>';
            }
        }
        return $html;
    }

}
