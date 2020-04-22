<?php

    include("koneksi.php");

    $db = new dObj();
    $connection = $db->getConnstring();

    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["id"])) {
                $id = intval($_GET["id"]);
                get_employee($id);
            } else {
                get_employees();
            }
            break;

        case 'POST':
            insert_employee();
            break;

        case 'PUT':
            $id = intval($_GET["id"]);
            update_employee($id);
            break;

        case 'DELETE':
            $id = intval($_GET["id"]);
            delete_employee($id);
            break;
            
        default:
            header("HTTP/1.0 405 Method Not Allow");
            break;
    }

    function get_employee($id){

        global $connection;

        $query = "SELECT * FROM `tb_employee` WHERE id = $id";

        $response = array();

        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
            
        }header('Content-Type:application/json');
        echo json_encode($response);
    }


    function get_employees(){

        global $connection;

        $query = "SELECT * FROM `tb_employee`";

        $response = array();
        
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }header('Content-Type:application/json');
        echo json_encode($response);
    }

    function insert_employee(){

        global $connection;

        $data = json_decode(file_get_contents('php://input'), true);

        $nama = $data['name'];
        $gaji = $data['salary'];
        $umur = $data['age'];

        $query = "INSERT INTO `tb_employee` (`id`, `name`, `salary`, `age`) VALUES (NULL, '".$nama."', '".$gaji."', '". $umur."')";

        if (mysqli_query($connection, $query)) {
            $response = array(
                'status' => 1,
                'status_message' => 'Employee Added Success.');
        } else{
            $response = array(
                'status' => 0,
                'status_message' => 'Employee Add Fail');
        }
        header('Content-Type:application/json');
        echo json_encode($response);
    }

    function update_employee($id){

        global $connection;

        $post_vars = json_decode(file_get_contents("php://input"), true);

        $nama = $post_vars['name'];
        $gaji = $post_vars['salary'];
        $umur = $post_vars['age'];

        $query = "UPDATE `tb_employee` SET `name` = '" . $nama . "', `salary` = '" . $gaji . "', `age` = '" . $umur . "' WHERE `tb_employee`.`id` =" . $id;
        if (mysqli_query($connection, $query)) {
            $response = array(
                'status' => 1,
                'status_message' => 'Employee Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Employee Update Fail'
            );
        }
        header('Content-Type:application/json');
        echo json_encode($response);
    }

    function delete_employee($id){

        global $connection;
        
        $query = "DELETE FROM `tb_employee` WHERE `tb_employee`.`id` =".$id;

        if (mysqli_query($connection, $query)) {
            $response = array(
                'status' => 1,
                'status_message' => 'Employee Delete Success');
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Employee Delete Fail');
        }header('Content-Type:application/json');
        echo json_encode($response);
        }

    ?>