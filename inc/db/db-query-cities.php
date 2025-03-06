<?php

function get_cities(string $city = ''): array
{
    global $wpdb;

    /**
     * get tables
     */

    $posts_table = $wpdb->posts;
    $terms_table = $wpdb->terms;
    $term_relationships_table = $wpdb->term_relationships;
    $term_taxonomy_table = $wpdb->term_taxonomy;

    /**
     * get a sorted list of cities by taxonomy by combining tables
     */

    $query = $wpdb->prepare(
        "SELECT p.ID, p.post_title AS city_name, t.name AS country_name 
        FROM $posts_table p
        INNER JOIN $term_relationships_table tr ON p.ID = tr.object_id
        INNER JOIN $term_taxonomy_table tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $terms_table t ON tt.term_id = t.term_id
        WHERE p.post_type = %s 
        AND p.post_status = %s 
        AND tt.taxonomy = %s
        AND p.post_name LIKE %s
        ORDER BY t.name ASC",
        'cities',
        'publish',
        'countries',
        '%' . $wpdb->esc_like($city) . '%'
    );

    $cities = $wpdb->get_results($query);

    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);

        return [
            'success' => false,
            'message' => 'DB error: ' . $wpdb->last_error,
        ];
    }

    return [
        'success' => true,
        'data' => $cities,
    ];
}
