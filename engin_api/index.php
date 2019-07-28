<?php //header('Access-Control-Allow-Origin: *');
      
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Accept-Charset,X-Accept,Content-Type,Authorization,Accept,Origin,Access-Control-Request-Method,Access-Control-Request-Headers");
    header("Content-Type: application/json");
    
    include 'endpoints.php';
    include 'routes.php';
     
    class index{
        
        var $routes = NULL; 
        
        public function __construct() {

            $this->routes = new Routes();

             foreach (Endpoints::FeaturesList as $k => $v) {
                 $this->routes->add(trim($k),preg_replace('/\s+/', '', $v));
             }
                         
        }
         
        function initUI(){


          if  ($this->routes->routeToModels(false) == false){
              $this->response('403',"End Point Does not Exist", []);
          };


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
    
    $self = new index();
    $self->initUI();
    
?>