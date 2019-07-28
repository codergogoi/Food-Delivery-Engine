<?php

class product_manager extends BaseClass
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

            case 'CATEGORY':

                $this->viewByCategory($data);
                break;
            case 'VIEW':

                $this->viewProducts($data);
                break;


            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }



    // CATEGORY

    private function viewByCategory($data){

        $this->connectDB();

        $query = "SELECT pc.*, psc.* FROM product_category pc LEFT JOIN product_sub_category psc ON pc.cat_id = psc.cat_id ORDER BY pc.cat_name";

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['cat_id'];
                $name = $row['cat_name'];
                $cat_section = $row['cat_section'];
                $sub_cat_id = $row['sub_cat_id'];
                $sub_cat_name = $row['sub_cat_name'];

                if($sub_cat_id != NULL){
                    $users[$name][] = array(
                        "id"=> $id,
                        "name" => $sub_cat_name,
                        "section" => $cat_section,
                        "sub_id" => $sub_cat_id,
                    );
                }

            }

            $category = array();


            foreach($users as $k => $val){

                $category[] = array("cat" => $k, "product" => $val);

            }


            $this->response($this->successCode, "Available Category Data ", $category);

        }else{

            $this->response($this->successCode, "Category Data Not Available!", []);

        }
    }

    private function viewProducts($data){

        $id =  mysqli_real_escape_string($this->getConn(),$data['id']);


        $this->connectDB();

        $query = "SELECT pd.*, pp.* FROM products pd LEFT JOIN products_pricing pp ON pd.product_id = pp.product_id WHERE pd.sub_cat_id='$id' ORDER BY pd.product_name ASC, pp.pack_unit DESC";

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['product_id'];
                $name = $row['product_name'];
                $pack_id = $row['package_id'];
                $pack_unit = $row['pack_unit'];
                $price = $row['price'];
                $product_unit = $row['product_unit'];
                $local_name = $row['local_name'];

                $users[$name][] = array(
                    "id"=> $id,
                    "name" => $name,
                    "pack_unit" => $pack_unit,
                    "pack_id" => $pack_id,
                    "price" => $price,
                    "unit"=> $product_unit,
                    "local_name"=> $local_name
                );

            }

            $category = array();


            foreach($users as $k => $val){

                $local_name = $val[0]["local_name"];
                $price = number_format(doubleval($val[0]["price"]), 2);

                $category[] = array("name" => $k, "pack" => $val, "local_name" => $local_name, "default_price" => $price);

            }


            $this->response($this->successCode, "Available Category Data ", $category);

        }else{

            $this->response($this->successCode, "Category Data Not Available!", []);

        }
    }



}