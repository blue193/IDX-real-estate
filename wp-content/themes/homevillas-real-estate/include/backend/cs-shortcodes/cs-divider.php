<?php
/**
 * @Divider html form for page builder
 */
if ( !function_exists( 'wp_rem_cs_var_page_builder_divider' ) ) {

	function wp_rem_cs_var_page_builder_divider( $die = 0 ) {
		global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$wp_rem_cs_counter = $_POST['counter'];
		if ( isset( $_POST['action'] ) && !isset( $_POST['shortcode_element_id'] ) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes( $shortcode_element_id );
			$PREFIX = 'wp_rem_cs_divider';
			$parseObject = new ShortcodeParse();
			$output = $parseObject->wp_rem_cs_shortcodes( $output, $shortcode_str, true, $PREFIX );
		}
		$defaults = array(
			'wp_rem_cs_var_divider_padding_left' => '0',
			'wp_rem_cs_var_divider_padding_right' => '0',
			'wp_rem_cs_var_divider_margin_top' => '0',
			'wp_rem_cs_var_divider_margin_buttom' => '0',
			'wp_rem_cs_var_divider_align' => '',
		);
		if ( isset( $output['0']['atts'] ) ) {
			$atts = $output['0']['atts'];
		} else {
			$atts = array();
		}
		$divider_element_size = '100';
		foreach ( $defaults as $key => $values ) {
			if ( isset( $atts[$key] ) ) {
				$$key = $atts[$key];
			} else {
				$$key = $values;
			}
		}
		$name = 'wp_rem_cs_var_page_builder_divider';
		$coloumn_class = 'column_' . $divider_element_size;
		$wp_rem_cs_var_divider_padding_left = isset( $wp_rem_cs_var_divider_padding_left ) ? $wp_rem_cs_var_divider_padding_left : '';
		$wp_rem_cs_var_divider_padding_right = isset( $wp_rem_cs_var_divider_padding_right ) ? $wp_rem_cs_var_divider_padding_right : '';
		$wp_rem_cs_var_divider_margin_top = isset( $wp_rem_cs_var_divider_margin_top ) ? $wp_rem_cs_var_divider_margin_top : '';
		$wp_rem_cs_var_divider_margin_buttom = isset( $wp_rem_cs_var_divider_margin_buttom ) ? $wp_rem_cs_var_divider_margin_buttom : '';
		$wp_rem_cs_var_divider_align = isset( $wp_rem_cs_var_divider_align ) ? $wp_rem_cs_var_divider_align : '';

		if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		global $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_short_code_strings();
		?>
		<div id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?>
			 <?php echo esc_attr( $shortcode_view ); ?>" item="divider" data="<?php echo wp_rem_cs_element_size_data_array_index( $divider_element_size ) ?>" >
				 <?php wp_rem_cs_element_setting( $name, $wp_rem_cs_counter, $divider_element_size ) ?>
			<div class="cs-wrapp-class-<?php echo esc_attr( $wp_rem_cs_counter ); ?> <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>" data-shortcode-template="[wp_rem_cs_divider {{attributes}}]{{content}}[/wp_rem_cs_divider]" style="display: none;"">
				<div class="cs-heading-area">
					<h5><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_edit' ) ); ?></h5>
					<a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>','<?php echo esc_js( $filter_element ); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
				<div class="cs-pbwp-content">
					<div class="cs-wrapp-clone cs-shortcode-wrapp">

						<?php
						$wp_rem_cs_opt_array = array(
							'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_left_padding' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_left_padding_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => esc_html( $wp_rem_cs_var_divider_padding_left ),
								'id' => 'divider_height',
								'cust_name' => 'wp_rem_cs_var_divider_padding_left[]',
								'return' => true,
								'cs-range-input' => 'cs-range-input',
							),
						);

						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

						$wp_rem_cs_opt_array = array(
							'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_right_padding' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_right_padding_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => esc_html( $wp_rem_cs_var_divider_padding_right ),
								'id' => 'divider_height',
								'cust_name' => 'wp_rem_cs_var_divider_padding_right[]',
								'return' => true,
								'cs-range-input' => 'cs-range-input',
							),
						);

						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

						$wp_rem_cs_opt_array = array(
							'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_top_margin' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_top_margin_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => esc_html( $wp_rem_cs_var_divider_margin_top ),
								'id' => 'divider_height',
								'cust_name' => 'wp_rem_cs_var_divider_margin_top[]',
								'return' => true,
								'cs-range-input' => 'cs-range-input',
							),
						);

						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

						$wp_rem_cs_opt_array = array(
							'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_bottom_margin' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_bottom_margin_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => esc_html( $wp_rem_cs_var_divider_margin_buttom ),
								'id' => 'divider_height',
								'cust_name' => 'wp_rem_cs_var_divider_margin_buttom[]',
								'return' => true,
								'cs-range-input' => 'cs-range-input',
							),
						);
						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

						$wp_rem_cs_opt_array = array(
							'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_align' ),
							'desc' => '',
							'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_divider_field_align_hint' ),
							'echo' => true,
							'field_params' => array(
								'std' => $wp_rem_cs_var_divider_align,
								'id' => '',
								'cust_name' => 'wp_rem_cs_var_divider_align[]',
								'classes' => 'dropdown chosen-select',
								'options' => array(
									'center' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_heading_sc_center' ),
									'left' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_heading_sc_left' ),
									'right' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_heading_sc_right' ),
								),
								'return' => true,
							),
						);
						$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
						?>

					</div>
					<?php if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
						<ul class="form-elements insert-bg">
							<li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js( str_replace( 'wp_rem_cs_var_page_builder_', '', $name ) ); ?>', '<?php echo esc_js( $name . $wp_rem_cs_counter ); ?>', '<?php echo esc_js( $filter_element ); ?>')" ><?php echo esc_html( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_insert' ) ); ?></a> </li>
						</ul>
						<div id="results-shortocde"></div>
						<?php
					} else {
						$wp_rem_cs_opt_array = array(
							'std' => 'divider',
							'id' => '',
							'before' => '',
							'after' => '',
							'classes' => '',
							'extra_atr' => '',
							'cust_id' => '',
							'cust_name' => 'wp_rem_cs_orderby[]',
							'return' => false,
							'required' => false
						);
						$wp_rem_cs_var_html_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );

						$wp_rem_cs_opt_array = array(
							'name' => '',
							'desc' => '',
							'hint_text' => '',
							'echo' => true,
							'field_params' => array(
								'std' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_save' ),
								'cust_id' => '',
								'cust_type' => 'button',
								'classes' => 'cs-wp_rem_cs-admin-btn',
								'cust_name' => '',
								'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
								'return' => true,
							),
						);

						$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
					}
					?>
				</div>
			</div>
		</div>
		
		<?php
		if ( $die <> 1 ) {
			die();
		}
	}

	add_action( 'wp_ajax_wp_rem_cs_var_page_builder_divider', 'wp_rem_cs_var_page_builder_divider' );
}

