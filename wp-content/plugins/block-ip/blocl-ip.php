<?php
/**
* Block IP 
* 
* @package Block.IP
* @auther shafiq 
* @copyright 2023 shafiq 
* @license GPL-2-later 
* 
* @wordpress-plugin 
* plugin name: Block Ip 
* plugin url: https://ikonicsolution.com/ 
* Description: This plugin is the task plugin from ikonicsolution the Main functionlity of plugin is to redirect the list of user who ip start from "77.29"  
* version: 1.0
* Develop By: Shafiq
* Develop For: ikonicsolution.com 
* authorURL: https://ikonicsolution.com/ 
*
*/
function activate_block_ip() {
    // path of Plugin
    $plugin = 'block-ip/block-ip.php'; 
    activate_plugin($plugin);
}

// Hook the activation function to an action.
register_activation_hook(__FILE__, 'activate_block_ip');

function deactivate_block_ip() {
    // Patch of Plugin
    $plugin = 'block-ip/block-ip.php'; 
    deactivate_plugins($plugin);
}

// Hook the deactivation function to an action.
register_deactivation_hook(__FILE__, 'deactivate_block_ip');

function redirect_users_by_ip() {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if the IP address starts with "77.29"
    if (strpos($user_ip, '77.29') === 0) {
        // Redirect the user
        wp_redirect('https://google.com/');
        exit();
    }
}

// Hook the function to the template_redirect action
add_action('template_redirect', 'redirect_users_by_ip');