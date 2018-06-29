<?php

/*

 * Theme style

 */

if ( ! function_exists('wp_rem_cs_var_custom_style_theme_options') ) {

    $wp_rem_cs_var_custom_themeoption_str = '';



    /**

     * @Start Function for Theme Option Backend Settings and Classes

     *

     */

    function wp_rem_cs_var_custom_style_theme_options() {

        global $wp_rem_cs_var_custom_themeoption_str;

        $wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');

        ob_start();

        $wp_rem_cs_var_theme_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_theme_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_theme_color'] : '';

        $wp_rem_cs_var_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_bg_color']) && $wp_rem_cs_var_options['wp_rem_cs_var_bg_color'] != '' ) ? $wp_rem_cs_var_options['wp_rem_cs_var_bg_color'] : '';

        $wp_rem_cs_var_text_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_text_color']) && $wp_rem_cs_var_options['wp_rem_cs_var_text_color'] != '' ) ? $wp_rem_cs_var_options['wp_rem_cs_var_text_color'] : '';

        $wp_rem_cs_var_theme_sticky_bgcolor = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header_bgcolor']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header_bgcolor'] : '';

        $wp_rem_cs_var_second_theme_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_second_theme_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_second_theme_color'] : '';

        $wp_rem_cs_var_sticky_menu_text_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_menu_text_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_menu_text_color'] : '';

        $wp_rem_cs_var_title_bottom_spacing = isset($wp_rem_cs_var_options['wp_rem_cs_var_title_bottom_spacing']) ? $wp_rem_cs_var_options['wp_rem_cs_var_title_bottom_spacing'] : '';

        ?>



        /*!

        *Theme Colors Classes*/

        .text-color, .property-sorting-holder .user-location-filters li a:hover, .property-sorting-holder .user-location-filters li a.active, .property-grid .text-holder .property-price, .property-grid .like-btn a:hover,

        .property-grid .post-title a:hover, .property-medium .post-title a:hover, .property-medium .like-btn a:hover, .wp-rem-filters .search-options .reset-results, .sub-header .breadcrumbs ul li.active a, .sub-header .breadcrumbs ul li.active:after,

        .sub-header .breadcrumbs ul li:hover a, .sub-header .breadcrumbs ul li:hover:after, .field-select-holder ul li ul.dropdown-select li a:hover, .field-select-holder ul li a span, .nav-list-detail ul li:hover a, .main-header .social-media li a:hover,

        .blog .text-holder .author-info span a, .blog .post-title h2:hover a, .blog .text-holder .post-options li:hover a, .blog .post-title h3:hover a, .blog .post-title h4:hover a,.widget.widget-latest-post ul li .text-holder h6 a:hover, .widget.widget-archives ul li:hover a,

        .widget.widget-property-types ul li:hover a, blockquote p i, blockquote p:before, .tags-list ul li a, .blog.blog-grid .icons-list span a:hover,

        .blog.blog-grid .post-title h5 a:hover, .member-grid .member-info li a:hover,

        .sub-header  ul.breadcrumbs li:hover:after, .sub-header  ul.breadcrumbs li:hover a, .sub-header  ul.breadcrumbs li:hover, .sub-header ul.breadcrumbs li.active, .sub-header ul.breadcrumbs li.active:after, .property-featured-widget .text-holder h6 a:hover, .member-medium .text-holder .post-title h4 a:hover, .member-medium .member-info li a:hover, #footer .footer-widget a:hover, .widget.widget_nav_menu ul li a:hover, .widget.widget-categories li a:hover, .widget.widget_categories li a:hover, .widget.widget_pages ul li a:hover, .widget.widget_archive li a:hover,

        .widget.widget_meta li a:hover, .widget.widget_nav_menu ul li a:hover:before, .widget.widget-categories li a:hover:before, .widget.widget-archives ul li a:hover,

        .widget.widget_categories li:hover:before, .widget.widget_pages ul li:hover:before, .widget.widget_archive li:hover:before, .widget.widget-archives ul li:hover a:before, .widget.twitter-post li p a, .widget.widget_recent_comments li a:hover, .widget.widget_rss li .rsswidget:hover, .user-account-nav.user-account-sidebar ul.dashboard-nav li:hover a, .section-title span, .faqs .element-title h5, .blockquote-fancy blockquote p:before, .blockquote-fancy blockquote p:after, .main-header .login-option .user-dashboard-menu li.user-dashboard-menu-children ul i, .main-header .top-header .property-btn, .page-not-found .cs-text span.cs-error, .blog.blog-grid .button-holder .btn-readmore:hover i, .blog.blog-grid .button-holder .btn-readmore:hover,

        .suggest-list-holder .text-holder a.shortlisted i.icon-heart5, .property-type.checkbox label, #footer .copy-right p a:hover, .cs-checkbox-list .checkbox label:hover, .profile-info .submit-btn:hover, .widget-payment-holder a:hover, .profile-info input[type="submit"]:hover, .member-detail .member-info .text-holder .info-list li:hover, .member-detail .member-info .text-holder .info-list a:hover, .widget.widget-newsletter .field-holder .btn-holder:hover, .comment-form .field-holder .submit-btn:hover, .pricetable-holder a.buy-now:hover, .contact-form form .field-holder .btn-holder:hover, .blog .text-holder .post-views a:hover, .modal-form .field-holder p a:hover, .field-select-holder ul li ul.delivery-dropdown li a:hover, .ysection .media-story .media-title a:hover, .property-detail .apartment-list tbody tr td .view-btn:hover, .property-detail .architecture-holder .nav > li > a:hover, .member-medium .profile-btn:hover, .member-alphabatic ul li a:hover, .icon-boxes h5 a:hover, .show-more-property #filters li.active a, .show-more-property #filters li a:hover, .show-more-property #filters li a:focus, .liting_map_info .info-txt-holder a.info-title:hover, .liting_map_info a.close:hover, .suggest-list-holder .text-holder span a:hover, .real-estate-property .caption-inner .rent-label:hover a, .user-property .user-list ul.panel-group li .panel .panel-heading .img-holder span:hover a, .user-account-nav.user-account-sidebar ul.dashboard-nav li.active a, .poi-info-window .view-link:hover, .poi-info-window a:hover, .cs-construction .cs-social-media li a, .signup-form .login-section a, .woocommerce.single-product div.product .product_meta .posted_in a, .woocommerce .wc-proceed-to-checkout .checkout-button.button:hover, .woocommerce form table.shop_table input.button[type="submit"]:hover, p.lost_password a:hover, .woocommerce ul.products li.product .price del, .wp-rem-filters .cs-parent-checkbox-list .checkbox label, .membership-info-main .property-pkg-select:hover, .member-detail .contactform_name input[type='submit']:hover, .member-tabs  .nav > li > a:hover, .member-tabs  .nav > li > a:focus, .member-tabs  .nav > li.active a, .member-tabs  .nav > li a:active, .user-account-holder .user-holder.create-property-holder .btns-section .back-btn-field:hover i, .modal-form input[type='button']:hover, .modal-form input[type='submit']:hover, .post-inner-member .post-title h4 a:hover, .widget .properties-post .post-title h4 a:hover, .widget .member-post .post-title h4 a:hover, .chosen-container .chosen-results li.highlighted, .chosen-container .chosen-results li.result-selected, ul.sub-nav li.active .btn-edit-profile,

        ul.sub-nav li.active a, .upload-file button[type='button'], .blog.blog-medium .blog-post .text-holder p .read-more, .blog.blog-large .text-holder p .read-more, .pricetable-holder .buy-btn:hover, .pricetable-holder .wp-rem-subscribe-pkg-btn:hover i, .tabs-property address a:hover, .discussion-submit:hover, .property-medium .property-price, .select-location .select-popup .location-close-popup I, .checkbox label:hover, .member-medium .member-info li a, .member-grid .member-info li, .member-grid .member-info li a, .tabs-property .member-data span a:hover, .property-data li a:hover, .member-detail .member-opening-hours ul li ul.delivery-dropdown li.today a span.opend-day, .member-detail .member-opening-hours ul li ul.delivery-dropdown li.today a span.opend-time, input[type='radio'].css-radio:checked + label.css-radio-lbl:after, .pricetable-holder.center ul li:before, .member-medium .member-info li, .member-medium .properties-count span, .wp-rem-wpml-languages ul li ul > li:hover > a img ~ span, .real-estate-property .modern-filters li.active span a, .real-estate-property .modern-filters li:hover span a, .column-text.classic .categories-holder.classic li i, .blog.blog-medium.classic .img-holder figure i, .property-grid.modern .like-btn a, .property-grid.default .checkbox label, .team.team-grid.classic .post-options li a:hover, .compare-text-div a, .compare-properties-types .field-holder ul li label, .counter-holder .cs-counter.default .img-holder i, .team.default .swiper-button-next, .team.default .swiper-button-prev, .team-grid.default .post-title:hover h5 a, .team.team-grid.default .social-media ul li a:hover i, #footer.modern .footer-social-media ul li a i:hover, #footer .widget-nav ul li:hover:before, #footer .widget_nav_menu ul li:hover:before, .property-grid.modern.v2 .like-btn a i.icon-heart5, .property-grid.modern .text-holder .property-price em, .top-locations.v2 ul li a:hover, .scoring-list .text-holder .moredetail-btn:hover, .attachment-holder ul.attachment-formats li a:hover, .list-detail-options a.btn-compare:hover span, .detail-nav ul li:hover a, .detail-nav-map ul li.active a, .scoring-list .text-holder strong:hover, .main-search .field-holder.advanced-btn a, .property-medium.modern .post-title h4 a:hover, .blog.blog-medium.list .text-holder h5 a, .member-grid.member-grid-slider span.properties-count > a, .blog.blog-medium.list .post-title h4 a.text-color, .faqs.modern .panel-group .panel-heading a, .faqs.modern .faq.panel-group .panel-heading a.collapsed:hover, .main-search.fancy.v3 .select-location .slider-handle:before{

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }

        /*!

        * Theme Background Color */

        .bgcolor, .top-map-search-inner input[type="submit"], .real-estate-property .caption-inner span.rent-label,

        .pagination li a:hover, .pagination li.active a, .pagination li a.active, .pagination li.active span, .main-header .top-header .property-btn:hover, .widget.widget-tag-cloud a:hover, .member-medium .social-media a:hover, .member-detail .member-info .social-media a:hover, .member-medium .profile-btn, .footer-widget .widget-social-media ul li a:hover i, .widget .tagcloud a:hover, .page-sidebar .widget-title h5:after, .widget.widget-newsletter .field-holder .btn-holder:hover, .widget.widget_search form .btn-default:hover .pagination > .active > span, .main-search .field-holder.advanced-btn a, .datepicker table tr td.day:hover, .datepicker thead tr:first-child th:hover, .datepicker tfoot tr:first-child th:hover, .slicknav_btn, .wp-rem-bank-transfer .list-group li > .badge, .property-type.checkbox input[type="radio"]:checked + label, .main-search .property-type.checkbox label:hover, .slide-loader-holder.slide-loader:before, .user-account-holder .wp_rem_loader, .member-detail .member-info .send-btn:hover, .team .contact-btn:hover, .team.team-medium .social-media ul li a:hover, .wp-rem-top-map-holder .slide-loader.loading:before, .wp-rem-top-map-holder ul.map-actions li, .password_protected input[type="submit"], .password_protected .protected-icon a, .post-title h3 span, .wp-rem-filters .search-options .reset-holder .email-me-top .email-alert-btn:hover, .signup-form .input-filed .input-sec input[type="radio"]:checked + label, .signup-form .input-filed .input-sec label:hover, .signup-form .user-submit, .blog .btn-readmore:hover, .tags-list ul li a:hover, .related-post .swiper-button-next:hover, .related-post .swiper-button-prev:hover, .login-form .login-switches li:last-child a, .no-results .suggestions ul li:before, .suggestion-search .btn-default, .woocommerce.single-product div.product .stock, .woocommerce.single-product div.product form.cart .button, .woocommerce .woocommerce-message a.button, .woocommerce .wc-proceed-to-checkout .checkout-button.button, .woocommerce form .woocommerce-checkout-payment .form-row input.button, #add_payment_method #payment ul.payment_methods li.wc_payment_method input[type="radio"]:checked + label:after, .woocommerce-checkout #payment ul.payment_methods li.wc_payment_method input[type="radio"]:checked + label:after, .woocommerce form.login .form-row input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input[type="submit"], .woocommerce ul.products li.product a.added_to_cart:hover, .member-contact-form input[type='submit'], .switchs-holder2 .acc-submit:hover, .property-back-dashboard a, .tabs-property .member-data address i:hover, .wp-rem-button-loader, .back-page-url a:hover, .price-per-person .slider-handle, .back-page-url a:hover:before, .property-grid-slider .swiper-button-next:hover i, .property-grid-slider .swiper-button-prev:hover i, .back-page-url a:hover:before, #ui-datepicker-div .ui-state-highlight, #ui-datepicker-div.ui-widget-content .ui-state-highlight, #ui-datepicker-div .ui-widget-header .ui-state-highlight, div.xdsoft_datetimepicker .xdsoft_calendar td:hover,

        div.xdsoft_datetimepicker .xdsoft_time_box >div >div:hover,

        div.xdsoft_datetimepicker .xdsoft_timepicker .xdsoft_time_box >div >div:hover, .invite-member .btn-send, .pricetable-holder.center .cs-price a.try-btn:hover,

        .plans-top-btns a:hover, .plans-compare-btn a:hover, .user-account-holder .user-holder.create-property-holder .btns-section .next-btn-field .next-btn:hover, .payment-holder input[type='submit']:hover, .classic .main-header .login-option a, .column-content.modern .img-holder figure i, .column-content.modern .text-holder .view-btn, .property-grid.classic .post-category-list li:hover i, .real-estate-property .classic .caption-inner .rent-label:hover, .member-medium .text-holder .member-address i, .team.classic .swiper-button-prev:hover, .team.classic .swiper-button-next:hover, .compare-properties-types .field-holder ul li label:hover, .compare-properties-types .field-holder ul li input[type='radio']:checked + label, .default-v2 .main-header .property-btn, header#header.default.default-v2.no-transparent .main-header, .featured-slider .swiper-pagination-bullet-active, .video-holder:hover .img-holder .play-btn a, .btn-top:hover, .view-loc-btn, .grid-default-slider .property-grid.default .location-list, .button-next-member:hover, .button-prev-member:hover, .real-estate-property .swiper-button-next.default:hover, .real-estate-property .swiper-button-prev.default:hover, .newsletter.classic.v2 .field-holder .btn-holder, #header.advance.v2 .main-header .user-dashboard-menu > ul > li.user-dashboard-menu-children:hover, .blog .btn-readmore span, .main-search.fancy.v2 .select-location .select-popup .my-location:hover a, .main-search.fancy.v2 .select-location .slider-handle, .top-locations ul li .image-holder:hover ~ .text-holder, .top-locations ul li .text-holder:hover,	.top-locations ul li .image-holder:hover ~ .text-holder:after, .top-locations ul li .text-holder:hover:after, .main-header .user-dashboard-menu li.menu-open.user-dashboard-menu-children, .main-search.modern.v3 .select-location .slider-handle {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }



        /*!

        * Theme Border Color */

        .border-color, #lang_sel_list #lang_sel ul li a:hover, .widget .tagcloud a:hover, .main-header .top-header .property-btn:hover, .main-header .top-header .property-btn, .property-type.checkbox input[type="radio"]:checked + label, .main-search .property-type.checkbox label:hover, .profile-info .submit-btn:hover, .widget-payment-holder a:hover, .profile-info input[type="submit"]:hover, .widget.widget-newsletter .field-holder .btn-holder:hover, .comment-form .field-holder .submit-btn:hover, .button_style .custom-btn.medium-btn:hover, .team .contact-btn:hover, .team.team-medium .social-media ul li a:hover, .contact-form form .field-holder .btn-holder, .property-detail .apartment-list tbody tr td .view-btn:hover, .member-medium .profile-btn:hover, .real-estate-property .caption-inner .rent-label:hover, .wp-rem-filters .search-options .reset-holder .email-me-top .email-alert-btn:hover, .signup-form .input-filed .input-sec input[type="radio"]:checked + label, .signup-form .input-filed .input-sec label:hover, .blog .btn-readmore:hover, .tags-list ul li a, .related-post .swiper-button-next:hover, .related-post .swiper-button-prev:hover, .woocommerce .wc-proceed-to-checkout .checkout-button.button, .woocommerce form table.shop_table input.button[type="submit"]:hover, .woocommerce ul.products li.product a.added_to_cart:hover, .membership-info-main .property-pkg-select:hover, .member-detail .contactform_name input[type='submit']:hover, .user-account-holder .user-holder.create-property-holder .btns-section .next-btn-field .next-btn:hover, .switchs-holder2 .acc-submit:hover, .modal-form input[type='button']:hover, .modal-form input[type='submit']:hover, .property-back-dashboard a, .upload-file button[type='button'], .tabs-property .member-data address i:hover, .discussion-submit:hover, .testimonial-holder .img-holder .swiper-pagination-switch.active:after, .payment-holder input[type='submit']:hover, .payment-holder input[type='button']:hover, .plans-compare-btn a:hover, .modern-price-table .plans-top-btns a:hover, .property-grid.classic .post-category-list li:hover, .team.classic .swiper-button-prev:hover, .team.classic .swiper-button-next:hover, .compare-properties-types .field-holder ul li label, .team.default .swiper-button-next, .team.default .swiper-button-prev, .advance .main-header .top-header .property-btn, .button-next-member:hover, .button-prev-member:hover, .real-estate-property .swiper-button-next.default:hover, .real-estate-property .swiper-button-prev.default:hover, .top-locations ul li .image-holder:hover ~ .text-holder, .top-locations ul li .text-holder:hover

        {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            border-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }

        /*!

        * Theme Border Bottom Color */

        .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a, .pricetable-holder.active, .detail-nav ul li:hover a, .detail-nav-map ul li.active a

        {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }

        /** Theme Border top Color */

        .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a, .price-per-person .slider-handle:before, .property-grid.modern .text-holder, .main-search.fancy.v2 .select-location .slider-handle:after

        {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            border-top-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }

        /** Theme Border left Color */

        .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a

        {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            border-left-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }

        /* Theme Border right Color */

        .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a

        {

        <?php if ( isset($wp_rem_cs_var_theme_color) || $wp_rem_cs_var_theme_color != '' ) { ?>

            border-right-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_color); ?> !important;

        <?php } ?>

        }



        /* Header sticky background color apply to the sticky */



        #header.header1 .main-header .nav-area.sticky-header.sticky-active,

        header#header.default-v2 .main-header.sticky-active, 

        #header.classic.no-transparent .main-header .nav-area, 

        .classic .main-header .nav-area.sticky-active, 

        .modern .main-header.sticky-header.sticky-active .top-header, 

        .default .main-header.sticky-header.sticky-active .top-header, 

        .advance .main-header.sticky-header.sticky-active .top-header, 

        #header.modern.transparent.sticky-active .main-header,

        #header.default.default-v2 .sticky-header.sticky-active

        {

        <?php if ( isset($wp_rem_cs_var_theme_sticky_bgcolor) || $wp_rem_cs_var_theme_sticky_bgcolor != '' ) { ?>

            background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_sticky_bgcolor); ?> !important;

        <?php } ?>

        }



        .classic.no-transparent .main-header .top-header .contact-info, .classic.no-transparent .main-header .top-header .contact-info i, .classic.no-transparent .main-header .top-header .contact-info a, .classic.no-transparent .main-header .top-header .contact-info small, .classic.no-transparent .main-header .top-header .contact-info span, .classic.no-transparent .main-header .social-media li a, .classic.no-transparent .main-header .login-area > a, .classic.no-transparent .main-header .login-area > i, .logged-in .classic.no-transparent .main-header .user-dashboard-menu-children > a



        {

        <?php if ( isset($wp_rem_cs_var_theme_sticky_bgcolor) || $wp_rem_cs_var_theme_sticky_bgcolor != '' ) { ?>

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_sticky_bgcolor); ?> !important;

        <?php } ?>

        }



        .classic.no-transparent .main-header .login-area > a     {

        <?php if ( isset($wp_rem_cs_var_theme_sticky_bgcolor) || $wp_rem_cs_var_theme_sticky_bgcolor != '' ) { ?>

            border-left-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_sticky_bgcolor); ?> !important;

        <?php } ?>

        }		









        #header.header1 .main-header .nav-area.sticky-header.sticky-active .main-navigation > ul > li > ul,

        header#header.default-v2 .main-header.sticky-active .main-navigation > ul > li > ul, 

        #header.classic.no-transparent .main-header .nav-area .main-navigation > ul > li > ul, 

        .classic .main-header .nav-area.sticky-active .main-navigation > ul > li > ul, 

        .modern .main-header.sticky-header.sticky-active .top-header .main-navigation > ul > li > ul, 

        .default .main-header.sticky-header.sticky-active .top-header .main-navigation > ul > li > ul, 

        .advance .main-header.sticky-header.sticky-active .top-header .main-navigation > ul > li > ul, 

        #header.modern.transparent.sticky-active .main-header .main-navigation > ul > li > ul

        {

        <?php if ( isset($wp_rem_cs_var_theme_sticky_bgcolor) || $wp_rem_cs_var_theme_sticky_bgcolor != '' ) { ?>

            border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_theme_sticky_bgcolor); ?> !important;

        <?php } ?>

        }



        /* Start Sticky menu text color apply to the theme */

        #header.header1 .main-header .nav-area.sticky-header.sticky-active .main-nav > nav > ul > li > a,

        header#header.default-v2 .main-header.sticky-active .main-nav > nav > ul > li > a, 

        #header.classic.no-transparent .main-header .nav-area .main-nav > nav > ul > li > a, 

        .classic .main-header .nav-area.sticky-active .main-nav > nav > ul > li > a, 

        .modern .main-header.sticky-header.sticky-active .top-header .main-nav > nav > ul > li > a, 

        .default .main-header.sticky-header.sticky-active .top-header .main-nav > nav > ul > li > a, 

        .advance .main-header.sticky-header.sticky-active .top-header .main-nav > nav > ul > li > a, 

        #header.modern.transparent.sticky-active .main-header .main-nav > nav > ul > li > a,

        #header.header1 .main-header .nav-area.sticky-header.sticky-active .social-media li a,

        #header.header1 .main-header .nav-area.sticky-header.sticky-active .login-option > .user-dashboard-menu > ul > li > a,

        #header.header1 .main-header .nav-area.sticky-header.sticky-active .login-option > .user-dashboard-menu > ul > li > a i



        {

        <?php if ( isset($wp_rem_cs_var_sticky_menu_text_color) || $wp_rem_cs_var_sticky_menu_text_color != '' ) { ?>

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_sticky_menu_text_color); ?> !important;

        <?php } ?>

        }



        /* End Sticky menu text color apply to the theme  */







        /* Start Theme 2 text color apply to the theme */

        .main-navigation .sub-menu-label > span,

        .main-header .main-nav li a i,

        .contact-property .modern ul .contact-info li i,

        .team.team-medium .post-designation,

        .blog.blog-grid .button-holder .btn-readmore,

        .fancy-heading h2,

        #footer .copy-right p a,

        .icons-lists ul li i,

        .property-search .property-list li,

        .property-search .property-list li a,

        .about-info ul li:before,

        .cs-construction .time-box h4,

        .pricetable-holder.center .cs-pricespan .title,

        .main-header .user-dashboard-menu li ul li a:hover,

        .property-grid .post-category-list li,

        .property-medium .post-category-list li,

        .member-alphabatic .search-title span,

        .minimum-loading-list .spinner span i,

        .price-per-person .rang-text,

        .wp-rem-filters .search-options .reset-holder .email-me-top .email-alert-btn,

        .wp-rem-filters form .field-holder label i,

        .property-info-holder h2,

        .property-info-holder .catagories-list ul li i,

        .profile-info h2,

        .icon-check-list ul li i,

        .show-more-property .element-title h2,

        .show-more-property .element-title .show-more-property,

        .pricetable-holder .cs-price span.title,

        .plans-compare-btn a,

        .select-location .select-popup .my-location i,

        .select-location .select-popup .my-location a,

        .suggest-list-holder .text-holder span,

        .suggest-list-holder .text-holder span a,

        .switchs-holder2 .acc-submit,

        .user-holder .checkbox-list input[type='checkbox']:checked + label,

        .user-holder .create-property-holder .field-holder .checkbox-list input[type='checkbox']:checked + label,

        .user-holder .checkbox-list label:hover,

        .user-holder .create-property-holder .field-holder .checkbox-list label:hover,

        .check-box-remind input[type='checkbox']:checked + label:after,

        .modal-form .field-holder p a,

        .cs-datepicker .datepicker-text-bottom i,

        .tabs-property .member-data i,

        .show-more-property .element-title .show-more-property,

        .property-grid .post-category-list li,

        .property-search .property-list li,

        .blog.blog-grid .button-holder .btn-readmore, 

        .wp-rem-filters form .field-holder,

        .widget-payment-holder .range-slider span.price, .create-properties-cats ul.property-cats-list li input[type='radio']:checked + label, .create-properties-cats ul.property-cats-list li label:hover,

        .contact-property.modern ul.contact-info li i,

        .top-locations.v2 ul li a,

        .column-content ul li:before,

        .property-medium.modern .property-price,

        .grid-default-slider .property-grid.default .price-holder .property-price{

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }



        /* End Theme 2 text color apply to the theme */



        /* Start Theme 2 text placeholder Color apply to the theme */



        .field-input::-webkit-input-placeholder,

        .wp-rem-filters form .field-holder .field-input::-moz-placeholder,

        .wp-rem-filters form .field-holder .field-input:-ms-input-placeholder,

        .wp-rem-filters form .field-holder .field-input:-moz-placeholder {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }



        /* End Theme 2 text placeholder apply to the theme */



        /* Start Theme 2 background color apply to the theme */

        .cs-calltoaction a,

        .contact-property ul .contact-info li,

        .contact-property.modern ul .contact-info:before,

        .button_style .custom-btn,

        .cs-calltoaction a,

        .blog.btn-readmore span,

        .cs-seprater:after,

        .center.cs-seprater:after,

        .left.cs-seprater:after,

        .right.cs-seprater:after,

        .pricetable-holder.center.cs-pricea.try-btn,

        .slide-loader-holder.slide-loader:before,

        .property-medium .opening-time,

        .member-search-filter li a:hover,

        .member-search-filter li.active a,

        .price-per-person .slider-selection,

        .list-detail-options .enquire-holder a.enquire-btn.wp-rem-open-signin-tab

        .main-post.slider .swiper-button-next:hover i,

        .main-post.slider .swiper-button-prev:hover i,

        .main-search .nav-tabs li,

        .main-search .tab-content,

        .singup-from .form-btn,

        .singup-from input.form-btn,

        .select-location .slider-selection,

        .login-form .cs-demo-login a,

        .newsletter .field-holder input[type='button'],

        .newsletter .field-holder input[type='submit'],

        .user-account-holder .wp_rem_loader,

        .login-form form input[type='button'],

        .login-form form input[type='submit'],

        .map-checkboxes .checkbox input[type='checkbox']:checked + label,

        .modal-form input[type='button'],

        .modal-form input[type='submit'],

        div.daterangepicker td.available:hover,

        div.daterangepicker th.available:hover,

        div.daterangepicker .btn-default,

        #ui-datepicker-div .ui-state-active,

        #ui-datepicker-div .ui-widget-content .ui-state-active,

        #ui-datepicker-div .ui-widget-header .ui-state-active,

        #ui-datepicker-div a.ui-button:active,

        #ui-datepicker-div .ui-button:active,

        #ui-datepicker-div .ui-button.ui-state-active:hover,

        .property-data .urgent-property span,

        div.xdsoft_datetimepicker .xdsoft_calendar td.xdsoft_default,

        div.xdsoft_datetimepicker .xdsoft_calendar td.xdsoft_current,

        div.xdsoft_datetimepicker .xdsoft_time_box > div > div.xdsoft_current,

        div.xdsoft_datetimepicker .xdsoft_timepicker .xdsoft_time_box > div > div:hover,

        div.xdsoft_datetimepicker .xdsoft_timepicker .xdsoft_time_box > div > div.xdsoft_current,

        .widget-payment-sec h6, .widget-payment-holder .range-slider .slider-selection,

        .widget-payment-holder .range-slider .slider-handle,

        .list-detail-options .enquire-holder a.enquire-btn[data-target="#enquiry-modal"],

        .back-page-url a,

        .membership-info-main .property-pkg-select,

        .back-page-url a:before,

        .payment-holder input[type='submit'], .payment-holder input[type='button'], .property-back-dashboard a, .wp-rem-top-map-holder ul.map-actions li.map-draw-tools a.delete-draw-area,

        .contact-property ul.contact-info li i,

        .contact-property.modern ul.contact-info:before {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }



        /* End Theme 2 background apply to the theme */





        /* Start Theme 2 background scrollbar color apply to the theme */

        .gm-style .gm-style-iw > div::-webkit-scrollbar-thumb,

        .gm-style .gm-style-iw > div::-webkit-scrollbar-track,

        {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }

        /* End Theme 2 background scrollbar color apply to the theme */





        /* Start Theme 2 border-color apply to the theme */



        .show-more-property .element-title .show-more-property, .map-holder .map-actions li.active a, ul.property-radios li input[type='radio']:checked + label, ul.property-radios li input[type='radio'] + label:hover, .create-properties-cats ul.property-cats-list li input[type='radio']:checked + label, .create-properties-cats ul.property-cats-list li label:hover, .switchs-holder2 .acc-submit, .type-holder-main .loader-holder

        {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            border-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }



        /* End Theme 2 border-color apply to the theme */



        /* Start Theme 2 border-left-color apply to the theme */



        .type-categry-holder-main .loader-holder, .type-holder-main .loader-holder:before, .type-categry-holder-main .loader-holder:before, .property-medium .img-holder:before, .property-grid .img-holder:before

        {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            border-left-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }

        /* End Theme 2 border-left-color apply to the theme */



        /* Start Theme 2 Border Bottom Color apply to the theme */

        .border-bottom-color

        {

        <?php if ( isset($wp_rem_cs_var_second_theme_color) || $wp_rem_cs_var_second_theme_color != '' ) { ?>

            border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_second_theme_color); ?> !important;

        <?php } ?>

        }

        /* End Theme 2 Border Bottom Color apply to the theme */



        /* Theme background color apply to the back page url border */

        .back-page-url a:before

        {

        <?php if ( isset($wp_rem_cs_var_bg_color) || $wp_rem_cs_var_bg_color != '' ) { ?>

            border-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_color); ?> !important;

        <?php } ?>

        }

        <?php

        $wp_rem_cs_var_sitcky_header_switch = isset($wp_rem_cs_var_options['wp_rem_cs_var_sitcky_header_switch']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sitcky_header_switch'] : '';

        $wp_rem_cs_var_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_layout'] : '';

        $wp_rem_cs_var_custom_bgimage = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_bgimage']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_bgimage'] : '';

        $wp_rem_cs_var_bg_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_bg_image']) ? $wp_rem_cs_var_options['wp_rem_cs_var_bg_image'] : '';

        $wp_rem_cs_var_pattern_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_pattern_image']) ? $wp_rem_cs_var_options['wp_rem_cs_var_pattern_image'] : '';

        $wp_rem_cs_var_background_position = isset($wp_rem_cs_var_options['wp_rem_cs_var_bgimage_position']) ? $wp_rem_cs_var_options['wp_rem_cs_var_bgimage_position'] : '';

        if ( $wp_rem_cs_var_layout != 'full_width' ) {

            $wp_rem_cs_repeat_options = false;

            if ( $wp_rem_cs_var_custom_bgimage != "" ) {

                $wp_rem_cs_repeat_options = true;

                $wp_rem_cs_var_background_image = $wp_rem_cs_var_custom_bgimage;

            } else if ( $wp_rem_cs_var_bg_image != "" && $wp_rem_cs_var_bg_image != 'bg0' ) {

                $wp_rem_cs_var_background_image = trailingslashit(get_template_directory_uri()) . "assets/backend/images/background/" . wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_image) . ".png";

            } else if ( $wp_rem_cs_var_pattern_image != "" && $wp_rem_cs_var_pattern_image != 'pattern0' ) {

                $wp_rem_cs_var_background_image = trailingslashit(get_template_directory_uri()) . "assets/backend/images/patterns/" . wp_rem_cs_allow_special_char($wp_rem_cs_var_pattern_image) . ".png";

            }

            if ( isset($wp_rem_cs_var_background_image) && $wp_rem_cs_var_background_image <> "" ) {

                if ( $wp_rem_cs_repeat_options == true ) {

                    $wrppaer_style = 'background:url(' . wp_rem_cs_allow_special_char($wp_rem_cs_var_background_image) . ') ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_background_position) . ' ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_color) . ' !important;';

                } else {

                    $wrppaer_style = 'background:url(' . $wp_rem_cs_var_background_image . ') repeat ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_color) . ' !important;';

                }

            } else if ( $wp_rem_cs_var_bg_color != '' ) {

                $wrppaer_style = 'background:' . $wp_rem_cs_var_bg_color . ' !important;';

            }

        } else if ( $wp_rem_cs_var_custom_bgimage != '' ) {

            $wrppaer_style = 'background:url(' . $wp_rem_cs_var_custom_bgimage . ') ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_background_position) . ' ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_color) . ' !important;';

        } else if ( $wp_rem_cs_var_bg_color != '' ) {

            $wrppaer_style = 'background:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_bg_color) . ' !important;';

        }

        if ( isset($wrppaer_style) && $wrppaer_style != '' ) {

            ?>

            body{ <?php echo wp_rem_cs_allow_special_char($wrppaer_style) ?> }

            <?php

        }

