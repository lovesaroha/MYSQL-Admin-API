<?php 
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

  $data = json_decode(file_get_contents("php://input"));
  $fields = "";
  $values = "";
  $totalFields = count(get_object_vars($data));
  $count = 0;

  foreach ($data as $key => $value) {
      $fields .= "$key";
      $values .= "'$value'";
      $count++;
      if($count < $totalFields) {
          $fields .= " , ";
          $values .= " , ";
      }
  }

  $sql = "INSERT INTO $tableName ( $fields ) VALUES ( $values );";
  $result = $conn->query($sql);
  echo json_encode($result);
?>