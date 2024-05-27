<?php
/**
 * @package Subscribe Plugin by W.G
 * Auth:
 * @version 1.1.5
 */

/*
Plugin Name:  WG-Wecan-group
Plugin URI: https://wecan-group.com/
Description: Quản lý Wecan-Group
Author: Wecan Group
Version: 1.0
Author URI: https://wecan-group.com/
*/

$userRoles = '';
$userPer   = '';

add_action('admin_menu', 'show_menu_app1');

function show_menu_app1(){
    global $userRoles,$userPer;
    $userRoles = wp_get_current_user();
    $userPer = $userRoles->roles;

    add_menu_page( 'Đánh giá khách hàng', 'Đánh giá khách hàng', 'manage_options', 'reviews', 'danhgia' , 'dashicons-star-filled', 40);

}
include plugin_dir_path( __FILE__ ) . '/includes/config.php';


function danhgia() {
    include plugin_dir_path(__FILE__) . '/danhgia/danhgia.php';
}
