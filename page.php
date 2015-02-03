<?php
$example = <<<EOD

<?php 
if (!empty(\$_POST)) {
	//it should show here that the POST data will not contain any of the information 
	// that are about the buyer
	// or all input elements in the form that has a class "ticketed" will not be submitted
	var_dump(\$_POST);
	die;
}

\$user_id = '52f21d22-2268-5560-db04-ca6691414f34';
\$password = '12345';
\$timestamp = time();
\$order_id = mt_rand();

\$location_api_id = 'testlocation';

//this should be in proper sequence
\$data = \$user_id . \$location_api_id . \$timestamp . \$order_id;
\$key = hash_hmac('sha256', \$data, \$password);
?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="ticket-jquery.js"></script>
<script>
$(document).ready(function(){
  //these are the authentication information required by the server
  $("#myform").ticket({
  	user_id : "<?= \$user_id ?>",
  	timestamp : "<?= \$timestamp ?>",
  	signature : "<?= \$key ?>",
  	location_api_id : "<?= \$location_api_id ?>",
  	order_id : "<?= \$order_id ?>"
  });
});
</script>
</head>
<body>

<!--- in this implementation, all elements that you do not want to be received by your system shall
have a class named "ticketed". also each element needs to have a data-ticket attribute to determine
the name of it in the post data to be sent in to the server ---->
<form method="POST" id='myform'>
	<label for="item_number">item number: </label><input type="text" name="item_number"> <br>
	<label for="customer_name">Customer name: </label><input type="text" name="customer_name"> <br>
	<label for="credit_card_number">Credit card number: </label><input type="text" name="credit_card_number" class="ticketed" data-ticket="credit_card_number"> <br>
	<label for="cvv">CVV: </label><input type="text" name="cvv" class="ticketed" data-ticket="cvv"> <br>
	<label for="exp_date">Expiration Date: </label> <input type="text" name="exp_date" class="ticketed" data-ticket="exp_date"> <br>
	<input type="submit" value="submit">
</form>

</body>
</html>
EOD;
?>