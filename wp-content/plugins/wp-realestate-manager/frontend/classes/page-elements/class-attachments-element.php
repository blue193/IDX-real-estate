<?php
/**
 * File Type: Property Sidebar Map Page Element
 */
if ( ! class_exists( 'wp_rem_attachments_element' ) ) {

	class wp_rem_attachments_element {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_action( 'wp_rem_attachments_html', array( $this, 'wp_rem_attachments_html_callback' ), 11, 1 );
		}

		public function wp_rem_attachments_html_callback( $property_id = '' ) {
			global $post, $wp_rem_plugin_options;
			if ( $property_id == '' ) {
				$property_id = $post->ID;
			}

			$wp_rem_property_type_slug = get_post_meta( $property_id, 'wp_rem_property_type', true );

			$property_type_id = 0;
			if ( $post = get_page_by_path( $wp_rem_property_type_slug, OBJECT, 'property-type' ) ) {
				$property_type_id = $post->ID;
			}
			$wp_rem_full_data = get_post_meta( $property_type_id, 'wp_rem_full_data', true );
			if ( ! isset( $wp_rem_full_data['wp_rem_attachments_options_element'] ) || $wp_rem_full_data['wp_rem_attachments_options_element'] != 'on' ) {
				return false;
			}

			$wp_rem_transaction_property_doc_num = get_post_meta( $property_id, 'wp_rem_transaction_property_doc_num', true );
			$wp_rem_attachments = get_post_meta( $property_id, 'wp_rem_attachments', true );
			$counter = 1;
			if ( isset( $wp_rem_attachments ) && ! empty( $wp_rem_attachments ) ) {
				?>
				<div id="attachments" class="attachment-holder">
					<div class="element-title">
						<h3><?php echo wp_rem_plugin_text_srt('wp_rem_attachments_files'); ?></h3>
					</div>
					<ul class="row">
						<?php
						foreach ( $wp_rem_attachments as $key => $attchment ) {
							if ( $counter <= $wp_rem_transaction_property_doc_num ) {
								if ( isset( $attchment ) && count( $attchment ) > 0 ) {
									extract( $attchment );
								}
								if ( $attachment_file != '' ) {
									$file_url = wp_get_attachment_url( $attachment_file );
									$filet_type = wp_check_filetype( $file_url );
									$filet_type = isset( $filet_type['ext'] ) ? $filet_type['ext'] : '';
									$file_size = $this->getSize( get_attached_file( $attachment_file ) );
									$thumb_url = wp_rem::plugin_url() . '/assets/common/attachment-images/attach-' . $filet_type . '.png';
									?>
									<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<div class="img-holder">
											<figure><a href="<?php echo esc_url( $file_url ); ?>" download="<?php echo esc_html( $attachment_title ); ?>"><img src="<?php echo esc_url( $thumb_url ); ?>" alt=""></a></figure>
										</div>
										<div class="text-holder">
											<?php if ( $attachment_title != '' ) { ?>
												<strong><a href="<?php echo esc_url( $file_url ); ?>" download="<?php echo esc_html( $attachment_title ); ?>"><?php echo esc_html( $attachment_title ); ?></a></strong>
											<?php } ?>
											<ul class="attachment-formats">
												<li><a href="<?php echo esc_url( $file_url ); ?>" download="<?php echo esc_html( $attachment_title ); ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_attachments_downloads'); ?></a></li>
											</ul>
										</div>
									</li>
								<?php } ?>
								<?php
							} $counter ++;
						}
						?>
					</ul>
				</div>
				<?php
			}
		}

		public function getSize( $file ) {
			$bytes = filesize( $file );
			$s = array( 'b', 'Kb', 'Mb', 'Gb' );
			$e = floor( log( $bytes ) / log( 1024 ) );

			return sprintf( '%.2f ' . $s[$e], ($bytes / pow( 1024, floor( $e ) ) ) );
		}

	}

	global $wp_rem_attachments;
	$wp_rem_attachments = new wp_rem_attachments_element();
}