<?php
/**
 * Plugin Name: The Sorter
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

require_once( 'settings.php' );
require_once( 'areas.php' );
require_once( 'items.php' );
require_once( 'metaboxes.php' );
require_once( 'widget.php' );
require_once( 'ajax.php' );

class The_sorter {
	
	var $areas = FALSE;					// Global class object for 'Area' Object
	var $items = FALSE;					// Global class object for 'Item' Object
	
	var $pagehook = FALSE;				// Global class object for 'Area Page' Object
	var $pagehook_items = FALSE;		// Global class object for 'Item' Object
	var $pagehook_howto = FALSE;		// Global class object for 'How To' Object
	
	/**
	 * Object Constructor
	 *
	 * @param none
	 * @return none
	 * @since 
	 */
	
	public function __construct()
	{
		// Installer and uninstaller
		register_activation_hook( __FILE__, array( &$this, 'install' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'uninstall' ) );
		
		// Create the admin menu item for the plugin
		add_action( 'admin_init', array( &$this, 'register_elements' ) );
	
		// Create the admin menu item for the plugin
		add_action( 'admin_menu', array( &$this, 'build_menu' ) );
				
		// Register the save for areas
		add_action( 'admin_post_save_the_sorter_area', array( 'The_sorter_areas', 'save' ) );

		// Register the change for areas
		add_action( 'admin_post_change_the_sorter_area', array( 'The_sorter_areas', 'change' ) );
		
		// Register the save for items
		add_action( 'admin_post_save_the_sorter_item', array( 'The_sorter_items', 'save' ) );

		// Register the change for items
		add_action( 'admin_post_change_the_sorter_item', array( 'The_sorter_items', 'change' ) );
		
		// Add the shortcode for areas
		add_shortcode( 'the_sorter', array( &$this, 'show_area_shortcode' ) );
		
		$this->areas = new The_sorter_areas();
		$this->items = new The_sorter_items();
		
		// Load the text domain.
		load_plugin_textdomain( 'thsrtr', FALSE, plugin_basename( dirname( __FILE__ ) ) . '/lang/' );
		
		// Widget init
		add_action( 'widgets_init', array( 'The_sorter_widget', 'widget_init' ) );
	}

	/**
	 * DB Installation
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function install()
	{
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		if( ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE \'%1$s\'', SORTER_TB_AREAS ) ) != SORTER_TB_AREAS ) AND
		 	( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE \'%1$s\'', SORTER_TB_ITEMS ) ) != SORTER_TB_ITEMS ) )
		{
			$areas_table_query = sprintf(
				'CREATE TABLE IF NOT EXISTS %s (
					`area_id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
					`user_creator_id` bigint(20) NOT NULL,
					`user_modifier_id` bigint(20) DEFAULT NULL,
					`date_created` datetime NOT NULL,
					`date_modified` datetime DEFAULT NULL,
					`area_name` varchar(255) NOT NULL DEFAULT \'\',
					`area_slug` varchar(255) NOT NULL,
					`area_main_container_template` text NOT NULL,
					`area_item_template` text NOT NULL,
					`active` tinyint(1) DEFAULT \'1\',
					PRIMARY KEY (`area_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;',
				SORTER_TB_AREAS
			);

			$items_table_query = sprintf(
				'CREATE TABLE IF NOT EXISTS %s (
					`item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					`area_id` bigint(20) NOT NULL,
					`user_creator_id` bigint(20) NOT NULL,
					`user_modifier_id` bigint(20) DEFAULT NULL,
					`date_created` datetime NOT NULL,
					`date_modified` datetime DEFAULT NULL,
					`item_order` int(11) DEFAULT NULL,
					`item_post_id` bigint(20) NOT NULL,
					`item_post_type` varchar(255) DEFAULT NULL,
					`active` tinyint(1) DEFAULT \'1\',
					PRIMARY KEY (`item_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;',
				SORTER_TB_ITEMS
			);

			dbDelta( $areas_table_query );
			dbDelta( $items_table_query );
			
			add_option( 'the_sorter_version', SORTER_VERSION );
		}
	}

	/**
	 * Plugin and DB uninstaller
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function uninstall()
	{
		global $wpdb;

		$areas_table_query = sprintf( 'DROP TABLE IF EXISTS %s', SORTER_TB_AREAS );
		$items_table_query = sprintf( 'DROP TABLE IF EXISTS %s', SORTER_TB_ITEMS );
		$wpdb->query( $areas_table_query );
		$wpdb->query( $items_table_query );

		delete_option( 'the_sorter_version' );
	}

	/**
	 * Menu builder for the plugin
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */
	
	public function build_menu()
	{
		$this->pagehook_items = add_menu_page(
			__( "The Sorter > Items", "thsrtr" ),
			__( "The Sorter", "thsrtr" ),
			'edit_posts',
			'the_sorter',
			array( &$this, 'item_screen' ),
			plugins_url( 'img/icon16.png', __FILE__ )
		);
		
		$this->pagehook = add_submenu_page(
			'the_sorter',
			__( "The Sorter > Areas", "thsrtr" ),
			__( "Areas", "thsrtr" ),
			'manage_options',
			'the_sorter_areas',
			array( &$this, 'area_screen' )
		);

		$this->pagehook_howto = add_submenu_page(
			'the_sorter',
			__( "The Sorter > How to use", "thsrtr" ),
			__( "How To Use", "thsrtr" ),
			'manage_options',
			'the_sorter_howto',
			array( &$this, 'howto_screen' )
		);
		
		add_action( 'load-' . $this->pagehook, array( &$this, 'load_elements' ) );
		add_action( 'load-' . $this->pagehook_items, array( &$this, 'load_elements' ) );
		add_action( 'load-' . $this->pagehook_howto, array( &$this, 'load_elements' ) );
	}

	/**
	 * Loads scripts and styles on demand, according to the page currently loaded
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */
	
	public function load_elements()
	{		
		//ensure, that the needed javascripts been loaded to allow drag/drop, expand/collapse and hide/show of boxes
		wp_enqueue_style( 'sorter-format' );

		switch( $_REQUEST['page'] )
		{
			case "the_sorter":
				if( empty( $_GET['area_id'] ) )
				{
					wp_enqueue_script( 'jquery-ui' );
					wp_enqueue_script( 'jquery-ui-widget' );
					wp_enqueue_script( 'jquery-ui-mouse' );

					wp_enqueue_script( 'jquery-ui-draggable' );
					wp_enqueue_script( 'jquery-ui-droppable' );
					wp_enqueue_script( 'jquery-ui-selectable' );
					wp_enqueue_script( 'jquery-ui-sortable' );

					wp_enqueue_script( 'sorter-manage' );
				}
				else
				{
					wp_enqueue_script( 'sorter-jquery-ui' );
					wp_enqueue_script( 'sorter-add-item' );
				}
				break;
			case "the_sorter_areas":
				wp_enqueue_script( 'common' );
				wp_enqueue_script( 'wp-lists' );
				wp_enqueue_script( 'postbox' );
				break;
		}
	}

	/**
	 * Loads scripts and styles prior to admin init
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function register_elements()
	{		
		wp_register_script( 'sorter-manage', SORTER_URL . 'js/manage.js', array( 'jquery' ), SORTER_VERSION, TRUE );
		wp_register_script( 'sorter-add-item', SORTER_URL . 'js/add-item.js', array( 'jquery' ), SORTER_VERSION, TRUE );
		wp_register_script( 'sorter-jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array( 'jquery' ), "1.9.2", TRUE );

		wp_register_style( 'sorter-format', SORTER_URL . 'css/format.css', NULL, SORTER_VERSION );
	}

	/**
	 * Callback function that retrieves the 'Areas' screen and links to the menu subpage
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function area_screen()
	{
		// The metaboxes
		add_meta_box( 'the-sorter-meta-1', __( 'Attention', 'thsrtr' ), array( 'The_sorter_metaboxes', 'metabox_area_common' ), $this->pagehook, 'side', 'core' );
		add_meta_box( 'the-sorter-meta-2', __( 'Advanced tags', 'thsrtr' ), array( 'The_sorter_metaboxes', 'metabox_advanced_tags' ), $this->pagehook, 'side', 'core' );

		$this->areas->screen( $this->pagehook );
	}

	/**
	 * Callback function that retrieves the 'Items' screen and links to the menu subpage
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function item_screen()
	{
		if( empty( $_GET['area_id'] ) )
		{
			$this->items->screen();
		}
		else
		{
			require_once( 'add-item.php' );
		}
	}

	/**
	 * Callback function that retrieves the 'How to use' screen and links to the menu subpage
	 *
	 * @param none
	 * @return none
	 * @since 1.0
	 */

	public function howto_screen()
	{
		include( 'howto.php' );
	}

	/**
	 * Display the indicated area, returning an html code to print.
	 *
	 * @param $area_id int The area identifier
	 * @param $limit int (optional) Force item listing interruption
	 * @return string
	 * @since 1.0
	 */
	
	public static function show_area( $area_id, $limit = false )
	{
		$area = The_sorter_areas::get_valid_areas( $area_id );
		
		if( ! empty( $area ) )
		{
			$return = '';
			$items = The_sorter_items::get_valid_items( $area_id );
			$r_items = FALSE;
			if( ! empty( $items ) )
			{
				$post_counter = 0;
				
				foreach( $items AS $i )
				{
					$post = get_post( $i->item_post_id );
										
					if( $post )
					{
						$short_tags = array(
							'{thumb_s}',
							'{thumb_m}',
							'{thumb_f}',
							'{link}',
							'{title}',
							'{excerpt}',
							'{date}'
						);
						
						$post_id = ( $post->post_type != "attachment" ) ? get_post_thumbnail_id( $post->ID ) : $post->ID;
					
						$img_s = wp_get_attachment_image_src( $post_id, 'thumbnail' )[0];
						$img_m = wp_get_attachment_image_src( $post_id, 'medium' )[0];
						$img_f = wp_get_attachment_image_src( $post_id, 'full' )[0];
						
						$post_content = ( empty( $post->post_content ) ) ? "" : substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 140 ) . " ...";
					
						$tags_values = array(
							( ! empty( $img_s ) ) ? $img_s : "",
							( ! empty( $img_m ) ) ? $img_m : "",
							( ! empty( $img_f ) ) ? $img_f : "",
							get_permalink( $post->ID ),
							get_the_title( $post->ID ),
							( ! empty ( $post->post_excerpt ) ) ? $post->post_excerpt : $post_content,
							mysql2date( get_option( 'date_format' ), $post->post_date ) . " " . mysql2date( get_option( 'time_format' ), $post->post_date )
						);
					
						$r_items .= str_replace( $short_tags, $tags_values, $area->area_item_template );
						
						$post_counter++;
						if( $limit == $post_counter ) break;
					}
				}
			}

			return ( $r_items ) ? stripslashes( str_replace( "{items}", $r_items, $area->area_main_container_template ) ) : FALSE;
		}
		
		return false;
	}

	/**
	 * Adds the 'show_area' function via shortcode to the portion of post content
	 *
	 * @param $atts array The attributes from the shortcode
	 * @return string
	 * @since 1.0
	 */

	public function show_area_shortcode( $atts )
	{
		extract( wp_parse_args( $atts, array(
			'area' => FALSE,
			'limit' => FALSE
		) ) );

		return self::show_area( $area, $limit );
	}
	
}


// Let's run it!
$the_sorter = new The_sorter;

?>