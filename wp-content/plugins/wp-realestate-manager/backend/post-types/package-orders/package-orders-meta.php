<?php

/**
 * Start Function  how to Create Transations Fields
 */
if ( ! function_exists('wp_rem_create_package_orders_fields') ) {

	function wp_rem_create_package_orders_fields($key, $param) {
		global $post, $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;
		$wp_rem_gateway_options = get_option('wp_rem_plugin_options');
		$wp_rem_currency_sign = wp_rem_get_currency_sign();
		$wp_rem_value = $param['title'];
		$html = '';
		switch ( $param['type'] ) {
			case 'text' :
				// prepare
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

				if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
					if ( $key == 'transaction_expiry_date' ) {
						$wp_rem_value = date_i18n('d-m-Y', $wp_rem_value);
					} else {
						$wp_rem_value = $wp_rem_value;
					}
				} else {
					$wp_rem_value = '';
				}

				$wp_rem_opt_array = array(
					'name' => $param['title'],
					'desc' => '',
					'hint_text' => '',
					'field_params' => array(
						'std' => $wp_rem_value,
						'id' => $key,
						'classes' => 'wp-rem-form-text wp-rem-input',
						'force_std' => true,
						'return' => true,
					),
				);
				$output = '';
				$output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
				$output .= '<span class="wp-rem-form-desc">' . $param['description'] . '</span>' . "\n";


				$html .= $output;
				break;
			case 'checkbox' :
				// prepare
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

				$wp_rem_opt_array = array(
					'name' => $param['title'],
					'desc' => '',
					'hint_text' => '',
					'field_params' => array(
						'std' => $wp_rem_value,
						'id' => $key,
						'classes' => 'wp-rem-form-text wp-rem-input',
						'force_std' => true,
						'return' => true,
					),
				);
				$output = '';
				$output .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

				$html .= $output;
				break;
			case 'textarea' :
				// prepare
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
				if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
					$wp_rem_value = $wp_rem_value;
				} else {
					$wp_rem_value = '';
				}

				$wp_rem_opt_array = array(
					'name' => $param['title'],
					'desc' => '',
					'hint_text' => '',
					'field_params' => array(
						'std' => '',
						'id' => $key,
						'return' => true,
					),
				);

				$output = $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
				$html .= $output;
				break;
			case 'select' :
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
				if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
					$wp_rem_value = $wp_rem_value;
				} else {
					$wp_rem_value = '';
				}
				$wp_rem_classes = '';
				if ( isset($param['classes']) && $param['classes'] != "" ) {
					$wp_rem_classes = $param['classes'];
				}
				$wp_rem_opt_array = array(
					'name' => $param['title'],
					'desc' => '',
					'hint_text' => '',
					'field_params' => array(
						'std' => '',
						'id' => $key,
						'classes' => $wp_rem_classes,
						'options' => $param['options'],
						'return' => true,
					),
				);

				$output = $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
				// append
				$html .= $output;
				break;
			case 'hidden_label' :
				// prepare
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

				if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
					$wp_rem_value = $wp_rem_value;
				} else {
					$wp_rem_value = '';
				}

				$wp_rem_opt_array = array(
					'name' => $param['title'],
					'hint_text' => '',
				);
				$output = $wp_rem_html_fields->wp_rem_opening_field($wp_rem_opt_array);

				$output .= '<span>#' . $wp_rem_value . '</span>';

				$output .= $wp_rem_form_fields->wp_rem_form_hidden_render(
						array(
							'name' => '',
							'id' => $key,
							'return' => true,
							'classes' => '',
							'std' => $wp_rem_value,
							'description' => '',
							'hint' => ''
						)
				);

				$wp_rem_opt_array = array(
					'desc' => '',
				);
				$output .= $wp_rem_html_fields->wp_rem_closing_field($wp_rem_opt_array);
				$html .= $output;
				break;
			case 'trans_dynamic' :
				$wp_rem_trans_dynamic = get_post_meta($post->ID, "wp_rem_transaction_dynamic", true);
				
				if(is_array($wp_rem_trans_dynamic) && sizeof($wp_rem_trans_dynamic) > 0) {
					$wp_rem_opt_array = array(
						'name' => $param['title'],
						'hint_text' => '',
					);
					$output = $wp_rem_html_fields->wp_rem_opening_field($wp_rem_opt_array);
					
					foreach($wp_rem_trans_dynamic as $trans_dynamic){
						if(isset($trans_dynamic['field_type']) && isset($trans_dynamic['field_label']) && isset($trans_dynamic['field_value'])) {
							$d_type = $trans_dynamic['field_type'];
							$d_label = $trans_dynamic['field_label'];
							$d_value = $trans_dynamic['field_value'];
							if ($d_type == 'single-choice') {
								$d_value = $d_value == 'on' ? wp_rem_plugin_text_srt( 'wp_rem_property_yes' ) : wp_rem_plugin_text_srt( 'wp_rem_property_no' );
							}
							
							$output .= '<div class="col-md-3"><strong>'.$d_label.'</strong></div><div class="col-md-8">'.$d_value.'</div><br><hr>' . "\n";
						}
					}
	
					$wp_rem_opt_array = array(
						'desc' => '',
					);
					$output .= $wp_rem_html_fields->wp_rem_closing_field($wp_rem_opt_array);
					
					$html .= $output;
				}
				
				break;
			case 'extra_features' :
				// prepare
				$wp_rem_property_ids = get_post_meta($post->ID, "wp_rem_property_ids", true);
				$wp_rem_featured_ids = get_post_meta($post->ID, "wp_rem_featured_ids", true);
				$wp_rem_top_cat_ids = get_post_meta($post->ID, "wp_rem_top_cat_ids", true);
				
				$output = '';
				
				$output .= '<div class="form-elements">';
				
				$wp_rem_post_data = '<div class="col-md-12">';
				$wp_rem_post_data .= '<h1>' . wp_rem_plugin_text_srt( 'wp_rem_package_lists_used' ) . '</h1>';
				if ( is_array($wp_rem_property_ids) && sizeof($wp_rem_property_ids) ) {
					$wp_rem_total_lists = get_post_meta($post->ID, "wp_rem_transaction_properties", true);
					$wp_rem_remain_lists = (int) $wp_rem_total_lists - absint(sizeof($wp_rem_property_ids));
					$wp_rem_remain_lists = absint($wp_rem_remain_lists);
					$wp_rem_post_data .= '<h2>' . sprintf( wp_rem_plugin_text_srt( 'wp_rem_package_total' ), $wp_rem_total_lists) . '</h2>';
					$wp_rem_post_data .= '<h2>' . sprintf( wp_rem_plugin_text_srt( 'wp_rem_package_used' ), absint(sizeof($wp_rem_property_ids))) . '</h2>';
					$wp_rem_post_data .= '<h2>' . sprintf( wp_rem_plugin_text_srt( 'wp_rem_package_remaining' ), $wp_rem_remain_lists) . '</h2>';
					$wp_rem_post_data .= '<hr>';
					$property_counter = 1;
					foreach ( $wp_rem_property_ids as $id ) {
						$wp_rem_permalink = get_the_title($id) ? ' target="_blank" href="' . get_edit_post_link($id) . '"' : '';
						$wp_rem_title = get_the_title($id) ? get_the_title($id) : wp_rem_plugin_text_srt( 'wp_rem_package_removed' );
						$wp_rem_post = '<ul>';
						$wp_rem_post .= '<li><strong>' . $property_counter . '. </strong>' . wp_rem_plugin_text_srt( 'wp_rem_package_property_id' ) . ' : #' . $id . '</li>';
						$wp_rem_post .= '<li>' . wp_rem_plugin_text_srt( 'wp_rem_package_property_title' ) . ' : <a' . $wp_rem_permalink . '">' . $wp_rem_title . '</a></li>';
						$wp_rem_post .= '</ul>';
						$wp_rem_post_data .= '<span>' . $wp_rem_post . '</span>';
						$property_counter++;
					}
				} else {
					$wp_rem_post_data .= wp_rem_plugin_text_srt( 'wp_rem_package_used_yet' );
				}
				$wp_rem_post_data .= '</div>';
				
				$output .= $wp_rem_post_data;
				
				$output .= '</div>';

				$html .= $output;
				break;

			default :
				break;
		}
		return $html;
	}

}
/**
 * End Function  how to Create Transations Fields
 */