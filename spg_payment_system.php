<?php
if(!session_id()) {
    session_start();
}
/**
 * Plugin Name:  Spgateway Payment System
 * Plugin URI:
 * Description: Payment system using "agreed credit card payment way" and "credit card payment way"
 * Version: 1.0
 * Author: Jesus Erwin Suarez
 * Author URI:
 * License:
 */

require_once( ABSPATH . "wp-includes/option.php");

add_action("admin_menu", "spg_ps_admin_menu");

function spg_ps_admin_menu()
{

    add_menu_page('Spgateway Payment System', 'Spgateway Payment System', 'manage_options', "spg-payment-system", 'spg_p_s_admin');
}

function spg_ps_header() {
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
}
function spg_ps_admin () {

    spg_p_s_header();

    // insert post here to wp option

    if(isset($_POST['spg_ps_update_settings'])) {

        // live
        update_option('spb_ps_hasKey', $_POST['spb_ps_hasKey']);
        update_option('spb_ps_hasKeyIV', $_POST['spb_ps_hasKeyIV']);
        update_option('spb_ps_merchantId', $_POST['spb_ps_merchantId']);
        update_option('spb_ps_payment_url', $_POST['spb_ps_payment_url']);


        // testing
        update_option('spb_ps_hasKey_test', $_POST['spb_ps_hasKey_test']);
        update_option('spb_ps_hasKeyIV_test', $_POST['spb_ps_hasKeyIV_test']);
        update_option('spb_ps_merchantId_test', $_POST['spb_ps_merchantId_test']);
        update_option('spb_ps_payment_url_test', $_POST['spb_ps_payment_url_test']);

        // global settings
        update_option('spg_ps_status', $_POST['spg_ps_status']);


        print "<didv class='alert alert-success'> Settings updated. </didv>";

    }

    // live
    $spb_ps_hasKey      = (!empty( get_option( 'spb_ps_hasKey' ))) ?  get_option( 'spb_ps_hasKey' ) : null;
    $spb_ps_hasKeyIV    = (!empty( get_option( 'spb_ps_hasKeyIV' ))) ?  get_option( 'spb_ps_hasKeyIV' ) : null;
    $spb_ps_merchantId  = (!empty( get_option( 'spb_ps_merchantId' ))) ?  get_option( 'spb_ps_merchantId' ) : null;
    $spb_ps_payment_url = (!empty( get_option( 'spb_ps_payment_url' ))) ?  get_option( 'spb_ps_payment_url' ) : null;

    // testing
    $spb_ps_hasKey_test      = (!empty( get_option( 'spb_ps_hasKey_test' ))) ?  get_option( 'spb_ps_hasKey_test' ) : null;
    $spb_ps_hasKeyIV_test    = (!empty( get_option( 'spb_ps_hasKeyIV_test' ))) ?  get_option( 'spb_ps_hasKeyIV_test' ) : null;
    $spb_ps_merchantId_test  = (!empty( get_option( 'spb_ps_merchantId_test' ))) ?  get_option( 'spb_ps_merchantId_test' ) : null;
    $spb_ps_payment_url_test = (!empty( get_option( 'spb_ps_payment_url_test' ))) ?  get_option( 'spb_ps_payment_url_test' ) : null;

    // global settings
    $spg_ps_status      = (!empty( get_option( 'spg_ps_status' ))) ?  get_option( 'spg_ps_status' ) : null;
    ?>

    <h1> Spgateway payment system!</h1>
    <hr>
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" >
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">General Settings</a></li>
                <li><a data-toggle="tab" href="#menu1">Live Settings</a></li>
                <li><a data-toggle="tab" href="#menu2">Testing Settings</a></li>
                <li><a data-toggle="tab" href="#menu3">Documentation</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <br><br>
                    <label class="form-label"> Select payment status mode </label>
                    <fieldset class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="spg_ps_status" id="spg_ps_status" value="Live" <?php print ($spg_ps_status == 'Live') ? 'checked' : null ?> />
                                Live
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="spg_ps_status" id="spg_ps_status" value="Testing" <?php print ($spg_ps_status == 'Testing') ? 'checked' : null ?> />
                                Testing
                            </label>
                        </div>
                    </fieldset>
                </div>
                <div id="menu1" class="tab-pane fade">

                    <br><br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hash Key</label>
                        <input type="text" value="<?php print $spb_ps_hasKey; ?>" name="spb_ps_hasKey" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">Enter your store hashkey ex: YK5drj7GZuYiSgfoPlc24OhHJj5g6I35</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">HashIV</label>
                        <input type="text" value="<?php print $spb_ps_hasKeyIV; ?>"  name="spb_ps_hasKeyIV" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store hashkey iv ex: t8jUsqArVyJOPZcF</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Merchant Id</label>
                        <input type="text" value="<?php print $spb_ps_merchantId; ?>"  name="spb_ps_merchantId" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store id ex: MS3709347 </small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Payment Url</label>
                        <input type="text" value="<?php print $spb_ps_payment_url; ?>"  name="spb_ps_payment_url" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store id ex: https://ccore.spgateway.com/MPG/mpg_gateway </small>
                    </div>


                </div>
                <div id="menu2" class="tab-pane fade">
                    <br><br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hash Key</label>
                        <input type="text" value="<?php print $spb_ps_hasKey_test; ?>" name="spb_ps_hasKey_test" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">Enter your store hashkey ex: YK5drj7GZuYiSgfoPlc24OhHJj5g6I35</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">HashIV</label>
                        <input type="text" value="<?php print $spb_ps_hasKeyIV_test; ?>"  name="spb_ps_hasKeyIV_test" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store hashkey iv ex: t8jUsqArVyJOPZcF</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Merchant Id</label>
                        <input type="text" value="<?php print $spb_ps_merchantId_test; ?>"  name="spb_ps_merchantId_test" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store id ex: MS3709347 </small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Payment Url</label>
                        <input type="text" value="<?php print $spb_ps_payment_url_test; ?>"  name="spb_ps_payment_url_test" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted">Enter your store id ex: https://ccore.spgateway.com/MPG/mpg_gateway </small>
                    </div>
                </div>


                <div id="menu3" class="tab-pane fade" >
                    <br><br>

                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Pages</a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    spgateway credit card payment way <br>
                                    http://localhost/wordpress/credit-card-payment-way/<br>
                                    [spgateway_credit_card_payment_way]<br>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Other Documentation 1</a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Other Documentation 2 </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" name="spg_ps_update_settings" class="btn btn-primary">Update Settings</button>
    </form>

    <?php
}


function spg_ps_checkout()
{


    print "this is the checkout page";
}
function spg_ps_thank_you()
{
    print "this is the thank you page";
}
