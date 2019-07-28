<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:59
 */

class error_log extends BaseClass
{


    public function __construct()
    {
        parent:: __construct();
        $this->initData();
    }

    private function initData(){

        $data = json_decode(file_get_contents('php://input'), true);

        $uri_array =  explode("/",$_GET['uri']);

        $command = strtoupper($uri_array[1]);

        switch($command){

            case 'VIEW':
                $this->viewLog($data);
                break;
            case 'ADD':
                $this->addLog($data);
                break;
            case 'EDIT':
                $this->editLog($data);
                break;
            case 'DELETE':
                $this->deleteLog($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewLog($data){

        $this->response($this->successCode,'View Log data',[]);

    }

    private function addLog($data){
        $this->response($this->successCode,'Add Log data',[]);

    }

    private function editLog($data){
        $this->response($this->successCode,'Edit Log data',[]);

    }

    private function deleteLog($data){
        $this->response($this->successCode,'Delete Log data',[]);

    }

}