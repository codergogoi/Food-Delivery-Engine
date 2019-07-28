<?php

//import all required classes
include 'order_manager.php';
include 'product_manager.php';
include 'user_manager.php';
include 'invoice_manager.php';

class Endpoints{

    //features List 
    const FeaturesList  = array(
        '/orders'=> 'order_manager',
        '/products'=> 'product_manager',
        '/users'=>  'user_manager',
        '/invoice'=> 'invoice_manager',
         );
    
 }
 
 

