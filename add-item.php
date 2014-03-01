<?php
/**
 * Plugin: The Sorter
 * Plugin URI: http://metamorpher.net/the-sorter
 * Description: A drag & drop sorter of posts, for any purpose.
 * Version: 1.0
 * Author: Metamorpher
 * Author URI: http://metamorpher.net/
 * License: GPLv2 or later
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * @author Metamorpher
 * @package the-sorter
 * @since 1.0
 */
?>

	<div id="the_sorter_form" class="wrap">

		<h2><?php _e( "The Sorter", 'thsrtr' ); ?><small><?php _e( "Add item", 'thsrtr' ); ?></small></h2>

		<!-- ADD FORM -->
	
		<?php if( isset( $_GET['area_id'] ) ) : $area = The_sorter_areas::get_area( $_GET['area_id'] ); ?>
	
		<div id="add_item">
		
			<div class="intro">
				<p><?php printf( __( 'To add a new item into the <strong>"%1$s"</strong> area, follow the steps on the left side of this panel.', "thsrtr" ), $area->area_name ); ?></p>
			</div>

			<form action="admin-post.php" method="POST">
			
				<?php wp_nonce_field( 'the_sorter_item' ); ?>
				<input type="hidden" name="action" id="action" value="save_the_sorter_item" />
				<?php if( isset( $area->area_id ) ) : ?><input type="hidden" name="area_id" id="area_id" value="<?php echo $area->area_id; ?>" /><?php endif; ?>
				
				<div class="cut" id="pick-post-type">
					<h2><span class="crimson">1</span><?php _e( "Select the post type", "thsrtr" ); ?></h2>
					<div class="box-izq grad-box">
						<p><?php _e( "What kind of content you want to link to the area.", "thsrtr" ); ?></p>
					</div>
					<div class="center" id="post_types">
						<?php $types = get_post_types( array( 'show_ui' => true ), 'objects' ); foreach( $types AS $element ) : ?>
						<span>
							<input type="radio" name="post_type" id="post_type_<?php echo $element->name; ?>" value="<?php echo $element->name; ?>" />
							<label for="post_type_<?php echo $element->name; ?>"><?php echo $element->label; ?></label>
						</span>
						<?php endforeach; ?>
					</div>
				</div>
			
				<div class="hidden cut" id="pick-post">
					<h2><span class="skyblue">2</span><?php _e( "Select the post", "thsrtr" ); ?></h2>
					<div class="box-izq grad-box">
						<p><?php _e( "Which post you want to reference into the link.", "thsrtr" ); ?></p>
					</div>
					<div class="center v-separation">
						<input type="text" id="post_text" name="post_text" class="combo-text" />
						<button id="post_button" type="button" class="combo-button button">&#x25BC;</button>
						<select id="posts" name="posts"></select>
						<p class="posts-alert"><?php _e( "No entries in this category.", "thsrtr" ); ?></p>
					</div>
				</div>
			
				<div class="cut" id="confirm">
					<div class="center">
						<button type="submit" name="create" id="create-item" class="button button-primary button-large hidden"><?php _e( "Save Item", "thsrtr" ); ?></button>
						<a id="close" class="button button-large" href="?page=<?php echo $_REQUEST['page']; ?>"><?php _e( "Cancel", "thsrtr" ); ?></a>
					</div>
				</div>
			
			</form>
		
		</div>
	
		<?php endif; ?>
	
		<!-- ADD FORM -->
	
	</div>
