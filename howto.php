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

		<div id="the_sorter_howto" class="wrap">
	
			<div class="icon32"><br /></div><h2><?php _e( "The Sorter", 'thsrtr' ); ?> <small><?php _e( "How To Use", 'thsrtr' ); ?></small></h2>
			
			<p><?php _e( "The Sorter organizes the posts in the way you prefer. It let you illustrate in a better way, sections of your themes that earlier were ordered only by columns on your database.", "thsrtr" ); ?></p>
			
			<p><?php _e( "With The Sorter you can organize those posts creatively, and later give shape to slides, or lists with CSS. Don't worry, we do the tough job for you. You just will need to stylize the result.", "thsrtr" ); ?></p>
			
			<h3><?php _e( "Brief description of the product", "thsrtr" ); ?></h3>
			
			<p><?php _e( "The Sorter handles two concepts: Areas and Items. Areas groups items and that is all. It means that you can create as many areas as you want, and populate them with items.", "thsrtr" ); ?></p>
			
			<p><?php _e( "Areas consists of zones where the items are dropped to be displayed later. And items are references to the posts, fancy links with lot of properties that can be displayed in any manner, depending on your creativity and element manipulation.", "thsrtr" ); ?></p>
			
			<h3><?php _e( "Procedure", "thsrtr" ); ?></h3>
			
			<p><?php _e( "In order to take advantage of The Sorter in its entirety, after the set up, you must follow these steps:", "thsrtr" ); ?></p>
			
			<ol>
				<li><?php _e( "<strong>Create an Area.</strong> Go to 'Areas' and create an area using the form. The only field you MUST complete is the Name. The templates already have a default value. But of course, you can edit them to stylize the output the way you like. Anyway, is important to tell you that you MUST HAVE some HTML knowledge to edit the templates. In case you mess with that code without knowing what you are doing, the output might not work properly.", "thsrtr" ); ?></li>
			
				<li><?php _e( "<strong>Add an Item.</strong> After having created the area, you have to populate it with 'Items', which are actually fancy links, with HTML elements that you can add or remove. They point to the entries you have made, of any kind: posts, pages, media files and custom post types. In order to add the items, you must go to the main page of the plugin (The Sorter) and click on the button displaying 'Add Item', which will open a little window with a form within. First, pick which kind of post you want to get. After this, a second field appear. There you have to pick the post you want to link a reference with. After having picked the post and pressed the Save button, then you have to see the element created just below the name of the area in which you added the item.", "thsrtr" ); ?></li>
			
				<li><?php _e( "<strong>Order 'a piacere'.</strong> Once you have multiple items within an area, you can use drag and drop to place the items in the order you wish. You will see the current order number at the top right corner of the item, showing you the final order the elements will take when displayed.", "thsrtr" ); ?></li>
			
				<li><?php _e( "<strong>Add the code or the widget.</strong> This is the last step. Once you add the code, you are free to go. Go to the Areas' Page. There you will see the list of the created areas. Once you find the one you were looking for, place the cursor over the name. There you'll see a menu appearing below that name. Clic the 'View Code' option. Now you have two options: Add the PHP code within a page of the theme you like, or add the area's 'shortcode' to any specific entry, like a page, a post or custom one. <strong>BE CAREFUL:</strong> The first one only works within PHP files. The second one is meant to be used only within Wordpress' entries, that is why they have so different syntaxes. WIDGET: You can also add an instance of the widget in any dynamic sidebar your theme could have.", "thsrtr" ); ?></li>
			</ol>
			
			<p><?php _e( "If you followed these steps properly, now you have to be seeing a list of posts and links anywhere you placed the code we supplied.", "thsrtr" ); ?></p>
			
			<h3><?php _e( "Uses", "thsrtr" ); ?></h3>
			
			<p><?php _e( "You can use the generated code to display those posts the way you want. You can use it as picture galleries, posts slides, sidebars for featured posts, merge it with any JS and CSS library to do something special, any way you can imagine. It is now up to you and your creativity to find the best way to amuse with the output this plugin gives you.", "thsrtr" ); ?></p>
			
			<h3><?php _e( "Advices", "thsrtr" ); ?></h3>
			
			<ul>
				<li><?php _e( "When you deactivate an item or an area, they won't be displayed in public.", "thsrtr" ); ?></li>
				<li><?php _e( "When you delete an item or an area, the element cannot be restored.", "thsrtr" ); ?></li>
				<li><?php _e( "When you delete an area, the items within get deleted also.", "thsrtr" ); ?></li>
			</ul>

			<p><?php _e( "That's it. Farewell and good luck!", "thsrtr" ); ?></p>
		</div>
