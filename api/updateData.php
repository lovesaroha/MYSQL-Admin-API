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
  $setQuery = "";
  $whereQuery = "";
  $totalFields = count(get_object_vars($data)) / 2;
  $setCount = 0;
  $whereCount = 0;

  foreach ($data as $key => $value) {
    if(strpos($key , 'oldvalue') == true) {
        $whereCount++;
        $keyName = str_replace("oldvalue" , "" , $key);
        $whereQuery .= "$keyName = '$value'";
        if($whereCount < $totalFields) {
            $whereQuery .= " AND ";
        }
    } else {
        $setCount++;
        $setQuery.= "$key = '$value'";
        if($setCount < $totalFields) {
            $setQuery .= " , ";
        }
    }
  }

  $sql = "UPDATE $tableName SET $setQuery WHERE $whereQuery;";
  $result = $conn->query($sql);
  echo json_encode($result);
?>