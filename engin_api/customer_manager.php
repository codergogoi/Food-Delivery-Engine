<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:57
 */

class customer_manager extends BaseClass
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
                $this->viewCustomer($data);
                break;
            case 'ADD':
                $this->addCustomer($data);
                break;
            case 'EDIT':
                $this->editCustomer($data);
                break;
            case 'DELETE':
                $this->deleteCustomer($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewCustomer($data){

        $this->connectDB();

        $query = "SELECT * FROM app_users ORDER BY member_id ORDER BY first_name";

        if(isset($data['id'])) {
            $id = mysqli_real_escape_string($this->getConn(), $data['id']);
            $query = "SELECT * FROM app_user WHERE member_id='$id'";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['member_id'];
                $email = $row['email_id'];
                $mobile = $row['mobile'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $address = $row['address'];

                $users[] = array(
                    "id"=> $id,
                    "email" => $email,
                    "mobile" => $mobile,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "address" => $address,

                );

            }

            $this->response($this->successCode, "Available User Data ", $users);

        }else{

            $this->response($this->successCode, "User Data Not Available!", []);

        }
    }

    private function addCustomer($data){
        $this->response($this->successCode,'Add Customer data',[]);

    }

    private function editCustomer($data){
        $this->response($this->successCode,'Edit Customer data',[]);

    }

    private function deleteCustomer($data){
        $this->response($this->successCode,'Delete Customer data',[]);

    }
}