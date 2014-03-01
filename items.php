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


class The_sorter_items {

	/**
	 * Display the 'area' form, for adding or editing
	 *
	 * @param object $pagehook add_menu_page object result, for do_meta_boxes() use.
	 * @return output string
	 * @since 1.0
	 */

	public function screen()
	{
		$areas = The_sorter_areas::get_valid_areas(); ?>
		
		<div id="the_sorter_items" class="wrap">
			
			<h2><?php _e( "The Sorter", 'thsrtr' ); ?> <small><?php _e( "Items", 'thsrtr' ); ?></small></h2><br />
			
			<?php if( ! empty( $areas ) ) : ?>
				
			<?php foreach( $areas AS $a ) : $items = $this->get_items( $a->area_id ); ?>

			<div class="area_items" id="<?php echo $a->area_id . "-" . $a->area_slug; ?>">
				<h3><?php echo $a->area_name; ?></h3>
				
				<div class="areas-blocks" id="area-block-<?php echo $a->area_id; ?>">
				
					<?php if( ! empty( $items ) ) :
							foreach( $items AS $i ) :
								$post = get_post( $i->item_post_id );
								$creator = get_userdata( $i->user_creator_id );
								$post_thumb = ( $post->post_type != "attachment" ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( 300, 300 ) ) : wp_get_attachment_image_src( $post->ID, array( 300, 300 ) );
								$post_thumb_bg = ( ! empty( $post_thumb ) ) ? ' style="background-image: url(' . $post_thumb[0] . ')"' : "";
					?>
					
					<div id="item-<?php echo $i->item_id; ?>" class="item-dragger ui-draggable item<?php if( $i->active == 0 ) echo ' item-deactivated'; ?>"<?php echo $post_thumb_bg; ?> title="<?php echo $post->post_title; ?>">
						<div class="item-deactivated-message"><?php _e( "Deactivated", "thsrtr" ); ?></div>
						<input type="hidden" name="item_id_<?php echo $i->item_id; ?>" id="item_id_<?php echo $i->item_id; ?>" value="<?php echo $i->item_id; ?>" />
						<div class="tools">
						<?php if( $i->active == 1 ) : ?>
							<a class="deactivate" href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_item' ); ?>&action=change_the_sorter_item&proceed=deactivate&item_id=<?php echo $i->item_id; ?>"><?php _e( "Deactivate", "thsrtr" ); ?></a>
						<?php else : ?>
							<a class="activate" href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_item' ); ?>&action=change_the_sorter_item&proceed=activate&item_id=<?php echo $i->item_id; ?>"><?php _e( "Activate", "thsrtr" ); ?></a>
						<?php endif; ?>
							<a class="delete" href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_item' ); ?>&action=change_the_sorter_item&proceed=delete&item_id=<?php echo $i->item_id; ?>" data-confirm="<?php _e( "Are you sure you want to delete this item from this area?", "thsrtr" ); ?>"><?php _e( "Delete", "thsrtr" ); ?></a>
						</div>
						<div class="order"><?php echo $i->item_order; ?></div>
						<h3><?php if ( strlen( $post->post_title ) > 35 ) echo substr( $post->post_title, 0, 35 ) . "..."; else echo $post->post_title; ?></h3>
						<div class="info">
							<span><?php echo mysql2date( get_option( 'date_format' ), $post->post_date ); ?></span>
							<span><?php echo ucfirst( $post->post_type ); ?></span>
							<span><a target="_BLANK" href="<?php echo admin_url( 'user-edit.php?user_id=' . $creator->ID ); ?>"><?php echo $creator->user_login; ?></a></span>
						</div>
					</div>

				<?php endforeach; endif; ?>
				
				</div>

				<a class="add-item" title="<?php _e( "Add Item", "thsrtr" ); ?>" href="?page=<?php echo $_REQUEST['page']; ?>&area_id=<?php echo $a->area_id; ?>">+ <?php _e( "Add Item", "thsrtr" ); ?></a>

			</div>

			<?php endforeach; else : ?>
			
			<div id="empty_areas"><?php printf( __( 'You must add an area first. <a href="%s">Click here</a> to do it.', "thsrtr" ), "admin.php?page=the_sorter_areas" ); ?></div>
			
			<?php endif; ?>
		
		</div>
				
		<?php
	}

