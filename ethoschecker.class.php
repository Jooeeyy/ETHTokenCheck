<?php
/**
 * Created by PhpStorm.
 * User: Elias
 * Date: 26.01.2018
 * Time: 09:34
 */

class EthosChecker
{
    public function run()
    {
        $this->mainPage();
        if (isset($_POST['address'])) {
            $this->checkAddress();
        }
    }

    public function write($message, $type = "secondary")
    {
        echo "<div class='alert alert-" . $type . "'>" . $message . "</div>";
    }

    public function mainPage()
    {

        $address = isset($_POST['address']) ? $_POST['address'] : '';

        echo '
<div class="col-sm">
            <h1>Input Address</h1>
            <form method="post">
            <div class="form-group">
            <input class="form-control" name="address" id="address" value="' . $address . '" />
            </div>
            <div class="alert alert-info">We only check in the last 50 transactions whether you sent us a confirmation. </div>
            <button class="btn btn-success">Check</button>
            </form>
            </div>
        ';
    }

    public function checkAddress()
    {

        $transactionChecker = new TransactionChecker("freekey");

        echo '<div class="col-sm">';
        echo "<h1>Result</h1>";

        $address = $_POST['address'];

        $this->write("Let us check your account: ".$address, "info");
        $this->write("First we need to check if you have ETHOS on your account");


        try {
            $balance = $transactionChecker->getTokenBalance($address, "0x5af2be193a6abca9c8817001f45744777db30756");

            if ($balance >= 1) {
                $this->write("ETHOS Tokens: " . $balance);

                //check for confirmation transaction
                $toAddress = "0xc6bbdbd889867ec21830daf6e94e0a90b211d075";
                $exist = $transactionChecker->checkAvailableTransaction($address, $toAddress);

                if ($exist) {
                    $this->write("Your address has enough ETHOS and sent a transaction to our address", "success");
                } else {
                    $this->write("Your address has ETHOS but you need to send a transaction to this address with 0 ETH: " . $toAddress, "warning");
                }

            } else {
                $this->write("Your address has not enough ETHOS Tokens", "danger");
            }

        } catch (Exception $e) {
            $this->write("Error:  " . $e->getMessage(), "danger");
        }


        echo "</div>";

    }
}