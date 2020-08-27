<?php
/**
 * Plugin Name: Redirect to API
 * Description: Allow users to enter urls to redirect, then output the data in the Rest API for consumption by a separate front-end.
 * Version: 1.0.0
 * Author: Tim Smith
 * Author URI: https://www.iamtimsmith.com
 *  
 * This plugin requires ACF pro to work properly.
 */

/**
 * Create redirects page
 */
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Custom Redirects',
		'menu_title'	=> 'Redirects',
		'menu_slug' 	=> 'custom-redirects',
		'capability'	=> 'edit_posts',
		'icon_url'		=> 'dashicons-external',
		'redirect'		=> false
	));
}

/**
 * Add custom redirect fields
 */
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5f470b2c3230f',
		'title' => 'Redirects',
		'fields' => array(
			array(
				'key' => 'field_5f470b313fa5d',
				'label' => 'Redirect',
				'name' => 'redirect',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add Redirect',
				'sub_fields' => array(
					array(
						'key' => 'field_5f470b3a3fa5e',
						'label' => 'From',
						'name' => 'from',
						'type' => 'url',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5f470b583fa5f',
						'label' => 'To',
						'name' => 'to',
						'type' => 'url',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'custom-redirects',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'permalink',
			1 => 'the_content',
			2 => 'excerpt',
			3 => 'discussion',
			4 => 'comments',
			5 => 'revisions',
			6 => 'slug',
			7 => 'author',
			8 => 'format',
			9 => 'page_attributes',
			10 => 'featured_image',
			11 => 'categories',
			12 => 'tags',
			13 => 'send-trackbacks',
		),
		'active' => true,
		'description' => '',
	));
	
endif;

/**
 * Output redirects in rest endpoint
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'redirects/v1', '/all', array(
		'methods' => 'GET',
		'callback' => 'get_redirects',
	) );
} );

function get_redirects() {
	if( function_exists('acf_add_local_field_group') ) {
		$all = get_field('redirect', 'option');
		return $all ? $all : [];
	}
	return 'There was an error. Make sure the ACF Pro plugin is installed...';
}
