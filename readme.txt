=== The Sorter ===
Tags: posts sorter, sorter, arrange, arranger, drag & drop, areas, display, links, links to post
Requires at least: 3.5.1
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Sorter let you define areas or zones where to drop entries links and stylize them your way.

== Description ==

The Sorter is a plugin that let you show the posts, pages, any kind of entry you may have and display it in a list, which you can stylize using JS or CSS and explore your creativity making simple lists, complex lists, image slides, galleries, and a lot more.

== Installation ==

Follow these steps to install the plugin.

1. Upload `the-sorter` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **The Sorter** menu. Click on **Areas**.
4. Create an area. They will hold your items.
5. Go to **The Sorter** and you'll see the area created. **Add an item**, which is actually a post or page or custom post. Add as many as you want.
6. Now you can arrange the item position using drag & drop.
7. Add your areas raw into your themes using the code generated in the area's list. Or add them into your posts using shortcode, or add into a sidebar using the widget.

== Frequently Asked Questions ==

= What does this plugin actually do? =
The Sorter let you choose the entries you want, add them into an area or zone, and then display that zone into an specific section in your theme.

= What can I use this for? =
You can use this to merely display some posts you might find important and want your viewers to see, till creating complex posts slides to illustrate your home page with featured and exclusive content.

= Where does this data get stored =
The plugin only saves the areas and the position of the items. Everything else is stored within your own entries and posts. So, in case you change the title of a post, The Sorter gets the new title, not the old one.

= Why did you created this plugin? =
I created this plugin to let me arrange the post order of my client's websites easily and intuitively. But I expect to expand it for multiple automated purposes in a future.

= If I deactivate the plugin, does my items and areas get deleted? =
Yes. This plugin creates two database tables to store data concerning to the items and areas. When you deactivate the plugin, it also destroys both tables, so you got that storage space freed.

= I don't want to delete an area or item, I just want to hide it for a while. What do I have to do? =
You can always **Deactivate** areas and item. That works like a trash can. Obviously you will see those items and areas in the admin interface, but with the DEACTIVATED legend. In public they won't be shown, but also won't get deleted from the database. You can restore both areas and items anytime you want.

= I need more help. Where to go? =
There's a **How To Use** page within the plugin menu. Also, you can contact me at `metamorpher.py@gmail.com` indicating the name of the plugin in the subject. I'll try to answer all your inquiries as soon as I get some free time.

= Which languages does this support? =
Currently, English and Spanish. If you want to translate it, there's a PO english file within the plugin. If you can translate this into your own language please help us grow our language textdomain. Send both PO and MO files to `metamorpher.py@gmail.com`. Your help will be appreciated and your name will appear on the plugin credits.

== How To Use ==

The Sorter organizes the posts in the way you prefer. It let you illustrate in a better way, sections of your themes that earlier were ordered only by columns on your database.

With The Sorter you can organize those posts creatively, and later give shape to slides, or lists with CSS. Don't worry, we do the tough job for you. You just will need to stylize the result.

= Brief description of the product =

The Sorter handles two concepts: Areas and Items. Areas groups items and that is all. It means that you can create as many areas as you want, and populate them with items.

Areas consists of zones where the items are dropped to be displayed later. And items are references to the posts, fancy links with lot of properties that can be displayed in any manner, depending on your creativity and element manipulation.

= Procedure =

In order to take advantage of The Sorter in its entirety, after the set up, you must follow these steps:

* **Create an Area**. Go to 'Areas' and create an area using the form. The only field you MUST complete is the Name. The templates already have a default value. But of course, you can edit them to stylize the output the way you like. Anyway, is important to tell you that you MUST HAVE some HTML knowledge to edit the templates. In case you mess with that code without knowing what you are doing, the output might not work properly.
* **Add an Item**. After having created the area, you have to populate it with 'Items', which are actually fancy links, with HTML elements that you can add or remove. They point to the entries you have made, of any kind: posts, pages, media files and custom post types. In order to add the items, you must go to the main page of the plugin (The Sorter) and click on the button displaying 'Add Item', which will open a little window with a form within. First, pick which kind of post you want to get. After this, a second field appear. There you have to pick the post you want to link a reference with. After having picked the post and pressed the Save button, then you have to see the element created just below the name of the area in which you added the item.
* **Order 'a piacere'**. Once you have multiple items within an area, you can use drag and drop to place the items in the order you wish. You will see the current order number at the top right corner of the item, showing you the final order the elements will take when displayed.
* **Add the code or the widget**. This is the last step. Once you add the code, you are free to go. Go to the Areas' Page. There you will see the list of the created areas. Once you find the one you were looking for, place the cursor over the name. There you'll see a menu appearing below that name. Clic the 'View Code' option. Now you have two options: Add the PHP code within a page of the theme you like, or add the area's 'shortcode' to any specific entry, like a page, a post or custom one. BE CAREFUL: The first one only works within PHP files. The second one is meant to be used only within Wordpress' entries, that is why they have so different syntaxes. WIDGET: You can also add an instance of the widget in any dynamic sidebar your theme could have.

If you followed these steps properly, now you have to be seeing a list of posts and links anywhere you placed the code we supplied.

= Uses =

You can use the generated code to display those posts the way you want. You can use it as picture galleries, posts slides, sidebars for featured posts, merge it with any JS and CSS library to do something special, any way you can imagine. It is now up to you and your creativity to find the best way to amuse with the output this plugin gives you.

= Advices =

* When you deactivate an item or an area, they won't be displayed in public.
* When you delete an item or an area, the element cannot be restored.
* When you delete an area, the items within get deleted also.

That's it. Farewell and good luck!

== Screenshots ==

1. The item's list. Use drag & drop to arrange them.
2. The area's list and form for the area creation.
3. Multiple instances of the widget.
4. The shortcode in action.
5. The modal with the form for item creation.

== Changelog ==

= Version 1.0 (2/28/2014) =

* Launch and first release.