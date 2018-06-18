<?php
/**
 * Core Functions of Plugin
 * @return
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('wp_rem_cs_var_core_functions')) {

    class wp_rem_cs_var_core_functions {

	public function __construct() {
	    //add_action('save_post', array($this, 'wp_rem_cs_var_save_custom_option'));
	}
    }

}


/**
 * Framework Form
 * @Fields
 *
 */
if (!function_exists('wp_rem_cs_column_pb')) {

    function wp_rem_cs_column_pb($die = 0, $shortcode = '', $section_data) {
	global $post, $wp_rem_cs_node, $wp_rem_cs_xmlObject, $wp_rem_cs_count_node, $column_container, $coloum_width, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;

	$total_widget = 0;
	$i = 1;
	$wp_rem_cs_page_section_title = $wp_rem_cs_page_section_height = $wp_rem_cs_page_section_width = '';
	$wp_rem_cs_section_background_option = '';
	$wp_rem_cs_var_section_title = '';
	$wp_rem_cs_var_section_subtitle = '';
        $column_class       = 'col_100';
	$title_sub_title_alignment = '';
	$wp_rem_cs_section_bg_image = '';
	$wp_rem_cs_section_bg_image_position = '';
	$wp_rem_cs_section_bg_image_repeat = '';
	$wp_rem_cs_section_parallax = '';
	$wp_rem_cs_section_nopadding = '';
	$wp_rem_cs_section_nomargin = '';
	$wp_rem_cs_section_slick_slider = '';
	$wp_rem_cs_section_custom_slider = '';
	$wp_rem_cs_section_video_url = '';
	$wp_rem_cs_section_video_mute = '';
	$wp_rem_cs_section_video_autoplay = '';
	$wp_rem_cs_section_border_bottom = '0';
	$wp_rem_cs_section_border_top = '0';
	$wp_rem_cs_section_border_color = '#e0e0e0';
	$wp_rem_cs_section_padding_top = '60';
	$wp_rem_cs_section_padding_bottom = '30';
	$wp_rem_cs_section_margin_top = '0';
	$wp_rem_cs_section_margin_bottom = '0';
        $wp_rem_cs_section_padding_top_mobile = '0';
	$wp_rem_cs_section_padding_bottom_mobile = '0';
	$wp_rem_cs_section_margin_top_mobile = '0';
	$wp_rem_cs_section_margin_bottom_mobile = '0';
	$wp_rem_cs_section_css_id = '';
	$wp_rem_cs_section_view = 'container';
	$wp_rem_cs_layout = '';
	$wp_rem_cs_sidebar_left = '';
	$wp_rem_cs_sidebar_right = '';
	$wp_rem_cs_sidebar_right_second = '';
	$wp_rem_cs_sidebar_left_second = '';
	$wp_rem_cs_section_bg_color = '';
	$wp_rem_cs_section_titlt_color = '';
	$wp_rem_cs_section_subtitlt_color = '';
        $section_array      = array();
        if( isset( $section_data ) && $section_data!= '' ){
            //$section_data       = str_replace( '>', '&gt!', $section_data );
            //$section_data       = str_replace( '<', '&lt!', $section_data );
            $shortcode_matches    = array();
            $pattern = get_shortcode_regex();
            preg_match_all("/$pattern/",$section_data,$shortcode_matches);
            $shortcodes_array = $shortcode_matches[0];
            
            $section_exp        = explode( '[section', $section_data );
            $section_exp        = explode( ']', $section_exp[1] );
            $section_atr        = explode( '" ', $section_exp[0] );
            
            foreach( $section_atr as $section_atr_value ){
                $section_atr_exp    = explode( '="', $section_atr_value );
                $section_array[trim($section_atr_exp[0])] = str_replace( '"', '', trim($section_atr_exp[1]));
            }
        }
        extract( $section_array );
        
	$style = '';
	if (isset($_POST['action']) && $_POST['action'] != 'wp_rem_generate_elements_view' ) {
	    $name = $_POST['action'];
	    $wp_rem_cs_counter = $_POST['counter'];
	    $total_column = $_POST['total_column'];
	    $column_class = isset($_POST['column_class'] ) ? $_POST['column_class'] : 'col_100';
	    $postID = $_POST['postID'];
	    $randomno = rand(12345678, 93242432);
	    $rand = rand(12345678, 93242432);
	    $style = '';
	} else {
	    $postID = $post->ID;
	    $name = '';
	    $wp_rem_cs_counter = '';
	    $total_column = 0;
	    $rand = rand(1, 999);
	    $randomno = rand(34, 3242432);
	    $name = $_REQUEST['action'];
	    $style = ' style="display:none;"';
	}
	$wp_rem_cs_page_elements_name = wp_rem_cs_shortcode_names();
	$wp_rem_cs_page_categories_name = wp_rem_cs_elements_categories();
	$wp_rem_cs_var_add_element = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_add_element');
	$wp_rem_cs_var_search = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_search');
	$wp_rem_cs_var_show_all = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_search');
	$wp_rem_cs_var_filter_by = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_filter_by');
	$wp_rem_cs_var_insert_sc = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_insert_sc');
        
        if( isset( $wp_rem_cs_section_border_color ) && $wp_rem_cs_section_border_color == '-' ){
            $wp_rem_cs_section_border_color = '';
        }
	?>
	<div class="cs-page-composer composer-<?php echo absint($rand) ?>" id="composer-<?php echo absint($rand) ?>" style="display:none">
	    <div class="page-elements">
		<div class="cs-heading-area">

		    <h5> <i class="icon-plus-circle"></i> <?php echo esc_html($wp_rem_cs_var_add_element); ?>  </h5>
		    <span class='cs-btnclose' onclick='javascript:wp_rem_cs_frame_removeoverlay("composer-<?php echo absint($rand) ?>", "append")'><i class="icon-cross"></i></span> 
		</div>
		<script>
		    jQuery(document).ready(function ($) {
			'use strict';
			wp_rem_cs_page_composer_filterable('<?php echo absint($rand) ?>');
		    });
		</script>
		<div class="cs-filter-content">
		    <p>

			<?php
			if (function_exists('wp_rem_cs_var_date_picker')) {

			    wp_rem_cs_var_date_picker();
			}
			$wp_rem_cs_opt_array = array(
			    'std' => '',
			    'cust_id' => 'quicksearch' . absint($rand),
			    'classes' => '',
			    'cust_name' => '',
			    'extra_atr' => ' placeholder=' . $wp_rem_cs_var_search,
			);
			$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
			?>

		    </p>
		    <div class="cs-filtermenu-wrap">
			<h6><?php echo esc_html($wp_rem_cs_var_filter_by); ?></h6>
			<ul class="cs-filter-menu" id="filters<?php echo absint($rand) ?>">
			    <li data-filter="all" class="active"><?php echo esc_html($wp_rem_cs_var_show_all); ?></li>
			    <?php foreach ($wp_rem_cs_page_categories_name as $key => $value) { ?>
	    		    <li data-filter="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></li>
			    <?php } ?>
			</ul>
		    </div>
		    <div class="cs-filter-inner" id="page_element_container<?php echo absint($rand) ?>">
			<?php foreach ($wp_rem_cs_page_elements_name as $key => $value) { ?>
	    		<div class="element-item <?php echo esc_attr($value['categories']); ?>"> 
	    		    <a href='javascript:wp_rem_cs_frame_ajax_widget("wp_rem_cs_var_page_builder_<?php echo esc_js($value['name']); ?>","<?php echo esc_js($rand) ?>")'>
				    <?php wp_rem_cs_page_composer_elements($value['title'], $value['icon']); ?>
	    		    </a> 
	    		</div>
			<?php } ?>                    
		    </div>
		</div>
	    </div>
	</div>
	<?php
	if (isset($shortcode) && $shortcode <> '') {
	    ?>
	    <a class="button" href="javascript:wp_rem_cs_frame_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')"><i class="icon-plus-circle"></i><?php echo esc_html($wp_rem_cs_var_insert_sc); ?> </a>
	    <?php
	} else {
	    ?>
            
	    <div id="<?php echo esc_attr($randomno); ?>_del" class="column columnmain parentdeletesection column_100" >
	        <div class="column-in"> <a class="button" href="javascript:wp_rem_cs_frame_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')"><i class="icon-plus-circle"></i> <?php echo esc_html($wp_rem_cs_var_add_element); ?></a>
	    	<p> 
	    	    <a href="javascript:wp_rem_cs_frame_createpop('<?php echo esc_js($column_class . $randomno); ?>','filterdrag')" class="options">
	    		<i class="icon-cog3"></i></a> &nbsp; <a href="#" class="delete-it btndeleteitsection"><i class="icon-trash-o"></i></a> &nbsp; 
	    	</p>
	        </div>
	        <div class="column column_container page_section <?php echo sanitize_html_class($column_class); ?>" >
		    <?php
		    $parts = explode('_', $column_class);
                    
		    if ($total_column > 0) {
			for ($i = 1; $i <= $total_column; $i ++) {
			    ?>
		    	<div class="dragarea" data-item-width="col_width_<?php echo esc_attr($parts[$i]); ?>">

				<?php
				$wp_rem_cs_opt_array = array(
				    'std' => '0',
				    'cust_id' => '',
				    'classes' => 'textfld',
				    'cust_name' => 'total_widget[]',
				    'extra_atr' => '',
				);
				$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
				?>

		    	    <div class="draginner" id="counter_<?php echo absint($rand) ?>"></div>
		    	</div>
			    <?php
			}
		    }
		    $i = 1;
                    $column_container   = '';
		    if (isset($column_container)) {
			global $wpdb;

			$total_column = count($shortcodes_array);
			$section = 0;
			$section_widget_element_num = 0;
			while ($i == 1 ) {
			    $section ++;
			    $total_widget = count($shortcodes_array);
			    ?>
		    	<script type="text/javascript">

		    	    function wp_rem_cs_var_gallery_view(val) {
		    		var wp_rem_cs_var_gallery_view = jQuery('.gallery_slider_view').val();
		    		if (wp_rem_cs_var_gallery_view == 'slider') {
		    		    jQuery('#slider_gallery').show();
		    		    jQuery('#slider_gallery').show();
		    		    jQuery('.slider_view_paging').hide();
		    		    jQuery('#slider_category').hide();
		    		    jQuery('.slider_view_paging_unique').hide();
		    		} else if (wp_rem_cs_var_gallery_view == 'unique_gallery') {
		    		    jQuery('.slider_view_paging_unique').show();
		    		    jQuery('.slider_view_paging_style').hide();
		    		} else {
		    		    jQuery('#slider_gallery').hide();
		    		    jQuery('.slider_view_paging_unique').hide();
		    		    jQuery('.slider_view_paging').show();
		    		    jQuery('#slider_category').show();
		    		    jQuery('#slider_category_column').hide();
		    		}
		    	    }
                            
                            jQuery(function () {
                                jQuery(".draginner").sortable({
                                    connectWith: '.draginner',
                                    //connectWith: '#counter_<?php echo absint($rand) ?>',
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
		    	</script>
		    	<div class="dragarea" data-item-width="col_width_<?php echo esc_attr($parts[$i]) ?>">
		    	    
		    	    <div class="draginner" id="counter_<?php echo absint($rand) ?>">
                                    <?php
				    $wp_rem_cs_opt_array = array(
					'std' => esc_attr($total_widget),
					'cust_id' => '',
					'classes' => 'textfld page-element-total-widget',
					'cust_name' => 'total_widget[]',
					'extra_atr' => '',
				    );
				    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
				    ?>
				    <?php
				    $shortcode_element = '';
				    $filter_element = 'filterdrag';
				    $shortcode_view = '';
				    $global_array = array();
				    $section_widget__element = 0;
				    $all_shortcode_list = wp_rem_cs_shortcode_names();
				    foreach ($shortcodes_array as $wp_rem_cs_node) {
                                        $sc_name        = wp_rem_shortcode_name( $wp_rem_cs_node );
                                        $sc_element_size    = wp_rem_element_size( $wp_rem_cs_node );
                                        $sc_element_size    = ( $sc_element_size > 100 )? 100: $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size < 25 )? 25: $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size > 25 && $sc_element_size < 33 )? 33: $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size > 33 && $sc_element_size < 50 )? 50: $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size > 50 && $sc_element_size < 67 )? 67: $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size > 67 && $sc_element_size < 75 ) ? 75 : $sc_element_size;
                                        $sc_element_size    = ( $sc_element_size > 75 && $sc_element_size < 100 )? 100: $sc_element_size;
					$section_widget__element ++;
					$shortcode_element_idd = $rand . '_' . $section_widget__element;
					$global_array[] = $wp_rem_cs_node;
					$wp_rem_cs_count_node ++;
					$wp_rem_cs_counter = $postID . $wp_rem_cs_count_node;
					$a = $name = "wp_rem_cs_var_page_builder_".$sc_name;
					$coloumn_class = $sc_element_size;
					$type = '';
					if ($sc_name == 'page_element') {
					    $type = 'page_element';
					}
					$wp_rem_cs_var_quick_quote = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_quick_quote');
					$wp_rem_cs_var_edit_options = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_edit_options');
					?>
					<div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete  column_<?php echo $coloumn_class; ?> <?php echo esc_attr($shortcode_view); ?>" item="<?php echo $sc_name; ?>" data="<?php echo wp_rem_cs_element_size_data_array_index($sc_element_size) ?>" >
					    <?php wp_rem_cs_ajax_element_setting($sc_name, $wp_rem_cs_counter, $sc_element_size, $shortcode_element_idd, $postID, $element_description = '', 'cs_'.$sc_name.'-icon', $type); ?>
					    <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" style="display: none;">
						<div class="cs-heading-area">
						    <?php
						    $shortcode_name = '';
						    if ($sc_name == 'quick_slider') {
							$shortcode_name = $wp_rem_cs_var_quick_quote;
						    } else {
							$shortcode_name = str_replace("_", " ", $sc_name);
							$shortcode_name = $all_shortcode_list[$sc_name]['title'];
						    }
						    ?>
						    <h5><?php echo sprintf($wp_rem_cs_var_edit_options, esc_html($shortcode_name)) ?></h5>

						    <a href="javascript:;" onclick="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_attr($name . $wp_rem_cs_counter); ?>', '<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
						</div>
						<?php
						$wp_rem_cs_opt_array = array(
						    'std' => 'shortcode',
						    'cust_id' => 'shortcode_' . $name . $wp_rem_cs_counter,
						    'classes' => 'cs-wiget-element-type',
						    'cust_name' => 'wp_rem_cs_widget_element_num[]',
						    'extra_atr' => '',
						);
						$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
						?>
						<div class="pagebuilder-data-load">
						    <?php
						    $wp_rem_cs_opt_array = array(
							'std' => 'cs_'.$sc_name,
							'cust_id' => '',
							'classes' => '',
							'cust_name' => 'wp_rem_cs_orderby[]',
							'extra_atr' => '',
							'force_std' => true,
						    );
						    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
						    $wp_rem_cs_opt_array = array(
							'std' => $wp_rem_cs_node,
							'cust_id' => '',
							'classes' => 'cs-textarea-val',
							'cust_name' => 'shortcode['.$sc_name.'][]',
							'extra_atr' => ' style=display:none;',
							'force_std' => true,
						    );
						    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_textarea_render($wp_rem_cs_opt_array);
						    ?>
						</div>
					    </div>
					</div>
					<?php
				    }
				    ?>
		    	    </div>
		    	</div>
			    <?php
			    $i ++;
			}
		    }
		    ?>
	        </div>
	        <div id="<?php echo esc_attr($column_class . $randomno); ?>" style="display:none">
	    	<div class="cs-heading-area">
	    	    <h5><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_edit_page'); ?></h5>
	    	    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($column_class . $randomno); ?>','filterdrag')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
	    	<div class="cs-pbwp-content">
	    	    <div class="cs-wrapp-clone cs-shortcode-wrapp">
			    <?php
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_title'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_title_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_var_section_title,
				    'id' => 'section_title',
				    'classes' => '',
				    'array' => true,
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_title_color'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_titlt_color),
				    'cust_id' => '',
				    'classes' => 'bg_color',
				    'cust_name' => 'wp_rem_cs_section_titlt_color[]',
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_subtitle'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_subtitle_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_var_section_subtitle,
				    'id' => 'section_subtitle',
				    'classes' => '',
				    'array' => true,
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_subtitle_color'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_subtitlt_color),
				    'cust_id' => '',
				    'classes' => 'bg_color',
				    'cust_name' => 'wp_rem_cs_section_subtitlt_color[]',
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    

			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_title_sub_title_align'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_title_sub_title_align_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => $title_sub_title_alignment,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'title_sub_title_alignment[]',
				    'classes' => 'chosen-select-no-single select-medium',
				    'options' => array(
					'left' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_align_left'),
					'center' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_align_center'),
					'right' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_align_right'),
				    ),
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_view'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_choose_bg'),
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_section_background_option,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_background_option[]',
				    'classes' => 'chosen-select-no-single select-medium',
				    'options' => array(
					'no-image' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_none'),
					'section-custom-background-image' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_image'),
					'section-custom-slider' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_custom_slider'),
					'section_background_video' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_video'),
				    ),
				    'return' => true,
				    'extra_atr' => 'onchange="javascript:wp_rem_cs_section_background_settings_toggle(this.value, ' . absint($randomno) . ')"',
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
			    ?>    
	    		<div class="meta-body noborder section-custom-background-image-<?php echo esc_attr($randomno); ?>" style=" <?php
			    if ($wp_rem_cs_section_background_option == "section-custom-background-image") {
				echo "display:block";
			    } else
				echo "display:none";
			    ?>">
				     <?php
				     $wp_rem_cs_opt_array = array(
					 'std' => $wp_rem_cs_section_bg_image,
					 'id' => 'section_bg_image',
					 'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_image'),
					 'desc' => '',
					 'force_std' => true,
					 'echo' => true,
					 'array' => true,
					 'field_params' => array(
					     'std' => $wp_rem_cs_section_bg_image,
					     'cust_id' => '',
					     'id' => 'section_bg_image',
					     'force_std' => true,
					     'return' => true,
					     'array' => true,
					     'array_txt' => false,
					 ),
				     );
				     $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
				     $wp_rem_cs_opt_array = array(
					 'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_position'),
					 'desc' => '',
					 'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_position_hint'),
					 'echo' => true,
					 'field_params' => array(
					     'std' => $wp_rem_cs_section_bg_image_position,
					     'id' => '',
					     'cust_id' => '',
					     'cust_name' => 'wp_rem_cs_section_bg_image_position[]',
					     'classes' => 'select_dropdown chosen-select-no-single select-medium',
					     'options' => array(
						 'no-repeat center top' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_center_top'),
						 'repeat center top' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_center_top'),
						 'no-repeat center' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_center'),
						 'no-repeat center / cover' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_center_cover'),
                                                 'repeat center / cover' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_center_cover'),
						 'repeat center' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_repeat_center'),
						 'no-repeat left top' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_left_top'),
						 'repeat left top' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_repeat_left_top'),
						 'no-repeat fixed center' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_fixed'),
						 'no-repeat fixed center / cover' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_fixed_cover'),
					     ),
					     'return' => true,
					     'extra_atr' => '',
					 ),
				     );
				     $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
				     ?>    
	    		</div>
	    		<div class="meta-body noborder section-slider-<?php echo esc_attr($randomno); ?>" style=" <?php
			    if ($wp_rem_cs_section_background_option == "section-slider") {
				echo "display:block";
			    } else
				echo "display:none";
			    ?>">
	    		</div>
	    		<div class="meta-body noborder section-custom-slider-<?php echo esc_attr($randomno); ?>" style=" <?php
                        
                            
                            
                            
                            
			    if ($wp_rem_cs_section_background_option == "section-custom-slider") {
				echo "display:block";
			    } else
				echo "display:none";
			    ?>" >
				     <?php
				     /*$wp_rem_cs_opt_array = array(
					 'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_custom_slider'),
					 'desc' => '',
					 'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_custom_slider_hint'),
					 'echo' => true,
					 'field_params' => array(
					     'std' => esc_attr($wp_rem_cs_section_custom_slider),
					     'cust_id' => '',
					     'classes' => 'txtfield',
					     'cust_name' => 'wp_rem_cs_section_custom_slider[]',
					     'return' => true,
					 ),
				     );
				     $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                      */
                                     $slider_array   = array( '' => __( 'None', 'wp-rem-frame' ));
                                     if( class_exists( 'RevSlider' ) ){
                                        $rev_sliders = new RevSlider();
                                        $all_slides_array = $rev_sliders->getArrSliders();
                                        $slider_array   = array( '' => __( 'None' , 'wp-rem-frame' ));
                                        if(!empty($all_slides_array)){
                                            foreach($all_slides_array as $slider){
                                                $slider_array[$slider->getAlias()]  = $slider->getTitle();
                                            }
                                        }
                                    }
                                     
                                      $wp_rem_cs_opt_array = array(
					 'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_custom_slider'),
					 'desc' => '',
					 'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_custom_slider_hint'),
					 'echo' => true,
					 'field_params' => array(
					     'std' => esc_attr($wp_rem_cs_section_custom_slider),
					     'id' => '',
					     'cust_id' => '',
					     'cust_name' => 'wp_rem_cs_section_custom_slider[]',
					     'classes' => 'select_dropdown chosen-select-no-single select-medium',
					     'options' => $slider_array,
					     'return' => true,
					     'extra_atr' => '',
					 ),
				     );
				     $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                     
                                     
                                     
				     ?>
	    		</div>
	    		<div class="meta-body noborder section-background-video-<?php echo esc_attr($randomno); ?>" style=" <?php
			    if ($wp_rem_cs_section_background_option == "section_background_video") {
				echo "display:block";
			    } else
				echo "display:none";
			    ?>">
	    		    <div class="form-elements">
	    			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    			    <label><?php echo esc_html('wp_rem_cs_var_video_url'); ?></label>
	    			</div>
	    			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	    			    <div class="input-sec">
					    <?php
					    $wp_rem_cs_opt_array = array(
						'std' => esc_url(wp_rem_cs_var_frame_text_srt('wp_rem_cs_section_video_url')),
						'cust_id' => '',
						'id' => 'section_video_url_' . esc_attr($randomno),
						'classes' => '',
						'cust_name' => 'wp_rem_cs_section_video_url',
						'extra_atr' => '',
					    );
					    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
					    ?>
	    				<label class="browse-icon">
						<?php
						$wp_rem_cs_opt_array = array(
						    'std' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_browse'),
						    'cust_id' => '',
						    'cust_type' => 'button',
						    'classes' => 'cs-wp_rem_cs-media left',
						    'cust_name' => 'wp_rem_cs_section_video_url_' . esc_attr($randomno),
						    'extra_atr' => '',
						);
						$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
						?>
	    				</label>
	    			    </div>
	    			</div>
	    		    </div>
				<?php
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_mute'),
				    'desc' => '',
				    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_choose_mute'),
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_section_video_mute,
					'id' => '',
					'cust_id' => '',
					'cust_name' => 'wp_rem_cs_section_video_mute[]',
					'classes' => 'select_dropdown chosen-select-no-single select-medium',
					'options' => array(
					    'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
					    'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
					),
					'return' => true,
					'extra_atr' => '',
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
				?>    
				<?php
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_video_auto'),
				    'desc' => '',
				    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_choose_video_auto'),
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_section_video_autoplay,
					'id' => '',
					'cust_id' => '',
					'cust_name' => 'wp_rem_cs_section_video_autoplay[]',
					'classes' => 'select_dropdown chosen-select-no-single select-medium',
					'options' => array(
					    'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
					    'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
					),
					'return' => true,
					'extra_atr' => '',
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
				?>      
	    		</div>
			    <?php
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_enable_parallax'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_section_parallax,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_parallax[]',
				    'classes' => 'select_dropdown chosen-select-no-single select-medium',
				    'options' => array(
					'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
					'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
				    ),
				    'return' => true,
				    'extra_atr' => '',
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_section_nopadding'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_padding_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_section_nopadding,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_nopadding[]',
				    'classes' => 'select_dropdown chosen-select-no-single select-medium',
				    'options' => array(
					'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
					'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
				    ),
				    'return' => true,
				    'extra_atr' => '',
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_section_nomargin'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no_margin_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_section_nomargin,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_nomargin[]',
				    'classes' => 'select_dropdown chosen-select-no-single select-medium',
				    'options' => array(
					'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
					'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
				    ),
				    'return' => true,
				    'extra_atr' => '',
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_select_view'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
				    'std' => $wp_rem_cs_section_view,
				    'id' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_view[]',
				    'classes' => 'select_dropdown chosen-select-no-single select-medium',
				    'options' => array(
					'container' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_box'),
					'wide' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_wide'),
				    ),
				    'return' => true,
				    'extra_atr' => '',
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_bg_color'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_choose_bg_coor'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_bg_color),
				    'cust_id' => '',
				    'classes' => 'bg_color',
				    'cust_name' => 'wp_rem_cs_section_bg_color[]',
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    //range
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_top'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_top_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_padding_top),
				    'id' => '',
				    'classes' => 'small',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_padding_top[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
                            
                            $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_top_mobile'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_top_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_padding_top_mobile),
				    'id' => '',
				    'classes' => 'small',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_padding_top_mobile[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_bot'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_bot_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_padding_bottom),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_padding_bottom[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
                            
                            $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_bot_mobile'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_padding_bot_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_padding_bottom_mobile),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_padding_bottom_mobile[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
                            
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_top'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_top_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_margin_top),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_margin_top[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
                            $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_top_mobile'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_top_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_margin_top_mobile),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_margin_top_mobile[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_bot'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_bot_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_margin_bottom),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_margin_bottom[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
                            $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_bot_mobile'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_margin_bot_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_margin_bottom_mobile),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_margin_bottom_mobile[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_border_top'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_border_top_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => absint($wp_rem_cs_section_border_top),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_border_top[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_border_bot'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_border_bot_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => absint($wp_rem_cs_section_border_bottom),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => 'wp_rem_cs_section_border_bottom[]',
				    'return' => true,
				    'required' => false,
				    'after' => '<span class="wp_rem_cs_form_px">(px)</span>',
				),
				'return' => true,
				'extra_atr' => '',
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_border_color'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_choose_border_color'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_border_color),
				    'cust_id' => '',
				    'classes' => 'bg_color',
				    'cust_name' => 'wp_rem_cs_section_border_color[]',
				    'return' => true,
				),
			    );

			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    $choose_id = '';
			    $wp_rem_cs_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_cus_id'),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_cus_id_hint'),
				'echo' => true,
				'field_params' => array(
				    'std' => esc_attr($wp_rem_cs_section_css_id),
				    'cust_id' => '',
				    'classes' => 'txtfield',
				    'cust_name' => 'wp_rem_cs_section_css_id[]',
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    ?>
	    		<div class="form-elements elementhiddenn">
                            <?php
                              /*$wp_rem_cs_var_opt_array = array(
							'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_bg_color' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_bg_color_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => '',
								'cust_id' => '',
								'classes' => 'bg_color',
								'cust_name' => 'wp_rem_cs_var_page_bg_color[]',
								'return' => true,
							),
						);

						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );*/
                                                ?>
	    		    <ul class="noborder">
	    			<li class="to-label">
	    			    <label><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_select_layout'); ?></label>
	    			</li>
	    			<li class="to-field">
	    			    <div class="meta-input">
	    				<div class="meta-input pattern">
	    				    <div class='radio-image-wrapper'>
						    <?php
						    $checked = '';

						    if ($wp_rem_cs_layout == "none") {
							$checked = "checked";
						    }
						    $wp_rem_cs_opt_array = array(
							'extra_atr' => 'onclick="show_sidebar(\'none\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
							'cust_name' => 'wp_rem_cs_layout[' . esc_attr($rand) . '][]',
							'cust_id' => 'radio_1' . esc_attr($randomno),
							'classes' => 'radio_wp_rem_sidebar',
							'std' => 'none',
						    );
						    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render($wp_rem_cs_opt_array);
						    ?>
	    					<label for="radio_1<?php echo esc_attr($randomno) ?>"> 
	    					    <span class="ss"> <img src="<?php echo wp_rem_cs_var_frame()->plugin_url() . 'assets/images/no_sidebar.png'; ?>"  alt="" />  </span>
	    					    <span  <?php
							if ($wp_rem_cs_layout == "none") {
							    echo "class='check-list'";
							}
							?> id="check-list"></span> 
	    					</label>
							<span class="title-theme"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_full_width'); ?></span>
	    				    </div>
	    				    <div class='radio-image-wrapper'>
						    <?php
						    $checked = '';
						    if ($wp_rem_cs_layout == "right") {
							$checked = "checked";
						    }
						    $wp_rem_cs_opt_array = array(
							'extra_atr' => 'onclick="show_sidebar(\'right\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
							'cust_name' => 'wp_rem_cs_layout[' . esc_attr($rand) . '][]',
							'cust_id' => 'radio_2' . esc_attr($randomno),
							'classes' => 'radio_wp_rem_sidebar',
							'std' => 'right',
						    );
						    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render($wp_rem_cs_opt_array);
						    ?>
	    					<label for="radio_2<?php echo esc_attr($randomno) ?>"> 
	    					    <span class="ss"><img src="<?php echo wp_rem_cs_var_frame()->plugin_url() . 'assets/images/sidebar_right.png'; ?>" alt="" /></span> 
	    					    <span <?php
							if ($wp_rem_cs_layout == "right") {
							    echo "class='check-list'";
							}
							?> id="check-list"></span> 
	    					</label>
							<span class="title-theme"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_sidebar_right'); ?></span>
	    				    </div>
	    				    <div class='radio-image-wrapper'>
						    <?php
						    $checked = '';
						    if ($wp_rem_cs_layout == "left") {
							$checked = "checked";
						    }
						    $wp_rem_cs_opt_array = array(
							'extra_atr' => 'onclick="show_sidebar(\'left\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
							'cust_name' => 'wp_rem_cs_layout[' . esc_attr($rand) . '][]',
							'cust_id' => 'radio_3' . esc_attr($randomno),
							'classes' => 'radio_wp_rem_sidebar',
							'std' => 'left',
						    );
						    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_radio_render($wp_rem_cs_opt_array);
						    ?>
	    					<label for="radio_3<?php echo esc_attr($randomno); ?>">
	    					    <span class="ss">
	    						<img src="<?php echo wp_rem_cs_var_frame()->plugin_url() . 'assets/images/sidebar_left.png'; ?>" alt="" /></span> <span <?php
							if ($wp_rem_cs_layout == "left") {
							    echo "class='check-list'";
							}
							?> id="check-list">
	    					    </span> 
	    					</label>
							<span class="title-theme"><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_sidebar_left'); ?></span>
	    				    </div>
							</div>
	    			    </div>
	    			</li>
	    		    </ul>
				<?php
				global $wpdb;
				$wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');
				$a_option = array();
				if (isset($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) && count($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) > 0) {
				    foreach ($wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] as $sidebar) {
					$a_option[sanitize_title($sidebar)] = esc_html($sidebar);
				    }
				}

				$display = 'none';
				if ($wp_rem_cs_layout == "left" || $wp_rem_cs_layout == "both_left" || $wp_rem_cs_layout == "small_left" || $wp_rem_cs_layout == "small_left_large_right" || $wp_rem_cs_layout == "large_left_small_right") {
				    $display = "block";
				}
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_left_sidebar'),
				    'desc' => '',
				    'classes' => 'meta-body',
				    'styles' => 'display:' . $display,
				    'extra_atr' => '',
				    'id' => esc_attr($randomno) . '_sidebar_left',
				    'hint_text' => '',
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_sidebar_left,
					'id' => '',
					'cust_name' => 'wp_rem_cs_sidebar_left[]',
					'classes' => 'dropdown chosen-select-no-single select-medium',
					'options' => $a_option,
					'return' => true,
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

				$display = 'none';
				if ($wp_rem_cs_layout == "right" || $wp_rem_cs_layout == "both_right" || $wp_rem_cs_layout == "small_right" || $wp_rem_cs_layout == "small_left_large_right" || $wp_rem_cs_layout == "large_left_small_right") {
				    $display = "block";
				}
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_right_sidebar'),
				    'desc' => '',
				    'classes' => 'meta-body',
				    'styles' => 'display:' . $display,
				    'extra_atr' => '',
				    'id' => esc_attr($randomno) . '_sidebar_right',
				    'hint_text' => '',
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_sidebar_right,
					'id' => '',
					'cust_name' => 'wp_rem_cs_sidebar_right[]',
					'classes' => 'dropdown chosen-select-no-single select-medium',
					'options' => $a_option,
					'return' => true,
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

				$display = 'none';
				if ($wp_rem_cs_layout == "both_right") {
				    $display = "block";
				}
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_second_right_sidebar'),
				    'desc' => '',
				    'classes' => 'meta-body',
				    'styles' => 'display:' . $display,
				    'extra_atr' => '',
				    'id' => esc_attr($randomno) . '_sidebar_right_second',
				    'hint_text' => '',
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_sidebar_right_second,
					'id' => '',
					'cust_name' => 'wp_rem_cs_sidebar_right_second[]',
					'classes' => 'dropdown chosen-select-no-single select-medium',
					'options' => $a_option,
					'return' => true,
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

				$display = 'none';
				if ($wp_rem_cs_layout == "both_left") {
				    $display = "block";
				}
				$wp_rem_cs_opt_array = array(
				    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_second_left_sidebar'),
				    'desc' => '',
				    'classes' => 'meta-body',
				    'styles' => 'display:' . $display,
				    'extra_atr' => '',
				    'id' => esc_attr($randomno) . '_sidebar_left_second',
				    'hint_text' => '',
				    'echo' => true,
				    'field_params' => array(
					'std' => $wp_rem_cs_sidebar_left_second,
					'id' => '',
					'cust_name' => 'wp_rem_cs_sidebar_left_second[]',
					'classes' => 'dropdown chosen-select-no-single select-medium',
					'options' => $a_option,
					'return' => true,
				    ),
				);
				$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
				?>
	    		</div>
			    <?php
			    $wp_rem_cs_opt_array = array(
				'name' => '',
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
				    'std' => 'Save',
				    'cust_id' => '',
				    'cust_type' => 'button',
				    'classes' => 'cs-admin-btn',
				    'cust_name' => '',
				    'extra_atr' => 'onclick="javascript:wp_rem_cs_frame_removeoverlay(\'' . esc_js($column_class . $randomno) . '\', \'filterdrag\')"',
				    'return' => true,
				),
			    );
			    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
			    ?>   
	    	    </div>
	    	</div>
	        </div>
		<?php
		$wp_rem_cs_opt_array = array(
		    'std' => esc_attr($rand),
		    'id' => '',
		    'before' => '',
		    'after' => '',
		    'classes' => '',
		    'extra_atr' => '',
		    'cust_id' => '',
		    'cust_name' => 'column_rand_id[]',
		    'required' => false
		);
		$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
		$wp_rem_cs_opt_array = array(
		    'std' => isset( $column_class ) ? esc_attr($column_class) : '',
		    'id' => '',
		    'before' => '',
		    'after' => '',
		    'classes' => '',
		    'extra_atr' => '',
		    'cust_id' => '',
		    'cust_name' => 'column_class[]',
		    'required' => false
		);
		$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
		$wp_rem_cs_opt_array = array(
		    'std' => esc_attr($total_column),
		    'id' => '',
		    'before' => '',
		    'after' => '',
		    'classes' => '',
		    'extra_atr' => '',
		    'cust_id' => '',
		    'cust_name' => 'total_column[]',
		    'required' => false
		);
		$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
		?>                   
	    </div>
	    <?php
	}
	if ($die <> 1) {
	    die();
	}
    }

    add_action('wp_ajax_wp_rem_cs_column_pb', 'wp_rem_cs_column_pb');
}

