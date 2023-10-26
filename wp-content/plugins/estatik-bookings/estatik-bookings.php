<?php

/**
 * Plugin Name: Estatik Bookings
 * Description: Custom booking post type with date fields and address.
 * Version: 1.0
 */

namespace Estatik;

class EstatikBookingsPlugin
{
    public function __construct()
    {
        add_action('init', array($this, 'registerPostType'));
        add_action('add_meta_boxes', array($this, 'addBookingMetabox'));
        add_action('save_post', array($this, 'saveBookingMetabox'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('the_content', array($this, 'displayBookingDates'));
        add_action('the_content', array($this, 'displayGoogleMap'));
    }

    public function registerPostType(): void
    {
        register_post_type(
            'booking',
            array(
            'labels' => array(
                'name' => 'Bookings',
                'singular_name' => 'Booking',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor'),
            )
        );
    }

    public function addBookingMetabox($post): void
    {
        add_meta_box('estatik_booking_metabox', 'Booking Details', array($this, 'bookingMetaboxCallback'), 'booking');
    }

    public function bookingMetaboxCallback($post): void
    {
        wp_nonce_field('estatik_booking_metabox', 'estatik_booking_metabox_nonce');

        $startDate = get_post_meta($post->ID, 'start_date', true);
        $endDate = get_post_meta($post->ID, 'end_date', true);
        $address = get_post_meta($post->ID, 'address', true);

        echo '<label for="start_date">Start Date:</label>';
        echo '<input type="text" id="start_date" name="start_date" class="datepicker" value="' . esc_attr($startDate) . '"><br>';

        echo '<label for="end_date">End Date:</label>';
        echo '<input type="text" id="end_date" name="end_date" class="datepicker" value="' . esc_attr($endDate) . '"><br>';

        echo '<label for "address">Property Address:</label>';
        echo '<input type="text" id="address" name="address" value="' . esc_attr($address) . '">';
    }

    public function saveBookingMetabox($postId): void
    {
        if (!isset($_POST['estatik_booking_metabox_nonce'])) {
            return;
        }

        $nonce = $_POST['estatik_booking_metabox_nonce'];

        if (!wp_verify_nonce($nonce, 'estatik_booking_metabox')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        update_post_meta($postId, 'start_date', sanitize_text_field($_POST['start_date']));
        update_post_meta($postId, 'end_date', sanitize_text_field($_POST['end_date']));
        update_post_meta($postId, 'address', sanitize_text_field($_POST['address']));
    }

    public function enqueueScripts($hook)
    {
        if ($hook != 'post-new.php' && $hook != 'post.php') {
            return;
        }

        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');

        wp_enqueue_script('estatik-booking-datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);
    }

    public function displayBookingDates($content): string
    {
        $startDate = get_post_meta(get_the_ID(), 'start_date', true);
        $endDate = get_post_meta(get_the_ID(), 'end_date', true);

        if (!empty($startDate) && !empty($endDate)) {
            $formattedStartDate = date('d M Y H:i', strtotime($startDate));
            $formattedEndDate = date('d M Y H:i', strtotime($endDate));
            return $content . '<p>Booking Period: ' . $formattedStartDate . ' to ' . $formattedEndDate . '</p>';
        }
        return $content;
    }

    public function displayGoogleMap($content): string
    {
        $address = get_post_meta(get_the_ID(), 'address', true);

        if (!empty($address)) {
            $content .= '<div id="booking-map" style="width: 100%; height: 300px;"></div>';
            $content .= '<script>
                function initMap() {
                    var geocoder = new google.maps.Geocoder();
                    var map = new google.maps.Map(document.getElementById("booking-map"), {
                        zoom: 14,
                        center: {lat: 0, lng: 0}
                    });
                    geocoder.geocode({ address: "' . esc_js($address) . '" }, function(results, status) {
                        if (status === "OK" && results[0]) {
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });
                            map.setCenter(results[0].geometry.location);
                        }
                    });
                }
            </script>';
            $content .= '<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap"></script>';
        }

        return $content;
    }
}

$estatikBookingsPlugin = new EstatikBookingsPlugin();
