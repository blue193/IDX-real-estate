<?php

/**
 * Admin Functions
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Auto Mobile 1.0
 */
if ( ! function_exists( 'wp_rem_cs_var_icomoon_icons_box' ) ) {

	function wp_rem_cs_var_icomoon_icons_box( $icon_value = '', $id = '', $name = '', $group = '' ) {

		global $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

		$wp_rem_cs_var_icomoon = '';
		$wp_rem_cs_var_icomoon .= '
		<script>
		jQuery(document).ready(function ($) {

			var e9_element = $(\'#e9_element_' . esc_html( $id ) . '\').fontIconPicker({
				theme: \'fip-bootstrap\'
			});
			// Add the event on the button
			$(\'#e9_buttons_' . esc_html( $id ) . ' button\').on(\'click\', function (e) {
				e.preventDefault();
				// Show processing message
				$(this).prop(\'disabled\', true).html(\'<i class="icon-cog demo-animate-spin"></i> ' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_wait' ) . '\');
				$.ajax({
					url: "' . get_template_directory_uri() . '/assets/common/icomoon/js/selection.json",
					type: \'GET\',
					dataType: \'json\'
				}).done(function (response) {
						// Get the class prefix
						var classPrefix = response.preferences.fontPref.prefix,
								icomoon_json_icons = [],
								icomoon_json_search = [];
						$.each(response.icons, function (i, v) {
								icomoon_json_icons.push(classPrefix + v.properties.name);
								if (v.icon && v.icon.tags && v.icon.tags.length) {
										icomoon_json_search.push(v.properties.name + \' \' + v.icon.tags.join(\' \'));
								} else {
										icomoon_json_search.push(v.properties.name);
								}
						});
						// Set new fonts on fontIconPicker
						e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
						// Show success message and disable
						$(\'#e9_buttons_' . esc_html( $id ) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-success\').text(\'' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_load_icon' ) . '\').prop(\'disabled\', true);
				})
				.fail(function () {
						// Show error message and enable
						$(\'#e9_buttons_' . esc_html( $id ) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-danger\').text(\'' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_try_again' ) . '\').prop(\'disabled\', false);
				});
				e.stopPropagation();
			});
			jQuery("#e9_buttons_' . esc_html( $id ) . ' button").click();
		});
		</script>';

		$wp_rem_cs_opt_array = array(
			'std' => esc_html( $icon_value ),
			'cust_id' => 'e9_element_' . esc_html( $id ),
			'cust_name' => esc_html( $name ) . '[]',
			'return' => true,
		);
		$wp_rem_cs_var_icomoon .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render( $wp_rem_cs_opt_array );
		$wp_rem_cs_var_icomoon .= '
        <span id="e9_buttons_' . esc_html( $id ) . '" style="display:none">
            <button autocomplete="off" type="button" class="btn btn-primary">' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_load_json' ) . '</button>
        </span>';

		return $wp_rem_cs_var_icomoon;
	}

}

/**
 * @count Banner Clicks
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_banner_click_count_plus' ) ) {

	function wp_rem_cs_var_banner_click_count_plus() {
		$code_id = isset( $_POST['code_id'] ) ? $_POST['code_id'] : '';
		$banner_click_count = get_option( "banner_clicks_" . $code_id );
		$banner_click_count = $banner_click_count <> '' ? $banner_click_count : 0;
		if ( ! isset( $_COOKIE["banner_clicks_" . $code_id] ) ) {
			setcookie( "banner_clicks_" . $code_id, 'true', time() + 86400, '/' );
			update_option( "banner_clicks_" . $code_id, $banner_click_count + 1 );
		}
		die( 0 );
	}

	add_action( 'wp_ajax_wp_rem_cs_var_banner_click_count_plus', 'wp_rem_cs_var_banner_click_count_plus' );
	add_action( 'wp_ajax_nopriv_wp_rem_cs_var_banner_click_count_plus', 'wp_rem_cs_var_banner_click_count_plus' );
}

/**
 * @Adding Ads Unit
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_ads_banner' ) ) {

	function wp_rem_cs_var_ads_banner() {

		global $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_short_code_strings();
		$wp_rem_cs_rand_num = rand( 123456, 987654 );
		$wp_rem_cs_html = '';
		if ( $_POST['banner_title_input'] ) {

			$title = isset( $_POST['banner_title_input'] ) ? $_POST['banner_title_input'] : '';
		}
		$wp_rem_cs_html .= '<tr id="del_' . absint( $wp_rem_cs_rand_num ) . '">';
		$wp_rem_cs_html .= '
		<td>' . esc_html( $title ) . '</td> 
                <td>' . esc_html( $_POST['banner_style_input'] ) . '</td> ';
		if ( $_POST['banner_type_input'] == 'image' ) {

			$wp_rem_cs_html .= '<td><img src="' . esc_url( $_POST['image_path'] ) . '" alt="" width="100" /></td>';
			$wp_rem_cs_html .= '<td>&nbsp;</td>';
		} else {
			$wp_rem_cs_html .= '<td>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_custom_code' ) . '</td>';
			$wp_rem_cs_html .= '<td>&nbsp;</td>';
		}

		$wp_rem_cs_html .= '<td>[wp_rem_cs_ads id="' . absint( $wp_rem_cs_rand_num ) . '"]</td>';
		$wp_rem_cs_html .= '
              <td class="centr"> 
			<a class="remove-btn" onclick="javascript:return confirm(\'' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_are_sure' ) . '\')" href="javascript:ads_del(\'' . absint( $wp_rem_cs_rand_num ) . '\')"><i class="icon-times"></i></a>
			<a href="javascript:wp_rem_cs_var_toggle(\'' . absint( $wp_rem_cs_rand_num ) . '\')"><i class="icon-edit3"></i></a>
		</td>
		</tr>';

		$wp_rem_cs_html .= '
		<tr id="' . absint( $wp_rem_cs_rand_num ) . '" style="display:none">
		  <td colspan="3">
			<div class="form-elements">
			  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
			  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<a onclick="wp_rem_cs_var_toggle(\'' . absint( $wp_rem_cs_rand_num ) . '\')"><i class="icon-times"></i></a>
			  </div>
			</div>';

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_title_field' ),
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_title_field_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['banner_title_input'] ) ? $_POST['banner_title_input'] : '',
				'cust_id' => 'banner_title' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_banner_title[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_style' ),
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_style_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['banner_style_input'] ) ? $_POST['banner_style_input'] : '',
				'cust_id' => 'banner_style' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_banner_style[]',
				'desc' => '',
				'classes' => 'input-small chosen-select',
				'options' =>
				array(
					'top_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_top' ),
					'bottom_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_bottom' ),
					'sidebar_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_sidebar' ),
					'vertical_banner' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_vertical' ),
				),
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type' ),
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_type_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['banner_type_input'] ) ? $_POST['banner_type_input'] : '',
				'cust_id' => 'banner_type' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_banner_type[]',
				'desc' => '',
				'extra_atr' => 'onchange="javascript:wp_rem_cs_var_banner_type_toggle(this.value , \'' . absint( $wp_rem_cs_rand_num ) . '\')"',
				'classes' => 'input-small chosen-select',
				'options' =>
				array(
					'image' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_image' ),
					'code' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_code' ),
				),
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
		$display_ads = 'none';
		if ( $_POST['banner_type_input'] == 'image' ) {
			$display_ads = 'block';
		} else if ( $_POST['banner_type_input'] == 'code' ) {
			$display_ads = 'none';
		}
		$wp_rem_cs_html .='<div id="ads_image' . absint( $wp_rem_cs_rand_num ) . '" style="display:' . esc_html( $display_ads ) . '">';


		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_image' ),
			'id' => 'banner_image',
			'std' => isset( $_POST['image_path'] ) ? $_POST['image_path'] : '',
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_image_hint' ),
			'prefix' => '',
			'array' => true,
			'field_params' => array(
				'std' => isset( $_POST['image_path'] ) ? $_POST['image_path'] : '',
				'id' => 'banner_image',
				'prefix' => '',
				'array' => true,
				'return' => true,
			),
		);

		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );
		$wp_rem_cs_html .='</div>';
		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_url_field' ),
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_url_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['banner_field_url_input'] ) ? $_POST['banner_field_url_input'] : '',
				'cust_id' => 'banner_field_url' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_banner_field_url[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_target' ),
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_target_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['banner_target_input'] ) ? $_POST['banner_target_input'] : '',
				'desc' => '',
				'cust_id' => 'banner_target' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_banner_target[]',
				'classes' => 'input-small chosen-select',
				'options' =>
				array(
					'_self' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_target_self' ),
					'_blank' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_target_blank' ),
				),
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
		$display_ads = 'none';
		if ( $_POST['banner_type_input'] == 'image' ) {
			$display_ads = 'none';
		} else if ( $_POST['banner_type_input'] == 'code' ) {
			$display_ads = 'block';
		}
		$wp_rem_cs_html .='<div id="ads_code' . absint( $wp_rem_cs_rand_num ) . '" style="display:' . esc_html( $display_ads ) . '">';
		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_ad_sense_code' ),
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_banner_ad_sense_code_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['adsense_code_input'] ) ? $_POST['adsense_code_input'] : '',
				'cust_id' => 'adsense_code' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_adsense_code[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field( $wp_rem_cs_opt_array );
		$wp_rem_cs_html .='</div>';

		$wp_rem_cs_opt_array = array(
			'std' => absint( $wp_rem_cs_rand_num ),
			'id' => 'banner_field_code_no' . absint( $wp_rem_cs_rand_num ),
			'cust_name' => 'wp_rem_cs_var_banner_field_code_no[]',
			'return' => true,
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );


		$wp_rem_cs_html .= '	
		  </td>
		</tr>';


		echo force_balance_tags( $wp_rem_cs_html );
		die;
	}

	add_action( 'wp_ajax_wp_rem_cs_var_ads_banner', 'wp_rem_cs_var_ads_banner' );
}



/**
 * @Adding Social Icons
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_add_social_icon' ) ) {

	function wp_rem_cs_var_add_social_icon() {

		global $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_short_code_strings();
		$wp_rem_cs_rand_num = rand( 123456, 987654 );
		$wp_rem_cs_html = '';
		if ( $_POST['social_net_awesome'] ) {

			$icon_awesome = $_POST['social_net_awesome'];
		}
		$socail_network = get_option( 'wp_rem_cs_var_social_network' );





		$wp_rem_cs_html .= '<li class="wp-rem-list-item">';

		$wp_rem_cs_html .= '<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
		if ( isset( $icon_awesome ) && $icon_awesome <> '' ) {
			$wp_rem_cs_html .= '<i  class="' . $_POST['social_net_awesome'] . ' icon-2x"></i>';
		} else {
			$wp_rem_cs_html .= '<img width="50" src="' . esc_url( $_POST['social_net_icon_path'] ) . '">';
		}

		$wp_rem_cs_html.='</div>
                                            </div>
                                        </div>';

		$wp_rem_cs_html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
		$wp_rem_cs_html .= esc_html( $_POST['social_net_tooltip'] );
		$wp_rem_cs_html.='</div>
                                            </div>
                                        </div>';


		$wp_rem_cs_html .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
		$wp_rem_cs_html .= '<a href="#">' . esc_url( $_POST['social_net_url'] ) . '</a>';
		$wp_rem_cs_html.='</div>
                                            </div>
                                        </div>';

		$wp_rem_cs_html .= '<a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>';
		$wp_rem_cs_html .= '<a href="javascript:void(0);" class="wp-rem-edit wp-rem-parent-li-edit"><i class="icon-edit2"></i></a>';

		$wp_rem_cs_html .= '<div class="parent-li-edit-div" style="display:none;">';
		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_title_field' ),
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_icon_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['social_net_tooltip'] ) ? $_POST['social_net_tooltip'] : '',
				'cust_id' => 'social_net_tooltip' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_social_net_tooltip[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_url_field' ),
			'desc' => '',
			'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_url_hint' ),
			'field_params' => array(
				'std' => isset( $_POST['social_net_url'] ) ? $_POST['social_net_url'] : '',
				'cust_id' => 'social_net_url' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_social_net_url[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_icon_path' ),
			'id' => 'social_icon_path',
			'std' => isset( $_POST['social_net_icon_path'] ) ? $_POST['social_net_icon_path'] : '',
			'desc' => '',
			'hint_text' => '',
			'prefix' => '',
			'array' => true,
			'field_params' => array(
				'std' => isset( $_POST['social_net_icon_path'] ) ? $_POST['social_net_icon_path'] : '',
				'id' => 'social_icon_path',
				'prefix' => '',
				'array' => true,
				'return' => true,
			),
		);

		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );
                
                $cs_icon_group   = isset( $_POST['cs_icon_group'] )? $_POST['cs_icon_group'] : 'default';
		$wp_rem_cs_html .= '
			<div class="form-elements" id="wp_rem_cs_var_infobox_networks' . absint( $wp_rem_cs_rand_num ) . '">
			  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_icon' ) . '</label></div>
			  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                ' . apply_filters( 'cs_icons_fields', $_POST['social_net_awesome'], "networks" . absint( $wp_rem_cs_rand_num ), 'wp_rem_cs_var_social_net_awesome', $cs_icon_group ) . '
			  </div>
			</div>';

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_icon_color' ),
			'desc' => '',
			'hint_text' => '',
			'field_params' => array(
				'std' => isset( $_POST['social_font_awesome_color'] ) ? $_POST['social_font_awesome_color'] : '',
				'cust_id' => 'social_font_awesome_color' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_cs_var_social_icon_color[]',
				'classes' => 'bg_color',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_html .= '</div>';

		echo force_balance_tags( $wp_rem_cs_html );
		die;
	}

	add_action( 'wp_ajax_wp_rem_cs_var_add_social_icon', 'wp_rem_cs_var_add_social_icon' );
}

/**
 * @Tool Tip Help Text Style
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_tooltip_helptext' ) ) {

	function wp_rem_cs_var_tooltip_helptext( $popover_text = '', $return_html = true ) {
		$popover_link = '';
		if ( isset( $popover_text ) && $popover_text != '' ) {
			$popover_link = '<a class="cs-help" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . esc_attr( $popover_text ) . '"><i class="icon-help"></i></a>';
		}
		if ( $return_html == true ) {
			return $popover_link;
		} else {
			echo force_balance_tags( $popover_link );
		}
	}

}

/**
 * @Decoding Shortcode
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_custom_shortcode_decode' ) ) {

	function wp_rem_cs_var_custom_shortcode_decode( $sh_content = '' ) {
		$sh_content = str_replace( array( 'wp_rem_cs_open', 'wp_rem_cs_close' ), array( '[', ']' ), $sh_content );
		return $sh_content;
	}

}


/**
 * @Adding Social Icons
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_add_clients' ) ) {

	function wp_rem_cs_var_add_clients() {

		global $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
		$wp_rem_cs_rand_num = rand( 123456, 987654 );
		$wp_rem_cs_html = '';
		if ( $_POST['counter_clients'] ) {

			$counter_clients = $_POST['counter_clients'];
		}


		$wp_rem_cs_html .= '<li class="wp-rem-list-item">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">';
		if ( isset( $_POST['clients_image'] ) && $_POST['clients_image'] <> '' ) {
			$wp_rem_cs_html .= '<img width="50" src="' . esc_url( $_POST['clients_image'] ) . '">';
		}
		$wp_rem_cs_html .= '</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">
                                                ' . esc_html( $_POST['clients_title'] ) . '
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="input-element">
                                                <div class="input-holder">
                                                <a href="#">' . esc_url( $_POST['clients_url'] ) . '</a>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                                        <a href="javascript:void(0);" class="wp-rem-edit wp-rem-parent-li-edit"><i class="icon-edit2"></i></a>';

		$wp_rem_cs_html .= '<div class="parent-li-edit-div" style="display:none;">';

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_admin_func_title' ),
			'desc' => '',
			'hint_text' => '',
			'field_params' => array(
				'std' => isset( $_POST['clients_title'] ) ? $_POST['clients_title'] : '',
				'cust_id' => 'clients_title' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_clients_title[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_admin_func_url' ),
			'desc' => '',
			'hint_text' => '',
			'field_params' => array(
				'std' => isset( $_POST['clients_url'] ) ? $_POST['clients_url'] : '',
				'cust_id' => 'clients_url' . absint( $wp_rem_cs_rand_num ),
				'cust_name' => 'wp_rem_clients_url[]',
				'classes' => '',
				'return' => true,
			),
		);
		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_opt_array = array(
			'name' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_admin_func_logo' ),
			'id' => 'social_icon_path',
			'std' => isset( $_POST['clients_image'] ) ? $_POST['clients_image'] : '',
			'desc' => '',
			'hint_text' => '',
			'prefix' => '',
			'array' => true,
			'field_params' => array(
				'std' => isset( $_POST['clients_image'] ) ? $_POST['clients_image'] : '',
				'id' => 'clients_image',
				'prefix' => '',
				'array' => true,
				'return' => true,
			),
		);

		$wp_rem_cs_html .= $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );

		$wp_rem_cs_html .= '</div>';
		$wp_rem_cs_html .= '</li>';

		echo force_balance_tags( $wp_rem_cs_html );
		die;
	}

	add_action( 'wp_ajax_wp_rem_cs_var_add_clients', 'wp_rem_cs_var_add_clients' );
	add_action( 'wp_ajax_nopriv_wp_rem_cs_var_add_clients', 'wp_rem_cs_var_add_clients' );
}