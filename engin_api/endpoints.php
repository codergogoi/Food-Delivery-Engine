<?php

//import all required classes
include 'merchant_manager.php';
include 'customer_manager.php';
include 'order_manager.php';
include 'product_manager.php';
include 'user_manager.php';
include 'delivery_manager.php';
include 'invoice_manager.php';
include 'error_log.php';
  
class Endpoints{

    //features List 
    const FeaturesList  = array(
        '/merchant'=> 'merchant_manager',
        '/customer'=> 'customer_manager',
        '/orders'=> 'order_manager',
        '/products'=> 'product_manager',
        '/users'=>  'user_manager',
        '/delivery'=> 'delivery_manager',
        '/invoice'=> 'invoice_manager',
        '/error'=> 'error_log'
         );
    
 }
 
 

