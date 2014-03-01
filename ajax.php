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

class The_sorter_ajax {
	
	/**
	 * Class constructor
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */
	
	public function __construct()
	{
		add_action( 'wp_ajax_deliver_posts_list', array( &$this, 'deliver_posts_list' ) );
		add_action( 'wp_ajax_reorder_items', array( &$this, 'reorder_items' ) );
	}
		
	/**
	 * Get posts to populate select in the add_item.php file.
	 *
	 * @param none
	 * @return output
	 * @since 1.0
	 */
	
	function deliver_posts_list()
	{
		if( empty( $_POST ) )
		{
			echo 0;
			die();
		}

		$posts = get_posts( array(
			'numberposts' 	=> -1,
			'orderby'		=> 'title',
			'post_type'		=> $_POST['post_type']
		));
		
		if( isset( $posts ) AND ! empty( $posts ) )
		{
			$return = array();
			foreach( $posts AS $p )
			{
				$return[$p->ID] = $p->post_title;
			}
			if( ! empty( $return ) )
			{
				echo json_encode( $return );
				die();
			}
			else
			{
				echo 0;
				die();
			}
		}
	}
		
	/**
	 * Updates the order of items in the database according their current positions in the list.
	 *
	 * @param none
	 * @return output
	 * @since 1.0
	 */

	public static function reorder_items()
	{
		global $wpdb;
		
		unset( $_POST['action'] );

		if( ! is_array( $_POST['items'] ) AND empty( $_POST['items'] ) AND empty( $_POST ) )
		{
			echo 0;
			die();
		}

		foreach( $_POST['items'] AS $k => $v )
		{
			if( $wpdb->update( 
				SORTER_TB_ITEMS, 
				array(
					'item_order' => $v,
					'user_modifier_id' => get_current_user_id(),
					'date_modified' => current_time( 'mysql' )
				), 
				array(
					'item_id' => $k
				)
			) )
			{
				$ready = true;
			}
			else
			{
				$ready = false;
			}
		}

		if( $ready )
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		
		die();
	}
		
}

$the_sorter_ajax = new The_sorter_ajax;

?>