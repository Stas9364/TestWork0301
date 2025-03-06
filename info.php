<?php
/*
Template Name: Info page
*/
?>

<?php get_header(); ?>

<form method="post" id="search-city-form">
    <input type="text" name="city" placeholder="Enter the city" required>
    <input type="hidden" name="action" value="searchCity">

    <input id="submit" type="submit" value="Search city">
</form>

<?php
$result = get_cities();

if ($result['success']) {
    $cities = $result['data'];

    if (!empty($cities)) { ?>

        <?php 
        /**
         * you can output the necessary data before the table
         */

        do_action('storefront_before_info_table'); 
        ?>

        <table class="weather-table">
            <thead class="weather-table--head">
                <tr class="weather-table--headers">
                    <th>Country</th>
                    <th>City</th>
                    <th>Temperature (°C)</th>
                </tr>
                <tr class="loader"></tr>
            </thead>
            <tbody id="weather-table-body" class="weather-table--body">

                <?php
                foreach ($cities as $city) {
                ?>
                    <tr>
                        <td><?= $city->country_name ?></td>
                        <td> <?= $city->city_name ?></td>
                        <td> <?= Cities_Temperature_Widget::getTemperature($city->city_name) . ' °C' ?></td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>

        <?php 
        /**
         * you can output the necessary data after the table
         */

        do_action('storefront_after_info_table'); 
        ?>

<?php
    } else {
        echo 'No cities were found.';
    }
} else {
    echo 'An error has occurred please come back later';
}
?>

<?php get_footer();
