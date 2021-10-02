<?php
    /*  Love Saroha
    lovesaroha1994@gmail.com (email address)
    https://www.lovesaroha.com (website)
    https://github.com/lovesaroha  (github)
    */
    // Get posted data.
    $data = json_decode(file_get_contents("php://input"));
    header('Content-Type: application/json');

    // Check form parameters.
    if(empty($data->hostname) || empty($data->username) || empty($data->password) || $data->port < 0) {
        http_response_code(500);
        echo json_encode(array("error" => "INVALIDFORMPARAMETERS"));
        exit;
    }

    // Create connection.
    try {
        $conn = new PDO("mysql:host=$data->hostname;port=$data->port", $data->username, $data->password);
        // set the PDO error mode to exception.
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Response json content.
        http_response_code(200);
        echo json_encode(array("connected" => true));
        exit;
      } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => "Cannot connect to mysql server, Make sure all credentials are right and mysql server is running"));
        exit;
      }
?>