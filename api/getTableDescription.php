<?php 
    /*  Love Saroha
    lovesaroha1994@gmail.com (email address)
    https://www.lovesaroha.com (website)
    https://github.com/lovesaroha  (github)
    */
    $headers = apache_request_headers();
    $hostname = $headers["X-HOSTNAME"];
    $port = $headers["X-PORT"];
    $databaseName = $headers["X-DATABASE"];
    $tableName = $headers["X-TABLENAME"];
    header('Content-Type: application/json');
    // Create connection.
    try {
        $conn = new PDO("mysql:host=$hostname;port=$port;dbname=$databaseName", $headers["X-USERNAME"], $headers["X-PASSWORD"]);
        // set the PDO error mode to exception.
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => "CANNOTCONNECT"));
        exit;
      }
    
      $sql = "DESCRIBE $tableName";
      $result = $conn->query($sql);
      $columns = $result->fetchAll();
  
      http_response_code(200);
      echo json_encode(array("columns" => $columns));  
?>