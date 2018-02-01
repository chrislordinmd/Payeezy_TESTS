<?php
date_default_timezone_set('UTC');
//echo date_default_timezone_get();

error_reporting(E_ALL ^ E_NOTICE);
//demo gateway ID: AC5550-05
//demo password: hotdog10
//demo key ID: 62348
//demo HMAC key: rtQGfIgYsItRKkQJZyo_AHFVU8o3J6nB


	$address = array( 
		'address1'=>'z street',
		'city'=>'hatertown',
		'state'=>'MD',
		'zip'=>'12345',
	);

  		  	
$line_items = array(array(
		  'quantity'=> '2',
		  'commodity_code'=> '40054',
		  'description'=> 'tacopack',
		  'discount_amount'=> '00.00',
		  'discount_indicator'=> '1',
		  'gross_net_indicator'=> '0',
		  'line_item_total'=> '20.00',
		  'product_code'=> 'PN0339763321',
		  'tax_amount'=> '1.01',
		  'tax_rate'=> '7.25',
		  'tax_type'=> '2',
		  'unit_cost'=> '10.00',
		  'unit_of_measure'=> 'QTL',		
		),
	);
	
$json_arr = array(
	'gateway_id' => 'AC5550-05',
	'authorization_num' => '',
	'transaction_type' => '00',
	'transaction_tag' => '',	
	//'credit_card_type' => 'Visa',
	'cc_expiry' => '1220',
	'amount' =>'302.00', 
	'cardholder_name' => 'FirstData Test', 
	'cc_number' => '4788250000028291',
	'cvd_presence_ind' => '0',
	'cvd_code' => '123',
	'password'=>'hotdog10',
    'transarmor_token'=>'',
	'reference_no' => '1234567890',
	'customer_ref' => '123456',
	'reference_3' => '',
	'address' => $address,

	
	 		'level3'=> array(
            'alt_tax_amount'=> '0.0',
            'alt_tax_id'=> '',
            'discount_amount'=> '0.00',
  		  	'duty_amount'=> '0.00',
            'freight_amount'=> '5.00',
            'ship_from_zip'=> '64111',

		
		  'line_items'=> $line_items,

		  'ship_to_address'=> array(
		  'address_1'=> '123 shipping st',
		  'city' => 'hatertown',
		  'country' =>'US',
		  'customer_number' =>'90125',
		  'email' => 'test@test.com',
		  'name' => 'Bob Loblaw',
		  'phone' => '3011234567',
		  'state' => 'MD',
		  'zip' => '21742',
		  ),
		 ) 

);
		
		

	
/*remove transarmor_token is empty remove from array
if transarmor property is sent without a value, it will return error(only with json)	*/
if (empty($json_arr['transarmor_token'])) {
unset($json_arr['transarmor_token']);
}

$body = json_encode($json_arr);

//$ExactID = 'AC5550-05';
//$Password = 'hotdog10';
//hmac key=rtQGfIgYsItRKkQJZyo_AHFVU8o3J6nB
//key id= 62348


$version = 'v19';
$method = "POST\n";
$type = "application/json\n"; 
$time = date('Y-m-d\TH:i:s').Z;
$uri = "/transaction/".$version; 
$keyId = "62348"; //key id 
$key = "rtQGfIgYsItRKkQJZyo_AHFVU8o3J6nB"; //hmac key
$hmac_data = $method . $type . sha1($body) . "\n" . $time . "\n" . $uri;
$base64_hash = base64_encode (hash_hmac("sha1",$hmac_data,$key,TRUE));
$url = "https://api.demo.globalgatewaye4.firstdata.com/transaction/".$version;


$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Type:application/json","authorization:GGE4_API ". $keyId . ":" . $base64_hash,"x-gge4-content-sha1:" . sha1($body),"x-gge4-date:" . $time));
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($ch, CURLOPT_USERPWD, $ExactID . ":" . $Password);
//curl_setopt($ch, CURLOPT_PROXY, 'fdcproxy.1dc.com:8080/accelerated_pac_base.pac');
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_SSLCERT, $pemlocation);
//curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
$result = curl_exec($ch);
$headers = curl_getinfo($ch);
curl_close($ch);
//var_dump ($result);
$arr = json_decode($result, true);
$arr2 = json_decode($result, true);
//var_dump ($arr);
$ctr = array('ctr');
foreach($ctr as $ctr_key) {
   unset($arr[$ctr_key]);
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>GGE4 WS API HMAC cURL</title>
<style type="text/css">

pre.rxml
{
	font-size: 12.5px;
	color:#333;
	border:2px solid #a1a1a1;
	padding:20px 40px;
	width:700px;
	border-radius:25px;
	-moz-border-radius:25px; /* Old Firefox */
	white-space: pre-wrap;       /* css-3 */
	white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	word-wrap: break-word;       /* Internet Explorer 5.5+ */
	background-color:#F2F2F2
} 
body {font-family: Arial, Helvetica, sans-serif;font-size: 12px;text-align: left;}
table {padding:6px; border:0; margin-bottom:20px;}
th {background-color:#CACACA;padding:4px;border-radius:3em 1em 5em / 0.5em 3em;
-moz-border-radius:2em 1em 4em / 0.5em 3em;; /* Old Firefox */}
header {color:#333;font-size:14px;}
</style>
</head>
<table> 
<tbody>
<?php
	if ($arr){?>
	<tr><th>Bank_Message:</th>
    <td><?php echo $arr['bank_message'];?></td></tr>
	<tr> <th>EXact_Message:</th>
    <td><?php echo $arr['exact_message'];?></td></tr>
	<tr> <th>TransarmorToken:</th>
    <td><?php echo $arr['transarmor_token'];?></td></tr>
	<tr> <th>Authorization_Num:</th>
    <td><?php echo $arr['authorization_num'];?></td></tr>
	<tr><th>Transaction_Tag</th>
    <td><?php echo $arr['transaction_tag'];?></td></tr>
<?php }
else{
  echo("<tr><th>REST Exception:</th>
  <td>Transaction failed. See response for details</td></tr>");} 
?>   
<tr><td><a href='javascript:history.back();'>Perform Another Transaction</a></td></tr>
</tbody>
</table><header>Request JSON</header>
<div>

<?php

echo json_encode($json_arr, JSON_PRETTY_PRINT); 
?></pre> </div>
<header>Response JSON</header>
<div>
<pre class="rxml"><?php 
$encode_arr = json_encode($arr, JSON_PRETTY_PRINT);

if($arr){
	echo $encode_arr;
	echo("<br /><br />".$arr2['ctr']);
		}
else {
echo $result;}
?></pre> </div>


</body>
</html>