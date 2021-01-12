<?php
include_once __DIR__.'/bppg_helper.php';
$pg_transaction = new BPPGModule;
$enc = $pg_transaction->aes_decryption($_POST['ENCDATA']);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<?php $response=explode("~",$enc); ?>
<!-- <?php print_r($response); ?> -->
<div class="jumbotron text-center">
  <h1 class="display-3">Thank You!</h1>
  <hr>
   <p>Order Id : <?php $data=explode("=",$response['19']);echo $data[1];?></p>
   <p>Status: <?php $data=explode("=",$response['8']);echo $data[1];?></p>
   <p>Amount : <?php $data=explode("=",$response['9']);echo $data[1];?></p>
   <p>Customer Name : <?php $data=explode("=",$response['21']);echo $data[1];?></p>
   <p>Customer Phone Number : <?php $data=explode("=",$response['3']);echo $data[1];?></p>
   <p>Response Message : <?php $data=explode("=",$response['10']);echo $data[1];?></p>
   <p>Email : <?php $data=explode("=",$response['11']);echo $data[1];?></p>

  <p class="lead"><strong>Please check your email</strong> for Receipt.</p>
  <hr>
  <p>
    Having trouble? <a href="">Contact us</a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="http://localhost/projects/new_merchant_hosted/" role="button">Continue to homepage</a>
  </p>
</div>
</body>
</html>



