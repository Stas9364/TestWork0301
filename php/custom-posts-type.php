<?php

/**
 *insert post type settings 
 */

function postsType()
{

    $posts_type = [
        'cities'  => [
            'title'              => 'Cities',
            'gutenberg'          => false,
            'editor'             => true,
            'taxonomy'           => ['Countries'],
            'slug'               => 'cities',
            'publicly_queryable' => true,
            'supports'            => ['title'],
            'menu_icon'                  => '',
        ],
    ];

    return $posts_type;
}

/**
 * init CustomPostType
 */

add_action('init', 'createCustomPosts');
function createCustomPosts(): void
{
    $posts_type = postsType();

    foreach ($posts_type as $key => $item) {
        $labels = [
            'name'          => $item['title'],
            'singular_name' => $item['title'],
            'add_new'       => __('Add'),
            'add_new_item'  => __('Add'),
            'edit_item'     => __('Edit'),
            'new_item'      => __('New'),
            'all_items'     => $item['title'],
            'view_item'     => __('View'),
            'search_items'  => __('Search'),
            'not_found'     => __('Post not found'),
            'menu_name'     => $item['title'],
        ];

        $args   = [
            'labels'              => $labels,
            'public'              => true,
            'show_in_menu'        => true,
            'menu_icon'           => !empty($item['menu_icon']) ? $item['menu_icon'] : 'dashicons-superhero-alt',
            'menu_position'       => 10,
            'hierarchical'        => false,
            'taxonomies'          => $item['taxonomy'],
            'has_archive'         => true,
            'query_var'           => '',
            'rewrite'             => ['slug' => $item['slug']],
            'supports'            => $item['supports'],
            'show_in_rest'        => $item['gutenberg'],
            'exclude_from_search' => false,
            'publicly_queryable'  => $item['publicly_queryable'],
        ];

        register_post_type($key, $args);
    }
}
