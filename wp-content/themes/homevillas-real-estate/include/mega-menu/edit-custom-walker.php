<?php

/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu {

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		
	}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;

		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_invalid' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_pending' ), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;

		$item_categories = isset( $item->categories ) ? $item->categories : '';

		if ( ! is_array( $item_categories ) ) {
			$item_categories = array();
		}
		?>
		<li id="menu-item-<?php echo absint( $item_id ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
							echo wp_nonce_url(
									add_query_arg(
											array(
								'action' => 'move-up-menu-item',
								'menu-item' => $item_id,
											), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									), 'move-menu_item'
							);
							?>" class="item-move-up" aria-label="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_move_up'); ?>">&#8593;</a>
							|
							<a href="<?php
							echo wp_nonce_url(
									add_query_arg(
											array(
								'action' => 'move-down-menu-item',
								'menu-item' => $item_id,
											), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									), 'move-menu_item'
							);
							?>" class="item-move-down" aria-label="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_move_down'); ?>">&#8595;</a>
						</span>
						<a class="item-edit" id="edit-<?php echo absint( $item_id ); ?>" title="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_edit_menu_item'); ?>" href="<?php
						echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_edit_menu_item'); ?></a>
					</span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo absint( $item_id ); ?>">
				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo absint( $item_id ); ?>">
							<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_url'); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo absint( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_navi_label'); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo absint( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_title_attr'); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo absint( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo absint( $item_id ); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo absint( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo absint( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_open_link_new_tab'); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_css_classes'); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo absint( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_link_relationship'); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo absint( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_description'); ?><br />
						<textarea id="edit-menu-item-description-<?php echo absint( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo absint( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped                                          ?></textarea>
						<span class="description"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_item_description_hint'); ?></span>
					</label>
				</p>        
				<?php
				/* New fields insertion starts here */
				?>
				<p class="field-custom description description-wide custom_onof">
					<label class="pbwp-checkbox" for="edit-menu-item-megamenu-<?php echo intval( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_active_mega_menu'); ?><br />
						<input type="hidden" value="off" name="cs_title_switch">
						<input type="checkbox" id="edit-menu-item-megamenu-<?php echo intval( $item_id ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-megamenu[<?php echo intval( $item_id ); ?>]" <?php
						if ( esc_attr( $item->megamenu ) == 'on' ) {
							echo 'checked="checked"';
						}
						?>>
						<span class="pbwp-box"></span>
					</label> 
				</p>
				<p class="field-view description description-wide" style="display:none;">
					<label for="edit-menu-item-view-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_mega_menu_view'); ?><br />
						<select id="edit-menu-item-view-<?php echo absint( $item_id ); ?>" onchange="wp_rem_cs_menu_view_select(this.value, '<?php echo absint( $item_id ); ?>')" class="widefat edit-menu-item-view" name="menu-item-view[<?php echo absint( $item_id ); ?>]">
							<option selected="selected" value="simple"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_mega_menu_view_simple'); ?></option>
						</select>
					</label>
				</p>
				<p id="field-cat-title-<?php echo absint( $item_id ); ?>" class="field-cat-title description description-wide" style="display: none;">
					<label for="edit-menu-item-cat-title-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title'); ?><br />
						<input type="text" id="edit-menu-item-cat-title-<?php echo absint( $item_id ); ?>" class="widefat code edit-menu-item-cat-title" name="menu-item-cat-title[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->cat_title ); ?>" />
					</label>
				</p>
				<p id="field-item-categories-<?php echo absint( $item_id ); ?>" class="field-categories description description-wide" style="display: none;">
					<label for="edit-menu-item-categories-<?php echo absint( $item_id ); ?>">
						<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_categories'); ?><br />
						<select id="edit-menu-item-categories-<?php echo absint( $item_id ); ?>" multiple class="widefat edit-menu-item-categories" name="menu-item-categories[<?php echo absint( $item_id ); ?>][]">
							<option value=""><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_select_categories'); ?></option>
							<?php
							$post_categories = get_categories();
							if ( is_array( $post_categories ) && sizeof( $post_categories ) > 0 ) {
								foreach ( $post_categories as $post_category ) {
									?>
									<option <?php echo in_array( $post_category->slug, $item_categories ) ? 'selected' : '' ?> value="<?php echo esc_html( $post_category->slug ); ?>" ><?php echo esc_html( $post_category->name ); ?></option>
									<?php
								}
							}
							?>
						</select>
					</label>
				</p>
				<?php
				/* New fields insertion ends here */
				?>
				<div class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_original' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo absint( $item_id ); ?>" href="<?php
					echo wp_nonce_url(
							add_query_arg(
									array(
						'action' => 'delete-menu-item',
						'menu-item' => $item_id,
									), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
							), 'delete-menu_item_' . $item_id
					);
					?>"><?php echo wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_remove' ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo absint( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
					?>#menu-item-settings-<?php echo absint( $item_id ); ?>"><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_cancel'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo absint( $item_id ); ?>]" value="<?php echo absint( $item_id ); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo absint( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}

	}
	