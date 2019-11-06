<?php
/*
Plugin Name: Seed restoHouse Theme
Description: Plugin para insertar elementos en el tema de prueba
Version: 0.01
Author: Aldo
License: GPL 2
*/


function programmatically_create_post() {
	
	$foods = ['asd','adfg','dfg','ty','bjk','ghi','fgh'];
	$types = ['Hamburguer', 'Milkshake', 'Pizza', 'Soup', 'Cake', 'Hot dog', 'Pasta', 'salad'];
	$tags = ['italian', 'american', 'vegan', 'healty', 'unhealty', 'fast food', 'breakfast', 'lunch'];
	
	 require 'food-tag.php';
	require 'food-type.php';
	require 'food.php'; 
	
}	
  register_activation_hook( __FILE__, 'programmatically_create_post' ); 

