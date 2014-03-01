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


class The_sorter_areas {

	/**
	 * Display the 'area' form, for adding or editing
	 *
	 * @param object $pagehook add_menu_page object result, for do_meta_boxes() use.
	 * @return output string
	 * @since 1.0
	 */
	
	public function screen( $pagehook )
	{
		$area = ( isset( $_GET['area_id'] ) ) ? $this->get_area( $_GET['area_id'] ) : FALSE;
		?>

		<div id="the_sorter_list" class="wrap">
			<?php $this->areas_list(); ?>

		</div>

		<div id="the_sorter_form" class="wrap">

			<h2>
				<?php _e( "The Sorter", 'thsrtr' ); ?>
				<small><?php echo ( empty( $area ) ) ? __( "Add area", 'thsrtr' ) : __( "Edit area", 'thsrtr' ); ?></small>
				<a href="?page=the_sorter_areas" class="add-new-h2"><?php _e( "Add new", "thsrtr" );  ?></a>
			</h2>

			<form action="admin-post.php" method="POST">
				
				<?php if( ! empty ( $_GET['error'] ) ) : ?><p class="advice"><?php _e( "There was an error during area saving. Try again.", "thsrtr" ); ?></p><?php endif; ?>
					
				<?php wp_nonce_field( 'the_sorter_areas' ); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
				<input type="hidden" name="action" id="action" value="save_the_sorter_area" />
				<?php if( ! empty( $area ) ) : ?><input type="hidden" name="area_id" id="area_id" value="<?php echo $area->area_id; ?>" /><?php endif; ?>
				
				<div id="poststuff" class="metabox-holder has-right-sidebar">
					<div id="side-info-column" class="inner-sidebar">
						<?php do_meta_boxes( $pagehook, 'side', false ); ?>

					</div>
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content">

							<table class="add-area" cellspacing="0" cellpadding="0">
								<col width="130" />
								<tr>
									<td><label for="area_name"><?php _e( "Area name", "thsrtr" ); ?> *</label></td>
									<td><input type="text" name="area_name" id="area_name" placeholder="<?php _e( "Enter area name", "thsrtr" ); ?>" value="<?php echo ( isset( $area->area_name ) ) ? $area->area_name : ""; ?>" /></td>
								</tr>
							</table>

							<h2><?php _e( "Advanced Options", "thsrtr" ); ?></h2>
							<p class="advice"><?php _e( "<strong>ADVICE:</strong> Proceed only if you have any HTML knowledge."); ?></p>

							<table class="add-area" cellspacing="0" cellpadding="0">
								<col width="130" />
								<tr>
									<td><label for="area_main_container_template"><?php _e( "Main Container Template", "thsrtr" ); ?> *</label></td>
									<td>
										<textarea name="area_main_container_template" id="area_main_container_template" class="code" rows="7"><?php
											if( ! empty( $area->area_main_container_template ) )
												echo stripslashes( $area->area_main_container_template );
											else
												print "<ul class=\"posts-list\">\n\t{items}\n</ul>";
										?></textarea>
									</td>
								</tr>
								<tr>
									<td><label for="area_item_template"><?php _e( "Item Template", "thsrtr" ); ?> *</label></td>
									<td>
										<textarea name="area_item_template" id="area_item_template" class="code" rows="7"><?php
											if( ! empty( $area->area_item_template ) )
												echo stripslashes( $area->area_item_template );
											else
												print "<li class=\"posts-list-item\">\n\t<img src=\"{thumb_m}\" class=\"thumbnail\" />\n\t<h3><a href=\"{link}\">{title}</a></h3>\n\t<p>{excerpt}</p>\n</li>";
										?></textarea>
									</td>
								</tr>
							</table>
							
							<p><button class="button button-primary button-large"><?php _e( "Save Area" ); ?></button></p>
							
						</div>
					</div>
				<br class="clear"/>
				</div>
			</form>
		</div>

		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );

				// postboxes setup
				postboxes.add_postbox_toggles( '<?php echo $pagehook; ?>' );
				
