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

            case 'VIEW':
                $this->viewProducts($data);
                break;
            case 'ADD':
                $this->addProduct($data);
                break;
            case 'EDIT':
                $this->editProduct($data);
                break;
            case 'DELETE':
                $this->deleteProduct($data);
                break;
            case 'VIEWCATEGORY':
                $this->viewCategory($data);
                break;
            case 'ADDCATEGORY':
                $this->addCategory($data);
                break;
            case 'VIEWSUBCATEGORY':
                $this->viewSubCategory($data);
                break;
            case 'ADDSUBCATEGORY':
                $this->addSubCategory($data);
                break;
                //Package Unit
            case 'VIEWUNIT':
                $this->viewUnit($data);
                break;
            case 'ADDUNIT':
                $this->addUnit($data);
                break;
            case 'EDITUNIT':
                $this->editUnit($data);
                break;
            case 'UPDATEUNIT':
                $this->updateUnit($data);
                break;
            case 'DELETEUNIT':
                $this->deleteUnit($data);
                break;
            default:
                $this->response($this->failureCode,'End Point Does not Match',[]);
                break;
        }

    }

    private function viewProducts($data){

        $this->connectDB();

        $query = "SELECT * FROM products ORDER BY product_name";

        if(isset($data['id'])){
            $id = mysqli_real_escape_string($this->getConn(),$data['id']);
            $query = "SELECT * FROM products WHERE product_id='$id' ORDER BY product_name";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['product_id'];
                $name = $row['product_name'];
                $localize_name = $row['local_name'];
                $desc = $row['product_desc'];
                $unit = $row['product_unit'];
                $availability = boolval($row['availability']);
                $mfg = $row['mfg'];
                $exp_date = $row['exp'];
                $img_dir = $row['img_dir'];

                $users[] = array(
                    "id"=> $id,
                    "name" => $name,
                    "desc" => $desc,
                    "local_name" => $localize_name,
                    "unit" => $unit,
                    "availability" => $availability,
                    "mfg" => $mfg,
                    "exp_date"=> $exp_date,
                    "img_dir" => $img_dir,

                );

            }

            $this->response($this->successCode, "Available Product Data ", $users);

        }else{

            $this->response($this->successCode, "Product Data Not Available!", []);

        }
    }

    private function addProduct($data){

        $this->connectDB();


        $name =  mysqli_real_escape_string($this->getConn(),$data['name']);
        $desc =  mysqli_real_escape_string($this->getConn(),$data['desc']);
        $unit =  mysqli_real_escape_string($this->getConn(),$data['unit']);
        $category_id =  mysqli_real_escape_string($this->getConn(),$data['id']);
        $localize_name =  mysqli_real_escape_string($this->getConn(),$data['local_name']);

        $mfg = date("Y-m-d");

        if(isset($data['mfg']) && strlen($data['mfg']) > 0) {
            $mfg = mysqli_real_escape_string($this->getConn(), $data['mfg']);
        }

        $exp = date("Y-m-d");
        if(isset($data['exp']) && strlen($data['exp']) > 0) {
            $exp = mysqli_real_escape_string($this->getConn(), $data['exp']);
        }

        $img_dir =  mysqli_real_escape_string($this->getConn(),$data['img_dir']);

        $sql = "INSERT INTO products(product_name,product_desc,product_unit,mfg,exp,img_dir, sub_cat_id, local_name) VALUES('$name','$desc','$unit','$mfg','$exp','$img_dir','$category_id','$localize_name')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add Product!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Added Product!", []);
        }

    }

    private function editProduct($data){

        $this->connectDB();

        $name =  mysqli_real_escape_string($this->getConn(),$data['name']);
        $desc =  mysqli_real_escape_string($this->getConn(),$data['desc']);
        $unit =  mysqli_real_escape_string($this->getConn(),$data['unit']);
        $id = mysqli_real_escape_string($this->getConn(),$data['id']);
        $local_name = mysqli_real_escape_string($this->getConn(), $data['local_name']);

        if($id == ""){
            return;
        }

        $sql = "UPDATE products SET product_name='$name',product_desc='$desc',product_unit='$unit', local_name='$local_name' WHERE product_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to Edit Product!".$sql, []);
        }else{
            $this->response($this->successCode, "Successfully  Edited Product!", []);
        }

    }

    private function deleteProduct($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);

        $sql = "DELETE FROM products WHERE product_id ='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Failed to Delete Product", []);
        }else{
            $this->viewProducts(null);
        }
    }

    // CATEGORY

    private function viewCategory($data){

        $this->connectDB();

        $query = "SELECT * FROM product_category ORDER BY cat_name";

        if(isset($data['id'])){
            $id = mysqli_real_escape_string($this->getConn(),$data['id']);
            $query = "SELECT * FROM product_category WHERE cat_id='$id' ORDER BY cat_name";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['cat_id'];
                $name = $row['cat_name'];
                $localize_name = $row['cat_local_name'];


                $users[] = array(
                    "id"=> $id,
                    "name" => $name,
                    "localize_name" => $localize_name,

                );

            }

            $this->response($this->successCode, "Available Category Data ", $users);

        }else{

            $this->response($this->successCode, "Category Data Not Available!", []);

        }
    }


    private function addCategory($data){

        $this->connectDB();

        $name =  mysqli_real_escape_string($this->getConn(),$data['catName']);
        $section =  mysqli_real_escape_string($this->getConn(),$data['catSection']);
        $localize_name =  mysqli_real_escape_string($this->getConn(),$data['catLocalName']);

        if($name == "" && $section == "") return;

        $sql = "INSERT INTO product_category(cat_name,cat_section,cat_local_name) VALUES('$name','$section','$localize_name')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add Product!".$sql, []);
        }else{
            $this->viewCategory($data);
        }

    }

    // SUB CATEGORY


    private function viewSubCategory($data){

        $this->connectDB();

        $query = "SELECT * FROM product_sub_category ORDER BY sub_cat_name";

        if(isset($data['id'])){
            $id = mysqli_real_escape_string($this->getConn(),$data['id']);
            $query = "SELECT * FROM product_sub_category WHERE sub_cat_id='$id' ORDER BY sub_cat_name";
        }

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $users = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['sub_cat_id'];
                $name = $row['sub_cat_name'];
                $localize_name = $row['sub_cat_local_name'];

                $users[] = array(
                    "id"=> $id,
                    "name" => $name,
                    "localize_name" => $localize_name,

                );

            }

            $this->response($this->successCode, "Available Sub Category Data ", $users);

        }else{

            $this->response($this->successCode, "Sub Category Data Not Available!", []);

        }
    }

    private function addSubCategory($data){

        $this->connectDB();

        $id =  mysqli_real_escape_string($this->getConn(),$data['id']);
        $name =  mysqli_real_escape_string($this->getConn(),$data['subCatName']);
        $localize_name =  mysqli_real_escape_string($this->getConn(),$data['subCatLocalName']);

        if($name == "" && $id == "") return;

        $sql = "INSERT INTO product_sub_category(sub_cat_name,sub_cat_local_name,cat_id) VALUES('$name','$localize_name','$id')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add  Sub Category!".$sql.'ID'.$id, []);
        }else{
            $this->viewSubCategory(null);
        }

    }

    // Add Unit

    private function viewUnit($data){

        $this->connectDB();

        $id = mysqli_real_escape_string($this->getConn(),$data['id']);
        $query = "SELECT * FROM products_pricing WHERE product_id='$id' ORDER BY pack_unit";

        $result = mysqli_query($this->conn,$query);

        if (mysqli_num_rows($result) > 0){

            $packages = array();

            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['package_id'];
                $product_id = $row['product_id'];
                $unit = doubleval($row['pack_unit']);
                $price = doubleval($row['price']);
                $discount = doubleval($row['discount']);
                $availability = boolval($row['availability']);

                $packages[] = array(
                    "id"=> $id,
                    "product_id" => $product_id,
                    "unit" => $unit,
                    "price" => $price,
                    "availability" => $availability,
                    "discount" => $discount
                );

            }

            $this->response($this->successCode, "Available Package Data ", $packages);

        }else{

            $this->response($this->successCode, "Data Not Available!", []);

        }
    }


    private function addUnit($data){

        $this->connectDB();

        $product_id =  mysqli_real_escape_string($this->getConn(),$data['id']);
        $unit =  doubleval(mysqli_real_escape_string($this->getConn(),$data['unit']));
        $price =  doubleval(mysqli_real_escape_string($this->getConn(),$data['price']));
        $discount =  doubleval(mysqli_real_escape_string($this->getConn(),$data['discount']));
        $availability = intval(mysqli_real_escape_string($this->getConn(),$data['availability']));

        if($availability == "") $availability = 0;

        if($unit == "" && $price == "") return;

        $sql = "INSERT INTO products_pricing(product_id,pack_unit,price,discount,availability) VALUES('$product_id','$unit','$price','$discount','$availability')";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add  Sub Category!".$sql, []);
        }else{
            $this->viewUnit($data);
        }

    }

    private function updateUnit($data){

        $this->connectDB();

        $id =  mysqli_real_escape_string($this->getConn(),$data['product_id']);
        $availability = intval(mysqli_real_escape_string($this->getConn(),$data['availability']));

        if($id == "" ) return;

        $sql = "UPDATE products_pricing SET availability='$availability' WHERE package_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add  Sub Category!".$sql, []);
        }else{
            $this->viewUnit($data);
        }

    }


    private function editUnit($data){

        $this->connectDB();

        $id =  mysqli_real_escape_string($this->getConn(),$data['product_id']);
        $unit =  doubleval(mysqli_real_escape_string($this->getConn(),$data['unit']));
        $price =  mysqli_real_escape_string($this->getConn(),$data['price']);
        $discount =  mysqli_real_escape_string($this->getConn(),$data['discount']);
        $availability = boolval(mysqli_real_escape_string($this->getConn(),$data['availability']));

        if($unit == "" && $price == "") return;

        $sql = "UPDATE products_pricing SET pack_unit='$unit',price='$price',discount='$discount',availability='$availability' WHERE package_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to add  Sub Category!".$sql, []);
        }else{
            $this->viewUnit($data);
        }

    }

    private function deleteUnit($data){

        $this->connectDB();

        $id =  mysqli_real_escape_string($this->getConn(),$data['product_id']);

        if($id == "") return;

        $sql = "DELETE FROM products_pricing WHERE package_id='$id'";

        if(!mysqli_query($this->conn, $sql)) {
            $this->response($this->failureCode, "Unable to Delete!".$sql, []);
        }else{
            $this->viewUnit($data);
        }

    }


}