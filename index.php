<?php 

include_once __DIR__.'/bppg_helper.php';

define('PG_REQUEST_URL', 'https://uat.bhartipay.com/crm/jsp/hostedPaymentRequest');
define('PG_RESPONSE_URL', 'http://localhost/projects/new_merchant_hosted/response.php');
define('PG_RESPONSE_MODE', 'SALE');
define('PG_SALT', '8535b0d335e545d4');
define('PG_PAY_ID', '2001141020561000');



?>
<?php
// if form is submitted
if (isset($_REQUEST['payment_check'])) {
    $pg_transaction = new BPPGModule;
    @$pg_transaction->setPayId(PG_PAY_ID);
    @$pg_transaction->setPgRequestUrl(PG_REQUEST_URL);
    @$pg_transaction->setSalt(PG_SALT);
    @$pg_transaction->setReturnUrl(PG_RESPONSE_URL);
    @$pg_transaction->setCurrencyCode(356);
    @$pg_transaction->setOrderId($_REQUEST['ORDER_ID']);
    @$pg_transaction->setAmount($_REQUEST['AMOUNT']*100); // convert to Rupee from Paisa
    @$pg_transaction->setPayment_Type('CARD');
    // @$pg_transaction->setMopType($_REQUEST['MOP_TYPE']);
    @$pg_transaction->setCardHolderName($_REQUEST['CUST_NAME']);
    @$pg_transaction->setCardNumber($_REQUEST['CARD_NUMBER']);
    @$pg_transaction->setCardExpDate($_REQUEST['CARD_EXP_MONTH'].$_REQUEST['CARD_EXP_YEAR']);
    @$pg_transaction->setCvv($_REQUEST['CVV']);
    @$pg_transaction->setCustEmail($_REQUEST['CUST_EMAIL']);
    @$pg_transaction->setCustPhone($_REQUEST['CUST_PHONE']);
    $postdata = $pg_transaction->createTransactionRequest();
    $hashstring = $pg_transaction->generateEncryption($postdata,$postdata['HASH']);
    //print_r($postdata);echo "<br>";print_r($hashstring);echo "<br>";
    $enc = $pg_transaction->aes_encyption($hashstring);
    //echo $decrypt_string = $pg_transaction->aes_decryption($enc);echo "<br>";
    $hostedpostdata['PAY_ID']=PG_PAY_ID;
    $hostedpostdata['ENCDATA']=$enc;
    $pg_transaction->hostedredirectForm($hostedpostdata,PG_REQUEST_URL);
     exit();

    //$pg_transaction->redirectForm($postdata);
    
} 
if (isset($_REQUEST['payment_check_nb'])) {
 $pg_transaction = new BPPGModule;
    @$pg_transaction->setPayId(PG_PAY_ID);
    @$pg_transaction->setPgRequestUrl(PG_REQUEST_URL);
    @$pg_transaction->setSalt(PG_SALT);
    @$pg_transaction->setReturnUrl(PG_RESPONSE_URL);
    @$pg_transaction->setCurrencyCode(356);
    @$pg_transaction->setOrderId($_REQUEST['NB_ORDER_ID']);
    @$pg_transaction->setAmount($_REQUEST['NB_AMOUNT']*100); // convert to Rupee from Paisa
    @$pg_transaction->setPayment_Type('NB');
     @$pg_transaction->setMopType($_REQUEST['NB_MOP_TYPE']);
    @$pg_transaction->setCustEmail($_REQUEST['NB_CUST_EMAIL']);
    @$pg_transaction->setCustPhone($_REQUEST['NB_CUST_PHONE']);
    $postdata = $pg_transaction->createTransactionRequestNb();
    $hashstring = $pg_transaction->generateEncryption($postdata,$postdata['HASH']);
    //print_r($postdata);echo "<br>";print_r($hashstring);echo "<br>";
    $enc = $pg_transaction->aes_encyption($hashstring);
    //echo $decrypt_string = $pg_transaction->aes_decryption($enc);echo "<br>";
    $hostedpostdata['PAY_ID']=PG_PAY_ID;
    $hostedpostdata['ENCDATA']=$enc;
    $pg_transaction->hostedredirectForm($hostedpostdata,PG_REQUEST_URL);
     exit();
}
else {?>

<html xmlns="http://www.w3.org/1999/xhtml">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

   <div class="col-md-6 offset-md-3">
                    <span class="anchor" id="formPayment"></span>
                    <!-- <hr class="my-5"> -->
                      <span></span>   
                    <!-- form card cc payment -->
                    <div class="card card-outline-secondary">
                        <div class="card-body">
                          <input type="checkbox" id="active-payment" checked data-toggle="toggle" data-on="Card" data-off="Net Banking" data-onstyle="success" data-offstyle="danger">
                            
                            <!-- <div class="alert alert-info p-2 pb-3">
                                <a class="close font-weight-normal initialism" data-dismiss="alert" href="#"><samp>×</samp></a> 
                                CVC code is required.
                            </div> -->
                            <form class="form" role="form"  method="post" action="" autocomplete="off">
                            <input type="hidden" name="payment_check">
                              <div id="form-card">
                                <h3 class="text-center">Card Payment</h3>
                               <hr>
                                <div class="form-group">
                                    <label for="order_id">Order Id</label>
                                    <input type="text" name="ORDER_ID" class="form-control" value="<?php echo 'BHARTID'.date('dmyHi')?>" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="email_id">Email Id</label>
                                    <input type="text" name="CUST_EMAIL" class="form-control" value="rohit.singh@bhartipay.com" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="CUST_PHONE" class="form-control" value="7503038008" required="required" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="cc_name">Card Holder's Name</label>
                                    <input type="text" class="form-control" name="CUST_NAME" value="Rohit Kr Singh" id="cc_name" pattern="\w+ \w+.*" title="First and last name" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" name="CARD_NUMBER" autocomplete="off" maxlength="20" pattern="\d{16}" title="Credit card number" value="4000000000000119" required="">
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-12">Card Exp. Date</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="CARD_EXP_MONTH" size="0">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="CARD_EXP_YEAR" size="0">
                                            <?php for ($i=1; $i <50 ; $i++) { 
                                                $year=2020;
                                                ?><option value="<?php echo $year+$i; ?>"><?php echo $year+$i; ?></option><?php
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="password" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" required="" name="CVV" placeholder="CVC" value="121">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12">Amount</label>
                                </div>
                                <div class="form-inline">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                                        <input type="text" class="form-control text-right" name="AMOUNT" id="exampleInputAmount" placeholder="1" value="1">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <!-- <div class="col-md-6">
                                        <button type="reset" class="btn btn-default btn-lg btn-block">Cancel</button>
                                    </div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">Proceed</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                      <form class="form" role="form"  method="post" action="" autocomplete="off">
                        <input type="hidden" name="payment_check_nb">
                                <div id="form-nb">

                                  <h3 class="text-center">Net Banking Payment</h3>
                               <hr>
                                <div class="form-group">
                                    <label for="order_id">Order Id</label>
                                    <input type="text" name="NB_ORDER_ID" class="form-control" value="<?php echo 'BHARTID'.date('dmyHi')?>" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="email_id">Email Id</label>
                                    <input type="text" name="NB_CUST_EMAIL" class="form-control" value="rohit.singh@bhartipay.com" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="NB_CUST_PHONE" class="form-control" value="7503038008" required="required" />
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12">Select Bank</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="NB_MOP_TYPE"  size="0">
                                            <option value="1027">Federal Bank</option>
                                            <option value="1030">SBI</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                 <div class="row">
                                    <label class="col-md-12">Amount</label>
                                </div>
                                <div class="form-inline">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                                        <input type="text" class="form-control text-right" name="NB_AMOUNT" id="exampleInputAmount" value="1" placeholder="1">
                                    </div>
                                </div>
                                <hr>
                                

                                <div class="form-group row">
                                    <!-- <div class="col-md-6">
                                        <button type="reset" class="btn btn-default btn-lg btn-block">Cancel</button>
                                    </div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">Proceed</button>
                                    </div>
                                </div>

                                

                                  
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /form card cc payment -->
                
                <p class="copyright" style="text-align:center;padding:40px 0;">Developed by <a href="#">Rohit Singh © Bhartipay</a></p>
            <?php } ?>
                <script>
                  $( document ).ready(function() {
                      $('#form-nb').hide();
                      $( "#active-payment").change(function() {
                        //alert($(this).text());
                      if($(".toggle-group").find(".active").text()=='Net Banking')
                      {
                      $('#form-card').toggle();
                      $('#form-nb').toggle();
                      }
                      });
                  });
                  
                </script>

            