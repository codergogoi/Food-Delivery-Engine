<?php
/**
 * Created by PhpStorm.
 * User: akbarmac
 * Date: 2019-03-12
 * Time: 16:59
 */

class user_manager extends BaseClass
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

            case 'PROFILE':
                $this->viewProfile($data);
                break;
            case 'SIGNUP':
                $this->registerUser($data);
                break;
            case 'SIGNIN':
                $this->loginUser($data);
                break;
            case 'EDIT':
                $this->editUser($data);
                break;
            case 'DELETE':
                $this->deleteUser($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewProfile($data){

        $this->connectDB();
//      $country_name = strtoupper(mysqli_real_escape_string($this->getConn(),$data['currency']));
//      $platform = intval(mysqli_real_escape_string($this->getConn(), $data['aui']));

        $query = "SELECT * FROM engin_access ORDER BY adm_id";

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $admin_id = $row['adm_id'];
                $admin_email = $row['adm_email'];
                $admin_pwd = $row['adm_pwd'];
                $admin_mobile = $row['adm_mobile'];
                $admin_lat = $row['adm_lat'];
                $admin_long = $row['adm_long'];
                $admin_status = boolval($row['adm_status']);
                $admin_type = $row['adm_type'];

                $users[] = array(
                    "id"=> $admin_id,
                    "email" => $admin_email,
                    "password" => $admin_pwd,
                    "mobile" => $admin_mobile,
                    "latitude" => $admin_lat,
                    "longitude" => $admin_long,
                    "status" => $admin_status,
                    "type"=> $admin_type
                );

            }

            $this->response($this->successCode, "Current Admin Users", $users);

        }else{

            $this->response($this->successCode, "No User Available!", []);

        }

    }

    private function loginUser($data){

        $this->connectDB();
//      $country_name = strtoupper(mysqli_real_escape_string($this->getConn(),$data['currency']));
//      $platform = intval(mysqli_real_escape_string($this->getConn(), $data['aui']));

        $query = "SELECT * FROM engin_access ORDER BY adm_id";

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $admin_id = $row['adm_id'];
                $admin_email = $row['adm_email'];
                $admin_pwd = $row['adm_pwd'];
                $admin_mobile = $row['adm_mobile'];
                $admin_lat = $row['adm_lat'];
                $admin_long = $row['adm_long'];
                $admin_status = boolval($row['adm_status']);
                $admin_type = $row['adm_type'];

                $users[] = array(
                    "id"=> $admin_id,
                    "email" => $admin_email,
                    "password" => $admin_pwd,
                    "mobile" => $admin_mobile,
                    "latitude" => $admin_lat,
                    "longitude" => $admin_long,
                    "status" => $admin_status,
                    "type"=> $admin_type
                );

            }

            $this->response($this->successCode, "Current Admin Users", $users);

        }else{

            $this->response($this->successCode, "No User Available!", []);

        }

    }

    private function registerUser($data){

        $this->connectDB();

        $email = mysqli_real_escape_string($this->getConn(),$data['email']);
        $pwd = mysqli_real_escape_string($this->getConn(),$data['password']);
        $phone = mysqli_real_escape_string($this->getConn(),$data['phone']);
        $type = mysqli_real_escape_string($this->getConn(),$data['type']);

        $sql = "INSERT INTO engin_access(adm_email,adm_pwd,adm_mobile,adm_type)VALUES('$email','$pwd','$phone','$type')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add Engine User!".$sql, []);
        }else{
            $this->response($this->successCode, "Sucessfully  Added Engine User!", []);
            return;
        }

    }

    private function editUser($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);
        $email = mysqli_real_escape_string($this->getConn(),$data['email']);
        $phone = mysqli_real_escape_string($this->getConn(),$data['phone']);
        $type = mysqli_real_escape_string($this->getConn(),$data['type']);
        $status = boolval(mysqli_real_escape_string($this->getConn(),$data['status']));

        $sql = "UPDATE engin_access SET adm_email='$email',adm_mobile='$phone',adm_type='$type', adm_status='$status' WHERE adm_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Error Occured while updating user Info!", []);
        }else{
            $this->viewUser($data);
        }

    }

    private function deleteUser($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);

        $sql = "DELETE FROM engin_access WHERE adm_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Failed to Delete User", []);
        }else{
            $this->viewUser($data);
        }

    }

}
