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

class The_sorter_widget extends WP_Widget {

	/**
	 * Constructor for the widget class
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */
	
	public function __construct()
	{
		$widget_ops = array( 'classname' => 'the_sorter', 'description' => __( "Display a select area from the sorter into a sidebar", "thsrtr" ) );
		$this->WP_Widget( 'the_sorter', __( "The Sorter", "thsrtr" ), $widget_ops );
	}

	/**
	 * Widget initializer. Used in the plugin constructor to define the widget 'instantiator' 
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public static function widget_init()
	{
		register_widget( "The_sorter_widget" );
	}

	/**
	 * The form with the widget's instance options
	 *
	 * @param array $instance The data saved in a global instance array
	 * @return none
	 * @since 1.0
	 */

	function form( $instance )
	{
		$areas = The_sorter_areas::get_valid_areas();
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'area_id' => '',
			'limit' => ''
		) );
		$title = $instance['title'];
		$area_id = $instance['area_id'];
		$limit = $instance['limit'];
		
		if( ! empty( $areas ) ) :
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="width: 40px; display: inline-block;"><?php _e( "Title", "thsrtr" ); ?>:</label>
			<input 
				type="text"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				value="<?php echo esc_attr( $title ); ?>"
			/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'area_id' ); ?>" style="width: 40px; display: inline-block;"><?php _e( "Area", "thsrtr" ); ?>:</label>
			<select  id="<?php echo $this->get_field_id( 'area_id' ); ?>" name="<?php echo $this->get_field_name( 'area_id' ); ?>" >
				<option><?php _e( "Choose an area", "thsrtr" );  ?></option>
			<?php foreach( $areas AS $a ) : ?>
			
				<option value="<?php echo $a->area_id; ?>" <?php selected( $a->area_id, esc_attr( $area_id ) ); ?>><?php echo $a->area_name; ?></option>
			
			<?php endforeach; ?>
			
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>" style="width: 40px; display: inline-block;"><?php _e( "Limit", "thsrtr" ); ?>:</label>
			<input type="number" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $limit ); ?>" style="width: 60px" />
			<small><?php _e( "Only numbers", "thsrtr" ); ?></small>
		</p>
		
		<?php else : ?>
			
		<p><?php _e( "You must add some areas first to use this widget.", "thsrtr" ); ?></p>

		<?php endif;
	}

	/**
	 * Instance savior callback.
	 *
	 * @param array $new_instance New data to be stored
	 * @param array $old_instance Old data to be compared
	 * @return array $instance
	 * @since 1.0
	 */

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['area_id'] = $new_instance['area_id'];
		$instance['limit'] = $new_instance['limit'];
		return $instance;
	}

	/**
	 * Display the widget instance where it belongs
	 *
	 * @param array $args Arguments
	 * @param array $instance The data of the instance
	 * @return none
	 * @since 1.0
	 */

	function widget( $args, $instance )
	{
		$area = The_sorter_areas::get_valid_areas( $instance['area_id'] );
		
		if( ! empty( $area ) )
		{
			extract( $args, EXTR_SKIP );
			echo $before_widget;
			$title = empty( $instance['title'] ) ? NULL : apply_filters( 'widget_title', $instance['title'] );
			$limit = (int)$instance['limit'];
			$limit = ( $limit <= 0 ) ? FALSE : $limit;
			if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
			echo The_sorter::show_area( $instance['area_id'], $limit );
			echo $after_widget;
		}
	}
	
}