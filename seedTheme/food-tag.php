<?php

if( taxonomy_exists( 'food-tag' ) ){
    foreach( $tags as  $tag ){
        if( !term_exists( $tag, 'food-tag' ) ) {
            wp_insert_term(
                $tag,
                'food-tag',
                array(
                'description' => 'This is an example category created with wp_insert_term.',
                )
            );
        }
    }
}