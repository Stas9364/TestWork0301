<?php

function searchCity()
{
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

    $result = get_cities($city);

    $posts = $result['data'];

    if ($result['success']) {
        foreach ($posts as $post) {
            $post->temperature = Cities_Temperature_Widget::getTemperature($post->city_name);
        }

        wp_send_json_success(['success' => true, 'data' => $posts]);
    } else {
        wp_send_json_error(['success' => false, 'message' => 'An error occurred. Please try again.']);
    }


    wp_die();
}
