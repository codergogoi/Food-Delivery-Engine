<?php

/*
"icons": { "16": "icon16.png",
           "48": "icon48.png",
          "128": "icon128.png" }
 *  */
/*
Edit agenda on get
Edit reservation on save
Delete notification response
 *  */
  
class Routes{
    
    private $input_uri = array();
    private $class_methods = array();
    
    
     public function add($uri, $method = null){
        
        $this->input_uri[] = '/'. trim($uri,'/');
        if($method != null){$this->class_methods[] = $method;}
     }
    
    public function routeToModels($isCaptured){
                
        $incomming_uri = isset($_GET['uri']) ? '/'.$_GET['uri'] : '/';

        
        foreach ($this->input_uri as $key => $val) {
             $ligitURL = strtolower($val);
             
            if(preg_match("#^$ligitURL#", strtolower($incomming_uri))){
                                
                     if(is_string($this->class_methods[$key])){

                         $currentClass = $this->class_methods[$key];
                         new $currentClass;
                         $isCaptured = true;
                         
                  }
             } 

         }
         

        return $isCaptured;
        
    }
     
    
    //only for Index           
    protected function response($status, $status_message,$data){

            //header("HTTP/1.1 $status $status_message");
            $response['status']= $status;
            $response['status_message'] = $status_message;
            $response['data'] = $data;

            $json_response = json_encode($response);
            echo $json_response;
                        
     }
     
}