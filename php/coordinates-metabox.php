<?php

/**
 * init metabox
 */

add_action('add_meta_boxes', 'addCoordinatesMeta');
function addCoordinatesMeta()
{
    add_meta_box('cities_meta', 'City Coordinates', 'coordinatesMetaCallback', 'cities', 'normal', 'high');
}

/**
 * displaying the metabox on the editing page
 */

function coordinatesMetaCallback($post)
{
    wp_nonce_field('saveCoordinatesMeta', 'coordinatesMetaNonce');
    $latitude = get_post_meta($post->ID, 'latitude', true);
    $longitude = get_post_meta($post->ID, 'longitude', true);

    echo '<div class="custom-metabox-container"><div><label for="latitude">Latitude: </label>';
    echo '<input type="text" id="latitude" name="latitude" value="' . esc_attr($latitude) . '" /></div>';
    echo '<br>';
    echo '<div><label for="longitude">Longitude: </label>';
    echo '<input type="text" id="longitude" name="longitude" value="' . esc_attr($longitude) . '" /></div></div>';
}

/**
 * save metabox
 */

add_action('save_post', 'saveCoordinatesMeta');
function saveCoordinatesMeta($post_id)
{
    if (!isset($_POST['coordinatesMetaNonce']) || !wp_verify_nonce($_POST['coordinatesMetaNonce'], 'saveCoordinatesMeta')) {
        return;
    }
    if (array_key_exists('latitude', $_POST)) {
        update_post_meta($post_id, 'latitude', sanitize_text_field($_POST['latitude']));
    }
    if (array_key_exists('longitude', $_POST)) {
        update_post_meta($post_id, 'longitude', sanitize_text_field($_POST['longitude']));
    }
}

/**
 * stylization meta boxes on editing page
 */
function metaBoxesStyles()
{
    echo '<style>
    .custom-metabox-container {
        display: flex;
        gap: 16px
    }

    .custom-meta-box input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .custom-meta-box label {
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }

    .custom-meta-box {
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    </style>';
}
add_action('admin_head', 'metaBoxesStyles');