///// Start Extra CSS

        if ( isset($wp_rem_cs_var_sitcky_header_switch) && $wp_rem_cs_var_sitcky_header_switch == 'on' ) {

            ?>

            .cs-main-nav {

            position: fixed !important;

            z-index: 99 !important;

            }

            <?php

        } else {

            ?>

            .cs-main-nav {

            position: relative !important;

            }

            <?php

            }

?>

            /* Start element title bottom spacing */

            .element-title-bottom-spacing, .element-title

            {

            <?php if ( isset($wp_rem_cs_var_title_bottom_spacing) || $wp_rem_cs_var_title_bottom_spacing != '' ) {

                ?>

                margin-bottom:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_title_bottom_spacing); ?>px !important;

            <?php } ?>

            }

            /* End element title bottom spacing */







<?php



            ///// END Extra CSS

            /**

            * @Set Header color Css

            *

            *

            */

            $wp_rem_cs_var_top_strip_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_top_strip_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_top_strip_color'] : '';

            $wp_rem_cs_var_top_strip_bgcolor = (isset($wp_rem_cs_var_options['wp_rem_cs_var_top_strip_bgcolor'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_top_strip_bgcolor'] : '';

            $wp_rem_cs_var_header_bgcolor = (isset($wp_rem_cs_var_options['wp_rem_cs_var_header_bgcolor']) and $wp_rem_cs_var_options['wp_rem_cs_var_header_bgcolor'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_header_bgcolor'] : '';

            $wp_rem_cs_var_menu_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_menu_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_menu_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_menu_color'] : '';

            $wp_rem_cs_var_menu_active_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_menu_active_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_menu_active_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_menu_active_color'] : '';

            $wp_rem_cs_var_menu_hover_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_menu_hover_bg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_menu_hover_bg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_menu_hover_bg_color'] : '';

            $wp_rem_cs_var_submenu_2nd_level_bgcolor = (isset($wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_bgcolor']) and $wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_bgcolor'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_bgcolor'] : '';

            $wp_rem_cs_var_modern_menu_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_color'] : '';

            $wp_rem_cs_var_modern_menu_active_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_active_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_active_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_modern_menu_active_color'] : '';

            $wp_rem_cs_var_submenu_bgcolor = (isset($wp_rem_cs_var_options['wp_rem_cs_var_submenu_bgcolor']) and $wp_rem_cs_var_options['wp_rem_cs_var_submenu_bgcolor'] <> '' ) ? $wp_rem_cs_var_options['wp_rem_cs_var_submenu_bgcolor'] : '';

            $wp_rem_cs_var_submenu_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_submenu_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_submenu_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_submenu_color'] : '';

            $wp_rem_cs_var_submenu_2nd_level_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_submenu_2nd_level_color'] : '';

            $wp_rem_cs_var_menu_heading_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_menu_heading_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_menu_heading_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_menu_heading_color'] : '';

            $wp_rem_cs_var_submenu_hover_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_submenu_hover_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_submenu_hover_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_submenu_hover_color'] : '';

            $wp_rem_cs_var_topstrip_bgcolor = (isset($wp_rem_cs_var_options['wp_rem_cs_var_topstrip_bgcolor']) and $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_bgcolor'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_bgcolor'] : '';

            $wp_rem_cs_var_topstrip_text_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_topstrip_text_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_text_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_text_color'] : '';

            $wp_rem_cs_var_topstrip_link_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_topstrip_link_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_link_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_topstrip_link_color'] : '';

            $wp_rem_cs_var_menu_activ_bg = (isset($wp_rem_cs_var_options['wp_rem_cs_var_theme_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_theme_color'] : '';

            $wp_rem_cs_var_page_title_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_color'] : '';

            /**

            * @Logo Margins

            *

            */

            $wp_rem_cs_var_logo_margint = (isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_margint']) and $wp_rem_cs_var_options['wp_rem_cs_var_logo_margint'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_margint'] : '0';

            $wp_rem_cs_var_logo_marginb = (isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_marginb']) and $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginb'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginb'] : '0';

            $wp_rem_cs_var_logo_marginr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_marginr']) and $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginr'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginr'] : '0';

            $wp_rem_cs_var_logo_marginl = (isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_marginl']) and $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginl'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_marginl'] : '0';

            /**

            * @Font Family

            *

            */

            $wp_rem_cs_var_content_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_font'] : '';

            $wp_rem_cs_var_content_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_font_att'] : '';

            $wp_rem_cs_var_mainmenu_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font'] : '';

            $wp_rem_cs_var_mainmenu_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font_att'] : '';

            $wp_rem_cs_var_heading1_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading1_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading1_font'] : '';

            $wp_rem_cs_var_heading1_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading1_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading1_font_att'] : '';

            $wp_rem_cs_var_heading2_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading2_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading2_font'] : '';

            $wp_rem_cs_var_heading2_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading2_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading2_font_att'] : '';

            $wp_rem_cs_var_heading3_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading3_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading3_font'] : '';

            $wp_rem_cs_var_heading3_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading3_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading3_font_att'] : '';

            $wp_rem_cs_var_heading4_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading4_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading4_font'] : '';

            $wp_rem_cs_var_heading4_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading4_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading4_font_att'] : '';

            $wp_rem_cs_var_heading5_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading5_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading5_font'] : '';

            $wp_rem_cs_var_heading5_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading5_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading5_font_att'] : '';

            $wp_rem_cs_var_heading6_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading6_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading6_font'] : '';

            $wp_rem_cs_var_heading6_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading6_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading6_font_att'] : '';

            $wp_rem_cs_var_section_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_font'] : '';

            $wp_rem_cs_var_section_title_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_font_att'] : '';
			
			$wp_rem_cs_var_element_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_font'] : '';

            $wp_rem_cs_var_element_title_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_font_att'] : '';

            $wp_rem_cs_var_page_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_font'] : '';

            $wp_rem_cs_var_page_title_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_font_att'] : '';

            $wp_rem_cs_var_post_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_font'] : '';

            $wp_rem_cs_var_post_title_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_font_att'] : '';

            $wp_rem_cs_var_widget_heading_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font'] : '';

            $wp_rem_cs_var_widget_heading_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font_att'] : '';

            $wp_rem_cs_var_ft_widget_heading_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font'] : '';

            $wp_rem_cs_var_ft_widget_heading_font_att = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font_att'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font_att'] : '';

            /**

            * @Setting Content Fonts

            *

            */

            $wp_rem_cs_var_content_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_content_font_att);

            $wp_rem_cs_var_content_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_content_fonts);

            /**

            * @Setting Main Menu Fonts

            *

            */

            $wp_rem_cs_var_mainmenu_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_mainmenu_font_att);

            $wp_rem_cs_var_mainmenu_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_mainmenu_fonts);

            /**

            * @Setting Heading Fonts

            *

            */

            $wp_rem_cs_var_heading1_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading1_font_att);

            $wp_rem_cs_var_heading1_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading1_fonts);

            $wp_rem_cs_var_heading2_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading2_font_att);

            $wp_rem_cs_var_heading2_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading2_fonts);

            $wp_rem_cs_var_heading3_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading3_font_att);

            $wp_rem_cs_var_heading3_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading3_fonts);

            $wp_rem_cs_var_heading4_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading4_font_att);

            $wp_rem_cs_var_heading4_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading4_fonts);

            $wp_rem_cs_var_heading5_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading5_font_att);

            $wp_rem_cs_var_heading5_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading5_fonts);

            $wp_rem_cs_var_heading6_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_heading6_font_att);

            $wp_rem_cs_var_heading6_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_heading6_fonts);

            /**

            * @Section Title Fonts

            *

            */

            $wp_rem_cs_var_section_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_section_title_font_att);

            $wp_rem_cs_var_section_title_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_section_title_fonts);
			
			$wp_rem_cs_var_element_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_element_title_font_att);
			$wp_rem_cs_var_element_title_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_element_title_fonts);

            /**

            * @Page Title Heading Fonts

            *

            */

            $wp_rem_cs_var_page_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_page_title_font_att);

            $wp_rem_cs_var_page_title_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_page_title_fonts);

            /**

            * @Post Title Heading Fonts

            *

            */

            $wp_rem_cs_var_post_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_post_title_font_att);

            $wp_rem_cs_var_post_title_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_post_title_fonts);

            /**

            * @Setting Widget Heading Fonts

            *

            */

            $wp_rem_cs_var_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_widget_heading_font_att);

            $wp_rem_cs_var_widget_heading_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_widget_heading_fonts);

            /**

            * @Setting Footer Widget Heading Fonts

            *

            */

            $wp_rem_cs_var_ft_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $wp_rem_cs_var_ft_widget_heading_font_att);

            $wp_rem_cs_var_ft_widget_heading_font_atts = wp_rem_cs_var_get_font_att_array($wp_rem_cs_var_ft_widget_heading_fonts);

            /**

            * @Font Sizes

            *

            */

            $wp_rem_cs_var_content_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_size'] : '';

            $wp_rem_cs_var_mainmenu_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_size'] : '';

            $wp_rem_cs_var_heading_1_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_1_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_1_size'] : '';

            $wp_rem_cs_var_heading_2_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_2_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_2_size'] : '';

            $wp_rem_cs_var_heading_3_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_3_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_3_size'] : '';

            $wp_rem_cs_var_heading_4_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_4_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_4_size'] : '';

            $wp_rem_cs_var_heading_5_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_5_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_5_size'] : '';

            $wp_rem_cs_var_heading_6_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_6_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_6_size'] : '';

            $wp_rem_cs_var_section_title_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_size'] : '';
			
			$wp_rem_cs_var_element_title_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_size'] : '';

            $wp_rem_cs_var_page_title_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_size'] : '';

            $wp_rem_cs_var_post_title_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_size'] : '';

            $wp_rem_cs_var_widget_heading_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_size'] : '';

            $wp_rem_cs_var_widget_title_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_title_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_title_color'] : '';

            $wp_rem_cs_var_ft_widget_heading_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_size'] : '';

            /**

            * @Font LIne Heights

            *

            */

            $wp_rem_cs_var_content_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_lh'] : '';

            $wp_rem_cs_var_mainmenu_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_lh'] : '';

            $wp_rem_cs_var_heading_1_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_1_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_1_lh'] : '';

            $wp_rem_cs_var_heading_2_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_2_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_2_lh'] : '';

            $wp_rem_cs_var_heading_3_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_3_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_3_lh'] : '';

            $wp_rem_cs_var_heading_4_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_4_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_4_lh'] : '';

            $wp_rem_cs_var_heading_5_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_5_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_5_lh'] : '';

            $wp_rem_cs_var_heading_6_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_6_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_6_lh'] : '';

            $wp_rem_cs_var_section_title_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_lh'] : '';
			
			$wp_rem_cs_var_element_title_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_lh'] : '';

            $wp_rem_cs_var_page_title_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_lh'] : '';

            $wp_rem_cs_var_post_title_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_lh'] : '';

            $wp_rem_cs_var_widget_heading_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_lh'] : '';

            $wp_rem_cs_var_ft_widget_heading_lh = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_lh'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_lh'] : '';

            $wp_rem_cs_var_content_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_spc'] : '';

            $wp_rem_cs_var_mainmenu_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_spc'] : '';

            $wp_rem_cs_var_heading_1_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_1_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_1_spc'] : '';

            $wp_rem_cs_var_heading_2_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_2_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_2_spc'] : '';

            $wp_rem_cs_var_heading_3_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_3_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_3_spc'] : '';

            $wp_rem_cs_var_heading_4_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_4_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_4_spc'] : '';

            $wp_rem_cs_var_heading_5_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_5_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_5_spc'] : '';

            $wp_rem_cs_var_heading_6_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_6_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_6_spc'] : '';

            $wp_rem_cs_var_section_title_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_spc'] : '';
			
			$wp_rem_cs_var_element_title_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_spc'] : '';

            $wp_rem_cs_var_page_title_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_spc'] : '';

            $wp_rem_cs_var_post_title_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_spc'] : '';

            $wp_rem_cs_var_section_title_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_color'] : '';

            $wp_rem_cs_var_widget_heading_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_spc'] : '';

            $wp_rem_cs_var_ft_widget_heading_spc = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_spc'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_spc'] : '';

            /**

            * @Font Text Transform

            *

            */

            $wp_rem_cs_var_content_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_textr'] : '';

            $wp_rem_cs_var_mainmenu_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_textr'] : '';

            $wp_rem_cs_var_heading_1_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_1_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_1_textr'] : '';

            $wp_rem_cs_var_heading_2_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_2_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_2_textr'] : '';

            $wp_rem_cs_var_heading_3_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_3_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_3_textr'] : '';

            $wp_rem_cs_var_heading_4_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_4_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_4_textr'] : '';

            $wp_rem_cs_var_heading_5_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_5_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_5_textr'] : '';

            $wp_rem_cs_var_heading_6_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_6_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_6_textr'] : '';

            $wp_rem_cs_var_section_title_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_textr'] : '';
			
			$wp_rem_cs_var_element_title_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_textr'] : '';

            $wp_rem_cs_var_page_title_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_textr'] : '';

            $wp_rem_cs_var_post_title_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_textr'] : '';

            $wp_rem_cs_var_post_title_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_color'] : '';

            $wp_rem_cs_var_widget_heading_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_textr'] : '';

            $wp_rem_cs_var_ft_widget_heading_textr = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_textr'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_textr'] : '';

            $wp_rem_cs_var_widget_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_color'] : '#2d2d2d';

            $wp_rem_cs_var_ft_widget_title_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_title_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_title_color'] : '';

            /**

            * @Font Color

            *

            */

            $wp_rem_cs_var_heading_h1_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h1_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h1_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h1_color'] : '';

            $wp_rem_cs_var_heading_h2_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h2_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h2_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h2_color'] : '';

            $wp_rem_cs_var_heading_h3_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h3_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h3_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h3_color'] : '';

            $wp_rem_cs_var_heading_h4_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h4_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h4_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h4_color'] : '';

            $wp_rem_cs_var_heading_h5_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h5_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h5_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h5_color'] : '';

            $wp_rem_cs_var_heading_h6_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading_h6_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_heading_h6_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_heading_h6_color'] : '';

            $wp_rem_cs_var_widget_heading_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_size'] : '';

            $wp_rem_cs_var_section_heading_size = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_heading_size'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_heading_size'] : '';

            $wp_rem_cs_var_copyright_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'] : '';

		
        $content_custom_font = false;
		$content_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'content_font' );

		if ( $content_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $content_custom_font_html );
			$content_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_content_size ) && $wp_rem_cs_var_content_size != '') || (isset( $wp_rem_cs_var_content_spc ) && $wp_rem_cs_var_content_spc != '') || (isset( $wp_rem_cs_var_content_textr ) && $wp_rem_cs_var_content_textr != '') || (isset( $wp_rem_cs_var_text_color ) && $wp_rem_cs_var_text_color != '') || (isset( $wp_rem_cs_var_content_lh ) && $wp_rem_cs_var_content_lh != '') ) {
			?>
			/*Theme Typo Colors Classes*/
			body,
			.main-section p,
			.mce-content-body p
			{
			<?php
			if ( $content_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'content_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'content_font' );
				if ( isset( $wp_rem_cs_var_content_size ) && $wp_rem_cs_var_content_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_content_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_content_spc ) && $wp_rem_cs_var_content_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_content_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_content_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_content_textr ) && $wp_rem_cs_var_content_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_content_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_content_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_text_color ) && $wp_rem_cs_var_text_color != '' ) {
					echo esc_html( $wp_rem_cs_var_text_color != '' ? 'color: ' . $wp_rem_cs_var_text_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_content_lh ) && $wp_rem_cs_var_content_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_content_lh != '' ? 'line-height: ' . $wp_rem_cs_var_content_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_content_font_atts, $wp_rem_cs_var_content_size, $wp_rem_cs_var_content_lh, $wp_rem_cs_var_content_font);
				if ( isset( $wp_rem_cs_var_content_spc ) && $wp_rem_cs_var_content_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_content_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_content_spc . 'px;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_content_textr ) && $wp_rem_cs_var_content_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_content_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_content_textr . ';' : ''  );
				}
				if ( isset( $wp_rem_cs_var_text_color ) && $wp_rem_cs_var_text_color != '' ) {
					echo esc_html( $wp_rem_cs_var_text_color != '' ? 'color: ' . $wp_rem_cs_var_text_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}
		if ( (isset( $wp_rem_cs_var_logo_margint ) && $wp_rem_cs_var_logo_margint != '') || (isset( $wp_rem_cs_var_logo_marginr ) && $wp_rem_cs_var_logo_marginr != '') || (isset( $wp_rem_cs_var_logo_marginb ) && $wp_rem_cs_var_logo_marginb != '') || (isset( $wp_rem_cs_var_logo_marginl ) && $wp_rem_cs_var_logo_marginl != '') ) {
			?>
			/*Header Default Start*/
			header .logo {
			<?php if ( isset( $wp_rem_cs_var_logo_margint ) && $wp_rem_cs_var_logo_margint != '' ) { ?>
				margin-top:<?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_logo_margint ); ?>px;
			<?php } if ( isset( $wp_rem_cs_var_logo_marginr ) && $wp_rem_cs_var_logo_marginr != '' ) { ?>
				margin-right:<?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_logo_marginr ); ?>px;
			<?php } if ( isset( $wp_rem_cs_var_logo_marginb ) && $wp_rem_cs_var_logo_marginb != '' ) { ?>
				margin-bottom:<?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_logo_marginb ); ?>px;
			<?php }if ( isset( $wp_rem_cs_var_logo_marginl ) && $wp_rem_cs_var_logo_marginl != '' ) { ?>
				margin-left:<?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_var_logo_marginl ); ?>px;
			<?php } ?>
			}
			<?php
		}

		$mainmenu_custom_font = false;
		$mainmenu_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'mainmenu_font' );
		if ( $mainmenu_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $mainmenu_custom_font_html );
			$mainmenu_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_mainmenu_size ) && $wp_rem_cs_var_mainmenu_size != '') || (isset( $wp_rem_cs_var_mainmenu_spc ) && $wp_rem_cs_var_mainmenu_spc != '') || (isset( $wp_rem_cs_var_mainmenu_textr ) && $wp_rem_cs_var_mainmenu_textr != '') || (isset( $wp_rem_cs_var_mainmenu_lh ) && $wp_rem_cs_var_mainmenu_lh != '') ) {
			?>
			/*Navigation Font Sizes*/
			#header .navigation > ul > li > a,
			#header .navigation > ul > li,
			.main-header .main-nav > nav > ul > li > a,
			.main-header .user-dashboard-menu > ul > li > a
			{
			<?php
			if ( $mainmenu_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'mainmenu_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'mainmenu_font' );
				if ( isset( $wp_rem_cs_var_mainmenu_size ) && $wp_rem_cs_var_mainmenu_size != '' ) {
					echo 'font-size: ' . wp_rem_cs_allow_special_char( $wp_rem_cs_var_mainmenu_size ) . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_mainmenu_spc ) && $wp_rem_cs_var_mainmenu_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_mainmenu_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_mainmenu_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_mainmenu_textr ) && $wp_rem_cs_var_mainmenu_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_mainmenu_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_mainmenu_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_mainmenu_lh ) && $wp_rem_cs_var_mainmenu_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_mainmenu_lh != '' ? 'line-height: ' . $wp_rem_cs_var_mainmenu_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_mainmenu_font_atts, $wp_rem_cs_var_mainmenu_size, $wp_rem_cs_var_mainmenu_lh, $wp_rem_cs_var_mainmenu_font, true);
				if ( isset( $wp_rem_cs_var_mainmenu_spc ) && $wp_rem_cs_var_mainmenu_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_mainmenu_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_mainmenu_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_mainmenu_textr ) && $wp_rem_cs_var_mainmenu_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_mainmenu_textr != '' ? 'text-transform: ' . wp_rem_cs_allow_special_char( $wp_rem_cs_var_mainmenu_textr ) . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading1_custom_font = false;
		$heading1_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading1_font' );
		if ( $heading1_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading1_custom_font_html );
			$heading1_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_1_size ) && $wp_rem_cs_var_heading_1_size != '') || (isset( $wp_rem_cs_var_heading_1_spc ) && $wp_rem_cs_var_heading_1_spc != '') || (isset( $wp_rem_cs_var_heading_1_textr ) && $wp_rem_cs_var_heading_1_textr != '') || (isset( $wp_rem_cs_var_heading_h1_color ) && $wp_rem_cs_var_heading_h1_color != '') || (isset( $wp_rem_cs_var_heading_1_lh ) && $wp_rem_cs_var_heading_1_lh != '') ) {
			?>
			h1, h1 a{
			<?php
			if ( $heading1_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading1_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading1_font' );
				if ( isset( $wp_rem_cs_var_heading_1_size ) && $wp_rem_cs_var_heading_1_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_1_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_1_spc ) && $wp_rem_cs_var_heading_1_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_1_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_1_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_1_textr ) && $wp_rem_cs_var_heading_1_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_1_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_1_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h1_color ) && $wp_rem_cs_var_heading_h1_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h1_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h1_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_1_lh ) && $wp_rem_cs_var_heading_1_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_1_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_1_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading1_font_atts, $wp_rem_cs_var_heading_1_size, $wp_rem_cs_var_heading_1_lh, $wp_rem_cs_var_heading1_font, true);
				if ( isset( $wp_rem_cs_var_heading_1_spc ) && $wp_rem_cs_var_heading_1_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_1_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_1_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_1_textr ) && $wp_rem_cs_var_heading_1_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_1_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_1_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h1_color ) && $wp_rem_cs_var_heading_h1_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h1_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h1_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading2_custom_font = false;
		$heading2_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading2_font' );
		if ( $heading2_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading2_custom_font_html );
			$heading2_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_2_size ) && $wp_rem_cs_var_heading_2_size != '') || (isset( $wp_rem_cs_var_heading_2_spc ) && $wp_rem_cs_var_heading_2_spc != '') || (isset( $wp_rem_cs_var_heading_2_textr ) && $wp_rem_cs_var_heading_2_textr != '') || (isset( $wp_rem_cs_var_heading_h2_color ) && $wp_rem_cs_var_heading_h2_color != '') || (isset( $wp_rem_cs_var_heading_2_lh ) && $wp_rem_cs_var_heading_2_lh != '') ) {
			?>
			h2, h2 a{
			<?php
			if ( $heading2_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading2_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading2_font' );
				if ( isset( $wp_rem_cs_var_heading_2_size ) && $wp_rem_cs_var_heading_2_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_2_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_2_spc ) && $wp_rem_cs_var_heading_2_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_2_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_2_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_2_textr ) && $wp_rem_cs_var_heading_2_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_2_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_2_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h2_color ) && $wp_rem_cs_var_heading_h2_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h2_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h2_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_2_lh ) && $wp_rem_cs_var_heading_2_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_2_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_2_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading2_font_atts, $wp_rem_cs_var_heading_2_size, $wp_rem_cs_var_heading_2_lh, $wp_rem_cs_var_heading2_font, true);
				if ( isset( $wp_rem_cs_var_heading_2_spc ) && $wp_rem_cs_var_heading_2_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_2_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_2_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_2_textr ) && $wp_rem_cs_var_heading_2_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_2_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_2_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h2_color ) && $wp_rem_cs_var_heading_h2_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h2_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h2_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading3_custom_font = false;
		$heading3_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading3_font' );
		if ( $heading3_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading3_custom_font_html );
			$heading3_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_3_size ) && $wp_rem_cs_var_heading_3_size != '') || (isset( $wp_rem_cs_var_heading_3_spc ) && $wp_rem_cs_var_heading_3_spc != '') || (isset( $wp_rem_cs_var_heading_3_textr ) && $wp_rem_cs_var_heading_3_textr != '') || (isset( $wp_rem_cs_var_heading_h3_color ) && $wp_rem_cs_var_heading_h3_color != '') || (isset( $wp_rem_cs_var_heading_3_lh ) && $wp_rem_cs_var_heading_3_lh != '') ) {
			?>
			h3, h3 a{
			<?php
			if ( $heading3_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading3_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading3_font' );
				if ( isset( $wp_rem_cs_var_heading_3_size ) && $wp_rem_cs_var_heading_3_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_3_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_3_spc ) && $wp_rem_cs_var_heading_3_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_3_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_3_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_3_textr ) && $wp_rem_cs_var_heading_3_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_3_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_3_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h3_color ) && $wp_rem_cs_var_heading_h3_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h3_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h3_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_3_lh ) && $wp_rem_cs_var_heading_3_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_3_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_3_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading3_font_atts, $wp_rem_cs_var_heading_3_size, $wp_rem_cs_var_heading_3_lh, $wp_rem_cs_var_heading3_font, true);
				if ( isset( $wp_rem_cs_var_heading_3_spc ) && $wp_rem_cs_var_heading_3_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_3_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_3_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_3_textr ) && $wp_rem_cs_var_heading_3_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_3_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_3_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h3_color ) && $wp_rem_cs_var_heading_h3_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h3_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h3_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading4_custom_font = false;
		$heading4_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading4_font' );
		if ( $heading4_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading4_custom_font_html );
			$heading4_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_4_size ) && $wp_rem_cs_var_heading_4_size != '') || (isset( $wp_rem_cs_var_heading_4_spc ) && $wp_rem_cs_var_heading_4_spc != '') || (isset( $wp_rem_cs_var_heading_4_textr ) && $wp_rem_cs_var_heading_4_textr != '') || (isset( $wp_rem_cs_var_heading_h4_color ) && $wp_rem_cs_var_heading_h4_color != '') || (isset( $wp_rem_cs_var_heading_4_lh ) && $wp_rem_cs_var_heading_4_lh != '') ) {
			?>
			h4, h4 a{
			<?php
			if ( $heading4_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading4_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading4_font' );
				if ( isset( $wp_rem_cs_var_heading_4_size ) && $wp_rem_cs_var_heading_4_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_4_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_4_spc ) && $wp_rem_cs_var_heading_4_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_4_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_4_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_4_textr ) && $wp_rem_cs_var_heading_4_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_4_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_4_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h4_color ) && $wp_rem_cs_var_heading_h4_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h4_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h4_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_4_lh ) && $wp_rem_cs_var_heading_4_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_4_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_4_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading4_font_atts, $wp_rem_cs_var_heading_4_size, $wp_rem_cs_var_heading_4_lh, $wp_rem_cs_var_heading4_font, true);
				if ( isset( $wp_rem_cs_var_heading_4_spc ) && $wp_rem_cs_var_heading_4_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_4_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_4_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_4_textr ) && $wp_rem_cs_var_heading_4_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_4_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_4_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h4_color ) && $wp_rem_cs_var_heading_h4_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h4_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h4_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading5_custom_font = false;
		$heading5_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading5_font' );
		if ( $heading5_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading5_custom_font_html );
			$heading5_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_5_size ) && $wp_rem_cs_var_heading_5_size != '') || (isset( $wp_rem_cs_var_heading_5_spc ) && $wp_rem_cs_var_heading_5_spc != '') || (isset( $wp_rem_cs_var_heading_5_textr ) && $wp_rem_cs_var_heading_5_textr != '') || (isset( $wp_rem_cs_var_heading_h5_color ) && $wp_rem_cs_var_heading_h5_color != '') || (isset( $wp_rem_cs_var_heading_5_lh ) && $wp_rem_cs_var_heading_5_lh != '') ) {
			?>
			h5, h5 a{
			<?php
			if ( $heading5_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading5_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading5_font' );
				if ( isset( $wp_rem_cs_var_heading_5_size ) && $wp_rem_cs_var_heading_5_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_5_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_5_spc ) && $wp_rem_cs_var_heading_5_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_5_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_5_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_5_textr ) && $wp_rem_cs_var_heading_5_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_5_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_5_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h5_color ) && $wp_rem_cs_var_heading_h5_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h5_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h5_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_5_lh ) && $wp_rem_cs_var_heading_5_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_5_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_5_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading5_font_atts, $wp_rem_cs_var_heading_5_size, $wp_rem_cs_var_heading_5_lh, $wp_rem_cs_var_heading5_font, true);
				if ( isset( $wp_rem_cs_var_heading_5_spc ) && $wp_rem_cs_var_heading_5_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_5_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_5_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_5_textr ) && $wp_rem_cs_var_heading_5_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_5_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_5_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h5_color ) && $wp_rem_cs_var_heading_h5_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h5_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h5_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$heading6_custom_font = false;
		$heading6_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'heading6_font' );
		if ( $heading6_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $heading6_custom_font_html );
			$heading6_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_heading_6_size ) && $wp_rem_cs_var_heading_6_size != '') || (isset( $wp_rem_cs_var_heading_6_spc ) && $wp_rem_cs_var_heading_6_spc != '') || (isset( $wp_rem_cs_var_heading_6_textr ) && $wp_rem_cs_var_heading_6_textr != '') || (isset( $wp_rem_cs_var_heading_h6_color ) && $wp_rem_cs_var_heading_h6_color != '') || (isset( $wp_rem_cs_var_heading_6_lh ) && $wp_rem_cs_var_heading_6_lh != '') ) {
			?>
			h6, h6 a{
			<?php
			if ( $heading6_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'heading6_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'heading6_font' );
				if ( isset( $wp_rem_cs_var_heading_6_size ) && $wp_rem_cs_var_heading_6_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_heading_6_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_heading_6_spc ) && $wp_rem_cs_var_heading_6_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_6_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_6_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_6_textr ) && $wp_rem_cs_var_heading_6_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_6_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_6_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h6_color ) && $wp_rem_cs_var_heading_h6_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h6_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h6_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_6_lh ) && $wp_rem_cs_var_heading_6_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_6_lh != '' ? 'line-height: ' . $wp_rem_cs_var_heading_6_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_heading6_font_atts, $wp_rem_cs_var_heading_6_size, $wp_rem_cs_var_heading_6_lh, $wp_rem_cs_var_heading6_font, true);
				if ( isset( $wp_rem_cs_var_heading_6_spc ) && $wp_rem_cs_var_heading_6_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_6_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_heading_6_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_6_textr ) && $wp_rem_cs_var_heading_6_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_6_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_heading_6_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_heading_h6_color ) && $wp_rem_cs_var_heading_h6_color != '' ) {
					echo esc_html( $wp_rem_cs_var_heading_h6_color != '' ? 'color: ' . $wp_rem_cs_var_heading_h6_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$section_title_custom_font = false;
		$section_title_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'section_title_font' );
		if ( $section_title_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $section_title_custom_font_html );
			$section_title_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_section_title_size ) && $wp_rem_cs_var_section_title_size != '') || (isset( $wp_rem_cs_var_section_title_spc ) && $wp_rem_cs_var_section_title_spc != '') || (isset( $wp_rem_cs_var_section_title_textr ) && $wp_rem_cs_var_section_title_textr != '') || (isset( $wp_rem_cs_var_section_title_color ) && $wp_rem_cs_var_section_title_color != '') || (isset( $wp_rem_cs_var_section_title_lh ) && $wp_rem_cs_var_section_title_lh != '') ) {
			?>
			.section-title h2{
			<?php
			if ( $section_title_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'section_title_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'section_title_font' );
				if ( isset( $wp_rem_cs_var_section_title_size ) && $wp_rem_cs_var_section_title_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_section_title_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_section_title_spc ) && $wp_rem_cs_var_section_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_section_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_section_title_textr ) && $wp_rem_cs_var_section_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_section_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_section_title_color ) && $wp_rem_cs_var_section_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_color != '' ? 'color: ' . $wp_rem_cs_var_section_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_section_title_lh ) && $wp_rem_cs_var_section_title_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_lh != '' ? 'line-height: ' . $wp_rem_cs_var_section_title_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_section_title_font_atts, $wp_rem_cs_var_section_title_size, $wp_rem_cs_var_section_title_lh, $wp_rem_cs_var_section_title_font, true);
				if ( isset( $wp_rem_cs_var_section_title_spc ) && $wp_rem_cs_var_section_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_section_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_section_title_textr ) && $wp_rem_cs_var_section_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_section_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_section_title_color ) && $wp_rem_cs_var_section_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_color != '' ? 'color: ' . $wp_rem_cs_var_section_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}
		
		$element_title_custom_font = false;
		$element_title_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'element_title_font' );
		if ( $element_title_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $element_title_custom_font_html );
			$element_title_custom_font = true;
		}
		
		if ( (isset( $wp_rem_cs_var_element_title_size ) && $wp_rem_cs_var_element_title_size != '') || (isset( $wp_rem_cs_var_element_title_spc ) && $wp_rem_cs_var_element_title_spc != '') || (isset( $wp_rem_cs_var_element_title_textr ) && $wp_rem_cs_var_element_title_textr != '') || (isset( $wp_rem_cs_var_element_title_color ) && $wp_rem_cs_var_element_title_color != '') || (isset( $wp_rem_cs_var_element_title_lh ) && $wp_rem_cs_var_element_title_lh != '') ) {
			?>
			.element-title h2{
			<?php
			if ( $element_title_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'element_title_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'element_title_font' );
				if ( isset( $wp_rem_cs_var_element_title_size ) && $wp_rem_cs_var_element_title_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_element_title_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_element_title_spc ) && $wp_rem_cs_var_element_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_section_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_section_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_element_title_textr ) && $wp_rem_cs_var_element_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_element_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_element_title_color ) && $wp_rem_cs_var_element_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_color != '' ? 'color: ' . $wp_rem_cs_var_element_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_element_title_lh ) && $wp_rem_cs_var_element_title_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_lh != '' ? 'line-height: ' . $wp_rem_cs_var_element_title_lh . 'px !important;' : ''  );
				}
			} else {
				
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_element_title_font_atts, $wp_rem_cs_var_element_title_size, $wp_rem_cs_var_element_title_lh, $wp_rem_cs_var_element_title_font, true);
				if ( isset( $wp_rem_cs_var_element_title_spc ) && $wp_rem_cs_var_element_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_element_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_element_title_textr ) && $wp_rem_cs_var_element_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_element_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_element_title_color ) && $wp_rem_cs_var_element_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_element_title_color != '' ? 'color: ' . $wp_rem_cs_var_element_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$post_title_custom_font = false;
		$post_title_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'post_title_font' );
		if ( $post_title_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $post_title_custom_font_html );
			$post_title_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_post_title_size ) && $wp_rem_cs_var_post_title_size != '') || (isset( $wp_rem_cs_var_post_title_spc ) && $wp_rem_cs_var_post_title_spc != '') || (isset( $wp_rem_cs_var_post_title_textr ) && $wp_rem_cs_var_post_title_textr != '') || (isset( $wp_rem_cs_var_post_title_color ) && $wp_rem_cs_var_post_title_color != '') || (isset( $wp_rem_cs_var_post_title_lh ) && $wp_rem_cs_var_post_title_lh != '') ) {
			?>
			.post-title h4 a{
			<?php
			if ( $post_title_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'post_title_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'post_title_font' );
				if ( isset( $wp_rem_cs_var_post_title_size ) && $wp_rem_cs_var_post_title_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_post_title_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_post_title_spc ) && $wp_rem_cs_var_post_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_post_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_post_title_textr ) && $wp_rem_cs_var_post_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_post_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_post_title_color ) && $wp_rem_cs_var_post_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_color != '' ? 'color: ' . $wp_rem_cs_var_post_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_post_title_lh ) && $wp_rem_cs_var_post_title_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_lh != '' ? 'line-height: ' . $wp_rem_cs_var_post_title_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_post_title_font_atts, $wp_rem_cs_var_post_title_size, $wp_rem_cs_var_post_title_lh, $wp_rem_cs_var_post_title_font, true);
				if ( isset( $wp_rem_cs_var_post_title_spc ) && $wp_rem_cs_var_post_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_post_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_post_title_textr ) && $wp_rem_cs_var_post_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_post_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_post_title_color ) && $wp_rem_cs_var_post_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_post_title_color != '' ? 'color: ' . $wp_rem_cs_var_post_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$page_title_custom_font = false;
		$page_title_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'page_title_font' );
		if ( $page_title_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $page_title_custom_font_html );
			$page_title_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_page_title_color ) && $wp_rem_cs_var_page_title_color != '') || (isset( $wp_rem_cs_var_page_title_size ) && $wp_rem_cs_var_page_title_size != '') || (isset( $wp_rem_cs_var_page_title_spc ) && $wp_rem_cs_var_page_title_spc != '') || (isset( $wp_rem_cs_var_page_title_textr ) && $wp_rem_cs_var_page_title_textr != '') || (isset( $wp_rem_cs_var_page_title_lh ) && $wp_rem_cs_var_page_title_lh != '') ) {
			?>
			.cs-page-title h1 {
			<?php
			if ( $page_title_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'page_title_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'page_title_font' );
				if ( isset( $wp_rem_cs_var_page_title_size ) && $wp_rem_cs_var_page_title_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_page_title_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_page_title_spc ) && $wp_rem_cs_var_page_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_page_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_page_title_textr ) && $wp_rem_cs_var_page_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_page_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_page_title_color ) && $wp_rem_cs_var_page_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_color != '' ? 'color: ' . $wp_rem_cs_var_page_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_page_title_lh ) && $wp_rem_cs_var_page_title_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_lh != '' ? 'line-height: ' . $wp_rem_cs_var_page_title_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_page_title_font_atts, $wp_rem_cs_var_page_title_size, $wp_rem_cs_var_page_title_lh, $wp_rem_cs_var_page_title_font, true);
				if ( isset( $wp_rem_cs_var_page_title_spc ) && $wp_rem_cs_var_page_title_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_page_title_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_page_title_textr ) && $wp_rem_cs_var_page_title_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_page_title_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_page_title_color ) && $wp_rem_cs_var_page_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_page_title_color != '' ? 'color: ' . $wp_rem_cs_var_page_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$widget_heading_custom_font = false;
		$widget_heading_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'widget_heading_font' );
		if ( $widget_heading_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $widget_heading_custom_font_html );
			$widget_heading_custom_font = true;
		}

		if ( (isset( $wp_rem_cs_var_widget_heading_size ) && $wp_rem_cs_var_widget_heading_size != '') || (isset( $wp_rem_cs_var_widget_heading_spc ) && $wp_rem_cs_var_widget_heading_spc != '') || (isset( $wp_rem_cs_var_widget_title_color ) && $wp_rem_cs_var_widget_title_color != '') || (isset( $wp_rem_cs_var_widget_heading_lh ) && $wp_rem_cs_var_widget_heading_lh != '') ) {
			?>
			.page-sidebar .widget .widget-title h5{
			<?php
			if ( $widget_heading_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'widget_heading_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'widget_heading_font' );
				if ( isset( $wp_rem_cs_var_widget_heading_size ) && $wp_rem_cs_var_widget_heading_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_widget_heading_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_widget_heading_spc ) && $wp_rem_cs_var_widget_heading_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_heading_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_widget_heading_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_widget_heading_textr ) && $wp_rem_cs_var_widget_heading_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_heading_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_widget_heading_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_widget_title_color ) && $wp_rem_cs_var_widget_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_title_color != '' ? 'color: ' . $wp_rem_cs_var_widget_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_widget_heading_lh ) && $wp_rem_cs_var_widget_heading_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_heading_lh != '' ? 'line-height: ' . $wp_rem_cs_var_widget_heading_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_widget_heading_font_atts, $wp_rem_cs_var_widget_heading_size, $wp_rem_cs_var_widget_heading_lh, $wp_rem_cs_var_widget_heading_font, true);
				if ( isset( $wp_rem_cs_var_widget_heading_spc ) && $wp_rem_cs_var_widget_heading_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_heading_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_widget_heading_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_widget_heading_textr ) && $wp_rem_cs_var_widget_heading_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_heading_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_widget_heading_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_widget_title_color ) && $wp_rem_cs_var_widget_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_widget_title_color != '' ? 'color: ' . $wp_rem_cs_var_widget_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

		$ft_widget_heading_custom_font = false;
		$ft_widget_heading_custom_font_html = wp_rem_cs_var_load_custom_fonts( 'ft_widget_heading_font' );
		if ( $ft_widget_heading_custom_font_html != '' ) {
			echo wp_rem_cs_allow_special_char( $ft_widget_heading_custom_font_html );
			$ft_widget_heading_custom_font = true;
		}
		if ( (isset( $wp_rem_cs_var_ft_widget_heading_size ) && $wp_rem_cs_var_ft_widget_heading_size != '') || (isset( $wp_rem_cs_var_ft_widget_heading_spc ) && $wp_rem_cs_var_ft_widget_heading_spc != '') || (isset( $wp_rem_cs_var_ft_widget_heading_textr ) && $wp_rem_cs_var_ft_widget_heading_textr != '') || (isset( $wp_rem_cs_var_ft_widget_title_color ) && $wp_rem_cs_var_ft_widget_title_color != '') || (isset( $wp_rem_cs_var_ft_widget_heading_lh ) && $wp_rem_cs_var_ft_widget_heading_lh != '') ) {
			?>
			/*
			* Footer Title color and fonts
			*/
			#footer .widget-title h5{
			<?php
			if ( $ft_widget_heading_custom_font == true ) {
				echo wp_rem_cs_var_custom_font_name( 'ft_widget_heading_font' );
				echo wp_rem_cs_var_load_custom_font_weight( 'ft_widget_heading_font' );
				if ( isset( $wp_rem_cs_var_ft_widget_heading_size ) && $wp_rem_cs_var_ft_widget_heading_size != '' ) {
					echo 'font-size: ' . $wp_rem_cs_var_ft_widget_heading_size . 'px !important;';
				}
				if ( isset( $wp_rem_cs_var_ft_widget_heading_spc ) && $wp_rem_cs_var_ft_widget_heading_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_heading_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_ft_widget_heading_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_ft_widget_heading_textr ) && $wp_rem_cs_var_ft_widget_heading_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_heading_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_ft_widget_heading_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_ft_widget_title_color ) && $wp_rem_cs_var_ft_widget_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_title_color != '' ? 'color: ' . $wp_rem_cs_var_ft_widget_title_color . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_ft_widget_heading_lh ) && $wp_rem_cs_var_ft_widget_heading_lh != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_heading_lh != '' ? 'line-height: ' . $wp_rem_cs_var_ft_widget_heading_lh . 'px !important;' : ''  );
				}
			} else {
				echo wp_rem_selected_google_font_print($wp_rem_cs_var_ft_widget_heading_font_atts, $wp_rem_cs_var_ft_widget_heading_size, $wp_rem_cs_var_ft_widget_heading_lh, $wp_rem_cs_var_ft_widget_heading_font, true);
				if ( isset( $wp_rem_cs_var_ft_widget_heading_spc ) && $wp_rem_cs_var_ft_widget_heading_spc != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_heading_spc != '' ? 'letter-spacing: ' . $wp_rem_cs_var_ft_widget_heading_spc . 'px !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_ft_widget_heading_textr ) && $wp_rem_cs_var_ft_widget_heading_textr != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_heading_textr != '' ? 'text-transform: ' . $wp_rem_cs_var_ft_widget_heading_textr . ' !important;' : ''  );
				}
				if ( isset( $wp_rem_cs_var_ft_widget_title_color ) && $wp_rem_cs_var_ft_widget_title_color != '' ) {
					echo esc_html( $wp_rem_cs_var_ft_widget_title_color != '' ? 'color: ' . $wp_rem_cs_var_ft_widget_title_color . ' !important;' : ''  );
				}
			}
			?>
			}
			<?php
		}

        if ( isset($wp_rem_cs_var_top_strip_bgcolor) && $wp_rem_cs_var_top_strip_bgcolor != '' ) {

            ?>

            /*TopBar Background Color*/

            #header .top-bar {

            background: <?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_top_strip_bgcolor); ?> !important;

            }

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_bgcolor) && $wp_rem_cs_var_submenu_bgcolor != '' ) {

            ?>

            /*Dropdown and Megamenu Background Color*/

            #header .main-navigation ul ul,

            .main-navigation ul li.mega-dropdown-lg ul,

            .main-navigation ul li.mega-menu ul.mega-dropdown-lg:before,

            #header .mega-menu .mega-dropdown-lg.has-border > li:before,

            .main-navigation ul li.mega-menu ul.mega-dropdown-lg:after,

            #header .main-navigation ul ul ul li:hover > a,

            ul.mega-dropdown-lg .menu-loader:before,

            #header .main-navigation ul .mega-dropdown-post .swiper-loader

            { background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_bgcolor); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_bgcolor) && $wp_rem_cs_var_submenu_bgcolor != '' ) {

            ?>

            /*Dropdown and Megamenu Arrow Color*/

            .main-header .main-navigation > ul > li.menu-item-has-children > a:after

            { border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_bgcolor); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_2nd_level_bgcolor) && $wp_rem_cs_var_submenu_2nd_level_bgcolor != '' ) {

            ?>

            /*Navigation-Menu Hover Link Color*/

            .main-header .main-navigation > ul > li.menu-item-has-children > a:after

            { border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_2nd_level_bgcolor); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_header_bgcolor) && $wp_rem_cs_var_header_bgcolor != '' ) {

            ?>

            /*Header Background Color*/

            #header .main-header, .modern .main-header .top-header, .default .main-header .top-header, .advance .main-header .top-header,

            .header1 .main-header .nav-area

            {

            background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_header_bgcolor); ?> !important;

            }

            <?php

        }



        if ( isset($wp_rem_cs_var_header_bgcolor) && $wp_rem_cs_var_header_bgcolor != '' ) {

            ?>

            /*Header border-bottom-color Color*/

            .main-header .main-navigation > ul > li > ul

            {

            border-bottom-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_header_bgcolor); ?> !important;

            }

            <?php

        }



        if ( isset($wp_rem_cs_var_submenu_color) && $wp_rem_cs_var_submenu_color != '' ) {

            ?>

            /*1st level Dropdown Link Color*/

            #header .main-navigation ul ul li a,

            #header .main-navigation ul ul li.menu-item-has-children > a:after,

            .main-header .top-header .contact-holder .login-option > i

            {color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_2nd_level_color) && $wp_rem_cs_var_submenu_2nd_level_color != '' ) {

            ?>

            /*2nd Level Menu link Color*/

            #header .main-navigation ul ul ul li a,

            #header .main-navigation ul ul ul ul li a

            {color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_2nd_level_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_hover_color) && $wp_rem_cs_var_submenu_hover_color != '' ) {

            ?>

            /*Submenu Hover Colors*/

            #header .main-navigation ul ul li:hover > a,

            #header .main-navigation ul li.current-menu-parent ul li.current-menu-item:hover > a,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-item > a,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-item > a:after,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-ancestor > a,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-ancestor > a:after {

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_hover_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_menu_color) && $wp_rem_cs_var_menu_color != '' ) {

            ?>

            /*Navigation-Menu Link Color*/

            #header .main-navigation > ul > li > a, #header .main-navigation ul li.menu-item-has-children a:after, .login-option .cs-popup-login-btn, .main-header .login-option, .login-option a.cs-popup-joinus-btn, .default.default-v2 .main-header .user-dashboard-menu-children > a, .default.default-v2 .main-header .login-option i.icon-caret-down, .main-header .user-dashboard-menu > ul > li > a,

            .main-header .user-dashboard-menu > ul > li > a > i, .main-header .social-media li a,

            .advance .main-header .top-header .property-btn

            { color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_menu_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_menu_active_color) && $wp_rem_cs_var_menu_active_color != '' ) {

            ?>

            .advance .main-header .top-header .property-btn{ border-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_menu_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_menu_active_color) && $wp_rem_cs_var_menu_active_color != '' ) {

            ?>			

            /*Navigation-Menu Hover Link Color*/

            #header .main-navigation ul li:hover > a,

            #header .main-navigation ul li.menu-item-has-children:hover > a:after,

            #header .main-navigation ul li.current-menu-ancestor > a,

            #header .main-navigation ul li.current-menu-ancestor > a:after,

            #header .main-navigation ul li.current-menu-item > a,

            #header .main-navigation ul li.current-menu-item > a:after

            { color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_menu_active_color); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_menu_active_color) && $wp_rem_cs_var_menu_active_color != '' ) {

            ?>			

            /*Navigation-Menu background border Hover Link Color*/

            #header.advance.v2 .main-header .main-navigation>ul>li>a:before,

            #header.advance.v2 .main-header .main-navigation>ul>li.current-menu-item > a:before,

            #header.advance.v2 .main-header .login-option a.login-popup-btn:hover, #header.advance.v2 .main-header .top-header .property-btn:hover,

            #header.advance.v2 .wp-rem-wpml-languages li:hover .wpml-ls-item-toggle

            { background:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_menu_active_color); ?> !important; }

            <?php

        }











        if ( isset($wp_rem_cs_var_menu_hover_bg_color) && $wp_rem_cs_var_menu_hover_bg_color != '' ) {

            ?>

            /*Menu Link hover background-color*/

            #header .main-navigation ul li:hover > a,

            #header .main-navigation ul li.current-menu-ancestor > a,

            #header .main-navigation ul li.current-menu-item > a,

            .home #header .main-navigation ul li.current-menu-item:hover > a,

            #header .main-navigation ul ul,

            #header .main-navigation ul ul ul li:hover > a

            { background:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_menu_hover_bg_color); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_submenu_2nd_level_bgcolor) && $wp_rem_cs_var_submenu_2nd_level_bgcolor != '' ) {

            ?>

            /*DropDown 2nd Level Background-Color*/

            #header .main-navigation ul ul ul,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-item > a,

            #header .main-navigation ul li.current-menu-ancestor ul li.current-menu-ancestor > a,

            #header .main-navigation ul ul,

            #header .main-navigation ul ul ul li:hover > a

            { background:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_submenu_2nd_level_bgcolor); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_widget_color) && $wp_rem_cs_var_widget_color != '' ) {

            ?>

            .page-sidebar .widget-title h3, .page-sidebar .widget-title h4, .page-sidebar .widget-title h5, .page-sidebar .widget-title h6{

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_widget_color); ?> !important;

            }

            <?php

        }

        if ( isset($wp_rem_cs_var_widget_color) && $wp_rem_cs_var_widget_color != '' ) {

            ?>

            .section-sidebar .widget-title h3, .section-sidebar .widget-title h4, .section-sidebar .widget-title h5, .section-sidebar .widget-title h6{

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_widget_color); ?> !important;

            }

            <?php

        }

        /**

         * @Set Footer Colors

         *

         *

         */

        $wp_rem_cs_var_footerbg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_footerbg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_footerbg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_footerbg_color'] : '';

        $wp_rem_cs_var_copyright_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'] : '';

        $wp_rem_cs_var_widget_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_bg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_widget_bg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_bg_color'] : '';

        $wp_rem_cs_var_footerbg_image = (isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_background_image']) and $wp_rem_cs_var_options['wp_rem_cs_var_footer_background_image'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_background_image'] : '';

        $wp_rem_cs_var_footer_text_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_text_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_footer_text_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_text_color'] : '';

        $wp_rem_cs_var_link_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_link_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_link_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_link_color'] : '';

        $wp_rem_cs_var_sub_footerbg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_footerbg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_sub_footerbg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_footerbg_color'] : '';

        $wp_rem_cs_var_copyright_text_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_copyright_text_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_copyright_text_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_copyright_text_color'] : '';

        $wp_rem_cs_var_copyright_bg_color = (isset($wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color']) and $wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'] <> '') ? $wp_rem_cs_var_options['wp_rem_cs_var_copyright_bg_color'] : '';

        /* Footer */

        /* Footer BackgroundImage */

        if ( isset($wp_rem_cs_var_footerbg_image) && $wp_rem_cs_var_footerbg_image != '' ) {

            ?>

            #footer .cs-footer-widgets {

            background: url(<?php echo esc_url($wp_rem_cs_var_footerbg_image); ?>) no-repeat !important;

            background-size: cover !important;

            }

            <?php

        }

        if ( isset($wp_rem_cs_var_footerbg_color) && $wp_rem_cs_var_footerbg_color != '' ) {

            ?>

            /*Footer Background Color*/

            #footer .footer-widget,

            #footer.modern { background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_footerbg_color); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_footerbg_color) && $wp_rem_cs_var_footerbg_color != '' ) {

            ?>

            /*Footer Background Color*/

            #footer .cs-footer-widgets { background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_custom_footer_background); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_sub_footerbg_color) && $wp_rem_cs_var_sub_footerbg_color != '' ) {

            ?>

            footer#footer-sec, footer.group:before { background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_sub_footerbg_color); ?> !important; }

            <?php

        }

        if ( isset($wp_rem_cs_var_footer_text_color) && $wp_rem_cs_var_footer_text_color != '' ) {

            ?>

            /*Footer Text Color*/

            #footer .footer-widget p, .custom-container

            {color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_footer_text_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_copyright_text_color) && $wp_rem_cs_var_copyright_text_color != '' ) {

            ?>

            /*Footer Copyright-text Color*/

            #footer.modern-v1 .cs-copyright p a,

            #footer.modern-v1 .cs-copyright .btn-top a,

            #footer .cs-copyright a,

            #footer .copy-right p,

            #footer .cs-copyright p a,

            #footer .cs-copyright .btn-top a

            {

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_copyright_text_color); ?> !important;

            }

        <?php }if ( isset($wp_rem_cs_var_link_color) && $wp_rem_cs_var_link_color != '' ) { ?>

            /*Footer Link Color*/

            #footer .footer-widget a,

            #footer .widget-nav ul li:before, 

            #footer .widget_nav_menu ul li:before,

            #footer .footer-nav ul li a

            {

            color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_link_color); ?> !important;

            }

            <?php

        }

        if ( isset($wp_rem_cs_var_copyright_bg_color) && $wp_rem_cs_var_copyright_bg_color != '' ) {

            ?>

            /*Footer Copyright Background Color*/

            .copyright-sec {background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_copyright_bg_color); ?> !important;}

            <?php

        }

        if ( isset($wp_rem_cs_var_copyright_bg_color) && $wp_rem_cs_var_copyright_bg_color != '' ) {

            ?>

            /*Footer Copyright Background Color*/

            .copyright-sec {background-color:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_copyright_bg_color); ?> !important;}

            <?php

        }

        $wp_rem_cs_var_custom_themeoption_str = ob_get_clean();

        return $wp_rem_cs_var_custom_themeoption_str;

    }



}







