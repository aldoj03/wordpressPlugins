<?php

if( post_type_exists( 'food' )){
	foreach( $foods as $food ){  
	$selectedTags = null;
	$random = ceil(rand( 0, 7 ));
	$type = $types[$random];
	for ($i=0; $i < $random ; $i++) { 
	   $randomTag = ceil(rand(0, 7));
	   $selectedTags[] = $tags[$randomTag];
   }
		if( !post_exists( $title ) ){ 
		   $author_id = get_current_user_id();        
		   $post_id = wp_insert_post(
		   array(
			   'comment_status'	=>	'closed',
			   'ping_status'		=>	'closed',
			   'post_author'		=>	$author_id,
			   'post_title'		=>	$food,
			   'post_status'		=>	'publish',
			   'post_type'			=>	'food',
			   'post_content'  	=>  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum fugiat praesentium ex assumenda numquam accusamus nsed.',
			   'tax_input'			=>	array(										
											'food-tag'	=>	$selectedTags 
										   )	 
		   )
		   );
		  
		   wp_set_object_terms( $post_id, $type, 'food-type' );
		}  
	} 
}