/**
 * Width sizes for Elements
 *
 */
if (!function_exists('wp_rem_cs_var_page_builder_element_sizes')) {

    function wp_rem_cs_var_page_builder_element_sizes($size = '100') {

	if (isset($size) && $size == '') {
	    $element_size = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
	} else {
	    $element_size_col = $size;
	}
	if (isset($element_size_col) and $element_size_col == '100' || $element_size_col > 75) {

	    $element_size = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
	} else if (isset($element_size_col) and $element_size_col == '75' || $element_size_col > 67) {

	    $element_size = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
	} else if (isset($element_size_col) and $element_size_col == '67' || $element_size_col > 50) {

	    $element_size = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
	} else if (isset($element_size_col) and $element_size_col == '50' || $element_size_col > 33) {

	    $element_size = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
	} else if (isset($element_size_col) and $element_size_col == '33' || $element_size_col > 25) {

	    $element_size = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
	} else if (isset($element_size_col) and $element_size_col == '25' || $element_size_col < 25) {

	    $element_size = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
	}

	return $element_size;
    }

}

/**
 * Shortcode Names for Elements
 *
 */
if (!function_exists('wp_rem_cs_shortcode_names')) {

    function wp_rem_cs_shortcode_names() {
	global $post, $wp_rem_cs_var_frame_static_text;
	$shortcode_array = array();
	$shortcode_array = apply_filters('wp_rem_cs_shortcode_names_list_populate', $shortcode_array);
	ksort($shortcode_array);
	return $shortcode_array;
    }

}
/**
 * List of the elements in Page Builder
 *
 */
