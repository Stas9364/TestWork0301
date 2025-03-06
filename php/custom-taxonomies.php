<?php

/**
 *insert taxonomies settings 
 */


function taxonomies()
{
    $taxonomies = [
        'countries' => [
            'post_type' => 'cities',
            'name'              => 'Countries',
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,

        ]
    ];

    return $taxonomies;
}

/**
 * init taxonomies
 */

add_action('init', 'createCustomTaxonomy');
function createCustomTaxonomy()
{
    $taxonomies = taxonomies();

    foreach ($taxonomies as $key => $item) {
        $labels = [
            'name'              => $item['name'],
            'singular_name'     => $item['name'],
            'search_items'      => __('Search'),
            'all_items'         => __('All'),
            'parent_item'       => __('Parent'),
            'parent_item_colon' => __('Parent:'),
            'edit_item'         => __('Edit'),
            'update_item'       => __('Update'),
            'add_new_item'      => __('Add New'),
            'new_item_name'     => __('New Country'),
            'menu_name'         => $item['name'],
        ];

        $args = [
            'labels' => $labels,
            'hierarchical'      => $item['hierarchical'],
            'show_ui'           => $item['show_ui'],
            'show_admin_column' => $item['show_admin_column'],
            'query_var'         => $item['query_var'],
            'rewrite'           => array('slug' => $key),
        ];

        register_taxonomy($key, $item['post_type'], $args);
    }
}
