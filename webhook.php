 1 <?php
 2 
 3 if($json = json_decode(file_get_contents("php://input"), true)) {
 4     print_r($json);
 5     $data = $json;
 6 } else {
 7     print_r($_POST);
 8     $data = $_POST;
 9 }
10 
11 echo "Saving data ...\n";
12 $url = "http://localhost:5984/incoming";
13 
14 $meta = &#91;"received" => time(),
15     "status" => "new",
16     "agent" => $_SERVER['HTTP_USER_AGENT']];
17 
18 $options = ["http" => [
19     "method" => "POST",
20     "header" => ["Content-Type: application/json"],
21     "content" => json_encode(["data" => $data, "meta" => $meta])]
22     ];
23 
24 $context = stream_context_create($options);
25 $response = file_get_contents($url, false, $context);