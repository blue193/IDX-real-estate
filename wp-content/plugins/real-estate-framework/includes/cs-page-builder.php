<?php
/**
 * Create UI for page builder and handle saving of page builder data.
 *
 * @package wp_rem_cs
 */
global $post, $wp_rem_cs_count_node, $wp_rem_cs_xmlObject;
add_action( 'add_meta_boxes', 'wp_rem_cs_page_bulider_add' );

/**
 * Adding Meta box with Frame static text.
 */
if ( ! function_exists( 'wp_rem_cs_page_bulider_add' ) ) {

    function wp_rem_cs_page_bulider_add() {
        global $wp_rem_cs_var_frame_static_text;
        $wp_rem_cs_var_page_builder = isset( $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_builder'] ) ? $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_page_builder'] : '';
        add_meta_box( 'id_page_builder', wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_builder' ), 'wp_rem_cs_page_bulider', 'page', 'normal', 'high' );
    }

}

if ( ! function_exists( 'wp_rem_cs_edit_form_after_title_callback' ) ) {

    function wp_rem_cs_edit_form_after_title_callback() {
        // get globals vars
        global $post;
        if ( isset( $post ) && $post->post_type == 'page' ) {
            $wp_rem_cs_page_bulider = get_post_meta( $post->ID, "wp_rem_cs_page_builder", true );
            $builder_active = get_post_meta( $post->ID, "wp_rem_cs_page_builder", true );
            ob_start();
            $value = ($builder_active == '1') ? wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_classic_editor' ) : wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_builder' );
			
            ?>
            <input type="button" value="<?php echo $value; ?>" style="float:none;" class="btn-toggle-page-builder">
            <style type="text/css">
				#titlediv{
					margin-bottom: 20px;
				}
				<?php if( $builder_active == '1' ) { ?>
				#post-body-content {
					margin-bottom: 10px;
				}
				<?php } ?>
				#wp-content-editor-tools {
					padding-top: 10px;
				 }
				<?php if( $builder_active == '1' ) { ?>
					#postdivrich {
						display: none;
					}
					#id_page_builder {
						display: block;
					}
				<?php }else{ ?>
					#postdivrich {
						display: block;
					}
					#id_page_builder {
						display: none;
					}
				<?php } ?>
            </style>
            <script type="text/javascript">
                (function ($) {
                    $(function () {
                        var is_builder_active = "<?php echo ($builder_active == '1') ? 'true' : 'false'; ?>";
						//is_builder_active == "true" ? toggle_builder("#id_page_builder", "#postdivrich") : toggle_builder("#postdivrich", "#id_page_builder");
                        $(".btn-toggle-page-builder").click(function () {
                            $(this).attr('disabled','disabled');
                            wp_rem_switching_editor( is_builder_active,$(this) );
                            if (is_builder_active == "true") {
                                //toggle_builder("#postdivrich", "#id_page_builder");
                                $(this).val("<?php echo wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_builder' ); ?>");
                                is_builder_active = "false";
								$('input[name="builder_active"]').val('0');
								$( "#post-body-content" ).css( "margin-bottom", "20px" );
                            } else {
                                toggle_builder("#id_page_builder", "#postdivrich");
                                $(this).val("<?php echo wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_classic_editor' ); ?>");
                                is_builder_active = "true";
								$('input[name="builder_active"]').val('1');
								$( "#post-body-content" ).css( "margin-bottom", "10px" );
                            }
                        });

                        function toggle_builder(active, inactive) {
                            $(inactive).fadeOut("fast", function () {
                                $(active).fadeIn();
                            });
							window.editorExpand && window.editorExpand.off && window.editorExpand.off();
                        }
                    });
                })(jQuery);
            </script>
            <?php
            $output = ob_get_clean();
            echo $output;
        }
    }

    add_action( 'edit_form_after_title', 'wp_rem_cs_edit_form_after_title_callback' );
}

/**
 * @Starting Page Builder
 *
 */
