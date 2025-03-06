<?php

class Cities_Temperature_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('cities_temperature_widget', 'City Temperature Widget');
    }

    public function widget($args, $instance)
    {
        /**
         * the function outputs the markup to the front of the application
         */

        $city_id = $instance['city_id'];
        $city = get_post($city_id);

        $temperature = self::getTemperature($city->post_title);

        echo $args['before_widget'];
        echo '<h2>' . esc_html($city->post_title) . '</h2>';
        echo '<p>Current Temperature: ' . esc_html($temperature) . '°C</p>';
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        /**
         * setting cities from custom posts types in the select
         */

        $cities = get_posts(array('post_type' => 'cities', 'numberposts' => -1));

        $city_id = !empty($instance['city_id']) ? $instance['city_id'] : '';

        echo '<select name="' . $this->get_field_name('city_id') . '">';
        foreach ($cities as $city) {
            echo '<option value="' . $city->ID . '"' . selected($city_id, $city->ID, false) . '>' . $city->post_title . '</option>';
        }
        echo '</select>';
    }

    public function update($new_instance, $old_instance)
    {
        /**
         * updating the widget with a new value
         */

        $instance = array();
        $instance['city_id'] = (!empty($new_instance['city_id'])) ? strip_tags($new_instance['city_id']) : '';

        return $instance;
    }

    static public function getTemperature($city_name)
    {
        $api_key = "734c7d69f1f44bdba87150403221407";
        $q = $city_name;
        $url = 'http://api.weatherapi.com/v1/current.json?';

        $queryParams = http_build_query([
            'key' => $api_key,
            'q' => $q,
        ]);

        $resp = wp_remote_get($url . $queryParams);
        $json = wp_remote_retrieve_body($resp);
        $data = $json ? json_decode($json, true) : [];

        return $data['current']['temp_c'];
    }
}

add_action('widgets_init', 'registerCitiesTemperatureWidget');
function registerCitiesTemperatureWidget()
{
    register_widget('Cities_Temperature_Widget');
}