if (!function_exists('wp_rem_cs_element_list')) {

    function wp_rem_cs_element_list() {
	global $wp_rem_cs_var_frame_static_text;
	$element_list = array(
	    'element_list' => array(),
	);
	$element_list['element_list'] = apply_filters('wp_rem_cs_element_list_populate', $element_list['element_list']);
	return $element_list;
    }

}

/**
 * Page builder Sorting List
 */
if (!function_exists('wp_rem_cs_elements_categories')) {

    function wp_rem_cs_elements_categories() {
	global $wp_rem_cs_var_frame_static_text;
	$strings = new wp_rem_cs_var_frame_all_strings;
	$wp_rem_cs_var_typography = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_typography');
	//$wp_rem_cs_var_common_elements = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_common_elements');
	//$wp_rem_cs_var_media_element = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_media_element');
	$wp_rem_cs_var_content_blocks = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_content_blocks');
	$wp_rem_cs_var_loops = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_loops');
	$wp_rem_cs_var_wpam = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_wpam');
	return array('typography' => $wp_rem_cs_var_typography, 'contentblocks' => $wp_rem_cs_var_content_blocks, 'loops' => $wp_rem_cs_var_loops);
    }

}

/*
 * Page builder Element (shortcode(s))
 */
if (!function_exists('wp_rem_cs_page_composer_elements')) {

    function wp_rem_cs_page_composer_elements($element = '', $icon = '', $description = '') {
	echo '<i class="' . $icon . '"></i><span data-title="' . esc_html($element) . '"> ' . esc_html($element) . '</span>';
    }

}

