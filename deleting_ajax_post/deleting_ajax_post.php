<?php
/*
Plugin Name: Deleting ajax post
Description: plugin para eliminar foods mediante ajax
Version: 0.01
Author: Aldo
License: GPL 2
*/



function dap_my_load_scripts() {
    if(is_home() || is_archive()){

        wp_enqueue_script( 'dap_js',  plugin_dir_url( __FILE__ ) . 'js/deleting_ajax_post.js' , array('jquery') );
        wp_enqueue_style( 'dap_style', plugin_dir_url( __FILE__ ) . 'css/deleting_ajax_post.css' );
     
        wp_localize_script( 'dap_js', 'ajax_var', array(
            'url'    => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
            'action' => 'my_deleting_post'
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'dap_my_load_scripts' );


function my_deleting_post_cb() {
    

    $nonce = sanitize_text_field( $_POST['nonce'] );
    
    if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' ) || !get_post( $_POST['id'] ) || !$_POST['id'] || get_post_type($_POST['id'] ) != 'food' ) {
        wp_die('Busted!');
    }
    
    else {
    wp_delete_post(  $_POST['id']  );
    echo 'success';
    }


    wp_die();
}
    

add_action( 'wp_ajax_nopriv_my_deleting_post', 'my_deleting_post_cb' );
add_action( 'wp_ajax_my_deleting_post', 'my_deleting_post_cb' );
