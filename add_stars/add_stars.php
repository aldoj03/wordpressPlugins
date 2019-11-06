
<?php
/*
Plugin Name: StarsRating
Description: ranquear comidas con estrellas
Author: Aldo Cabrera
Version: 0.1
License: GPL 2


*/
 
 


//*CARGAR ASSETS
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

 function stars_load_scripts() {
  if(is_single()){

    wp_enqueue_script( 'stars_script',  plugin_dir_url( __FILE__ ) . 'js/add_stars.js' , array('jquery') );
    wp_enqueue_style( 'stars_style', plugin_dir_url( __FILE__ ) . 'css/add_stars.css' );
  
    wp_localize_script( 'stars_script', 'ajax_var2', array(
        'url'    => admin_url( 'admin-ajax.php' ),
        'nonce'  => wp_create_nonce( 'my-ajax-nonce' )
    ) );
  }
}
add_action( 'wp_enqueue_scripts', 'stars_load_scripts' );
 
//*CREA LA DB SINO EXISTE

function stars_db() {
 
  global $wpdb;
  $nombreTabla = $wpdb->prefix . "stars";
  
  $created = dbDelta(  
    "CREATE TABLE IF NOT EXISTS $nombreTabla (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      post_id bigint(20) NOT NULL ,
      stars int(2) NOT NULL,
      PRIMARY KEY (id),
       FOREIGN KEY (post_id) REFERENCES wp_posts(id)
    )  CHARACTER SET utf8 COLLATE utf8_general_ci"
  );
} 
register_activation_hook( __FILE__, 'stars_db' );
 
  
//*GUARDA LA CANTIDAD DE PUNTOS DADA

function save_points_cb() {
    

  $post_id = $_POST['id'];
  $points = $_POST['point'];

  $nonce = sanitize_text_field( $_POST['nonce'] );
  
  if ( ! wp_verify_nonce( $nonce, 'my-ajax-nonce' ) ) {
      wp_die('Busted!');
  }
  
  else {
    global $wpdb;
    $nombreTabla = $wpdb->prefix . "stars";

    $result = $wpdb->get_results("SELECT * FROM wp_stars WHERE post_id = $post_id");
    if(!$result){      
      $wpdb->insert($nombreTabla, array('post_id'=>$post_id,'stars'=>$points));
    }
    else{
      $wpdb->update($nombreTabla, array('stars'=>$points), array('post_id'=>$post_id));
    }
    
    echo 'success';
  }


  wp_die();
}
  

add_action( 'wp_ajax_nopriv_save_points', 'save_points_cb' );
add_action( 'wp_ajax_save_points', 'save_points_cb' );


//* PETICION PARA MOSTRAR CANTIDAD DE PUNTOS PREVIAMENTE DADA

function initialize_stars_cb() {
  
  $id = $_GET['id'];
  if($_GET['id']){

    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM wp_stars WHERE post_id = $id");
    if(!$result){
     wp_die() ;  
   }
   else{
     $stars = $result[0]->stars; 
   }
  
   echo $stars; 
  }
  wp_die();


  }

  add_action( 'wp_ajax_nopriv_initialize_stars', 'initialize_stars_cb' );
  add_action( 'wp_ajax_initialize_stars', 'initialize_stars_cb' );