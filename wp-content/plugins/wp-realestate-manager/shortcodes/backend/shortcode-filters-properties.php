<?php
/**
 * Shortcode Name : wp_rem_properties_with_filters
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists( 'wp_rem_cs_var_page_builder_wp_rem_properties_with_filters' ) ) {

	function wp_rem_cs_var_page_builder_wp_rem_properties_with_filters( $die = 0 ) {
		global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
		if ( function_exists( 'wp_rem_cs_shortcode_names' ) ) {
			$shortcode_element = '';
			$filter_element = 'filterdrag';
			$shortcode_view = '';
			$wp_rem_cs_output = array();
			$wp_rem_cs_PREFIX = 'wp_rem_properties_with_filters';
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
				'properties_title' => '',
				'properties_title_limit' => '',
				'properties_subtitle' => '',
				'properties_filters_alagnment' => '',
				'property_view' => 'v1',
				'property_types' => array(),
				'property_type' => array(),
				'property_sort_by' => 'no',
				'property_featured' => 'only-featured',
				'property_ads_switch' => 'no',
				'property_open_house_filter' => 'yes',
				'property_price_filter' => 'yes',
				'property_ads_after_list_count' => '5',
				'property_location' => '',
				'posts_per_page' => '6',
				'pagination' => '',
				'show_more_button' => 'no',
				'show_more_button_url' => '',
				'property_no_custom_fields' => '3',
			);
			$defaults = apply_filters( 'wp_rem_properties_shortcode_admin_default_attributes', $defaults );
			if ( isset( $wp_rem_cs_output['0']['atts'] ) ) {
				$atts = $wp_rem_cs_output['0']['atts'];
			} else {
				$atts = array();
			}
			if ( isset( $wp_rem_cs_output['0']['content'] ) ) {
				$wp_rem_properties_with_filters_column_text = $wp_rem_cs_output['0']['content'];
			} else {
				$wp_rem_properties_with_filters_column_text = '';
			}
			$wp_rem_properties_with_filters_element_size = '100';
			foreach ( $defaults as $key => $values ) {
				if ( isset( $atts[$key] ) ) {
					$$key = $atts[$key];
				} else {
					$$key = $values;
				}
			}
			$name = 'wp_rem_cs_var_page_builder_wp_rem_properties_with_filters';
			$coloumn_class = 'column_' . $wp_rem_properties_with_filters_element_size;
			if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
				$shortcode_element = 'shortcode_element_class';
				$shortcode_view = 'cs-pbwp-shortcode';
				$filter_element = 'ajax-drag';
				$coloumn_class = '';
			}
			$property_rand_id = rand( 4444, 99999 );
			wp_rem_cs_var_date_picker();
			?>

			<div id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?>
				 <?php echo esc_attr( $shortcode_view ); ?>" item="wp_rem_properties_with_filters" data="<?php echo wp_rem_cs_element_size_data_array_index( $wp_rem_properties_with_filters_element_size ) ?>" >
					 <?php wp_rem_cs_element_setting( $name, $wp_rem_cs_counter, $wp_rem_properties_with_filters_element_size ) ?>
				<div class="cs-wrapp-class-<?php echo intval( $wp_rem_cs_counter ) ?>
					 <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>" data-shortcode-template="[wp_rem_properties_with_filters {{attributes}}]{{content}}[/wp_rem_properties_with_filters]" style="display: none;">
					<div class="cs-heading-area" data-counter="<?php echo esc_attr( $wp_rem_cs_counter ) ?>">
						<h5><?php echo wp_rem_plugin_text_srt( 'wp_rem_properties_with_filters_options' ); ?></h5>
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
								'name' => wp_rem_plugin_text_srt( 'wp_rem_element_title' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_element_title_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $properties_title ),
									'id' => 'properties_title',
									'cust_name' => 'properties_title[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );


							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_element_sub_title' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_element_sub_title_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $properties_subtitle ),
									'id' => 'properties_subtitle',
									'cust_name' => 'properties_subtitle[]',
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
									'std' => esc_attr( $properties_filters_alagnment ),
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'properties_filters_alagnment[]',
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
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_view'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_view_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_view),
                                    'id' => 'property_view' . $property_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_view[]',
                                    'extra_atr' => 'onchange="property_view' . $property_rand_id . '(this.value)"',
                                    'return' => true,
                                    'options' => array(
										'v1' => wp_rem_plugin_text_srt( 'wp_rem_view1' ),
										'v2' => wp_rem_plugin_text_srt( 'wp_rem_view2' ),
									),
                                ),
                            );
							$wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
							
							$wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
							$property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback( 'NULL' );
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_property_types' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'multi' => true,
								'field_params' => array(
									'std' => esc_attr( $property_type ),
									'multi' => true,
									'id' => 'property_type[]',
									'classes' => 'chosen-select',
									'cust_name' => 'property_type[]',
									'return' => true,
									'options' => $property_types_array
								),
							);
							//$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );
							?>
							<script>
								jQuery(document).ready(function () {
									jQuery(".save_property_types_<?php echo absint( $property_rand_id ); ?>").click(function () {
										var MY_SELECT = jQuery('#wp_rem_property_types_<?php echo absint( $property_rand_id ); ?>').get(0);
										var selection = ChosenOrder.getSelectionOrder(MY_SELECT);
										var property_type_value = '';
										var comma = '';
										jQuery(selection).each(function (i) {
											property_type_value = property_type_value + comma + selection[i];
											comma = ',';
										});
										jQuery('#property_type_<?php echo absint( $property_rand_id ); ?>').val(property_type_value);
									});

								});
							</script>
							<?php
							$saved_property_type = $property_type;
							$property_type_options = $property_types_array;

							if ( $property_type != '' ) {
								$property_types = explode( ',', $property_type );
								foreach ( $property_types as $property_type ) {
									$get_property_types[$property_type] = $property_type_options[$property_type];
								}
							}
							if ( $get_property_types ) {
								$property_type_options = array_unique( array_merge( $get_property_types, $property_type_options ) );
							} else {
								$property_type_options = $property_type_options;
							}

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_property_types' ),
								'desc' => '',
								'label_desc' => '',
								'multi' => true,
								'echo' => true,
								'field_params' => array(
									'std' => $saved_property_type,
									'id' => 'property_types_' . $property_rand_id . '',
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'property_types[]',
									'return' => true,
									'options' => $property_type_options,
								),
							);
							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

							$wp_rem_cs_opt_array = array(
								'std' => $property_type,
								'cust_id' => 'property_type_' . $property_rand_id . '',
								'cust_name' => "property_type[]",
								'required' => false
							);
							$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );


							$dynamic_title_length_grid = 'style="display: block;"';
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_title_length' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'main_wraper' => true,
								'main_wraper_class' => 'dynamic_title_length',
								'main_wraper_extra' => $dynamic_title_length_grid,
								'field_params' => array(
									'std' => esc_attr( $properties_title_limit ),
									'id' => 'properties_title_limit',
									'cust_name' => 'properties_title_limit[]',
									'return' => true,
								),
							);
							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_number_of_custom_fields' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'main_wraper' => true,
								'field_params' => array(
									'std' => esc_attr( $property_no_custom_fields ),
									'id' => 'property_no_custom_fields',
									'cust_name' => 'property_no_custom_fields[]',
									'return' => true,
								),
							);
							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							do_action( 'wp_rem_compare_properties_element_field', $atts );
							
							$wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_featured'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_featured),
                                    'id' => 'property_featured[]',
                                    'cust_name' => 'property_featured[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'all' => wp_rem_plugin_text_srt('wp_rem_options_all'),
                                        'only-featured' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_only_featured'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_ads_switch' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $property_ads_switch ),
									'id' => 'property_ads_switch[]',
									'cust_name' => 'property_ads_switch[]',
									'return' => true,
									'classes' => 'chosen-select-no-single',
									'extra_atr' => 'onchange="property_ads_count' . $property_rand_id . '(this.value)"',
									'options' => array(
										'no' => wp_rem_plugin_text_srt( 'wp_rem_property_no' ),
										'yes' => wp_rem_plugin_text_srt( 'wp_rem_property_yes' ),
									)
								),
							);
							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );


							$property_count_hide_string = '';
							if ( $property_ads_switch == 'no' ) {
								$property_count_hide_string = 'style="display:none;"';
							}

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_count' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_count_hint' ),
								'echo' => true,
								'main_wraper' => true,
								'main_wraper_class' => 'property_count_dynamic_fields' . $property_rand_id . '',
								'main_wraper_extra' => $property_count_hide_string,
								'field_params' => array(
									'std' => esc_attr( $property_ads_after_list_count ),
									'id' => 'property_ads_after_list_count',
									'cust_name' => 'property_ads_after_list_count[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
							?>
							<script>
								jQuery(document).ready(function () {
									jQuery(".save_property_locations_<?php echo absint( $property_rand_id ); ?>").click(function () {
										var MY_SELECT = jQuery('#wp_rem_property_locations_<?php echo absint( $property_rand_id ); ?>').get(0);
										var selection = ChosenOrder.getSelectionOrder(MY_SELECT);
										var property_location_value = '';
										var comma = '';
										jQuery(selection).each(function (i) {
											property_location_value = property_location_value + comma + selection[i];
											comma = ',';
										});
										jQuery('#property_location_<?php echo absint( $property_rand_id ); ?>').val(property_location_value);
									});

								});
							</script>
							<?php
							$saved_property_location = $property_location;
                            $property_location_options = array(
                                'country' => wp_rem_plugin_text_srt('wp_rem_options_country'),
                                'state' => wp_rem_plugin_text_srt('wp_rem_options_state'),
                                'city' => wp_rem_plugin_text_srt('wp_rem_options_city'),
                                'town' => wp_rem_plugin_text_srt('wp_rem_options_town'),
                                'address' => wp_rem_plugin_text_srt('wp_rem_options_town_complete_address'),
                            );

                            if ($saved_property_location != '') {
                                $property_locations = explode(',', $saved_property_location);
                                foreach ($property_locations as $property_loc) {
                                    $get_property_locations[$property_loc] = $property_location_options[$property_loc];
                                }
                            }
                            if ($get_property_locations) {
                                $property_location_options = array_unique(array_merge($get_property_locations, $property_location_options));
                            } else {
                                $property_location_options = $property_location_options;
                            }

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_location_filter' ),
								'desc' => '',
								'label_desc' => '',
								'multi' => true,
								'echo' => true,
								'field_params' => array(
									'std' => $saved_property_location,
									'id' => 'property_locations_' . $property_rand_id . '',
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'property_locations[]',
									'return' => true,
									'options' => $property_location_options,
								),
							);
							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

							$wp_rem_cs_opt_array = array(
								'std' => $property_location,
								'cust_id' => 'property_location_' . $property_rand_id . '',
								'cust_name' => "property_location[]",
								'required' => false
							);
							$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );

							do_action( 'wp_wp_rem_properties_with_filters_shortcode_admin_fields', array( 'wp_rem_property_type' => $wp_rem_property_type, 'property_alert_button' => $property_alert_button ) );
							
							
							$show_more_switch_field_string = '';
							if ( $property_view == 'v2' ) {
								$show_more_switch_field_string = 'style="display:none;"';
							}
							
							$show_more_property_button_switch_options = array( 'no' => wp_rem_plugin_text_srt( 'wp_rem_property_no' ), 'yes' => wp_rem_plugin_text_srt( 'wp_rem_property_yes' ) );
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_show_more_switch' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'main_wraper' => true,
								'main_wraper_class' => 'show_more_switch_field' . $property_rand_id . '',
								'main_wraper_extra' => $show_more_switch_field_string,
								'field_params' => array(
									'std' => esc_attr( $show_more_button ),
									'id' => 'show_more_button',
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'show_more_button[]',
									'return' => true,
									'extra_atr' => 'onchange="show_more_button_count' . $property_rand_id . '(this.value)"',
									'options' => $show_more_property_button_switch_options
								),
							);

							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

							$show_more_button_hide_string = '';
							if ( $show_more_button == 'no' || $property_view == 'v2' ) {
								$show_more_button_hide_string = 'style="display:none;"';
							}

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_show_more_url' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_show_more_url_hint' ),
								'echo' => true,
								'main_wraper' => true,
								'main_wraper_class' => 'show_more_button_dynamic_fields' . $property_rand_id . '',
								'main_wraper_extra' => $show_more_button_hide_string,
								'field_params' => array(
									'std' => esc_attr( $show_more_button_url ),
									'id' => 'show_more_button_url',
									'cust_name' => 'show_more_button_url[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
							?>
							<script>
								function property_view<?php echo absint( $property_rand_id ); ?>(view) {
									if (view === 'v2') {
										jQuery('.show_more_switch_field<?php echo absint( $property_rand_id ); ?>').hide();
									} else {
										jQuery('.show_more_switch_field<?php echo absint( $property_rand_id ); ?>').show();
									}
								}
								function show_more_button_count<?php echo absint( $property_rand_id ); ?>(show_more_button_switcher) {
									if (show_more_button_switcher == 'no') {
										jQuery('.show_more_button_dynamic_fields<?php echo absint( $property_rand_id ); ?>').hide();
									} else {
										jQuery('.show_more_button_dynamic_fields<?php echo absint( $property_rand_id ); ?>').show();
									}
								}
								function property_ads_count<?php echo absint( $property_rand_id ); ?>($property_ads_switcher) {
									if ($property_ads_switcher == 'no') {
										jQuery('.property_count_dynamic_fields<?php echo absint( $property_rand_id ); ?>').hide();
									} else {
										jQuery('.property_count_dynamic_fields<?php echo absint( $property_rand_id ); ?>').show();
									}
								}
							</script>
							<?php
							$pagination_options = array( 'no' => wp_rem_plugin_text_srt( 'wp_rem_property_no' ), 'yes' => wp_rem_plugin_text_srt( 'wp_rem_property_yes' ) );
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_members_pagination' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $pagination ),
									'id' => 'pagination',
									'classes' => 'chosen-select-no-single',
									'cust_name' => 'pagination[]',
									'return' => true,
									'options' => $pagination_options
								),
							);

							$wp_rem_html_fields->wp_rem_select_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_members_posts_per_page' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $posts_per_page ),
									'id' => 'posts_per_page',
									'cust_name' => 'posts_per_page[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );


							$wp_rem_cs_opt_array = array(
								'std' => absint( $property_rand_id ),
								'id' => '',
								'cust_id' => 'property_counter',
								'cust_name' => 'property_counter[]',
								'required' => false
							);
							$wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );
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
								'std' => 'wp_rem_properties_with_filters',
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
									'cust_id' => 'wp_rem_properties_with_filters_save',
									'cust_type' => 'button',
									'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
									'classes' => 'cs-wp_rem_cs-admin-btn save_property_types_' . $property_rand_id . ' save_property_locations_' . $property_rand_id . '',
									'cust_name' => 'wp_rem_properties_with_filters_save',
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

	add_action( 'wp_ajax_wp_rem_cs_var_page_builder_wp_rem_properties_with_filters', 'wp_rem_cs_var_page_builder_wp_rem_properties_with_filters' );
}

if ( ! function_exists( 'wp_rem_cs_save_page_builder_data_wp_rem_properties_with_filters_callback' ) ) {

	/**
	 * Save data for wp_wp_rem_properties_with_filters shortcode.
	 *
	 * @param	array $args
	 * @return	array
	 */
	function wp_rem_cs_save_page_builder_data_wp_rem_properties_with_filters_callback( $args ) {

		$data = $args['data'];
		$counters = $args['counters'];
		$widget_type = $args['widget_type'];
		$column = $args['column'];
		$shortcode_data = '';
		if ( $widget_type == "wp_rem_properties_with_filters" || $widget_type == "cs_wp_rem_properties_with_filters" ) {
			$wp_rem_cs_bareber_wp_rem_properties_with_filters = '';

			$page_element_size = $data['wp_rem_properties_with_filters_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_with_filters']];
			$current_element_size = $data['wp_rem_properties_with_filters_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_with_filters']];

			if ( isset( $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] ) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
				$shortcode_str = stripslashes( ( $data['shortcode']['wp_rem_properties_with_filters'][$counters['wp_rem_cs_shortcode_counter_wp_rem_properties_with_filters']] ) );

				$element_settings = 'wp_rem_properties_with_filters_element_size="' . $current_element_size . '"';
				$reg = '/wp_rem_properties_with_filters_element_size="(\d+)"/s';
				$shortcode_str = preg_replace( $reg, $element_settings, $shortcode_str );
				$shortcode_data = $shortcode_str;
				$counters['wp_rem_cs_shortcode_counter_wp_rem_properties_with_filters'] ++;
			} else {
				$element_settings = 'wp_rem_properties_with_filters_element_size="' . htmlspecialchars( $data['wp_rem_properties_with_filters_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_with_filters']] ) . '"';
				$wp_rem_cs_bareber_wp_rem_properties_with_filters = '[wp_rem_properties_with_filters ' . $element_settings . ' ';
				if ( isset( $data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'properties_title="' . htmlspecialchars( $data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['properties_filters_alagnment'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['properties_filters_alagnment'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'properties_filters_alagnment="' . htmlspecialchars( $data['properties_filters_alagnment'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'properties_title_limit="' . htmlspecialchars( $data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'properties_subtitle="' . htmlspecialchars( $data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_view'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_view'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_view="' . htmlspecialchars( $data['property_view'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				
				if ( isset( $data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_type="' . htmlspecialchars( $data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_no_custom_fields="' . htmlspecialchars( $data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				// saving admin field using filter for add on
				$wp_rem_cs_bareber_wp_rem_properties_with_filters = apply_filters( 'wp_rem_save_properties_shortcode_admin_fields', $wp_rem_cs_bareber_wp_rem_properties_with_filters, $_POST, $counters['wp_rem_cs_counter_wp_rem_properties_with_filters'] );
				if ( isset( $data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_featured="' . htmlspecialchars( $data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_ads_switch="' . htmlspecialchars( $data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_price_filter="' . htmlspecialchars( $data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_open_house_filter="' . htmlspecialchars( $data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_ads_after_list_count="' . htmlspecialchars( $data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'posts_per_page="' . htmlspecialchars( $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['pagination'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['pagination'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'pagination="' . htmlspecialchars( $data['pagination'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['show_more_button'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['show_more_button'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'show_more_button="' . htmlspecialchars( $data['show_more_button'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['show_more_button_url'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['show_more_button_url'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'show_more_button_url="' . htmlspecialchars( $data['show_more_button_url'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				if ( isset( $data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= 'property_location="' . htmlspecialchars( $data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . '" ';
				}
				$wp_rem_cs_bareber_wp_rem_properties_with_filters .= ']';
				if ( isset( $data['wp_rem_properties_with_filters_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] ) && $data['wp_rem_properties_with_filters_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']] != '' ) {
					$wp_rem_cs_bareber_wp_rem_properties_with_filters .= htmlspecialchars( $data['wp_rem_properties_with_filters_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_with_filters']], ENT_QUOTES ) . ' ';
				}
				$wp_rem_cs_bareber_wp_rem_properties_with_filters .= '[/wp_rem_properties_with_filters]';
				$shortcode_data .= $wp_rem_cs_bareber_wp_rem_properties_with_filters;
				$counters['wp_rem_cs_counter_wp_rem_properties_with_filters'] ++;
			}
			$counters['wp_rem_cs_global_counter_wp_rem_properties_with_filters'] ++;
		}
		return array(
			'data' => $data,
			'counters' => $counters,
			'widget_type' => $widget_type,
			'column' => $shortcode_data,
		);
	}

	add_filter( 'wp_rem_cs_save_page_builder_data_wp_rem_properties_with_filters', 'wp_rem_cs_save_page_builder_data_wp_rem_properties_with_filters_callback' );
}

if ( ! function_exists( 'wp_rem_cs_load_shortcode_counters_wp_rem_properties_with_filters_callback' ) ) {

	/**
	 * Populate wp_rem_properties_with_filters shortcode counter variables.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_load_shortcode_counters_wp_rem_properties_with_filters_callback( $counters ) {
		$counters['wp_rem_cs_global_counter_wp_rem_properties_with_filters'] = 0;
		$counters['wp_rem_cs_shortcode_counter_wp_rem_properties_with_filters'] = 0;
		$counters['wp_rem_cs_counter_wp_rem_properties_with_filters'] = 0;
		return $counters;
	}

	add_filter( 'wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_properties_with_filters_callback' );
}



if ( ! function_exists( 'wp_rem_cs_element_list_populate_wp_rem_properties_with_filters_callback' ) ) {

	/**
	 * Populate wp_rem_properties_with_filters shortcode strings list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_element_list_populate_wp_rem_properties_with_filters_callback( $element_list ) {
		$element_list['wp_rem_properties_with_filters'] = wp_rem_plugin_text_srt( 'wp_rem_properties_with_filters_heading' );
		return $element_list;
	}

	add_filter( 'wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_properties_with_filters_callback' );
}

if ( ! function_exists( 'wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_with_filters_callback' ) ) {

	/**
	 * Populate wp_rem_properties_with_filters shortcode names list.
	 *
	 * @param	array $counters
	 * @return	array
	 */
	function wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_with_filters_callback( $shortcode_array ) {
		$shortcode_array['wp_rem_properties_with_filters'] = array(
			'title' => wp_rem_plugin_text_srt( 'wp_rem_properties_with_filters_heading' ),
			'name' => 'wp_rem_properties_with_filters',
			'icon' => 'icon-gears',
			'categories' => 'typography',
		);

		return $shortcode_array;
	}

	add_filter( 'wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_with_filters_callback' );
}
