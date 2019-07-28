<?php

class BaseClass{


    var $hostName = "localhost";

    var $userName = "demo";
    var $password = "demo123";
    var $dbName = "basket";

    /*
    var $userName = 'javacope_basket';
    var $password = '$1984$Basket$1984$';
    var $dbName = 'javacope_basket';
    */


    var $conn = NULL;

    var $successCode = 200;
    var $failureCode = 404;
    var $existCode = 202;


    public function __construct()
    {

    }


    function connectDB(){

        date_default_timezone_set("Asia/Kolkata");

        $this->conn = mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);
        
          if(mysqli_connect_errno()){
            // echo mysqli_connect_error();
             echo 'Fail to connect with database.'.mysqli_connect_error() ;
         } 
         
        if(!$this->conn){
            die("cannot connect to the database");
        } 
        
        mysqli_set_charset($this->conn, 'utf8');
         
    }
        
    function getConn(){
        
        return mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);

    }

    function responseWithName($name){
        $this->response($this->successCode,'Working With'. $name, []);
    }


    //Format response to JSON structured Data
    function response($status, $status_message,$data){

        //header("HTTP/1.1 $status $status_message");
        $response['status']= $status;
        $response['message'] = $status_message;
        $response['data'] = $data;

        $json_response = json_encode($response);
        echo $json_response;

    }


}

