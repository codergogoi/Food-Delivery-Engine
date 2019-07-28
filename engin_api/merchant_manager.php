<?php

include 'BaseClass.php';

class merchant_manager extends BaseClass
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
                $this->viewMerchant($data);
                break;
            case 'ADD':
                $this->addMerchant($data);
                break;
            case 'EDIT':
                $this->editMerchant($data);
                break;
            case 'DELETE':
                $this->deleteMerchant($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }


    private function viewMerchant($data){

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
                $locality = $row['locality'];
                $pincode = $row['pin_code'];
                $bank_name = $row['bank_name'];
                $account_number = $row['account_number'];
                $branch_address = $row['branch_address'];
                $availability = boolval($row['availability']);

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
                    "mou_id" => $mou_id,
                    "locality" => $locality,
                    "bank_name" => $bank_name,
                    "branch_address" => $branch_address,
                    "account_number" => $account_number,
                    "pin_code" => $pincode,
                    "availability" => $availability
                );

            }

            $this->response($this->successCode, "Available Merchant Data ", $users);

        }else{

            $this->response($this->successCode, "Merchant Data Not Available!", []);

        }

    }

    private function addMerchant($data){

        $this->connectDB();


        $email =  mysqli_real_escape_string($this->getConn(),$data['email']);

        if($email == ""){
            return;
        }

        $phone =  mysqli_real_escape_string($this->getConn(),$data['phone']);
        $mobile =  mysqli_real_escape_string($this->getConn(),$data['mobile']);
        $first_name =  mysqli_real_escape_string($this->getConn(),$data['first_name']);
        $last_name =  mysqli_real_escape_string($this->getConn(),$data['last_name']);
        $brand_name =  mysqli_real_escape_string($this->getConn(),$data['brand_name']);
        $address =  mysqli_real_escape_string($this->getConn(),$data['address']);
        $pin_code = mysqli_real_escape_string($this->getConn(),$data['pin_code']);
        $bank_name =  mysqli_real_escape_string($this->getConn(),$data['bank_name']);
        $branch_address =  mysqli_real_escape_string($this->getConn(),$data['branch_address']);
        $account_number =  mysqli_real_escape_string($this->getConn(),$data['account_number']);
        $ifsc =  mysqli_real_escape_string($this->getConn(),$data['ifsc_code']);
        $locality =  mysqli_real_escape_string($this->getConn(),$data['locality']);

        $mou_id =  "65454AHGF";
        $password = "123";

        $sql = "INSERT INTO suppliers(email_id,password,phone,mobile,first_name,last_name,address,brand_name,mou_id,pin_code,locality,account_number,bank_name,branch_address,ifsc_code)
 VALUES('$email','$password','$phone','$mobile','$first_name','$last_name','$address','$brand_name','$mou_id','$pin_code', '$locality','$account_number','$bank_name','$branch_address','$ifsc')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add Merchant!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Added Merchant!", []);
        }

    }

    private function editMerchant($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(), $data['id']);
        $email =  mysqli_real_escape_string($this->getConn(),$data['email']);
        $phone =  mysqli_real_escape_string($this->getConn(),$data['phone']);
        $mobile =  mysqli_real_escape_string($this->getConn(),$data['mobile']);
        $first_name =  mysqli_real_escape_string($this->getConn(),$data['first_name']);
        $last_name =  mysqli_real_escape_string($this->getConn(),$data['last_name']);
        $brand_name =  mysqli_real_escape_string($this->getConn(),$data['brand_name']);
        $address =  mysqli_real_escape_string($this->getConn(),$data['address']);
        $pin_code = mysqli_real_escape_string($this->getConn(),$data['pin_code']);
        $bank_name =  mysqli_real_escape_string($this->getConn(),$data['bank_name']);
        $branch_address =  mysqli_real_escape_string($this->getConn(),$data['branch_address']);
        $account_number =  mysqli_real_escape_string($this->getConn(),$data['account_number']);
        $ifsc =  mysqli_real_escape_string($this->getConn(),$data['ifsc']);
        $locality =  mysqli_real_escape_string($this->getConn(),$data['locality']);


        $sql = "UPDATE suppliers SET locality='$locality',ifsc_code='$ifsc', branch_address='$branch_address', bank_name='$bank_name', account_number='$account_number', email_id ='$email',phone='$phone',mobile='$mobile',first_name='$first_name',last_name='$last_name',address='$address',brand_name='$brand_name',pin_code='$pin_code' WHERE supplier_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to Update Merchant!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Updated Merchant!", []);
        }

    }

    private function deleteMerchant($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);

        $sql = "DELETE FROM suppliers WHERE supplier_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Failed to Delete Merchant ID", []);
        }else{
            $this->viewMerchant(null);
        }

    }

}