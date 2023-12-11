<?php
/**
* Ajax Endpoint 
* 
* @package Ajax Endpoint
* @auther shafiq 
* @copyright 2023 shafiq 
* @license GPL-2-later 
* 
* @wordpress-plugin 
* plugin name: Ejax Endpoint
* plugin url: https://ikonicsolution.com/ 
* Description: This plugin is the task plugin from ikonicsolution the Main functionlity of plugin is to  Create an Ajax endpoint that will output the last three published "Projects" that belong in the "Project Type" called "Architecture" If the user is not logged in. If the user is logged In it should return the last six published "Projects" in the project type call. "Architecture".
* version: 1.0
* Develop By: Shafiq
* Develop For: ikonicsolution.com 
* authorURL: https://ikonicsolution.com/ 
*
*/
function activate_ajax_endpoint() {
    // path of Plugin
    $plugin = 'Ajax-endpoint/ajax-endpoint.php'; 
    activate_plugin($plugin);
}

// Hook the activation function to an action.
register_activation_hook(__FILE__, 'activate_ajax_endpoint');

function deactivate_ajax_endpoint() {
    // Patch of Plugin
    $plugin = 'Ajax-endpoint/ajax-endpoint.php'; 
    deactivate_plugins($plugin);
}

// Hook the deactivation function to an action.
register_deactivation_hook(__FILE__, 'deactivate_ajax_endpoint');
// Register Custom Post Type

// Register Ajax endpoint
add_action('wp_ajax_get_architecture_projects', 'get_architecture_projects_callback');
add_action('wp_ajax_nopriv_get_architecture_projects', 'get_architecture_projects_callback');

function get_architecture_projects_callback() {
    // Check user login status
    $is_user_logged_in = is_user_logged_in();

    // Number of projects to retrieve based on user login status
    $projects_count = $is_user_logged_in ? 6 : 3;

    // Query to get the last published projects in the "Architecture" project type
    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $projects_count,
        'tax_query'      => array(
            array(
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => 'architecture',
            ),
        ),
    );

    $projects_query = new WP_Query($args);

    // Prepare response data
    $response_data = array();

    if ($projects_query->have_posts()) {
        while ($projects_query->have_posts()) {
            $projects_query->the_post();
            $response_data[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'link'  => get_permalink(),
            );
        }
    }

    // Restore original post data
    wp_reset_postdata();

    // Send JSON response
    $response = array(
        'success' => true,
        'data'    => $response_data,
    );

    wp_send_json($response);
}