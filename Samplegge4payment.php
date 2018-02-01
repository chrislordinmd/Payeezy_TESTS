<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>
Payment Pages: Sample PHP Payment Form
</title>
<style type="text/css">
label {
display: block;
margin: 5px 0px;
color: #AAA;
}
input {
display: block;
}
input[type=submit] {
margin-top: 20px;
}
</style>

</head>
<body>
<h1>Processing Please Wait...</h1>

<form action="https://demo.globalgatewaye4.firstdata.com/payment" method="POST" name="myForm" id="myForm">

<?php
//$lineitem = $_POST["lineitem"];
$x_login = $_POST["x_login"]; // Take from Payment Page ID in Payment Pages interface
$transaction_key = $_POST["transaction_key"]; // Take from Payment Pages configuration interface
$x_amount = $_POST["x_amount"];
$x_currency_code = "USD"; // Needs to agree with the currency of the payment page
srand(time()); // initialize random generator for x_fp_sequence
$x_fp_sequence = rand(1000, 100000) + 123456;
$x_fp_timestamp = time(); // needs to be in UTC. Make sure webserver produces UTC
$x_fee_amount = $_POST["x_fee_amount"];
//my demo:
//transaction_key: J_ei2KZP4c7kFlRe5X~S
//x_login: WSP-TACO-ydXAuwAnyA

// The values that contribute to x_fp_hash
$hmac_data = $x_login . "^" . $x_fp_sequence . "^" . $x_fp_timestamp . "^" . $x_amount . "^" . $x_currency_code;
$x_fp_hash = hash_hmac('MD5', $hmac_data, $transaction_key);

//echo ('<input name="x_line_item" value="' . $lineitem . '" type="hidden">' );
echo ('<input name="x_fp_sequence" value="' . $x_fp_sequence . '" type="hidden">' );
echo ('<input name="x_fp_timestamp" value="' . $x_fp_timestamp . '" type="hidden">' );
echo ('<input name="x_fp_hash" value="' . $x_fp_hash . '" size="50" type="hidden">' );
echo ('<input name="x_currency_code" value="' . $x_currency_code . '" type="hidden">');

// create parameters input in html
foreach ($_POST as $a => $b) {
	echo "<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>";
	$post = array();

}


?>

<input type="hidden" name="x_show_form" value="PAYMENT_FORM"/>
</form>

<script type='text/javascript'>


document.myForm.submit();</script>

</body>
</html>