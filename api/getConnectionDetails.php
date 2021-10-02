<?php
    /*  Love Saroha
    lovesaroha1994@gmail.com (email address)
    https://www.lovesaroha.com (website)
    https://github.com/lovesaroha  (github)
    */
    $headers = apache_request_headers();
    $hostname = $headers["X-HOSTNAME"];
    $port = $headers["X-PORT"];
    header('Content-Type: application/json');
    // Create connection.
    try {
        $conn = new PDO("mysql:host=$hostname;port=$port", $headers["X-USERNAME"], $headers["X-PASSWORD"]);
        // set the PDO error mode to exception.
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => "CANNOTCONNECT"));
        exit;
      }

    $serverInfo = $conn->getAttribute(PDO::ATTR_SERVER_INFO);
    $serverVersion = $conn->getAttribute(PDO::ATTR_SERVER_VERSION);
    $driverName = $conn->getAttribute(PDO::ATTR_DRIVER_NAME);
    $connectionStatus = $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);

    $result = $conn->query("SHOW DATABASES;");
    $databases = $result->fetchAll();

    http_response_code(200);
    echo json_encode(array("databases" => $databases ,"driverName" => $driverName, "status" => $connectionStatus, "version" => $serverVersion, "serverInfo" => $serverInfo));  
?> 