/**
 * Section element Size(s)
 *
 * @returm size
 */
if (!function_exists('wp_rem_cs_element_size_data_array_index')) {

    function wp_rem_cs_element_size_data_array_index($size) {
	if ($size == "" or $size == 100) {
	    return 0;
	} else if ($size == 75) {
	    return 1;
	} else if ($size == 67) {
	    return 2;
	} else if ($size == 50) {
	    return 3;
	} else if ($size == 33) {
	    return 4;
	} else if ($size == 25) {
	    return 5;
	}
    }

}

/**
 * Page Builder Elements Settings
 *
 */
if (!function_exists('wp_rem_cs_element_setting')) {

    function wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $element_size, $element_description = '', $page_element_icon = 'icon-star', $type = '') {
	global $wp_rem_cs_var_form_fields;
	$element_title = str_replace("wp_rem_cs_var_page_builder_", "", $name);
	$elm_name = str_replace("wp_rem_cs_var_page_builder_", "", $name);
	$element_list = wp_rem_cs_element_list();
	$all_shortcode_list = wp_rem_cs_shortcode_names();
	$current_shortcode_name = str_replace("wp_rem_cs_var_page_builder_", "", $name);
	$current_shortcode_detail = $all_shortcode_list[$current_shortcode_name];
	$shortcode_icon = isset($current_shortcode_detail['icon']) ? $current_shortcode_detail['icon'] : '';
	?>
	<div class="column-in">
	    <?php
	    $wp_rem_cs_opt_array = array(
		'std' => esc_attr($element_size),
		'id' => '',
		'before' => '',
		'after' => '',
		'classes' => 'item',
		'extra_atr' => '',
		'cust_id' => '',
		'cust_name' => esc_attr($element_title) . '_element_size[]',
		'required' => false
	    );
	    $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
	    ?>
	    <a href="javascript:;" onclick="javascript:wp_rem_cs_createpopshort(jQuery(this))" class="options"><i class="icon-cog3"></i></a>
	    <a href="#" class="delete-it btndeleteit"><i class="icon-trash-o"></i></a> &nbsp;
            <?php
               $no_size_elemnts = array();
               $no_size_elemnts = apply_filters( 'wp_rem_cs_shortcode_remove_sizes', $no_size_elemnts );
               if (!in_array( $current_shortcode_name, $no_size_elemnts ) )
                {
            ?>
	    <a class="decrement" onclick="javascript:wp_rem_cs_decrement(this)"><i class="icon-minus3"></i></a> &nbsp; 
	    <a class="increment" onclick="javascript:wp_rem_cs_increment(this)"><i class="icon-plus3"></i></a> 
                <?php } ?>
	    <span> 
		<i class="<?php echo $shortcode_icon . ' ' . str_replace("wp_rem_cs_var_page_builder_", "", $name); ?>-icon"></i> 
		<strong><?php
		    echo esc_html($element_list['element_list'][$elm_name]);
		    var_dump();
		    ?></strong><br/>
		<?php echo esc_attr($element_description); ?> 
	    </span>
	</div>
	<?php
    }

}

