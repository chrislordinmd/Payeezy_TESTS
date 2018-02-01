<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<head><a href="https://developer.payeezy.com/apis"><img src="https://developer.payeezy.com/sites/default/files/Payeezy-DevelopersLogo_Horz_0.png" width="120"></a>
</html>
<?php
date_default_timezone_set('UTC');
 header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
 header("Pragma: no-cache");

//allow for empty global $_POST to function with xampp / development environment

error_reporting(E_ALL ^ E_NOTICE);


$serviceURL = $_POST["serviceURL"] .$_POST['transaction_id'] .$post_token_url;
$apiKey = $_POST["apiKey"];
$apiSecret = $_POST["apiSecret"];
$token = $_POST["token"];


$nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
$timestamp = strval(time()*1000); //time stamp in milli seconds

$method = $_POST["method"];

//declaring variables to strip $, commas, decimals
$amount = $_POST["amount"];
$duty_amount = $_POST["duty_amount"];
$unit_cost = $_POST["unit_cost"];
$freight_amount = $_POST["freight_amount"];
$line_item_total = $_POST["line_item_total"];
$discount_amount = $_POST["discount_amount"];


$amount = preg_replace('/[^\p{L}\p{N}\s]/u', '', $amount);


	$billing_address = array(
			  'street'=> $_POST['street'],
			  'city'=> $_POST['city'],
              'state_province'=> $_POST['state_province'],
			  'zip_postal_code'=> $_POST['zip_postal_code'],
			  'country'=> $_POST['country'],
		);
	 
	$ship_to_address = array(
			'city'=> $_POST['city'],
            'state'=> $_POST['state'],
            'zip'=> $_POST['zip'],
            'country'=> $_POST['country'],
  		  	'email'=> $_POST['email'],
            'name'=> $_POST['name'],
            'phone'=> $_POST['phone'],
  		  	'address_1'=> $_POST['address_1'],

			);
	
	$line_items = array(

			  'description'=> $_POST['description'],
			  'quantity'=> $_POST['quantity'],
			  'commodity_code'=> $_POST['commodity_code'],
			  'discount_amount'=> $discount_amount,
			  'discount_indicator'=> $_POST['discount_indicator'],
			  'gross_net_indicator'=> $_POST['gross_net_indicator'],
			  'line_item_total'=> $line_item_total,
			  'product_code'=> $_POST['product_code'],
			  'tax_amount'=> $_POST['tax_amount'],
			  'tax_rate'=> $_POST['tax_rate'],
			  'tax_type'=> $_POST['tax_type'],
			  'unit_cost'=> $unit_cost,
			  'unit_of_measure'=> $_POST['unit_of_measure'],
			 
		);
			
			

	$token_data = array(
					  'type' => $_POST['type'],
                      'cardholder_name'=> $_POST['card_holder_name'],
                      'value'=> $_POST['card_number'],
                      'exp_date'=> $_POST['card_expiry'],
                      'cvv'=> $_POST['card_cvv'],

		);
			
	$level2 = array(
				'tax1_amount'=> $_POST['tax1_amount'],
				'tax1_number'=> $_POST['tax1_number'],
				'tax2_amount'=> $_POST['tax2_amount'],
				'tax2_number'=> $_POST['tax2_number'],
				'customer_ref'=> $_POST['customer_ref'],
	
		);	
	
	$level3 = array(
            'alt_tax_amount'=> $_POST['alt_tax_amount'],
            'alt_tax_id'=> $_POST['alt_tax_id'],
            'discount_amount'=> $discount_amount,
  		  	'duty_amount'=> $duty_amount,
            'freight_amount'=> $_POST['freight_amount'],
            'ship_from_zip'=> $_POST['ship_from_zip'],
            'ship_to_address'=> $ship_to_address,
			'line_items'=> array( $line_items,
				
		  ),	
      );		
	

	
