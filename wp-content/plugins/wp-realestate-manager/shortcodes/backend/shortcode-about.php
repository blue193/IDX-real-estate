<?php
/**
 * File Type: About Shortcode
 */
if ( ! class_exists( 'Wp_rem_Shortcode_About' ) ) {

	class Wp_rem_Shortcode_About {

		/**
		 * Constant variables
		 */
		var $PREFIX = 'wp_rem_about';

		/**
		 * Start construct Functions
		 */
		public function __construct() {

			add_filter( 'wp_rem_shortcodes_list', array( $this, 'wp_rem_field_button_option' ), 11, 1 );
			add_action( 'wp_ajax_wp_rem_shortcode_wp_rem_about', array( $this, 'wp_rem_shortcode_wp_rem_about_callback' ) );
		}

		/*
		 * Add this shortcode option in shortcode button.
		 */

		public function wp_rem_field_button_option( $shortcode_array ) {

			$shortcode_array['wp_rem_about'] = array(
				'title' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_heading' ),
				'name' => 'wp_rem_about',
				'icon' => 'icon-table',
				'categories' => 'loops misc',
			);

			return $shortcode_array;
		}

		/*
		 * Shortcode backend fields.
		 */

		public function wp_rem_shortcode_wp_rem_about_callback() {
			global $post, $wp_rem_html_fields, $wp_rem_form_fields;
			$shortcode_element = '';
			$filter_element = 'filterdrag';
			$shortcode_view = '';
			$output = array();
			$counter = $_POST['counter'];
			$wp_rem_counter = $_POST['counter'];
			$album_num = 0;
			if ( isset( $_POST['action'] ) && ! isset( $_POST['shortcode_element_id'] ) ) {
				$POSTID = '';
				$shortcode_element_id = '';
			} else {
				$POSTID = $_POST['POSTID'];
				$shortcode_element_id = $_POST['shortcode_element_id'];
				$shortcode_str = stripslashes( $shortcode_element_id );
				$PREFIX = $this->PREFIX;
				$parseObject = new ShortcodeParse();
				$output = $parseObject->wp_rem_shortcodes( $output, $shortcode_str, true, $PREFIX );
			}
			$defaults = array( 'title' => '', 'about_url' => '', 'bg_color' => '', 'text_color' => '', 'image_about_url' => '', 'button_text' => '', 'content', '', 'about_action_textarea' => '' );
			if ( isset( $output['0']['atts'] ) ) {
				$atts = $output['0']['atts'];
			} else {
				$atts = array();
			}
			if ( isset( $output['0']['content'] ) ) {
				$atts_content = $output['0']['content'];
			} else {
				$atts_content = array();
			}
			if ( is_array( $atts_content ) ) {
				$album_num = count( $atts_content );
			}
			$about_element_size = '100';
			foreach ( $defaults as $key => $values ) {
				if ( isset( $atts[$key] ) ) {
					$$key = $atts[$key];
				} else {
					$$key = $values;
				}
			}
			$name = 'wp_rem_pb_about';
			$coloumn_class = 'column_' . $about_element_size;
			if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
				$shortcode_element = 'shortcode_element_class';
				$shortcode_view = 'cs-pbwp-shortcode';
				$filter_element = 'ajax-drag';
				$coloumn_class = '';
			}
			$content_texarea = isset( $atts['content'] ) ? $atts['content'] : '';
			$wp_rem_image_url = isset( $atts['about_url'] ) ? $atts['about_url'] : '';
			$wp_rem_text_color = isset( $atts['text_color'] ) ? $atts['text_color'] : '';
			$wp_rem_bg_color = isset( $atts['bg_color'] ) ? $atts['bg_color'] : '';
			?>

			<div id="<?php echo esc_attr( $name . $wp_rem_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?> <?php echo esc_attr( $shortcode_view ); ?>" item="about" data="" >
				<div class="cs-wrapp-class-<?php echo intval( $wp_rem_counter ) ?> <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_counter ) ?>" data-shortcode-template="[<?php echo esc_attr( $this->PREFIX ); ?> {{attributes}}]{{content}}[/<?php echo esc_attr( $this->PREFIX ); ?>]" style="display: none;">
					<div class="cs-heading-area">
						<h5><?php echo wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_options' ); ?></h5>
						<a href="javascript:removeoverlay('<?php echo esc_js( $name . $wp_rem_counter ) ?>','<?php echo esc_js( $filter_element ); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
					<div class="cs-pbwp-content">
						<div class="cs-wrapp-clone cs-shortcode-wrapp">
							<?php
							if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
								
							}
							?>
							<?php
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_element_title' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_element_title_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => '',
									'id' => 'title',
									'cust_name' => 'title[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_button_url' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_url( $about_url ),
									'id' => 'about_url[]',
									'cust_name' => 'about_url[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_button_text' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_html( $button_text ),
									'id' => 'button_text',
									'cust_name' => 'button_text[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_button_color' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_button_color_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $wp_rem_text_color ),
									'cust_id' => '',
									'classes' => 'bg_color',
									'cust_name' => 'text_color[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_bg_color' ),
								'desc' => '',
								'label_desc' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_bg_color_hint' ),
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $wp_rem_bg_color ),
									'cust_id' => '',
									'classes' => 'bg_color',
									'cust_name' => 'bg_color[]',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_about_content' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_html( $content_texarea ),
									'id' => 'content_texarea',
									'cust_name' => 'content[]',
									'wp_rem_editor' => true,
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_textarea_field( $wp_rem_opt_array );
							?>
						</div>
						<?php if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
							<ul class="form-elements insert-bg">
								<li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js( str_replace( 'wp_rem_pb_', '', $name ) ); ?>', '<?php echo esc_js( $name . $wp_rem_counter ) ?>', '<?php echo esc_js( $filter_element ); ?>')" ><?php echo wp_rem_plugin_text_srt( 'wp_rem_insert' ); ?></a> </li>
							</ul>
							<div id="results-shortocde"></div>
						<?php } else { ?>
							<?php
							$wp_rem_opt_array = array(
								'std' => 'about',
								'id' => '',
								'before' => '',
								'after' => '',
								'classes' => '',
								'extra_atr' => '',
								'cust_id' => '',
								'cust_name' => 'orderby[]',
								'return' => true,
								'required' => false
							);
							echo wp_rem_special_char( $wp_rem_form_fields->wp_rem_form_hidden_render( $wp_rem_opt_array ) );
							?>
							<?php
							$wp_rem_opt_array = array(
								'name' => '',
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => wp_rem_plugin_text_srt( 'wp_rem_save' ),
									'cust_id' => '',
									'cust_type' => 'button',
									'classes' => 'cs-admin-btn',
									'cust_name' => '',
									'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
									'return' => true,
								),
							);

							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
							?>               
						<?php } ?>
						<script>
			                /* modern selection box function */
			                jQuery(document).ready(function ($) {
			                    chosen_selectionbox();
			                });
			                /* modern selection box function */
						</script>
					</div>
				</div>
			</div>
			<?php
			wp_die();
		}
	}
	global $wp_rem_shortcode_about;
	$wp_rem_shortcode_about = new Wp_rem_Shortcode_About();
}
