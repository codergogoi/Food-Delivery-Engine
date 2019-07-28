<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:58
 */

class invoice_manager extends BaseClass
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
                $this->viewInvoice($data);
                break;
            case 'EDIT':
                $this->editInvoice($data);
                break;
            case 'DELETE':
                $this->deleteInvoice($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewInvoice($data){

        $this->response($this->successCode,'View Invoice data',[]);

    }

    private function addInvoice($data){
        $this->response($this->successCode,'Add Invoice data',[]);

    }

    private function editInvoice($data){
        $this->response($this->successCode,'Edit Invoice data',[]);

    }

    private function deleteInvoice($data){
        $this->response($this->successCode,'Delete Invoice data',[]);

    }
}