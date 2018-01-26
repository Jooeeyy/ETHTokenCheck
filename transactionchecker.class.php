<?php
/**
 * User: Elias Trewin
 * Date: 26.01.2018
 * Time: 13:14
 */

class TransactionChecker
{

    private $apiKey;

    public function __construct($apikey = "freekey") {
        $this->apiKey = $apikey;
    }

    /**
     * @param $address
     * @param $contractAddress
     * @return float|int
     * @throws Exception
     * @description Returns the balance of a token
     */
    public function getTokenBalance($address, $contractAddress) {
        $url = "https://api.ethplorer.io/getAddressInfo/" . $address . "?apiKey=".$this->apiKey;

        $tokens = 0;

        $json = file_get_contents($url);
        $obj = json_decode($json, true);

        if (isset($obj["error"])) {
            // Throw an Error
            throw new Exception($obj['error']['message']);
        } else {
            // Check the balance
            if (isset($obj["tokens"])) {
                foreach ($obj["tokens"] as $token) {
                    if ($token["tokenInfo"]["address"] == $contractAddress) {
                        $balance = $token["balance"] / 100000000;
                        $tokens = $balance;
                    }
                }
            }
        }

        return $tokens;
    }

    /**
     * @param $from
     * @param $to
     * @return bool
     * @throws Exception
     * @description Check if a Address sent a Transaction to another address.
     *              This functions just check the last 50 transactions.
     */
    public function checkAvailableTransaction($from, $to) {
        $checkUrl = "https://api.ethplorer.io/getAddressTransactions/" . $from . "?apiKey=".$this->apiKey."&limit=50&showZeroValues=true";
        $json = file_get_contents($checkUrl);
        $obj = json_decode($json, true);

        if (isset($obj["error"])) {
            //Throw the error.
            throw new Exception($obj['error']['message']);
        } else {
            //check if the there is successfully transaction to the target address.
            if (is_array($obj)) {
                foreach ($obj as $transaction) {
                    if ($transaction["success"] == true && $transaction["to"] == $to) {
                        return true;
                    }
                }
            }

        }

        return false;
    }
}
