<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:57
 */
include 'BaseClass.php';

class order_manager extends BaseClass
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
                $this->viewOrder($data);
                break;
            case 'ADD':
                $this->addOrder($data);
                break;
            case 'EDIT':
                $this->editOrder($data);
                break;
            case 'DELETE':
                $this->deleteOrder($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewOrder($data){

        $this->connectDB();

        $query = "SELECT * FROM suppliers ORDER BY supplier_id";

        if(isset($data['id'])) {
            $id = mysqli_real_escape_string($this->getConn(), $data['id']);
            $query = "SELECT * FROM suppliers WHERE supplier_id='$id' ORDER BY supplier_id";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['supplier_id'];
                $email = $row['email_id'];
                $phone = $row['phone'];
                $mobile = $row['mobile'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $brand_name = $row['brand_name'];
                $brand_logo = $row['brand_logo'];
                $address = $row['address'];
                $lat = $row['lat'];
                $lng = $row['lng'];
                $mou_id = $row['mou_id'];

                $users[] = array(
                    "id"=> $id,
                    "email" => $email,
                    "phone" => $phone,
                    "mobile" => $mobile,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "brand_name" => $brand_name,
                    "brand_logo"=> $brand_logo,
                    "address" => $address,
                    "lat" => $lat,
                    "lng" => $lng,
                    "mou_id" => $mou_id
                );

            }

            $this->response($this->successCode, "Available Merchant Data ", $users);

        }else{

            $this->response($this->successCode, "Merchant Data Not Available!", []);

        }

    }

    private function addOrder($data){
        $this->response($this->successCode,'Add Order data',[]);

    }

    private function editOrder($data){
        $this->response($this->successCode,'Edit Order data',[]);

    }

    private function deleteOrder($data){
        $this->response($this->successCode,'Delete Order data',[]);

    }

}