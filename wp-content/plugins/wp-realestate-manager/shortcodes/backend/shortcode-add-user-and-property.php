<?php
/**
 * Shortcode Name : wp_rem_register_user_and_add_property
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists( 'wp_rem_cs_var_page_builder_wp_rem_register_user_and_add_property' ) ) {

	function wp_rem_cs_var_page_builder_wp_rem_register_user_and_add_property( $die = 0 ) {
		global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
		if ( function_exists( 'wp_rem_cs_shortcode_names' ) ) {
			$shortcode_element = '';
			$filter_element = 'filterdrag';
			$shortcode_view = '';
			$wp_rem_cs_output = array();
			$wp_rem_cs_PREFIX = 'wp_rem_register_user_and_add_property';

			$wp_rem_cs_counter = isset( $_POST['counter'] ) ? $_POST['counter'] : '';
			if ( isset( $_POST['action'] ) && ! isset( $_POST['shortcode_element_id'] ) ) {
				$wp_rem_cs_POSTID = '';
				$shortcode_element_id = '';
			} else {
				$wp_rem_cs_POSTID = isset( $_POST['POSTID'] ) ? $_POST['POSTID'] : '';
				$shortcode_element_id = isset( $_POST['shortcode_element_id'] ) ? $_POST['shortcode_element_id'] : '';
				$shortcode_str = stripslashes( $shortcode_element_id );
				$parseObject = new ShortcodeParse();
				$wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes( $wp_rem_cs_output, $shortcode_str, true, $wp_rem_cs_PREFIX );
			}
			$defaults = array(
				'property_title' => '',
				'property_subtitle' => '',
				'property_title_alignment' => '',
				'wp_rem_element_logo' => '',
			);
			if ( isset( $wp_rem_cs_output['0']['atts'] ) ) {
				$atts = $wp_rem_cs_output['0']['atts'];
			} else {
				$atts = array();
			}
			if ( isset( $wp_rem_cs_output['0']['content'] ) ) {
				$wp_rem_register_user_and_add_property_column_text = $wp_rem_cs_output['0']['content'];
			} else {
				$wp_rem_register_user_and_add_property_column_text = '';
			}
			$wp_rem_register_user_and_add_property_element_size = '100';
			foreach ( $defaults as $key => $values ) {
				if ( isset( $atts[$key] ) ) {
					$$key = $atts[$key];
				} else {
					$$key = $values;
				}
			}
			$name = 'wp_rem_cs_var_page_builder_wp_rem_register_user_and_add_property';
			$coloumn_class = 'column_' . $wp_rem_register_user_and_add_property_element_size;
			if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
				$shortcode_element = 'shortcode_element_class';
				$shortcode_view = 'cs-pbwp-shortcode';
				$filter_element = 'ajax-drag';
				$coloumn_class = '';
			}
			wp_rem_cs_var_date_picker();
			$property_title = isset( $atts['property_title'] ) ? $atts['property_title'] : '';
			$wp_rem_image_url = isset( $atts['register_user_and_add_property_url'] ) ? $atts['register_user_and_add_property_url'] : '';
			$wp_rem_text_color = isset( $atts['text_color'] ) ? $atts['text_color'] : '';
			$wp_rem_bg_color = isset( $atts['bg_color'] ) ? $atts['bg_color'] : '';
			$wp_rem_element_logo = isset( $atts['wp_rem_element_logo'] ) ? $atts['wp_rem_element_logo'] : '';
			?>
			<div id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?>
				 <?php echo esc_attr( $shortcode_view ); ?>" item="wp_rem_register_user_and_add_property" data="<?php echo wp_rem_cs_element_size_data_array_index( $wp_rem_register_user_and_add_property_element_size ) ?>" >
					 <?php wp_rem_cs_element_setting( $name, $wp_rem_cs_counter, $wp_rem_register_user_and_add_property_element_size ) ?>
				<div class="cs-wrapp-class-<?php echo intval( $wp_rem_cs_counter ) ?>
					 <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>" data-shortcode-template="[wp_rem_register_user_and_add_property {{attributes}}]{{content}}[/wp_rem_register_user_and_add_property]" style="display: none;">
					<div class="cs-heading-area" data-counter="<?php echo esc_attr( $wp_rem_cs_counter ) ?>">
						<h5><?php echo wp_rem_plugin_text_srt( 'wp_rem_register_user_and_property_options' ); ?></h5>
						<a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>','<?php echo esc_js( $filter_element ); ?>')" class="cs-btnclose">
							<i class="icon-cross"></i>
						</a>
					</div>
					<div class="cs-pbwp-content">
						<div class="cs-wrapp-clone cs-shortcode-wrapp">
							<?php
							if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
								wp_rem_cs_shortcode_element_size();
							}

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_element_sub_title' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_element_sub_title_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => $property_subtitle,
									'id' => 'property_subtitle',
									'cust_name' => 'property_subtitle[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_title_align' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_title_align_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $property_title_alignment ),
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'property_title_alignment[]',
									'return' => true,
									'options' => array(
										'align-left' => wp_rem_plugin_text_srt( 'wp_rem_align_left' ),
										'align-right' => wp_rem_plugin_text_srt( 'wp_rem_align_right' ),
										'align-center' => wp_rem_plugin_text_srt( 'wp_rem_align_center' ),
									),
								),
							);

							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_property_posted_logo' ),
								'std' => $wp_rem_element_logo,
								'desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => '',
									'cust_id' => '',
									'cust_name' => 'wp_rem_element_logo[]',
									'return' => true,
								),
							);
							$wp_rem_html_fields->wp_rem_upload_file_field( $wp_rem_opt_array );
							?>
						</div>
						<?php if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
							<ul class="form-elements insert-bg">
								<li class="to-field">
									<a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace( 'wp_rem_cs_var_page_builder_', '', $name ); ?>', '<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>', '<?php echo esc_js( $filter_element ); ?>')" ><?php echo wp_rem_plugin_text_srt( 'wp_rem_insert' ); ?></a>
								</li>
							</ul>
							<div id="results-shortocde"></div>
						<?php } else { ?>

							<?php
							$wp_rem_cs_opt_array = array(
								'std' => 'wp_rem_register_user_and_add_property',
								'id' => '',
								'before' => '',
								'after' => '',
								'classes' => '',
								'extra_atr' => '',
								'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
								'cust_name' => 'wp_rem_cs_orderby[]',
								'required' => false
							);
							$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );

							$wp_rem_cs_opt_array = array(
								'name' => '',
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_save' ),
									'cust_id' => 'wp_rem_register_user_and_add_property_save',
									'cust_type' => 'button',
									'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
									'classes' => 'cs-wp_rem_cs-admin-btn',
									'cust_name' => 'wp_rem_register_user_and_add_property_save',
									'return' => true,
								),
							);

							$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
						}
						?>
					</div>
				</div>
				<script type="text/javascript">
			        popup_over();

				</script>
			</div>

			<?php
		}
		if ( $die <> 1 ) {
			die();
		}
	}

	add_action( 'wp_ajax_wp_rem_cs_var_page_builder_wp_rem_register_user_and_add_property', 'wp_rem_cs_var_page_builder_wp_rem_register_user_and_add_property' );
}

if ( ! function_exists( 'wp_rem_cs_save_page_builder_data_wp_rem_register_user_and_add_property_callback' ) ) {

	/**
	 * Save data for wp_rem_register_user_and_add_property shortcode.
	 *
	 * @param	array $args
	 * @return	array
	 */
	function wp_rem_cs_save_page_builder_data_wp_rem_register_user_and_add_property_callback( $args ) {

		$data = $args['data'];
		$counters = $args['counters'];
		$widget_type = $args['widget_type'];
		$column = $args['column'];
                $shortcode_data = '';
		if ( $widget_type == "wp_rem_register_user_and_add_property" || $widget_type == "cs_wp_rem_register_user_and_add_property" ) {
			$wp_rem_cs_bareber_wp_rem_register_user_and_add_property = '';

			$page_element_size = $data['wp_rem_register_user_and_add_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_register_user_and_add_property']];
			$current_element_size = $data['wp_rem_register_user_and_add_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_register_user_and_add_property']];

			if ( isset( $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] ) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
				$shortcode_str = stripslashes( ( $data['shortcode']['wp_rem_register_user_and_add_property'][$counters['wp_rem_cs_shortcode_counter_wp_rem_register_user_and_add_property']] ) );

				$element_settings = 'wp_rem_register_user_and_add_property_element_size="' . $current_element_size . '"';
				$reg = '/wp_rem_register_user_and_add_property_element_size="(\d+)"/s';
				$shortcode_str = preg_replace( $reg, $element_settings, $shortcode_str );
				$shortcode_data = $shortcode_str;

				$wp_rem_cs_bareber_wp_rem_register_user_and_add_property ++;
			} else {
				$element_settings = 'wp_rem_register_user_and_add_property_element_size="' . htmlspecialchars( $data['wp_rem_register_user_and_add_property_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_register_user_and_add_property']] ) . '"';
				$wp_rem_cs_bareber_wp_rem_register_user_and_add_property = '[wp_rem_register_user_and_add_property ' . $element_settings . ' ';
				if ( isset( $data['property_title'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] ) && $data['property_title'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= 'property_title="' . htmlspecialchars( $data['property_title'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['wp_rem_element_logo'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] ) && $data['wp_rem_element_logo'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= 'wp_rem_element_logo="' . htmlspecialchars( $data['wp_rem_element_logo'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_subtitle'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] ) && $data['property_subtitle'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= 'property_subtitle="' . htmlspecialchars( $data['property_subtitle'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] ) && $data['property_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= 'property_title_alignment="' . htmlspecialchars( $data['property_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']], ENT_QUOTES ) . '" ';
				}
				$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= ']';
				if ( isset( $data['wp_rem_register_user_and_add_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] ) && $data['wp_rem_register_user_and_add_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= htmlspecialchars( $data['wp_rem_register_user_and_add_property_column_text'][$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property']], ENT_QUOTES ) . ' ';
				}
				$wp_rem_cs_bareber_wp_rem_register_user_and_add_property .= '[/wp_rem_register_user_and_add_property]';

				$shortcode_data .= $wp_rem_cs_bareber_wp_rem_register_user_and_add_property;
				$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property'] ++;
			}
			$counters['wp_rem_cs_global_counter_wp_rem_register_user_and_add_property'] ++;
		}
		return array(
			'data' => $data,
			'counters' => $counters,
			'widget_type' => $widget_type,
			'column' => $shortcode_data,
		);
	}

	add_filter( 'wp_rem_cs_save_page_builder_data_wp_rem_register_user_and_add_property', 'wp_rem_cs_save_page_builder_data_wp_rem_register_user_and_add_property_callback' );
}

if ( ! function_exists( 'wp_rem_cs_load_shortcode_counters_wp_rem_register_user_and_add_property_callback' ) ) {

	/**
	 * Populate wp_rem_register_user_and_add_property shortcode counter variables.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_load_shortcode_counters_wp_rem_register_user_and_add_property_callback( $counters ) {
		$counters['wp_rem_cs_global_counter_wp_rem_register_user_and_add_property'] = 0;
		$counters['wp_rem_cs_shortcode_counter_wp_rem_register_user_and_add_property'] = 0;
		$counters['wp_rem_cs_counter_wp_rem_register_user_and_add_property'] = 0;
		return $counters;
	}

	add_filter( 'wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_register_user_and_add_property_callback' );
}



if ( ! function_exists( 'wp_rem_cs_element_list_populate_wp_rem_register_user_and_add_property_callback' ) ) {

	/**
	 * Populate wp_rem_register_user_and_add_property shortcode strings list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_element_list_populate_wp_rem_register_user_and_add_property_callback( $element_list ) {
		$element_list['wp_rem_register_user_and_add_property'] = wp_rem_plugin_text_srt( 'wp_rem_register_user_and_property_heading' );
		return $element_list;
	}

	add_filter( 'wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_register_user_and_add_property_callback' );
}

if ( ! function_exists( 'wp_rem_cs_shortcode_names_list_populate_wp_rem_register_user_and_add_property_callback' ) ) {

	/**
	 * Populate wp_rem_register_user_and_add_property shortcode names list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_shortcode_names_list_populate_wp_rem_register_user_and_add_property_callback( $shortcode_array ) {
		$shortcode_array['wp_rem_register_user_and_add_property'] = array(
			'title' => wp_rem_plugin_text_srt( 'wp_rem_register_user_and_property_heading' ),
			'name' => 'wp_rem_register_user_and_add_property',
			'icon' => 'icon-gears',
			'categories' => 'typography',
		);

		return $shortcode_array;
	}

	add_filter( 'wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_register_user_and_add_property_callback' );
}
