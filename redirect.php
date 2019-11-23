<?php

function login_redirect_func(){
    $url=do_shortcode('[geturlnow]');
    return do_shortcode('[wpmem_form login redirect_to="'.$url.'"]');
}
add_shortcode('loginform_redirect','login_redirect_func');

function register_redirect_func(){
    $url=do_shortcode('[geturlnow]');
    return do_shortcode('[wpmem_form register redirect_to="'.$url.'"]');
}
add_shortcode('registerform_redirect','register_redirect_func');


function un_logged_in_user_redirect() {
    /*
    if( ! is_user_logged_in() && is_single() || is_archive() || is_singular( 'カスタム投稿' ) ) {
        wp_redirect( '/login' );// ログインページのURL
        exit();
    }
    if( ! is_user_logged_in() && is_page(1599)) {
        wp_redirect( '/login' );// ログインページのURL
        exit();
    }
    */
}
add_action( 'template_redirect',  'un_logged_in_user_redirect' );


function under_construction_redirect() {
    $cu=wp_get_current_user();
    /*    if( ! is_user_logged_in() || !($cu->has_cap('administrator'))) {
        wp_redirect( '/' );
        exit();
    }*/
}
//add_action( 'template_redirect',  'under_construction_redirect' );
add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2 );

function my_login_redirect( $redirect_to, $user_id ) {
    return '/';
}
/*
add_action( 'auth_redirect', 'subscriber_go_to_home' );
function subscriber_go_to_home( $user_id ) {
    $user = get_userdata( $user_id );
    if ( !$user->has_cap( 'edit_posts' ) ) {
    wp_redirect( get_home_url() );
    exit();
}
}*/

?>