if ( ! function_exists( 'wp_rem_cs_page_bulider' ) ) {

    function wp_rem_cs_page_bulider( $post ) {
        global $post, $wp_rem_cs_xmlObject, $wp_rem_cs_node, $wp_rem_cs_count_node, $post, $column_container, $coloum_width, $wp_rem_cs_var_frame_static_text;
        wp_reset_query();
        $postID = $post->ID;
        
        $page_content   = get_post_field( 'post_content', $postID );
        $page_exp       = explode( '[section', $page_content );
        $section_count  = 1;
        
        
        $count_widget = 0;
        $page_title = '';
        $page_content = '';
        $page_sub_title = '';
        $builder_active = 0;
        $wp_rem_cs_page_bulider = get_post_meta( $post->ID, "wp_rem_cs_page_builder", true );
        
        ?>
        <input type="hidden" name="builder_active" value="<?php echo esc_html( $builder_active ) ?>" />
        <div class="clear"></div>
        <div  class = "theme-wrap" id="add_page_builder_item" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>">
            <div id="wp_rem_cs_shortcode_area"></div>  
            <?php
            if ( $wp_rem_cs_page_bulider <> "" ) { 
                if ( isset( $wp_rem_cs_xmlObject->page_title ) )
                    $page_title = $wp_rem_cs_xmlObject->page_title;
                if ( isset( $wp_rem_cs_xmlObject->page_content ) )
                    $page_content = $wp_rem_cs_xmlObject->page_content;
                if ( isset( $wp_rem_cs_xmlObject->page_sub_title ) )
                    $page_sub_title = $wp_rem_cs_xmlObject->page_sub_title;
               
                
                while( $section_count < count($page_exp) ){
                    $section        = explode( '[/section]', $page_exp[$section_count] );
                    $section        = '[section'.$section[0].'[/section]';
                        wp_rem_render_pagebuilder_view( $section );
                    $section_count++;
                }
                
                
            }
            ?>

        </div>
        <div class="clear"></div>
        <div class="add-widget"> <span class="addwidget"> <a href="javascript:ajaxSubmit('wp_rem_cs_column_pb','1','column_full')"><i class="icon-plus-circle"></i> <?php echo wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_add_page_section' ); ?> </a> </span> 
            <div id="loading" class="builderload"></div>
            <div class="clear"></div>
            <input type="hidden" name="page_builder_form" value="1" />
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
	   <script type="text/javascript">
            var count_widget = <?php echo absint( $count_widget ); ?>;
            jQuery(function () {
                jQuery(".draginner").sortable({
                    connectWith: '.draginner',
                    handle: '.column-in',
                    start: function (event, ui) {
                        jQuery(ui.item).css({"width": "25%"});
                    },
                    cancel: '.draginner .poped-up,#confirmOverlay',
                    revert: false,
                    receive: function (event, ui) {
                        var sender_id   = ui.sender.attr('id');
                        var prev_parent_id   = jQuery('#'+sender_id).closest('.parentdeletesection').attr('id'); 
                        var prev_total_columns   = jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val();
                        jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val(parseInt(prev_total_columns)-parseInt(1));
                        var parent_id   = jQuery(this).closest('.parentdeletesection').attr('id');
                        var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                        jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                        
                        wp_rem_cs_frame_callme();
                    },
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true
                });
                jQuery("#add_page_builder_item").sortable({
                    handle: '.column-in',
                    connectWith: ".columnmain",
                    cancel: '.column_container,.draginner,#confirmOverlay',
                    revert: false,
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true
                });

            });
            function ajaxSubmit(action, total_column, column_class) {
                counter++;
                count_widget++;
                jQuery('.builderload').html("<img src='<?php echo wp_rem_cs_var_frame()->plugin_url() . 'assets/images/ajax_loading.gif' ?>' />");
                var newCustomerForm = "action=" + action + '&counter=' + counter + '&total_column=' + total_column + '&column_class=' + column_class + '&postID=<?php echo esc_js( $postID ); ?>';

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    data: newCustomerForm,
                    success: function (data) {
                        jQuery('.builderload').html("");
                        jQuery("#add_page_builder_item").append(data);
                        jQuery('div.cs-drag-slider').each(function () {
                            var _this = jQuery(this);
                            _this.slider({
                                range: 'min',
                                step: _this.data('slider-step'),
                                min: _this.data('slider-min'),
                                max: _this.data('slider-max'),
                                value: _this.data('slider-value'),
                                slide: function (event, ui) {
                                    jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                                }
                            });
                        });
                        jQuery('.bg_color').wpColorPicker();
                        jQuery(".draginner").sortable({
                            connectWith: '.draginner',
                            handle: '.column-in',
                            cancel: '.draginner .poped-up,#confirmOverlay',
                            revert: false,
                            start: function (event, ui) {
                                jQuery(ui.item).css({"width": "25%"})
                            },
                            receive: function (event, ui) {
                                var sender_id   = ui.sender.attr('id');
                                var prev_parent_id   = jQuery('#'+sender_id).closest('.parentdeletesection').attr('id');
                                var prev_total_columns   = jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val(parseInt(prev_total_columns)-parseInt(1));
                                var parent_id   = jQuery(this).closest('.parentdeletesection').attr('id');
                                var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                                wp_rem_cs_frame_callme();
                            },
                            placeholder: "ui-state-highlight",
                            forcePlaceholderSize: true
                        });

                    }
                });

            }

            function wp_rem_cs_frame_ajax_widget(action, id) {
                wp_rem_cs_frame_loader();
                counter++;
                var newCustomerForm = "action=" + action + '&counter=' + counter;
                var edit_url = action + counter;
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    data: newCustomerForm,
                    success: function (data) {
                        console.log(data);
                        jQuery("#counter_" + id).append(data);
                        jQuery("#" + action + counter).append('<input type="hidden" name="wp_rem_cs_widget_element_num[]" value="form" />');
                        var parent_id   = jQuery('#counter_' + id).closest('.parentdeletesection').attr('id');
                        var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                        jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                        jQuery('.bg_color').wpColorPicker();
                        jQuery(".draginner").sortable({
                            connectWith: '.draginner',
                            handle: '.column-in',
                            cancel: '.draginner .poped-up,#confirmOverlay',
                            revert: false,
                            receive: function (event, ui) {
                               var sender_id   = ui.sender.attr('id');
                                var prev_parent_id   = jQuery('#'+sender_id).closest('.parentdeletesection').attr('id');
                                var prev_total_columns   = jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val(parseInt(prev_total_columns)-parseInt(1));
                                var parent_id   = jQuery(this).closest('.parentdeletesection').attr('id');
                                var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                                wp_rem_cs_frame_callme();
                            },
                            placeholder: "ui-state-highlight",
                            forcePlaceholderSize: true
                        });
                        wp_rem_cs_frame_removeoverlay("composer-" + id, "append");
                        jQuery('div.cs-drag-slider').each(function () {
                            var _this = jQuery(this);
                            _this.slider({
                                range: 'min',
                                step: _this.data('slider-step'),
                                min: _this.data('slider-min'),
                                max: _this.data('slider-max'),
                                value: _this.data('slider-value'),
                                slide: function (event, ui) {
                                    jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                                }
                            });
                        });
                        wp_rem_cs_frame_callme();
                        chosen_selectionbox();
                        jQuery('[data-toggle="popover"]').popover();
                    }
                });
            }
            function wp_rem_cs_frame_ajax_widget_element(action, id, name) {

                wp_rem_cs_frame_loader();
                counter++;
                var newCustomerForm = "action=" + action + '&element_name=' + name + '&counter=' + counter;
                var edit_url = action + counter;

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    data: newCustomerForm,
                    success: function (data) {
                        jQuery("#counter_" + id).append(data);

                        jQuery("#counter_" + id + " #results-shortocde-id-form").append('<input type="hidden" name="wp_rem_cs_widget_element_num[]" value="form" />');
                        jQuery('.bg_color').wpColorPicker();
                        jQuery(".draginner").sortable({
                            connectWith: '.draginner',
                            handle: '.column-in',
                            cancel: '.draginner .poped-up,#confirmOverlay',
                            
                            revert: false,
                            receive: function (event, ui) {
                                var sender_id   = ui.sender.attr('id');
                                var prev_parent_id   = jQuery('#'+sender_id).closest('.parentdeletesection').attr('id');
                                var prev_total_columns   = jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val(parseInt(prev_total_columns)-parseInt(1));
                                var parent_id   = jQuery(this).closest('.parentdeletesection').attr('id');
                                var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                                jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                                wp_rem_cs_frame_callme();
                            },
                            placeholder: "ui-state-highlight",
                            forcePlaceholderSize: true
                        });
                        wp_rem_cs_frame_removeoverlay("composer-" + id, "append");
                        jQuery('div.cs-drag-slider').each(function () {
                            var _this = jQuery(this);
                            _this.slider({
                                range: 'min',
                                step: _this.data('slider-step'),
                                min: _this.data('slider-min'),
                                max: _this.data('slider-max'),
                                value: _this.data('slider-value'),
                                slide: function (event, ui) {
                                    jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                                }
                            });
                        });
                        wp_rem_cs_frame_callme();
                    }
                });
            }
            function wp_rem_cs_frame_ajax_submit(action) {
                counter++;
                count_widget++;
                var newCustomerForm = "action=" + action + '&counter=' + counter;
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url() ?>/admin-ajax.php",
                    data: newCustomerForm,
                    success: function (data) {
                        jQuery("#add_page_builder_item").append(data);
                        if (count_widget > 0)
                            jQuery("#add_page_builder_item").addClass('hasclass');

                    }
                });

            }
        </script>
        <?php
    }

}

