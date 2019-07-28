<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:58
 */

class delivery_manager extends  BaseClass
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
                $this->viewAgents($data);
                break;
            case 'ADD':
                $this->addAgents($data);
                break;
            case 'EDIT':
                $this->editAgents($data);
                break;
            case 'DELETE':
                $this->deleteAgents($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }


    private function viewAgents($data){

        $this->connectDB();

        $query = "SELECT * FROM shipping ORDER BY delivery_id";

        if(isset($data['id'])) {
            $id = mysqli_real_escape_string($this->getConn(), $data['id']);
            $query = "SELECT * FROM shipping WHERE delivery_id='$id' ORDER BY first_name";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['delivery_id'];
                $email = $row['email_id'];
                $phone = $row['phone'];
                $mobile = $row['mobile'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $pan_number = $row['pan_number'];
                $adhar_number = $row['adhar_number'];
                $address = $row['address'];
                $lat = $row['lat'];
                $lng = $row['lng'];
                $mou_id = $row['doc_id'];

                $users[] = array(
                    "id"=> $id,
                    "email" => $email,
                    "phone" => $phone,
                    "mobile" => $mobile,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "pan_number" => $pan_number,
                    "adhar_number"=> $adhar_number,
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

    private function addAgents($data){

        $this->connectDB();

        $email =  mysqli_real_escape_string($this->getConn(),$data['email']);
        $phone =  mysqli_real_escape_string($this->getConn(),$data['phone']);
        $mobile =  mysqli_real_escape_string($this->getConn(),$data['mobile']);
        $first_name =  mysqli_real_escape_string($this->getConn(),$data['first_name']);
        $last_name =  mysqli_real_escape_string($this->getConn(),$data['last_name']);
        $address =  mysqli_real_escape_string($this->getConn(),$data['address']);
        $lat =  mysqli_real_escape_string($this->getConn(),$data['lat']);
        $lng =  mysqli_real_escape_string($this->getConn(),$data['lng']);
        $password = mysqli_real_escape_string($this->getConn(), $data['password']);
        $pin_code = mysqli_real_escape_string($this->getConn(),$data['pin_code']);
        $doc_id =  mysqli_real_escape_string($this->getConn(),$data['doc_id']);
        $pan_number = mysqli_real_escape_string($this->getConn(),$data['pan_number']);
        $adhar_number = mysqli_real_escape_string($this->getConn(),$data['adhar_number']);

        $sql = "INSERT INTO shipping(email_id,password,phone,mobile,first_name,last_name,address,lat,lng,doc_id,pin_code,pan_number, adhar_number) 
                VALUES('$email','$password','$phone','$mobile','$first_name','$last_name','$address','$lat','$lng','$doc_id','$pin_code','$pan_number','$adhar_number')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add Deliver Person!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Added Delivery Person!", []);
        }

    }

    private function editAgents($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(), $data['id']);
        $email =  mysqli_real_escape_string($this->getConn(),$data['email']);
        $phone =  mysqli_real_escape_string($this->getConn(),$data['phone']);
        $mobile =  mysqli_real_escape_string($this->getConn(),$data['mobile']);
        $first_name =  mysqli_real_escape_string($this->getConn(),$data['first_name']);
        $last_name =  mysqli_real_escape_string($this->getConn(),$data['last_name']);
        $address =  mysqli_real_escape_string($this->getConn(),$data['address']);
        $lat =  mysqli_real_escape_string($this->getConn(),$data['lat']);
        $lng =  mysqli_real_escape_string($this->getConn(),$data['lng']);
        $pin_code = mysqli_real_escape_string($this->getConn(),$data['pin_code']);
        $doc_id =  mysqli_real_escape_string($this->getConn(),$data['doc_id']);
        $pan_number = mysqli_real_escape_string($this->getConn(),$data['pan_number']);
        $adhar_number = mysqli_real_escape_string($this->getConn(),$data['adhar_number']);

        $sql = "UPDATE shipping SET email_id ='$email',phone='$phone',mobile='$mobile',first_name='$first_name',last_name='$last_name',address='$address',pan_number='$pan_number',adhar_number='$adhar_number',lat='$lat',lng='$lng',doc_id='$doc_id',pin_code='$pin_code' WHERE delivery_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {

            $this->response($this->failureCode, "Unable to Update Merchant!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Updated Merchant!", []);
        }
    }

    private function deleteAgents($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);

        $sql = "DELETE FROM shipping WHERE delivery_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Failed to Delete Delivery data", []);
        }else{
            $this->viewAgents(null);
        }
    }

}