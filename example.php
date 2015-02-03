
<?php 
	if (!empty($_POST)) {
		//it should show here that the POST data will not contain any of the information 
		// that are about the buyer
		var_dump($_POST);
		die;
	} 

	$ticket_hash_key = 'yourtickethashkey';
	$timestamp = time();
	$order_id = mt_rand();

	$location_api_id = 'yourlocationapikey';
	
	//this should be in proper sequence
	$data = $location_api_id . $timestamp . $order_id;
	$key = hash_hmac('sha256', $data, $ticket_hash_key);
?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/zeam.core.js"></script>
<script src="js/zeam.jquery.js"></script>
<style type="text/css">
	.error {
		border-style: solid;
		border-color: red;
	}
</style>
<script>
$(document).ready(function(){
  //these are the authentication information required by the server
  $("#myform").ticket({
  	timestamp : "<?= $timestamp ?>",
  	signature : "<?= $key ?>",
  	location_api_key : "<?= $location_api_id ?>",
  	order_id : "<?= $order_id ?>",
  	url : "https://api.sandbox.zeamster.com/v1/cardTickets"
  });
});
</script>
</head>
<body>

<!--- in this implementation, all elements that you do not want to be received by your system shall
have a class named "ticketed". also each element needs to have a data-ticket attribute to determine
the name of it in the post data to be sent in to the server ---->
<form method="POST" id='myform'>
	<div class="errorSummary"></div>
	<label for="item_number">item number: </label><input type="text" name="item_number"> <br>
	<label for="customer_name">Customer name: </label><input type="text" name="customer_name"> <br>
	<label for="credit_card_number">Credit card number: </label><input type="text" name="credit_card_number" class="ticketed" data-ticket="card_number"> <br>
	<label for="cvv">CVV: </label><input type="text" name="cvv" class="ticketed" data-ticket="cvv"> <br>
	<label for="exp_date">Expiration Date: </label> <input type="text" name="exp_date" class="ticketed" data-ticket="exp_date"> <br>
	<label for="exp_date">Billing Zip </label> <input type="text" name="billing_zip" class="ticketed" data-ticket="billing_zip"> <br>
	<label for="exp_date">Billing Street </label> <input type="text" name="billing_street" class="ticketed" data-ticket="billing_street"> <br>
	<input type="submit" value="submit">
</form>

</body>
</html>