//Different transaction types
		if ($_POST['method'] == 'tele_check') {
	
		
        $body = array(
		  "method" => $_POST['method'],
          "transaction_type" => $_POST['transaction_type'],
          "amount" => $amount,
          "currency_code" => $_POST['currency_code'],
          "tele_check" => array(
          "check_number" => $_POST['check_number'],
          "check_type" => $_POST['check_type'],
          "routing_number" => $_POST['routing_number'],
          "account_number" => $_POST['account_number'],
          "accountholder_name" => $_POST['accountholder_name'],
          "customer_id_type" => $_POST['customer_id_type'],
          "customer_id_number" => $_POST['customer_id_number'],
          "client_email" => $_POST['client_email'],
          "gift_card_amount" => $_POST['gift_card_amount'],
          "vip" => $_POST['vip'],
          "clerk_id" => $_POST['clerk_id'],
          "device_id" => $_POST['device_id'],
          "micr" => $_POST['micr'],
          "release_type" => $_POST['release_type'],
          "registration_number" => $_POST['registration_number'],
          "registration_date" => $_POST['registration_date'],
          "date_of_birth" => $_POST['date_of_birth'],
		  
		  
          ),
			'billing_address' => $billing_address,

        );
	  }
		
		if($_POST['method'] == 'post_token') {
		
			
		$body = array(	
					'type' => 'FDToken',
					'credit_card'=> array(
						'type'=> $_POST['type'],
						'cardholder_name'=> $_POST['card_holder_name'],
						'card_number'=> $_POST['card_number'],
						'exp_date'=> $_POST['card_expiry'],
						'cvv'=> $_POST['card_cvv'],
          ),
					'auth'=> 'false',
					'ta_token'=> $_POST['ta_token'],
		  );
		  
		}
		if($_POST['method'] == 'live_post_token') {
		
			
		$body = array(	
					'type' => 'FDToken',
					'credit_card'=> array(
						'type'=> $_POST['type'],
						'cardholder_name'=> $_POST['card_holder_name'],
						'card_number'=> $_POST['card_number'],
						'exp_date'=> $_POST['card_expiry'],
						'cvv'=> $_POST['card_cvv'],
          ),
					'auth'=> 'false',
					'ta_token'=> $_POST['ta_token'],
		  );
		  
		}	  

	
		
		if($_POST['method'] == 'token')
        {

          $body = array(
            'merchant_ref'=> $_POST['merchant_ref'],
            'transaction_type'=> $_POST['transaction_type'],
            'method'=> $_POST['method'],
            'amount'=> $amount,
            'currency_code'=> strtoupper($_POST['currency_code']
			),
            'token'=> array(
              'token_type'=> 'FDToken',
              'token_data'=> $token_data,
            ),
			'billing_address'=> $billing_address,
			'level2'=> $level2,
			//'level3'=> $level3,
          );
        }


			  if($_POST['transaction_type'] == 'void')
	  {
		$body = array(
					'transaction_type'=> $_POST['transaction_type'],
					'transaction_tag'=> $_POST['transaction_tag'],
					'amount'=> $amount,
					'method'=> $_POST['method'],
					'currency_code'=> $_POST['currency_code'],
					);
	  }
	  	  if($_POST['transaction_type'] == 'refund')
	  {
		$body = array(
					'transaction_type'=> $_POST['transaction_type'],
					'transaction_tag'=> $_POST['transaction_tag'],
					'amount'=> $amount,
					'method'=> $_POST['method'],
					'currency_code'=> $_POST['currency_code'],
					);
	  }

	  if($_POST['transaction_type'] == 'capture')
	  {
		$body = array(
					'transaction_type'=> $_POST['transaction_type'],
					'transaction_tag'=> $_POST['transaction_tag'],
					'amount'=> $amount,
					'method'=> $_POST['method'],
					'currency_code'=> $_POST['currency_code'],
					);
	  }		  
      if($_POST['method'] == 'credit_card' && $_POST['transaction_type'] == 'purchase')
      {
        $body = array(
          'billing_address'=> $billing_address,
		  'eci_indicator'=> $eci_indicator,
		  'merchant_ref'=> $_POST['merchant_ref'],
          'transaction_type'=> $_POST['transaction_type'],
          'method'=> $_POST['method'],
          'amount'=> $amount,
          'currency_code'=> strtoupper($_POST['currency_code']
		  
		  ),
          'credit_card'=> array(
            'type'=> $_POST['type'],
            'cardholder_name'=> $_POST['card_holder_name'],
            'card_number'=> $_POST['card_number'],
            'exp_date'=> $_POST['card_expiry'],
            'cvv'=> $_POST['card_cvv'],
          ),
		  'level2'=> $level2,
		  'level3'=> $level3,
        );
		
      }
	  
	        if($_POST['transaction_type'] == 'authorize')
      {
        $body = array(
          'billing_address'=> $_POST['billing_address'],
		  'eci_indicator'=> $_POST['eci_indicator'],
		  'merchant_ref'=> $_POST['merchant_ref'],
          'transaction_type'=> $_POST['transaction_type'],
          'method'=> $_POST['method'],
          'amount'=> $amount,
          'currency_code'=> strtoupper($_POST['currency_code']
		  
		  ),
          'credit_card'=> array(
            'type'=> $_POST['type'],
            'cardholder_name'=> $_POST['card_holder_name'],
            'card_number'=> $_POST['card_number'],
            'exp_date'=> $_POST['card_expiry'],
            'cvv'=> $_POST['card_cvv'],
          ),

        );
		
      }

	  

