<?php
 // This file is not called from WordPress. We don't like that.
if ( ! function_exists( 'add_filter' ) ) {
	echo "Hi there! I'm just a part of plugin, not much I can do when called directly.";
	exit;
}

if ( ! function_exists( 'ppo_addquicktag_post_types' ) ) {

	// add custom function to filter hook 'addquicktag_post_types'
	add_filter( 'addquicktag_post_types', 'ppo_addquicktag_post_types' );
	
	/**
	 * Return array $post_types with custom post types strings
	 * 
	 * @param   $post_type Array
	 * @return  $post_type Array
	 */
	function ppo_addquicktag_post_types( $post_types ) {
		
		$post_types[] = 'product';
		
		return $post_types;
	}
	
}