<?php
include("config.php");
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {

        case 'add_server':
            addServer();
            break;
        case 'add_service':
            addService();
            break;
        default:
            $res = [
                'status' => 400,
                'message' => 'Invalid action'
            ];
            echo json_encode($res);
            break;
    }
}
function addServer()
{
    global $conn;
    $server_name = mysqli_real_escape_string($conn, $_POST['server_name']);
    $checkQuery = "SELECT server_name FROM server WHERE server_name = '$server_name'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        // Server already exists, send a response
        $response = [
            'status' => 400,  
            'message' => 'Server already found. Please choose a different server name.'
        ];
        echo json_encode($response);
        return;
    } else {
        $insertQuery = "INSERT INTO server (server_name) VALUES ('$server_name')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Server added successfully
            $response = [
                'status' => 200,  
                'message' => 'Server added successfully.'
            ];
            echo json_encode($response);
            return;
        }
    }
}
function addService()
{
    global $conn;
    $server_name = mysqli_real_escape_string($conn, $_POST['server_name']);
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $checkQuery = "SELECT service_name FROM services WHERE server_name = '$server_name' AND service_name='$service_name'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        // Service already exists, send a response
        $response = [
            'status' => 400,  
            'message' => 'Service already found in the server. Please choose a different service name.'
        ];
        echo json_encode($response);
        return;
    } else {
        $insertQuery = "INSERT INTO services (server_name,service_name) VALUES ('$server_name','$service_name')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Service added successfully
            $response = [
                'status' => 200,  
                'message' => 'Service added successfully.'
            ];
            echo json_encode($response);
            return;
        }
    }
}
