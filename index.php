<?php include "page.php" ?>

<?php 
  if (!empty($_POST)) {
    //it should show here that the POST data will not contain any of the information 
    // that are about the buyer
    var_dump($_POST);
    die;
  } 

  $ticket_hash_key = '54321';
  $timestamp = time();
  $order_id = mt_rand();

  $location_api_id = 'testlocation';
  
  //this should be in proper sequence
  $data = $location_api_id . $timestamp . $order_id;
  $key = hash_hmac('sha256', $data, $ticket_hash_key);
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/ticket-jquery.js"></script>

<script>
$(document).ready(function(){
  //these are the authentication information required by the server
  $("#myform").ticket({
    timestamp : "<?= $timestamp ?>",
    signature : "<?= $key ?>",
    location_api_id : "<?= $location_api_id ?>",
    order_id : "<?= $order_id ?>"
  });

  $('#myform').ticket.addValidationErrors = function ($form, data) {
    $errorSummary = $form.find('.errorSummary');
    $errorSummary.addClass('alert alert-danger');
    $errorSummary.html('');
    $.each(data.responseJSON, function (index, value) {
      $.each(value, function (i, v) {
        $('*[data-ticket=' + index + ']').addClass('error');
        $error = $('<p>');
        $error.html(v);
        $error.appendTo($errorSummary);
      });
    });
  }

  $('a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});
});


</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/prettify.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/prettify.css" rel="stylesheet">


<style>

ul.affix {
  position: fixed; 
  top: 0px;
 
}
ul.affix-top {
  position: static;
}
ul.affix-bottom {
  position: absolute;
}

/* First level of nav */

/* All levels of nav */
.sidebar .nav > li > a {
  display: block;
  color: #716b7a;
  padding: 5px 20px;
}
.sidebar .nav > li > a:hover,
.sidebar .nav > li > a:focus {
  text-decoration: none;
  background-color: #e5e3e9;
}
.sidebar .nav > .active > a,
.sidebar .nav > .active:hover > a,
.sidebar .nav > .active:focus > a {
  font-weight: bold;
  color: #563d7c;
  background-color: transparent;
}

/* Nav: second level */
.sidebar .nav .nav {
  margin-bottom: 8px;
}
.sidebar .nav .nav > li > a {
  padding-top:    3px;
  padding-bottom: 3px;
  padding-left: 30px;
  font-size: 90%;
}

</style>


</head>
<body data-spy="scroll" data-target="#affix-nav" onload="prettyPrint()">
<div class="container-fluid">
<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="images/logo_zeamster.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  <div class="jumbotron" id="headerjumbo">
        <h2>Ticket Requests</h2>
        <a class="btn btn-info btn-lg" role="button" href="js/zeam.core.js" target="_blank">Download core</a>
        <a class="btn btn-info btn-lg" role="button" href="js/zeam.jquery.js" target="_blank">Download jquery version</a>
        <a href="example.php" class="btn btn-info btn-lg" role="button">View minimal usage</a>
      </div>
  <div class="container">
  
    <div class="row">
    <nav id="affix-nav" class="sidebar col-md-3 hidden-xs">
      <ul class="nav sidenav affix" data-spy="affix" data-offset-top="290">
          <li class="active"><a href="#features">Features</a>
          <li><a href="#requirements">Requirements</a>
          <li><a href="#requirements">Usage</a>
            <ul class="nav">   
            <li><a href="#installation">Installation</a></li>
            <li><a href="#hash_generation">Hash Generation</a></li>
            <li><a href="#js_usage">Javascript</a></li>
            <li><a href="#html_usage">HTML</a></li>        
            </ul>
          </li>
          
      </ul>
    </nav>
<section id="content" class="col-md-9">
  <article id="features">
    <h2><a href="#features">Features</a></h2>
    <ul>
      <li>Removes all credit card information</li>
      <li>Validates user's input directly</li>
      <li>Extendable</li>
    </ul>
    </article>
    <br />

    <article id="requirements">
    <h2><a href="#requirements">Requirements</a></h2>
    <ul>
      <li>JQuery 1.0+</li>
      <li>sha256 server algorithm</li>
    </ul>
    </article>
    <br />
    <article id="workflow">
        <h2><a href="#workflow">Workflow</a></h2>
        <ol>
          <li>The Merchant website creates its typical form </li>
          <li>The merchant attaches the the form handler using the ticket() method with the required parameters
         </li>
          <li>After the client submits the form, the submit event becomes intercepted. The information that the client submitted will then be sent to
          zeamster.com and be processed for validation and ticket genereation
          </li>
          <li>If the information provided is valid, a response will be generated by zeamster.com containing the ticket, this will then be attached
          to the form as a hidden input with a name 'ticket'*.
          </li>
          <li>The javascript then removes all the information that has been sent to the server from the form and then resumes the submit event making
            the Seller receive only the ticket and some other non-sensitive information
          </li>          
        </ol>
      </article>
    <br />  
    <article id="usage">
        <h2><a href="#usage" >Usage</a></h2>
          <section id="installation">
            <h3>Installation</h3>
            <ol>
              <li>Download <a href="js/zeam.core.js">zeam.core.js</a></li>
              <li>Download <a href="js/zeam.core.js">zeam.jquery.js</a></li>
              <li>Include in your headers
               <pre class="prettyprint lang-html">
<?php echo htmlentities("<script src='js/zeam.core.js'></script>
<script src='js/zeam.jquery.js'></script>") ?>
              </pre> 
              </li>        
          </ol>
          </section>
        <section id="hash_generation"><h3>Generating Hash</h3>
          <p>This part has to be done in your server-side</p>
          <p>There are 4 parameters that is required by ZEAM to authorize your request</p>
          <table class="table">
            <tr>
              <td>Location API key</td>
              <td>Provided by zeamster.com as your location identifier</td>
            </tr>
            <tr>
              <td>Order ID</td>
              <td>a random number generated by your server</td>
            </tr>
            <tr>
              <td>Timestamp</td>
              <td>the current time when the page has been generated. it has an expire period of 5 minutes</td>
            </tr>
            <tr>
              <td>Signature</td>
              <td>this is the hashed concatenated location api key, order id and timestamp (in that exact order) using sha-256 algorithm and ticket hash key that is provided by zeamster as your private key</td>
            </tr>
          </table>

          <pre class="prettyprint lang-php">
          <?php
$hash_sample = <<<EOD

<?php
\$ticket_hash_key = 'yourtickethashkey';
\$location_api_key = 'yourlocationapikey';
\$timestamp = time();
\$order_id = mt_rand();

//this should be in proper sequence
\$data = \$location_api_key . \$timestamp . \$order_id;
\$signature = hash_hmac('sha256', \$data, \$ticket_hash_key);
?>
EOD;

echo htmlentities($hash_sample);
?>
          </pre>
        </section>
        <section id="js_usage">
        <h3>Javascript</h3>
        <p>After generating the hash, you can now initialize the binding with these parameters</p>
        <pre class="prettyprint lang-php">
          <?php
$sample = <<<EOD

<script>
$(document).ready(function(){
  $("#myform").ticket({
    timestamp : "<?= \$timestamp ?>",
    signature : "<?= \$signature ?>",
    location_api_key : "<?= \$location_api_key ?>",
    order_id : "<?= \$order_id ?>"
  });
});
</script>
EOD;

echo htmlentities($sample);
?>
</pre>
        </section>

        <section id="html_usage">
        <h3>HTML</h3>
        <p>All fields that are sensitive buyer-information must be set with a 'ticketed' class and a data-ticket which will be
        the name of its post parameter when sent to zeamster
        </p>
        <pre class="prettyprint lang-html">
          <?php
$sample = <<<EOD

<form method="POST" id='myform'>
  <label for="item_number">item number: </label><input type="text" name="item_number"> <br>
  <label for="customer_name">Customer name: </label><input type="text" name="customer_name"> <br>
  <label for="credit_card_number">Credit card number: </label><input type="text" name="credit_card_number" class="ticketed" data-ticket="credit_card_number"> <br>
  <label for="cvv">CVV: </label><input type="text" name="cvv" class="ticketed" data-ticket="cvv"> <br>
  <label for="exp_date">Expiration Date: </label> <input type="text" name="exp_date" class="ticketed" data-ticket="exp_date"> <br>
  <label for="exp_date">Billing Zip </label> <input type="text" name="billing_zip" class="ticketed" data-ticket="billing_zip"> <br>
  <label for="exp_date">Billing Street </label> <input type="text" name="billing_street" class="ticketed" data-ticket="billing_street"> <br>
  <input type="submit" value="submit">
</form>
EOD;

echo htmlentities($sample);
?>
</pre>
        </section>
      </article>
    <br />  
</section>      
</div><!-- end of row -->
  </div>


</div><!-- end of container -->

<footer class="bs-docs-footer">
  <div class="container">
    <p>OLU Technology solutions</p>
  </div>
</footer>

</body>
</html>