/**
 * @Saving Data for Page Builder by POST ID
 *
 */
if ( isset( $_POST['page_builder_form'] ) and $_POST['page_builder_form'] == 1 ) {
    add_action( 'save_post', 'save_page_builder' );
    if ( ! function_exists( 'save_page_builder' ) ) {

        /**
         * Save Page Builder contents.
         * @param type $post_id
         * @return typeSave 
         */
        function save_page_builder( $post_id ) {
			$page_builder	= get_post_meta( $post_id, "wp_rem_cs_page_builder", true );
			if( $page_builder == 1 ){
				$shortcode  = wp_rem_creating_shortcode($_POST );
                                $shortcode  = htmlspecialchars_decode( stripslashes( $shortcode ) );
				$post_content = array(
					'ID'           => $post_id,
					'post_content' => $shortcode,
				);
				remove_action( 'save_post', 'save_page_builder' );
				wp_update_post( $post_content );
				add_action( 'save_post', 'save_page_builder' );
			}
        }

    }
}

/**
 * Creating shortcode from posted data
 * @return shortcode string 
 */
if ( ! function_exists( 'wp_rem_creating_shortcode' ) ) {
    
    function wp_rem_creating_shortcode( $post_data ){
        $counters = array(
                        'wp_rem_cs_counter' => 0,
                        'page_element_id' => 0,
                        'column_container_no' => 0,
                        'widget_no' => 0,
                    );
        $counters = apply_filters( 'wp_rem_cs_load_shortcode_counters', $counters );
        $section_shortcode  = '';
        //$column_rand_id = $post_data['column_rand_id'][$counters['column_container_no']];
        foreach ( $post_data['total_column'] as $count_column ) {
            $column_rand_id = $post_data['column_rand_id'][$counters['column_container_no']];
            $fields = array(
                    'wp_rem_cs_var_section_title' => is_set( $post_data['wp_rem_cs_var_section_title_array'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_var_section_subtitle' => is_set( $post_data['wp_rem_cs_var_section_subtitle_array'][$counters['column_container_no']], '' ),
                    'title_sub_title_alignment' => is_set( $post_data['title_sub_title_alignment'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_background_option' => is_set( $post_data['wp_rem_cs_section_background_option'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_bg_image' => is_set( $post_data['wp_rem_cs_var_section_bg_image_array'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_bg_image_position' => is_set( $post_data['wp_rem_cs_section_bg_image_position'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_bg_image_repeat' => is_set( $post_data['wp_rem_cs_section_bg_image_repeat'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_flex_slider' => is_set( $post_data['wp_rem_cs_section_flex_slider'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_custom_slider' => is_set( $post_data['wp_rem_cs_section_custom_slider'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_video_url' => is_set( $post_data['wp_rem_cs_section_video_url'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_video_mute' => is_set( $post_data['wp_rem_cs_section_video_mute'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_video_autoplay' => is_set( $post_data['wp_rem_cs_section_video_autoplay'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_bg_color' => is_set( $post_data['wp_rem_cs_section_bg_color'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_titlt_color' => is_set( $post_data['wp_rem_cs_section_titlt_color'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_subtitlt_color' => is_set( $post_data['wp_rem_cs_section_subtitlt_color'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_padding_top' => is_set( $post_data['wp_rem_cs_section_padding_top'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_padding_top_mobile' => is_set( $post_data['wp_rem_cs_section_padding_top_mobile'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_padding_bottom' => is_set( $post_data['wp_rem_cs_section_padding_bottom'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_padding_bottom_mobile' => is_set( $post_data['wp_rem_cs_section_padding_bottom_mobile'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_border_bottom' => is_set( $post_data['wp_rem_cs_section_border_bottom'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_border_top' => is_set( $post_data['wp_rem_cs_section_border_top'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_border_color' => is_set( $post_data['wp_rem_cs_section_border_color'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_margin_top' => is_set( $post_data['wp_rem_cs_section_margin_top'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_margin_top_mobile' => is_set( $post_data['wp_rem_cs_section_margin_top_mobile'][$counters['column_container_no']], '0' ),
                    'wp_rem_cs_section_margin_bottom' => is_set( $post_data['wp_rem_cs_section_margin_bottom'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_margin_bottom_mobile' => is_set( $post_data['wp_rem_cs_section_margin_bottom_mobile'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_nopadding' => is_set( $post_data['wp_rem_cs_section_nopadding'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_parallax' => is_set( $post_data['wp_rem_cs_section_parallax'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_nomargin' => is_set( $post_data['wp_rem_cs_section_nomargin'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_css_id' => is_set( $post_data['wp_rem_cs_section_css_id'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_section_view' => is_set( $post_data['wp_rem_cs_section_view'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_layout' => is_set( $post_data['wp_rem_cs_layout'][$column_rand_id]['0'], '' ),
                    'wp_rem_cs_sidebar_left' => is_set( $post_data['wp_rem_cs_sidebar_left'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_sidebar_right' => is_set( $post_data['wp_rem_cs_sidebar_right'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_sidebar_left_second' => is_set( $post_data['wp_rem_cs_sidebar_left_second'][$counters['column_container_no']], '' ),
                    'wp_rem_cs_sidebar_right_second' => is_set( $post_data['wp_rem_cs_sidebar_right_second'][$counters['column_container_no']], '' ),
                );
            $fields['wp_rem_cs_section_padding_top'] = ( $fields['wp_rem_cs_section_padding_top'] == '' )? '0' : $fields['wp_rem_cs_section_padding_top'];
            $fields['wp_rem_cs_section_padding_bottom'] = ( $fields['wp_rem_cs_section_padding_bottom'] == '' )? '0' : $fields['wp_rem_cs_section_padding_bottom'];
            $fields['wp_rem_cs_section_padding_top_mobile'] = ( $fields['wp_rem_cs_section_padding_top_mobile'] == '' )? '0' : $fields['wp_rem_cs_section_padding_top_mobile'];
            $fields['wp_rem_cs_section_padding_bottom_mobile'] = ( $fields['wp_rem_cs_section_padding_bottom_mobile'] == '' )? '0' : $fields['wp_rem_cs_section_padding_bottom_mobile'];
            $fields['wp_rem_cs_section_border_color'] = ( $fields['wp_rem_cs_section_border_color'] == '' )? '-' : $fields['wp_rem_cs_section_border_color'];
            $section_shortcode      .= '[section';
            foreach ( $fields as $key => $value ) {
                if( $value != '' ){
                    $section_shortcode .= ' '.$key.'="'.$value.'"';
                }
            }
            $section_shortcode      .= ']';
            $a = $post_data['total_column'][$counters['column_container_no']];
            for ( $j = 1; $j <= $a; $j ++ ) {
                $counters['page_element_id'] ++;
                $widget_type = is_set( $post_data['wp_rem_cs_orderby'][$counters['wp_rem_cs_counter']], '' );
                $element_type = str_replace( 'cs_', '', $widget_type );
                $args = array(
                    'data' => $post_data,
                    'counters' => $counters,
                    'widget_type' => $widget_type,
                    'column' => '',
                );                
                $args = apply_filters( 'wp_rem_cs_save_page_builder_data_'.$element_type, $args );
                $shortcode = $args['column'];
                $counters = $args['counters'];
                $widget_type = $args['widget_type'];
                $section_shortcode .= $shortcode;
                $counters['wp_rem_cs_counter'] ++;
                $counters['widget_no']++;
            }
            $section_shortcode .= '[/section]';
            
           $counters['column_container_no']++;
        }

        
        return $section_shortcode;
    }
}


function wp_rem_render_pagebuilder_view( $section ){
    wp_rem_cs_column_pb( 1, '', $section );
}


if ( ! function_exists( 'wp_rem_generate_shortcode' ) ) {
    function wp_rem_generate_shortcode(){
        delete_post_meta( $_POST['post_ID'], "wp_rem_cs_page_builder");
        $shortcode  = wp_rem_creating_shortcode( $_POST );
        $shortcode  = htmlspecialchars_decode( stripslashes( $shortcode ) );
        echo $shortcode;
        wp_die();
    }
    add_action( 'wp_ajax_wp_rem_generate_shortcode', 'wp_rem_generate_shortcode' );
}

if ( ! function_exists( 'wp_rem_generate_elements_view' ) ) {
    function wp_rem_generate_elements_view(){
        $page_content       = stripcslashes($_POST['content']);
        $page_exp           = explode( '[section', $page_content );
        $section_count      = 1;
        update_post_meta( $_POST['post_id'], "wp_rem_cs_page_builder", 1 );
        echo '<div id="wp_rem_cs_shortcode_area"></div>';
        while( $section_count < count($page_exp) ){
            $section        = explode( '[/section]', $page_exp[$section_count] );
            $section        = '[section'.$section[0].'[/section]';
            echo wp_rem_render_pagebuilder_view( $section );
            $section_count++;
        }
        wp_die();
    }
    add_action( 'wp_ajax_wp_rem_generate_elements_view', 'wp_rem_generate_elements_view' );
}