/**
 * Sizes for Shortcodes elements
 *
 */
if (!function_exists('wp_rem_cs_shortcode_element_size')) {

    function wp_rem_cs_shortcode_element_size($column_size = '') {
	global $wp_rem_cs_var_html_fields, $wp_rem_cs_var_frame_static_text;
	$wp_rem_cs_opt_array = array(
	    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_size'),
	    'desc' => '',
	    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_column_hint'),
	    'echo' => true,
	    'field_params' => array(
		'std' => $column_size,
		'cust_id' => 'column_size',
		'cust_type' => 'button',
		'classes' => 'column_size  dropdown chosen-select-no-single select-medium',
		'cust_name' => 'wp_rem_cs_var_column_size[]',
		'extra_atr' => '',
		'options' => array(
		    '1/1' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_full_width'),
		    '1/2' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_one_half'),
		    '1/3' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_one_third'),
		    '2/3' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_two_third'),
		    '1/4' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_one_fourth'),
		    '3/4' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_three_fourth'),
		),
		'return' => true,
	    ),
	);
	$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
    }

}

/**
 * Adding Shortcode
 *
 */
if (!function_exists('wp_rem_cs_var_short_code')) {

    function wp_rem_cs_var_short_code($name = '', $function = '') {
	if ($name != '' && $function != '') {

	    add_shortcode($name, $function);
	}
    }

}