if ( !function_exists( 'wp_rem_cs_save_page_builder_data_divider_callback' ) ) {

	/**
	 * Save data for divider shortcode.
	 *
	 * @param	array $args
	 * @return	array
	 */
	function wp_rem_cs_save_page_builder_data_divider_callback( $args ) {
		$data = $args['data'];
		$counters = $args['counters'];
		$widget_type = $args['widget_type'];
		$column = $args['column'];
		
        $shortcode_data = '';
		if ( $widget_type == "divider" || $widget_type == "cs_divider" ) {
			$shortcode = '';
                        $page_element_size  =  $data['divider_element_size'][$counters['wp_rem_cs_global_counter_divider']];
                        $divider_element_size  =  $data['divider_element_size'][$counters['wp_rem_cs_global_counter_divider']];
                        
			if ( isset( $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] ) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
				$shortcode_str = stripslashes( ( $data['shortcode']['divider'][$counters['wp_rem_cs_shortcode_counter_divider']] ) );
                                
                                $element_settings   = 'divider_element_size="'.$divider_element_size.'"';
                                $reg = '/divider_element_size="(\d+)"/s';
                                $shortcode_str  = preg_replace( $reg, $element_settings, $shortcode_str );
                                $shortcode_data = $shortcode_str;
				$counters['wp_rem_cs_shortcode_counter_divider'] ++;
			} else {
                                $shortcode = '[wp_rem_cs_divider divider_element_size="'.htmlspecialchars( $data['divider_element_size'][$counters['wp_rem_cs_global_counter_divider']] ).'" ';
				if ( isset( $data['wp_rem_cs_var_divider_padding_left'][$counters['wp_rem_cs_counter_divider']] ) && $data['wp_rem_cs_var_divider_padding_left'][$counters['wp_rem_cs_counter_divider']] != '' ) {
					$shortcode .= 'wp_rem_cs_var_divider_padding_left="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_divider_padding_left'][$counters['wp_rem_cs_counter_divider']] ), ENT_QUOTES ) ) . '" ';
				}
				if ( isset( $data['wp_rem_cs_var_divider_padding_right'][$counters['wp_rem_cs_counter_divider']] ) && $data['wp_rem_cs_var_divider_padding_right'][$counters['wp_rem_cs_counter_divider']] != '' ) {
					$shortcode .= 'wp_rem_cs_var_divider_padding_right="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_divider_padding_right'][$counters['wp_rem_cs_counter_divider']] ), ENT_QUOTES ) ) . '" ';
				}
				if ( isset( $data['wp_rem_cs_var_divider_margin_top'][$counters['wp_rem_cs_counter_divider']] ) && $data['wp_rem_cs_var_divider_margin_top'][$counters['wp_rem_cs_counter_divider']] != '' ) {
					$shortcode .= 'wp_rem_cs_var_divider_margin_top="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_divider_margin_top'][$counters['wp_rem_cs_counter_divider']] ), ENT_QUOTES ) ) . '" ';
				}
				if ( isset( $data['wp_rem_cs_var_divider_margin_buttom'][$counters['wp_rem_cs_counter_divider']] ) && $data['wp_rem_cs_var_divider_margin_buttom'][$counters['wp_rem_cs_counter_divider']] != '' ) {
					$shortcode .= 'wp_rem_cs_var_divider_margin_buttom="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_divider_margin_buttom'][$counters['wp_rem_cs_counter_divider']] ), ENT_QUOTES ) ) . '" ';
				}
				if ( isset( $data['wp_rem_cs_var_divider_align'][$counters['wp_rem_cs_counter_divider']] ) && $data['wp_rem_cs_var_divider_align'][$counters['wp_rem_cs_counter_divider']] != '' ) {
					$shortcode .= 'wp_rem_cs_var_divider_align="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_divider_align'][$counters['wp_rem_cs_counter_divider']] ), ENT_QUOTES ) ) . '" ';
				}
				$shortcode .= ']';
				$shortcode .= '[/wp_rem_cs_divider]';
                                $shortcode_data .= $shortcode;
				$counters['wp_rem_cs_counter_divider'] ++;
			}
			$counters['wp_rem_cs_global_counter_divider'] ++;
		}
		return array(
			'data' => $data,
			'counters' => $counters,
			'widget_type' => $widget_type,
			'column' => $shortcode_data,
		);
	}

	add_filter( 'wp_rem_cs_save_page_builder_data_divider', 'wp_rem_cs_save_page_builder_data_divider_callback' );
}

