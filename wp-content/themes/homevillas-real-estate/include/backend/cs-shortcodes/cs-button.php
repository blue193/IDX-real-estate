<?php
/*
 *
 * @File : Button
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_button') ) {

	function wp_rem_cs_var_page_builder_button($die = 0) {
		global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

		if ( function_exists('wp_rem_cs_shortcode_names') ) {
			$shortcode_element = '';
			$filter_element = 'filterdrag';
			$shortcode_view = '';
			$wp_rem_cs_output = array();
			$PREFIX = 'wp_rem_cs_button';
			$wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
			if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
				$POSTID = '';
				$shortcode_element_id = '';
			} else {
				$POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
				$shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
				$shortcode_str = stripslashes($shortcode_element_id);
				$parseObject = new ShortcodeParse();
				$wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes($wp_rem_cs_output, $shortcode_str, true, $PREFIX);
			}
			$defaults = array(
				'wp_rem_cs_var_column' => '1',
				'wp_rem_cs_var_button_text' => '',
				'wp_rem_cs_var_button_link' => '',
				'wp_rem_cs_var_button_border' => '',
				'wp_rem_cs_var_button_type' => '',
				'wp_rem_cs_var_button_target' => '',
				'wp_rem_cs_var_button_border_color' => '',
				'wp_rem_cs_var_button_color' => '',
				'wp_rem_cs_var_button_bg_color' => '',
				'wp_rem_cs_var_button_align' => '',
				'wp_rem_cs_button_icon' => '',
				'wp_rem_cs_button_icon_group' => 'default',
				'wp_rem_cs_var_button_size' => '',
				'wp_rem_cs_var_icon_view' => '',
				'wp_rem_cs_var_button_alignment' => ''
			);
			if ( isset($wp_rem_cs_output['0']['atts']) ) {
				$atts = $wp_rem_cs_output['0']['atts'];
			} else {
				$atts = array();
			}
			if ( isset($wp_rem_cs_output['0']['content']) ) {
				$button_column_text = $wp_rem_cs_output['0']['content'];
			} else {
				$button_column_text = '';
			}
			$button_element_size = '33';
			foreach ( $defaults as $key => $values ) {
				if ( isset($atts[$key]) ) {
					$$key = $atts[$key];
				} else {
					$$key = $values;
				}
			}
			$name = 'wp_rem_cs_var_page_builder_button';
			$coloumn_class = 'column_' . $button_element_size;
			$wp_rem_cs_var_button_alignment = isset($wp_rem_cs_var_button_alignment) ? $wp_rem_cs_var_button_alignment : '';
			$wp_rem_cs_var_button_text = isset($wp_rem_cs_var_button_text) ? $wp_rem_cs_var_button_text : '';
			$wp_rem_cs_var_button_link = isset($wp_rem_cs_var_button_link) ? $wp_rem_cs_var_button_link : '';
			$wp_rem_cs_var_button_border = isset($wp_rem_cs_var_button_border) ? $wp_rem_cs_var_button_border : '';
			$wp_rem_cs_var_button_type = isset($wp_rem_cs_var_button_type) ? $wp_rem_cs_var_button_type : '';
			$wp_rem_cs_var_button_target = isset($wp_rem_cs_var_button_target) ? $wp_rem_cs_var_button_target : '';
			$wp_rem_cs_var_button_border_color = isset($wp_rem_cs_var_button_border_color) ? $wp_rem_cs_var_button_border_color : '';
			$wp_rem_cs_var_button_color = isset($wp_rem_cs_var_button_color) ? $wp_rem_cs_var_button_color : '';
			$wp_rem_cs_var_button_bg_color = isset($wp_rem_cs_var_button_bg_color) ? $wp_rem_cs_var_button_bg_color : '';
			$wp_rem_cs_var_button_align = isset($wp_rem_cs_var_button_align) ? $wp_rem_cs_var_button_align : '';
			$wp_rem_cs_button_icon = isset($wp_rem_cs_button_icon) ? $wp_rem_cs_button_icon : '';
			$wp_rem_cs_button_icon_group = isset($wp_rem_cs_button_icon_group) ? $wp_rem_cs_button_icon_group : 'default';
			$wp_rem_cs_var_button_size = isset($wp_rem_cs_var_button_size) ? $wp_rem_cs_var_button_size : '';
			$wp_rem_cs_var_icon_view = isset($wp_rem_cs_var_icon_view) ? $wp_rem_cs_var_icon_view : '';
			if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
				$shortcode_element = 'shortcode_element_class';
				$shortcode_view = 'cs-pbwp-shortcode';
				$filter_element = 'ajax-drag';
				$coloumn_class = '';
			}
			$strings = new wp_rem_cs_theme_all_strings;
			$strings->wp_rem_cs_short_code_strings();
			?>
			<div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
				 <?php echo esc_attr($shortcode_view); ?>" item="button" data="<?php echo wp_rem_cs_element_size_data_array_index($button_element_size) ?>" >
					 <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $button_element_size) ?>
				<div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
					 <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_button {{attributes}}]{{content}}[/wp_rem_cs_button]" style="display: none;">
					<div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
						<h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_edit_text')); ?></h5>
						<a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
							<i class="icon-cross"></i>
						</a>
					</div>
					<div class="cs-pbwp-content">
						<div class="cs-wrapp-clone cs-shortcode-wrapp">
							<?php
							if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
								wp_rem_cs_shortcode_element_size();
							}
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_text'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_text_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr($wp_rem_cs_var_button_text),
									'cust_id' => 'wp_rem_cs_var_button_text' . $wp_rem_cs_counter,
									'classes' => '',
									'cust_name' => 'wp_rem_cs_var_button_text[]',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_url'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_url_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr($wp_rem_cs_var_button_link),
									'cust_id' => 'wp_rem_cs_var_button_link' . $wp_rem_cs_counter,
									'classes' => '',
									'cust_name' => 'wp_rem_cs_var_button_link[]',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_border'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_border_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_button_border,
									'id' => '',
									'cust_name' => 'wp_rem_cs_var_button_border[]',
									'classes' => 'dropdown chosen-select',
									'options' => array(
										'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
										'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
									),
									'return' => true,
								),
							);
							$wp_rem_cs_opt_array = array(
								'name' => 'Button Align',
								'desc' => '',
								'hint_text' => 'Select the button alignment',
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_button_alignment,
									'id' => '',
									'cust_name' => 'wp_rem_cs_var_button_alignment[]',
									'classes' => 'dropdown chosen-select',
									'options' => array(
										'left' => 'Left',
										'right' => 'Right',
										'center' => 'Center'
									),
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_border_color'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_border_color_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr($wp_rem_cs_var_button_border_color),
									'cust_id' => 'wp_rem_cs_var_button_border_color' . $wp_rem_cs_counter,
									'classes' => 'bg_color',
									'cust_name' => 'wp_rem_cs_var_button_border_color[]',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_bg_color'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_bg_color_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr($wp_rem_cs_var_button_bg_color),
									'cust_id' => 'wp_rem_cs_var_button_bg_color' . $wp_rem_cs_counter,
									'classes' => 'bg_color',
									'cust_name' => 'wp_rem_cs_var_button_bg_color[]',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_color'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_color_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr($wp_rem_cs_var_button_color),
									'cust_id' => 'wp_rem_cs_var_button_color' . $wp_rem_cs_counter,
									'classes' => 'bg_color',
									'cust_name' => 'wp_rem_cs_var_button_color[]',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_size'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_size_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_button_size,
									'id' => '',
									'cust_name' => 'wp_rem_cs_var_button_size[]',
									'classes' => 'dropdown chosen-select',
									'options' => array(
										'btn-lg' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_large'),
										'medium-btn' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_medium'),
										'btn-sml' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_small'),
									),
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_icon_on_off'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_icon_on_off_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_icon_view,
									'id' => '',
									'cust_id' => 'wp_rem_cs_var_icon_view',
									'cust_name' => 'wp_rem_cs_var_icon_view[]',
									'classes' => 'dropdown chosen-select-no-single select-medium',
									'options' => array(
										'on' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
										'off' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
									),
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
							?>
							<style type="text/css">
								.icon_fields{ display: <?php echo esc_html($wp_rem_cs_var_icon_view == 'off' ? 'none' : 'block' ) ?>; }
							</style>
							<script>
			                    $(function () {
			                        $('#wp_rem_cs_var_icon_view').change(function () {
			                            var getValue = $("#wp_rem_cs_var_icon_view option:selected").val();
			                            if (getValue == 'on') {
			                                $('.icon_fields').css('display', 'block');
			                            } else {
			                                $('.icon_fields').css('display', 'none');
			                            }
			                        });
			                    });

							</script>
							<div class="icon_fields">
								<div class="form-elements" id="wp_rem_cs_button_<?php echo esc_attr($wp_rem_cs_counter); ?>">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_icon')); ?></label>
										<?php
										if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
											echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_icon_hint'));
										}
										?>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<?php //echo wp_rem_cs_var_icomoon_icons_box(esc_html($wp_rem_cs_button_icon), esc_attr($wp_rem_cs_counter), 'wp_rem_cs_button_icon'); ?>
                                                                            <?php echo apply_filters( 'cs_icons_fields', esc_html($wp_rem_cs_button_icon), esc_attr($wp_rem_cs_counter), 'wp_rem_cs_button_icon', $wp_rem_cs_button_icon_group ); ?>
									</div>
								</div>
								<?php
								$wp_rem_cs_opt_array = array(
									'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_alignment'),
									'desc' => '',
									'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_alignment_hint'),
									'echo' => true,
									'field_params' => array(
										'std' => $wp_rem_cs_var_button_align,
										'id' => '',
										'cust_name' => 'wp_rem_cs_var_button_align[]',
										'classes' => 'dropdown chosen-select',
										'options' => array(
											'left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_alignment_left'),
											'right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_alignment_right'),
										),
										'return' => true,
									),
								);
								$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
								?>
							</div>
							<?php
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_type'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_type_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_button_type,
									'id' => '',
									'cust_name' => 'wp_rem_cs_var_button_type[]',
									'classes' => 'dropdown chosen-select',
									'options' => array(
										'square' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_type_square'),
										'rounded' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_button_type_rounded'),
									),
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_target'),
								'desc' => '',
								'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_target_hint'),
								'echo' => true,
								'field_params' => array(
									'std' => $wp_rem_cs_var_button_target,
									'id' => '',
									'cust_name' => 'wp_rem_cs_var_button_target[]',
									'classes' => 'dropdown chosen-select',
									'options' => array(
										'_self' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_target_blank'),
										'_blank' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_sc_target_self'),
									),
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
							?>
						</div>
						<?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
							<ul class="form-elements insert-bg">
								<li class="to-field">
									<a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
								</li>
							</ul>
							<div id="results-shortocde"></div>
							<?php
						} else {
							$wp_rem_cs_opt_array = array(
								'std' => 'button',
								'id' => '',
								'before' => '',
								'after' => '',
								'classes' => '',
								'extra_atr' => '',
								'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
								'cust_name' => 'wp_rem_cs_orderby[]',
								'required' => false
							);
							$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
							$wp_rem_cs_opt_array = array(
								'name' => '',
								'desc' => '',
								'hint_text' => '',
								'echo' => true,
								'field_params' => array(
									'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
									'cust_id' => 'button_save' . $wp_rem_cs_counter,
									'cust_type' => 'button',
									'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
									'classes' => 'cs-wp_rem_cs-admin-btn',
									'cust_name' => 'button_save',
									'return' => true,
								),
							);
							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		if ( $die <> 1 ) {
			die();
		}
	}

	add_action('wp_ajax_wp_rem_cs_var_page_builder_button', 'wp_rem_cs_var_page_builder_button');
}
if ( ! function_exists('wp_rem_cs_save_page_builder_data_button_callback') ) {

	/**
	 * Save data for button shortcode.
	 *
	 * @param	array $args
	 * @return	array
	 */
	function wp_rem_cs_save_page_builder_data_button_callback($args) {
		$data = $args['data'];
		$counters = $args['counters'];
		$widget_type = $args['widget_type'];
		$column = $args['column'];
                $shortcode_data = '';
		if ( $widget_type == "button" || $widget_type == "cs_button" ) {
			$wp_rem_cs_var_button = '';
			$page_element_size = $data['button_element_size'][$counters['wp_rem_cs_global_counter_button']];
			$button_element_size = $data['button_element_size'][$counters['wp_rem_cs_global_counter_button']];

			if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
				$shortcode_str = stripslashes(( $data['shortcode']['button'][$counters['wp_rem_cs_shortcode_counter_button']]));
				$element_settings = 'button_element_size="' . $button_element_size . '"';
				$reg = '/button_element_size="(\d+)"/s';
				$shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
				$shortcode_data = $shortcode_str;

				$counters['wp_rem_cs_shortcode_counter_button'] ++;
			} else {
				$wp_rem_cs_var_button = '[wp_rem_cs_button button_element_size="' . htmlspecialchars($data['button_element_size'][$counters['wp_rem_cs_global_counter_button']]) . '" ';
				if ( isset($data['wp_rem_cs_var_button_text'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_text'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_text="' . htmlspecialchars($data['wp_rem_cs_var_button_text'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_alignment'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_alignment'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_alignment="' . htmlspecialchars($data['wp_rem_cs_var_button_alignment'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_link'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_link'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_link="' . htmlspecialchars($data['wp_rem_cs_var_button_link'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_size'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_size'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_size="' . htmlspecialchars($data['wp_rem_cs_var_button_size'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_button_icon'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_button_icon'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_button_icon="' . htmlspecialchars($data['wp_rem_cs_button_icon'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
                                if ( isset($data['wp_rem_cs_button_icon_group'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_button_icon_group'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_button_icon_group="' . htmlspecialchars($data['wp_rem_cs_button_icon_group'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_icon_view'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_icon_view'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_icon_view="' . htmlspecialchars($data['wp_rem_cs_var_icon_view'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_border'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_border'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_border="' . htmlspecialchars($data['wp_rem_cs_var_button_border'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_type'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_type'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_type="' . htmlspecialchars($data['wp_rem_cs_var_button_type'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_align'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_align'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_align="' . htmlspecialchars($data['wp_rem_cs_var_button_align'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_target'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_target'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_target="' . htmlspecialchars($data['wp_rem_cs_var_button_target'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_border_color="' . htmlspecialchars($data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_color'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_color'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_color="' . htmlspecialchars($data['wp_rem_cs_var_button_color'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				if ( isset($data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_button']]) && $data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= 'wp_rem_cs_var_button_bg_color="' . htmlspecialchars($data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . '" ';
				}
				$wp_rem_cs_var_button .= ']';
				if ( isset($data['button_text'][$counters['wp_rem_cs_counter_button']]) && $data['button_text'][$counters['wp_rem_cs_counter_button']] != '' ) {
					$wp_rem_cs_var_button .= htmlspecialchars($data['button_text'][$counters['wp_rem_cs_counter_button']], ENT_QUOTES) . ' ';
				}
				$wp_rem_cs_var_button .= '[/wp_rem_cs_button]';
				$shortcode_data .= $wp_rem_cs_var_button;

				$counters['wp_rem_cs_counter_button'] ++;
			}
			$counters['wp_rem_cs_global_counter_button'] ++;
		}
		return array(
			'data' => $data,
			'counters' => $counters,
			'widget_type' => $widget_type,
			'column' => $shortcode_data,
		);
	}

	add_filter('wp_rem_cs_save_page_builder_data_button', 'wp_rem_cs_save_page_builder_data_button_callback');
}
if ( ! function_exists('wp_rem_cs_load_shortcode_counters_button_callback') ) {

	/**
	 * Populate button shortcode counter variables.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_load_shortcode_counters_button_callback($counters) {
		$counters['wp_rem_cs_global_counter_button'] = 0;
		$counters['wp_rem_cs_shortcode_counter_button'] = 0;
		$counters['wp_rem_cs_counter_button'] = 0;
		return $counters;
	}

	add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_button_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_button_callback') ) {

	/**
	 * Populate button shortcode names list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_shortcode_names_list_populate_button_callback($shortcode_array) {
		$shortcode_array['button'] = array(
			'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_button'),
			'name' => 'button',
			'icon' => 'icon-support',
			'categories' => 'typography',
		);
		return $shortcode_array;
	}

	add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_button_callback');
}
if ( ! function_exists('wp_rem_cs_element_list_populate_button_callback') ) {

	/**
	 * Populate button shortcode strings list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_element_list_populate_button_callback($element_list) {
		$element_list['button'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_button');
		return $element_list;
	}

	add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_button_callback');
}