/**
 * Element Ajax Settings
 * @Size
 * @Remove
 *
 */
if (!function_exists('wp_rem_cs_ajax_element_setting')) {

    function wp_rem_cs_ajax_element_setting($name, $wp_rem_cs_counter, $element_size, $shortcode_element_id, $wp_rem_cs_POSTID, $element_description = '', $page_element_icon = '', $type = '') {
	global $wp_rem_cs_node, $post;
        $sc_name        = wp_rem_shortcode_name( $wp_rem_cs_node );
	$element_title = str_replace("wp_rem_cs_var_page_builder_", "", $name);
	$all_shortcode_list = wp_rem_cs_shortcode_names();
	$current_shortcode_name = str_replace("wp_rem_cs_var_page_builder_", "", $name);
	$current_shortcode_detail = isset($all_shortcode_list[$current_shortcode_name]) ? $all_shortcode_list[$current_shortcode_name] : '';
	$shortcode_icon = isset($current_shortcode_detail['icon']) ? $current_shortcode_detail['icon'] : '';
	?>
	<div class="column-in">
	    <input type="hidden" name="<?php echo esc_attr($element_title); ?>_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >

	    <a href="javascript:;" onclick="javascript:ajax_shortcode_widget_element(jQuery(this), '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($wp_rem_cs_POSTID); ?>', '<?php echo esc_js($name); ?>')" class="options"><i class="icon-cog3"></i></a><a href="#" class="delete-it btndeleteit"><i class="icon-trash-o"></i></a> &nbsp; 
            <?php
               $no_size_elemnts = array();
               $no_size_elemnts = apply_filters( 'wp_rem_cs_shortcode_remove_sizes', $no_size_elemnts );
               if (!in_array( $sc_name, $no_size_elemnts ) )
                {
            ?>
            <a class="decrement" onclick="javascript:wp_rem_cs_decrement(this)"><i class="icon-minus3"></i></a> &nbsp; <a class="increment" onclick="javascript:wp_rem_cs_increment(this)"><i class="icon-plus3"></i></a> 
            <?php } ?>
	    <span> 
		<i class="<?php echo $shortcode_icon . ' ' . str_replace("wp_rem_cs_var_page_builder_", "", $name); ?>-icon"></i> 
		<strong>
		    <?php
		    if ($sc_name == 'page_element') {
				$element_name = $sc_name;
				$element_name = str_replace("cs-", "", $element_name);
		    } else {
				$element_name = $sc_name;
				$element_name = isset($all_shortcode_list[$element_name]['title']) ? $all_shortcode_list[$element_name]['title'] : '';
		    }
		    echo str_replace('_', ' ', $element_name);
		    ?>
		</strong><br/>
		<?php echo esc_attr($element_description); ?> 
	    </span>
	</div>
	<?php
    }

}