$payload = json_encode($body);

echo "<br><br> Request JSON Payload :" ;

echo $payload ;

echo "<br><br> Authorization :" ;

$body = $apiKey . $nonce . $timestamp . $token . $payload;

$hashAlgorithm = "sha256";

### Make sure the HMAC hash is in hex -->
$hmac = hash_hmac ( $hashAlgorithm , $body , $apiSecret, false );

### Authorization : base64 of hmac hash -->
$hmac_enc = base64_encode($hmac);

echo "<br><br> " ;

echo $hmac_enc;

echo "<br><br>" ;


$curl = curl_init($serviceURL . $transactionid);

$headers = array(
      'Content-Type: application/json',
      'apikey:'.strval($apiKey),
      'token:'.strval($token),
      'Authorization:'.$hmac_enc,
      'nonce:'.$nonce,
      'timestamp:'.$timestamp,
    );



curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
curl_setopt($curl, CURLOPT_VERBOSE, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$json_response = curl_exec($curl);



$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//print ($headers["request_header"]);
echo "<br><br>Timestamp " ;
echo $timestamp;
echo "<br><br> " ;
$response = json_decode($json_response, true);


if ( $status != 201 ) {
"Error: call to URL $serviceURL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl);

}

curl_close($curl);

echo "Transaction Response is: ".$response."\n";

echo "<br><br> " ;



echo ("<pre>");
print_r($response);
echo ("</pre>"); 

echo "<br><br> " ;

echo "<br><br> " ;


$serviceURL = $_POST["serviceURL"];

$submitURL = preg_replace('{tokens}', '', $serviceURL);

if ($response["transaction_status"] == "approved") {

echo 'Transaction was approved! <br>';	
echo '<img src="chuck-norris-approved-funny-stuff.jpg" />' ;	
	
}

if ($response["transaction_status"] == "declined") {

echo 'Transaction was DECLINED! <br>';	
echo '<img src="declined.jpg" />' ;	
	
}

if ($response["Error"]) {


echo 'Transaction ERROR! <br>';	
echo '<img src="error.png" /> <br>' ;

	
}


?>

<title>PHP Response Page</title>
<style>
.transarmortoken {
   float: bottom;
   margin: 5px;
   padding: 5px;
   max-width: 500px;
   height: 280px;
   border: 1px solid black;
}
</style>
</head>
<body>
<p>
<html>
<h1>Void the Transaction</h1>

<form action="http://localhost/Payeezy_TESTS/level3dev.php" method="post">
<input size="50" type="hidden" name="transaction_type" value="void"/> 
<input size="50" type="hidden" name="method" value="credit_card"/> 
<input size="50" type="hidden" name="serviceURL" id="serviceURL" value="<?php echo $submitURL; ?>"/> 
<input size="50" type="hidden" name="token" id="token" value="<?php echo $_POST["token"] ?>"/> 
<input size="50" type="hidden" name="apiKey" id="apiKey" value="<?php echo $_POST["apiKey"] ?>"/> 
<input size="50" type="hidden" name="apiSecret" id="apiSecret" value="<?php echo $_POST["apiSecret"] ?>"/>
<input size="50" type="hidden" name="currency_code" value="USD"/>
<input size="50" type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $response["transaction_id"] ?>"/>  
<input size="50" type="hidden" name="transaction_tag" id="transaction_tag" value="<?php echo $response["transaction_tag"] ?>"/>  
<input size="50" type="hidden" name="amount" id="amount" value="<?php echo $response["amount"] + $response["fee_amount"] ?>"/> 
<br>
<INPUT type="submit" align="center" value="Void" name="submitBtn">
</form>



<html>
<h1>Charge the Transarmor Token</h1>
<div class="transarmortoken" id="transarmortoken">



<body>
<form action="http://localhost/Payeezy_TESTS/level3dev.php" method="post">
<input size="50" type="hidden" name="transaction_type" value="purchase"/> 
<input size="50" type="hidden" name="method" id="method" value="token"/> 
<input size="50" type="hidden" name="serviceURL" id="serviceURL" value="<?php echo $submitURL; ?>"/>
<input size="50" type="hidden" name="apiKey" id="apiKey" value="<?php echo $_POST["apiKey"] ?>"/> 
<input size="50" type="hidden" name="apiSecret" id="apiSecret" value="<?php echo $_POST["apiSecret"] ?>"/>
<input size="50" type="hidden" name="token" id="token" value="<?php echo $_POST["token"] ?>"/>
<input size="50" type="hidden" name="currency_code" value="USD"/>
<p>TA Token#<input size="50" type="text" name="card_number" id="card_number" value="<?php echo $response["token"]["token_data"]["value"]; echo $response["token"]["value"]; ?>"/></p>
<input size="50" type="hidden" name="token_type" id="token_type" value="FDToken"/>
CVV<input size="50" type="text" name="card_cvv" id="card_cvv" value="" maxlength="4">
<p>    
<input size="50" type="hidden" name="type" id="type" value="<?php echo $response["card"]["type"]; echo $response["token"]["type"]; echo $response["token"]["token_data"]["type"]; ?>"/>
<input size="50" type="hidden" name="card_holder_name" id="card_holder_name" value="<?php echo $response["card"]["cardholder_name"]; echo $response["token"]["cardholder_name"]; echo $response ["token"]["token_data"]["cardholder_name"]; ?>"/>
<input size="50" type="hidden" name="card_expiry" id="card_expiry" value="<?php echo $response["card"]["exp_date"]; echo $response["token"]["exp_date"]; echo $response["token"]["token_data"]["exp_date"]; ?>"/> 
<input size="50" type="hidden" name="street" id="street" value="<?php print $_POST["street"] ?>"/> 
<input size="50" type="hidden" name="city" id="city" value="<?php print $_POST["city"] ?>"/>
<input size="50" type="hidden" name="state_province" id="state_province" value="<?php print $_POST["state_province"] ?>"/> 
<input size="50" type="hidden" name="zip_postal_code" id="zip_postal_code" value="<?php print $_POST["zip_postal_code"] ?>"/>
<input size="50" type="hidden" name="country" id="country" value="<?php print $_POST["country"] ?>"/>   

Amount<input size="50" type="text" name="amount" id="amount" value="" required title="dollar sign, decimal and commas are stripped automatically"> 
<br><br>
<INPUT type="submit" value="Charge Transarmor Token" name="submitBtn">
</form>
</div>