if ( !function_exists( 'wp_rem_cs_load_shortcode_counters_divider_callback' ) ) {

	/**
	 * Populate divider shortcode counter variables.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_load_shortcode_counters_divider_callback( $counters ) {
		$counters['wp_rem_cs_counter_divider'] = 0;
		$counters['wp_rem_cs_shortcode_counter_divider'] = 0;
		$counters['wp_rem_cs_global_counter_divider'] = 0;
		return $counters;
	}

	add_filter( 'wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_divider_callback' );
}
if ( !function_exists( 'wp_rem_cs_shortcode_names_list_populate_divider_callback' ) ) {

	/**
	 * Populate divider shortcode names list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_shortcode_names_list_populate_divider_callback( $shortcode_array ) {
		$shortcode_array['divider'] = array(
			'title' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_divider' ),
			'name' => 'divider',
			'icon' => 'icon-ellipsis-h',
			'categories' => 'typography',
		);
		return $shortcode_array;
	}

	add_filter( 'wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_divider_callback' );
}

if ( !function_exists( 'wp_rem_cs_element_list_populate_divider_callback' ) ) {

	/**
	 * Populate divider shortcode strings list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_element_list_populate_divider_callback( $element_list ) {
		$element_list['divider'] = wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_divider' );
		return $element_list;
	}

	add_filter( 'wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_divider_callback' );
}