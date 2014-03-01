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

class The_sorter_metaboxes {

	/**
	 * Display common settings metabox's content
	 *
	 * @param $data misc Data passed by add_meta_box() function
	 * @return output string
	 * @since 1.0
	 */
	
	public static function metabox_area_common( $data )
	{
		?>
		
		<p><?php _e( "Required fields are marked with a <strong>star (*)</strong>.", "thsrtr" ); ?></p>
		
		<?php
	}

	/**
	 * Display advanced tags metabox's content
	 *
	 * @param $data misc Data passed by add_meta_box() function
	 * @return output string
	 * @since 1.0
	 */

	public static function metabox_advanced_tags( $data )
	{
		?>
		
		<p><?php _e( "You can use the following tags within the templates to arrange and blend them at taste.", "thsrtr" ); ?></p>
		
		<dl>
			<dt>{items}</dt><dd><?php _e( "The list of items for the area. <em>Only use this in the Main Container Template.</em>", "thsrtr" ); ?></dd>
		</dl>
		<dl>
			<dt>{thumb_s} {thumb_m} {thumb_f}</dt><dd><?php _e( "The URL for the post thumbnail (if supported by your theme), depending on the size you require.<br /><em>s = small</em><br /><em>m = medium</em><br /><em>f = full</em>", "thsrtr" ); ?></dd>
		</dl>
		<dl>
			<dt>{link}</dt><dd><?php _e( "The permanent URL for the post.", "thsrtr" ); ?></dd>
		</dl>
		<dl>
			<dt>{title}</dt><dd><?php _e( "The title of the post.", "thsrtr" ); ?></dd>
		</dl>
		<dl>
			<dt>{excerpt}</dt><dd><?php _e( "A brief extract from the post content, without format.", "thsrtr" ); ?></dd>
		</dl>
		<dl>
			<dt>{date}</dt><dd><?php _e( "Full date of post publish.", "thsrtr" ); ?></dd>
		</dl>
		
		<?php
	}
	
}

?>