<?php

class Index
{

    function init()
    {
        $this->response('404', 'Request does not Exist!', []);
    }


//Format response to JSON structured Data
    function response($status, $status_message, $data)
    {

        //header("HTTP/1.1 $status $status_message");
        $response['status'] = $status;
        $response['message'] = $status_message;
        $response['data'] = $data;

        $json_response = json_encode($response);
        echo $json_response;

    }

}

$self = new Index();
$self->init();