				$( ".trash a" ).click(function(){
					if( confirm( '<?php _e( "Are you sure you want to delete this area? It will also delete all items within.", "thsrtr" ); ?>' ) )
					{
						window.location = $( this ).attr( "href" );
					}
					
					return false;
				});
				
				
				show_code = function( element )
				{
					$( "#" + element ).slideToggle();
				};
			});
			//]]>
		</script>
		<?php
	}

	/**
	 * Display the Areas' list
	 *
	 * @param none
	 * @return output string
	 * @since 1.0
	 */

	public function areas_list()
	{
		$areas = $this->get_area();
		
		if( ! empty( $areas ) ) :
		?>
			
			<h2><?php _e( "The Sorter", 'thsrtr' ); ?> <small><?php _e( "Areas", 'thsrtr' ); ?></small></h2><br />

			<table class="wp-list-table widefat fixed posts" cellspacing="0">
				<col width="45%" />
				<thead>
					<tr>
						<th><?php _e( "Name", "thsrtr" ); ?></th>
						<th><?php _e( "# of Items", "thsrtr" ); ?></th>
						<th><?php _e( "Created", "thsrtr" ); ?></th>
						<th><?php _e( "Last Modify", "thsrtr" ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><?php _e( "Name", "thsrtr" ); ?></th>
						<th><?php _e( "# of Items", "thsrtr" ); ?></th>
						<th><?php _e( "Created", "thsrtr" ); ?></th>
						<th><?php _e( "Last Modify", "thsrtr" ); ?></th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach( $areas AS $k => $a ) : $creator = get_user_by( 'id', $a->user_creator_id ); $modifier = get_user_by( 'id', $a->user_modifier_id ); ?>
					<tr<?php echo ( ( $k % 2 ) == 0 ) ? ' class="alternate"' : ""; ?>>
						<td>
							<strong><?php echo $a->area_name; ?> <?php if( $a->active == 0 ) : ?><span class="deactivated">(<?php _e( "Deactivated", "thsrtr" ); ?>)</em><?php endif; ?></strong>
							<div class="row-actions">
								<span class="edit"><a href="?page=the_sorter_areas&area_id=<?php echo $a->area_id; ?>#the_sorter_form"><?php _e( "Edit", "thsrtr" ); ?></a></span> |
								<?php if( $a->active == 1 ) : ?><span class="deactivate"><a href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_area' ); ?>&action=change_the_sorter_area&proceed=deactivate&area_id=<?php echo $a->area_id; ?>"><?php _e( "Deactivate", "thsrtr" ); ?></a></span> |<?php endif; ?>
								<?php if( $a->active == 0 ) : ?><span class="activate"><a href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_area' ); ?>&action=change_the_sorter_area&proceed=activate&area_id=<?php echo $a->area_id; ?>"><?php _e( "Activate", "thsrtr" ); ?></a></span> |<?php endif; ?>
								<span class="trash"><a href="<?php echo wp_nonce_url( 'admin-post.php', 'change_the_sorter_area' ); ?>&action=change_the_sorter_area&proceed=delete&area_id=<?php echo $a->area_id; ?>"><?php _e( "Delete", "thsrtr" ); ?></a></span> |
								<span><a href="#" onclick="show_code('code-<?php echo $a->area_id; ?>');"><?php _e( "View Code", "thsrtr" ); ?></a></span>
							</div>

							<div id="code-<?php echo $a->area_id; ?>" class="hidden postbox" style="margin: 5px 0 5px">
								<div class="inside">
									<p><?php _e( "Place this code wherever within your themes:", "thsrtr" ); ?></p>
									<input type="text" class="code" value="&lt;?php print $the_sorter->show_area(<?php echo $a->area_id; ?>); ?>" size="45" style="padding: 5px; margin-bottom: 8px" />
									<p><?php _e( "<strong>or</strong> place this shortcode wherever within your posts:", "thsrtr" ); ?></p>
									<input type="text" class="code" value='[the_sorter area="<?php echo $a->area_id; ?>"]' size="25" style="padding: 5px" />
								</div>
							</div>
						</td>
						<td><?php echo $this->count_items( $a->area_id ); ?></td>
						<td><?php echo mysql2date( "d/m/Y H:i:s", $a->date_created ); ?><br /><em><a href="user-edit.php?user_id=<?php echo $creator->ID; ?>"><?php echo $creator->first_name . " " . $creator->last_name; ?></a></em></td>
						<td><?php if( ! empty( $a->date_modified ) ) : echo mysql2date( "d/m/Y H:i:s", $a->date_modified ); ?><br /><em><a href="user-edit.php?user_id=<?php echo $modifier->ID; ?>"><?php echo $modifier->first_name . " " . $modifier->last_name; ?></a></em><?php endif; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<br /><br />
			
		<?php endif;
	}

	/**
	 * The saving function, associated to the 'admin_post_save_the_sorter_area' action declared in the constructor of the main class.
	 * It is used for POST functions, like adding and updating the item.
	 * 
	 * @param none
	 * @return none
	 * @since 1.0
	 */
	
	public static function save()
	{
		global $wpdb;

		//cross check the given referer
		check_admin_referer( 'the_sorter_areas' );
		
		if( ! empty( $_POST['area_name'] ) AND ! empty( $_POST['area_main_container_template'] ) AND ! empty( $_POST['area_item_template'] ) )
		{
			if( ! isset( $_POST['area_id'] ) )
			{
				$_POST['area_slug'] = sanitize_title( $_POST['area_name'] );
				$_POST['date_created'] = current_time( 'mysql' );
				$_POST['user_creator_id'] = get_current_user_id();

				$data = $_POST;
				unset( $data['_wpnonce'], $data['_wp_http_referer'], $data['closedpostboxesnonce'], $data['meta-box-order-nonce'], $data['action'] );

				$wpdb->insert( SORTER_TB_AREAS, $data );
				
				$row_id = $wpdb->insert_id;
			}
			else
			{
				$_POST['area_slug'] = sanitize_title( $_POST['area_name'] );
				$_POST['date_modified'] = current_time( 'mysql' );
				$_POST['user_modifier_id'] = get_current_user_id();

				$data = $_POST;
				unset( $data['_wpnonce'], $data['_wp_http_referer'], $data['closedpostboxesnonce'], $data['meta-box-order-nonce'], $data['action'], $data['area_id'] );

				$wpdb->update( SORTER_TB_AREAS, $data, array( 'area_id' => $_POST['area_id'] ) );
				
				$row_id = $_POST['area_id'];
			}
			
			$wpdb->flush();
			wp_redirect( "admin.php?page=the_sorter_areas&area_id=" . $row_id );
		}
		else
		{
			wp_redirect( "admin.php?page=the_sorter_areas&error=1" . ( ( ! empty( $_POST['area_id'] ) ) ? "&area_id=" . $_POST['area_id'] : "" ) );
		}
	}

	/**
	 * The saving function, associated to the 'admin_post_change_the_sorter_area' action declared in the constructor of the main class.
	 * It is used for GET actions, like pick edit object, activate, deactivate and delete the item.
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public static function change()
	{
		global $wpdb;

		//cross check the given referer
		check_admin_referer( 'change_the_sorter_area' );
		
		switch( $_GET['proceed'] )
		{
			case 'deactivate': $wpdb->update( SORTER_TB_AREAS, array( 'active' => 0 ), array( 'area_id' => $_GET['area_id'] ) ); break;
			case 'activate': $wpdb->update( SORTER_TB_AREAS, array( 'active' => 1 ), array( 'area_id' => $_GET['area_id'] ) ); break;
			case 'delete':
				$query_delete_area = "DELETE FROM " . SORTER_TB_AREAS . " WHERE area_id = " . $_GET['area_id'];
				$query_delete_items = "DELETE FROM " . SORTER_TB_ITEMS . " WHERE area_id = " . $_GET['area_id'];
				$wpdb->query( $query_delete_area );
				$wpdb->flush();
				$wpdb->query( $query_delete_items );
				$wpdb->flush();
				break;
		}
		
		wp_redirect( 'admin.php?page=the_sorter_areas' );
	}

	/**
	 * A function to retrieve data from areas. If the parameter is set, then it gets that specific area.
	 * If it's not set, then the function gets every area in the table.
	 *
	 * @param int $area_id (optional) The area id
	 * @return object The query result
	 * @since 1.0
	 */

	public static function get_area( $area_id = null )
	{
		global $wpdb;
		
		if( ! empty( $area_id ) )
		{
			return $wpdb->get_row( "SELECT * FROM " . SORTER_TB_AREAS . " WHERE area_id = $area_id" );
		}
		else
		{
			return $wpdb->get_results( "SELECT * FROM " . SORTER_TB_AREAS . " ORDER BY area_id DESC" );
		}
	}

	/**
	 * The function that retrieves all valid areas in the table (or by id)
	 *
	 * @param int $area_id (optional) The area id
	 * @return object The query result
	 * @since 1.0
	 */

	public static function get_valid_areas( $area_id = null )
	{
		global $wpdb;

		if( ! empty( $area_id ) )
		{
			return $wpdb->get_row( "SELECT * FROM " . SORTER_TB_AREAS . " WHERE area_id = " . $area_id . " AND active = 1" );
		}
		else
		{
			return $wpdb->get_results( "SELECT * FROM " . SORTER_TB_AREAS . " WHERE active = 1 ORDER BY area_id DESC" );
		}
	}

	/**
	 * Count the number of items associated to that specific area.
	 *
	 * @param int $area_id The area id
	 * @return int The number of elements according to the query
	 * @since 1.0
	 */

	public function count_items( $area_id )
	{
		global $wpdb;
		$wpdb->get_results( "SELECT area_id FROM " . SORTER_TB_ITEMS . " WHERE area_id = " . $area_id );
		return $wpdb->num_rows;
	}
	
}

?>