/**
 * Page Builder ELements all Categories
 *
 */
if (!function_exists('wp_rem_cs_show_all_cats')) {

    function wp_rem_cs_show_all_cats($parent, $separator, $selected = "", $taxonomy, $optional = '') {
		global $wp_rem_cs_var_frame_static_text;
		if ($parent == "") {
			global $wpdb;
			$parent = 0;
		} else
			$separator .= " &ndash; ";
		$args = array(
			'parent' => $parent,
			'hide_empty' => 0,
			'taxonomy' => $taxonomy
		);
		$categories = get_categories($args);
		if ($optional) {
			$a_options = array();
			//$a_options[''] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_plz_select');
			foreach ($categories as $category) {
			$a_options[$category->slug] = $category->cat_name;
			}
			return $a_options;
		} else {
			foreach ($categories as $category) {
			?>
			<option <?php
			if ($selected == $category->slug) {
				echo "selected";
			}
			?> value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($separator . $category->cat_name); ?></option>
			<?php
			wp_rem_cs_show_all_cats($category->term_id, $separator, $selected, $taxonomy);
			}
		}
    }

}
/**
 * Bootstrap Coloumn Class
 *
 * @returm Coloumn
 */
if (!function_exists('wp_rem_cs_var_custom_column_class')) {

    function wp_rem_cs_var_custom_column_class($column_size) {
	$coloumn_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
	if (isset($column_size) && $column_size <> '') {
	    list($top, $bottom) = explode('/', $column_size);
	    $width = $top / $bottom * 100;
	    $width = (int) $width;
	    $coloumn_class = '';
	    if (round($width) == '25' || round($width) < 25) {
		$coloumn_class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
	    } elseif (round($width) == '33' || (round($width) < 33 && round($width) > 25)) {
		$coloumn_class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
	    } elseif (round($width) == '50' || (round($width) < 50 && round($width) > 33)) {
		$coloumn_class = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
	    } elseif (round($width) == '67' || (round($width) < 67 && round($width) > 50)) {
		$coloumn_class = 'col-lg-8 col-md-12 col-sm-12 col-xs-12';
	    } elseif (round($width) == '75' || (round($width) < 75 && round($width) > 67)) {
		$coloumn_class = 'col-md-9 col-lg-9 col-sm-12 col-xs-12';
	    } else {
		$coloumn_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
	    }
	}
	return esc_html($coloumn_class);
    }

}

