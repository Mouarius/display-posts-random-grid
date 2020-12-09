<?php
/**
 * Plugin Name: Display Posts - Customisation pour Léo Badiali
 * Plugin URI: https://github.com/Mouarius/display-posts-random-grid
 * Description: Display a square grid of random posts with the shortcode [display-posts image_size="large" layout="random-grid"]
 * Version: 1.0.0
 * Author: Marius Menault
 * Author URI: https://github.com/Mouarius
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @version 1.0.0
 * @author Marius Menault
 * @copyright Copyright (c) 2020, Marius Menault
 * @link https://github.com/Mouarius/display-posts-random-grid
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    die;
}

class Random_Posts_Customization
{

    /**
     * Primary constructor
     *
     */
    function __construct()
    {
        add_filter('display_posts_shortcode_wrapper_open', array( $this, 'layout_random_grid_open'), 10, 2);
        add_filter('display_posts_shortcode_output', array( $this, 'layout_random_grid_item'), 10, 11);
        add_filter('display_posts_shortcode_wrapper_close', array( $this, 'layout_random_grid_close'), 10,2);
        add_filter('display_posts_shortcode_args', array($this, 'force_random_orderby'), 10, 2);

    }

    /**
     * Layout = random posts, open
     * @author Marius Menault
     */
    function layout_random_grid_open($output, $atts){
        if( empty( $atts['layout'] ) || 'random-grid' !== $atts['layout'] ){
			return $output;
        }

        $classes = array( 'display-posts-listing', 'random-grid-layout');

        if( !empty( $atts['wrapper_class'] ) ){
            $classes[] = $atts['wrapper_class'];
        }
        
        $output = '<div class="' . join(" ", $classes) . '">';

        return $output;
    }

    

    /**
     * Layout = random posts, single item
     * @author Marius Menault
     */
    function layout_random_grid_item($output, $atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class, $author, $category_display_text )
    {
        if (empty($atts['layout']) || 'random-grid' !== $atts['layout']){
            return $output;
        }

        $classes = array('listing-item');

        $output = '<div class="'.join(" ", $classes) . '">';
        $output .= $image;
        $output .= '</div>';

        return $output;
    }

    /**
     * Layout = random posts, close
     * @author Marius Menault
     */
    function layout_random_grid_close($output, $atts){
        if( empty( $atts['layout'] ) || 'random-grid' !== $atts['layout'] ){
            return $output;
        }

        $output .= '</div>';

        return $output;
    }

    /**
     * Layout = random posts, Force random ordering
     * @author Marius Menault
     */
    function force_random_orderby( $args, $atts ){
        if( empty($atts['layout']) || 'random-grid' !== $atts['layout']){
            return $args;
        }
        if( empty( $atts['orderby'] ) || 'rand' !== $atts['orderby']){
            $args['orderby'] = 'rand';
        }
        return $args;
    }
}

new Random_Posts_Customization();

//Add the custom styles
function random_grid_class_styles() {
    if( apply_filters( 'dps_random_posts_extension_include_css', true ) )
        wp_enqueue_style( 'random-grid-layout', plugins_url( 'random-grid-layout.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'random_grid_class_styles' );