	/**
	 * Retrieve every item that is associated to the area_id.
	 *
	 * @param int $area_id The area id
	 * @return object The query result
	 * @since 1.0
	 */

	public static function get_items( $area_id )
	{
		global $wpdb;
		return $wpdb->get_results( "SELECT * FROM " . SORTER_TB_ITEMS . " WHERE area_id = " . $area_id . " ORDER BY item_order ASC" );
	}

	/**
	 * Retrieve every item that is associated to the area_id and is activated.
	 *
	 * @param int $area_id The area id
	 * @return object The query result
	 * @since 1.0
	 */

	public static function get_valid_items( $area_id )
	{
		global $wpdb;
		return $wpdb->get_results( "SELECT * FROM " . SORTER_TB_ITEMS . " WHERE area_id = " . $area_id . " AND active = '1' ORDER BY item_order ASC" );
	}
	
	/**
	 * Saves the new item in the assigned area
	 *
	 * @param none
	 * @return boolean
	 * @since 1.0
	 */

	public static function save()
	{
		global $wpdb;
		
		check_admin_referer( 'the_sorter_item' );

		if( ! empty( $_POST['area_id'] ) AND ! empty( $_POST['post_type'] ) AND ! empty( $_POST['posts'] ) )
		{
			$_POST['date_created'] = current_time( 'mysql' );
			$_POST['user_creator_id'] = get_current_user_id();
			
			$wpdb->insert( SORTER_TB_ITEMS, array(
				'area_id' 			=> $_POST['area_id'],
				'user_creator_id' 	=> $_POST['user_creator_id'],
				'date_created' 		=> $_POST['date_created'],
				'item_order' 		=> self::check_item_order(),
				'item_post_id' 		=> $_POST['posts'],
				'item_post_type'	=> $_POST['post_type']
			) );
		}
		
		wp_redirect( "admin.php?page=the_sorter" );
	}
	
	/**
	 * Changes the state of an item, or delete it on call
	 *
	 * @param none
	 * @return boolean
	 * @since 1.0
	 */

	public static function change()
	{
		global $wpdb;

		//cross check the given referer
		check_admin_referer( 'change_the_sorter_item' );
		
		$date_modified = current_time( 'mysql' );
		$user_modifier_id = get_current_user_id();
		
		switch( $_GET['proceed'] )
		{
			case 'deactivate': $wpdb->update( SORTER_TB_ITEMS, array( 'active' => 0, 'user_modifier_id' => $user_modifier_id, 'date_modified' => $date_modified ), array( 'item_id' => $_GET['item_id'] ) ); break;
			case 'activate': $wpdb->update( SORTER_TB_ITEMS, array( 'active' => 1, 'user_modifier_id' => $user_modifier_id, 'date_modified' => $date_modified ), array( 'item_id' => $_GET['item_id'] ) ); break;
			case 'delete':
				$query_delete_items = "DELETE FROM " . SORTER_TB_ITEMS . " WHERE item_id = " . $_GET['item_id'];
				$wpdb->query( $query_delete_items );
				break;
		}
		
		wp_redirect( 'admin.php?page=the_sorter' );
	}
	
	/**
	 * Defines item order according the current placement of rows in the DB.
	 *
	 * @param none
	 * @return output
	 * @since 1.0
	 */

	public static function check_item_order()
	{
		global $wpdb;
		
		if( empty( $_POST ) ) return false;

		$slides_count = $wpdb->get_var( "SELECT COUNT(*) FROM ". SORTER_TB_ITEMS . " WHERE area_id = " . $_POST['area_id'] );

		if( $slides_count == 0 )
		{
			return 1;
		}
		else
		{
			$select_query = $wpdb->get_row( "SELECT * FROM " . SORTER_TB_ITEMS . " WHERE area_id = " . $_POST['area_id'] . " ORDER BY item_order DESC" );
			$suma = ( $select_query->item_order + 1 );
			return $suma;
		}
	}
	

}