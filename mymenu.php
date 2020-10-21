<?php 
/*
Plugin Name: Section Menus
Plugin URI: https://github.com/chechepech/
Description: Add a section menu to the sidebar
Version: 0.1
Author: Cheche Pech
Author URI: https://chechepech.gq
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: mymenu
*/


/*******************************************************
	Check if the current page is the top level page
*******************************************************/

function mymenu_check_top_level_page(){

	//Check if we're on a page
	if( is_page()){
		global $post;

		// Check if the page has parents
		if($post->post_parent){

			//fetch higher level posts

			var_dump( $post->ID);

			$parents = array_reverse(get_post_ancestors($post->ID));


			//get the top level ancestor
			return $parents[0];
		}

		return $post->ID;
	}
}

/*******************************************************
	Output the section menu
*******************************************************/

function mymenu_section_menu(){ 

	//don't run on the the main blog page
	if(is_page() && ! is_home()){

		$ancestor = mymenu_check_top_level_page();

		//set the arguments for the children of the ancestor
		$args= array(
			'child_of' => $ancestor,
			'depth' => '-1',
			'title_li' => ''
		);

		//save output of get pages
		$list_pages = get_pages($args);


		if ($list_pages){ ?>

			<section class="section-menu sidebar widget">
				<h2 class="widget-title">
					<a href="<?php echo get_permalink($ancestor); ?>" title=""><?php echo get_the_title($ancestor);?></a>
				</h2>
				<ul class="subpages">
					<?php wp_list_pages($args); ?>
				</ul>
			</section>
		<?php }

	}
}

add_action('mymenu_sidebar', 'mymenu_section_menu');