<?php

if( taxonomy_exists( 'food-type' ) ){
    foreach( $types as  $type ){
        if( !term_exists( $type, 'food-type' ) ) {
        wp_insert_term(
            $type,
            'food-type',
            array(
              'description' => 'This is an example category created with wp_insert_term.',
            )
        );
        }
    }
}
 