/**
 * Page Builder Element Data on Ajax Call
 *
 */
if (!function_exists('wp_rem_cs_shortcode_element_ajax_call')) {

    function wp_rem_cs_shortcode_element_ajax_call() {
	global $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;

	if (isset($_POST['shortcode_element'])) {
	    $args = array(
		'type' => $_POST['shortcode_element'],
		'html_fields' => $wp_rem_cs_var_html_fields,
	    );
	    do_action('wp_rem_cs_shortcode_sub_element_ui', $args);
	}
	wp_die();
    }

    add_action('wp_ajax_wp_rem_cs_shortcode_element_ajax_call', 'wp_rem_cs_shortcode_element_ajax_call');
}

if (!function_exists('wp_rem_cs_custom_shortcode_encode')) {

    function wp_rem_cs_custom_shortcode_encode($sh_content = '') {
	$sh_content = str_replace(array('[', ']'), array('wp_rem_cs_open', 'wp_rem_cs_close'), $sh_content);
	return $sh_content;
    }

}

if (!function_exists('wp_rem_cs_blog_slider_image_sizes')) {

    function wp_rem_cs_blog_slider_image_sizes() {
	//home 2 sizes
	add_image_size('wp_rem_cs_media_11', 800, 470, true);  //Small Thumbs
	add_image_size('wp_rem_cs_media_12', 400, 470, true); //latest movies
	add_image_size('wp_rem_cs_media_13', 400, 235, true);   //Latest Stories Unique
	add_image_size('wp_rem_cs_media_14', 960, 370, true);   //Blog detail large image size for slider
        add_image_size('wp_rem_cs_media_15', 496, 212, true);   //blog Featured post in gird
    }

}
if (!function_exists('wp_rem_shortcode_name')) {
    function wp_rem_shortcode_name( $shortcode ){
        $matches    = array();
        $pattern    = get_shortcode_regex();
        preg_match_all("/$pattern/s",$shortcode,$matches);
        $shortcode_data = str_replace('wp_rem_cs_', '', $matches[2][0]);
        $shortcode_data = str_replace( 'column', 'flex_column', $shortcode_data );
        $shortcode_data = str_replace( 'progressbar', 'progressbars', $shortcode_data );
        return $shortcode_data;
    }
}

if (!function_exists('wp_rem_element_size')) {
    function wp_rem_element_size( $shortcode ){
        $matches    = array();
        $pattern = get_shortcode_regex();
        $shortcode_atts  = shortcode_parse_atts( $shortcode );
        preg_match_all("/$pattern/s",$shortcode,$matches);
        $shortcode_data = str_replace('wp_rem_cs_', '', $matches[2][0]);
        $shortcode_data = str_replace( 'column', 'flex_column', $shortcode_data );
        $shortcode_data = str_replace( 'progressbar', 'progressbars', $shortcode_data );
        $shortcode_data = $shortcode_atts[$shortcode_data.'_element_size'];
        preg_match_all('!\d+!', $shortcode_data, $number);
        return $number[0][0];
    }
}