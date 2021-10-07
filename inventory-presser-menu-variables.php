<?php
defined( 'ABSPATH' ) or exit;

/**
 * Plugin Name: Inventory Presser Menu Variables
 * Plugin URI: https://github.com/csalzano/inventory-presser-menu-variables
 * Description: An add-on for Inventory Presser that allows [invp_vin], [invp_stock_number], and other variables to be used in Custom Link Menu items.
 * Version: 1.0.0
 * Author: Corey Salzano
 * Author URI: https://profiles.wordpress.org/salzano
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

function invp_replace_menu_variables( $atts, $item, $args, $depth )
{
	//Is the core plugin running?
	if( ! class_exists( 'INVP' ) )
	{
		return $atts;
	}

	//Is this menu item a Custom Link?
	if( empty( $item->type ) || 'custom' != $item->type )
	{
		return $atts;
	}

	$start_pattern = '%5Binvp_';

	//Are there any variables in the URL?
	if( false === strpos( $atts['href'], $start_pattern ) )
	{
		return $atts;
	}

	global $post;
	foreach( INVP::keys() as $key )
	{
		$atts['href'] = str_replace( $start_pattern . $key . '%5D', INVP::get_meta( $key, $post->ID ), $atts['href'] );
	}

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'invp_replace_menu_variables', 20, 4 );
