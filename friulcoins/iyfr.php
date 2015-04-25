<?php

use BitWasp\BitcoinLib\BitcoinLib;
use BitWasp\BitcoinLib\Jsonrpcclient;
use BitWasp\BitcoinLib\RawTransaction;
require_once(__DIR__. '/../vendor/autoload.php');
BitcoinLib::setMagicByteDefaults("23|05");
$keys = [
                        'R9XT5mLp114Ri16Wkv49s3fSehMtSLzrTk2u9amr5F4qKQQuY3LQ'
                        ];
						
$pvk = ['R9XT5mLp114Ri16Wkv49s3fSehMtSLzrTk2u9amr5F4qKQQuY3LQ'];
$privateKey1 = BitcoinLib::WIF_to_private_key($pvk[0]);
$publicKey1 = BitcoinLib::private_key_to_public_key($privateKey1['key'], $privateKey1['is_compressed']);
$address1 = BitcoinLib::public_key_to_address($publicKey1);

$add = $address1  ;
$toadd = 'FTbv6PRsT9nBMxkXh2x9FfNeQHhcWqgbjn';
$amountCoins=.5;
   $url = "http://104.131.45.33:3001/api/addr/".$add."/utxo";        
         $getresult = file_get_contents($url);       
         $myArray = explode(',', $getresult);
         $myArray2 = explode('"', $myArray[0]); 
         $Baddress=$myArray2[3];
         $myArray2 = explode('"', $myArray[1]); 
         $Btxid=$myArray2[3];
         $myArray2 = explode('"', $myArray[2]); 
         $Bvout = substr($myArray2[2], 1);
         $myArray2 = explode('"', $myArray[4]); 
         $BscriptPubKey = $myArray2[3];
         $myArray2 = explode('"', $myArray[5]);
         $Bamount = substr($myArray2[2], 1);
						
$ixidf = $Btxid;
$amountid = $Bamount;
$address_add = $add;
$vouts = $Bvout * 1  ; 

$sendTo = $toadd;
$sendAmount = BitcoinLib::toSatoshi($amountCoins);

echo  $Bvout*2;
echo "\n"; 
//return;
// ----------------------------------------------------
$spk = substr(BitcoinLib::base58_decode($address_add), 2, 40);
$scriptPubKey_id ='76a914'.$spk.'88ac';

//echo $spk;

echo "\n";
echo $scriptPubKey_id; 
echo "\n";
echo $BscriptPubKey;
echo "\n";


//$ixidf = 'bfbbc679487aab781304e898f8a508dd6ef5e71d8d2f8f283d74dc696eccbee4';
//$amountid=9.22990000;
//$address_add='FJqhLzywMxh5xywBLPQKH7Na1M29szuVvD';
//$vouts=1; 


$inputs = array(
    array(
            'txid' => $ixidf,
            'vout' =>$vouts ,
            'address' => $address_add,
            'scriptPubKey' => $scriptPubKey_id,
            'amount' => BitcoinLib::toSatoshi($amountid),
                                                )
                                                ); 
$changeAddress = $add;
$fee = BitcoinLib::toSatoshi(0.0001);
// calculate total of input(s)
$inputsTotal = array_sum(array_column($inputs, 'amount'));
// calculate remaining change
$change = $inputsTotal - $sendAmount - $fee;
// Set up outputs here.
$outputs = [
    $sendTo => $sendAmount
];
// if there's change then we need another output
if ($change > 0) {
    $outputs[$changeAddress] = $change;
}
var_dump($inputsTotal, $fee, $change, $outputs);

// import private keys
$wallet = array();

RawTransaction::private_keys_to_wallet($wallet, $pvk);


// Create raw transaction
$raw_transaction = RawTransaction::create($inputs, $outputs);
print_r($raw_transaction); echo "\n";


$sign = RawTransaction::sign($wallet, $raw_transaction, json_encode($inputs));

print_r($sign); echo "\n";

// Get the transaction hash from the raw transaction
$txid = RawTransaction::txid_from_raw($sign['hex']);
echo "</br>";
print_r($txid); echo "\n";

echo "</br>";


$rpcHost = '127.0.0.1';
$rpcUser = 'coinrpcBanksYCIunnnm,';
$rpcPassword = 'EsKsoETThGsEAizPdwbqsJFWA6aENNrwE5NoLTM5XqKg6sadxx';
$rpcPort = 8333;
$rpc = new Jsonrpcclient(['url' => "http://{$rpcUser}:{$rpcPassword}@{$rpcHost}:{$rpcPort}"]);

do {
    $sendit = readline("do you want to send it? (say YES or NO) ");
    if (strtolower($sendit) === "yes") {
        if ($rpc->sendrawtransaction($sign['hex'])) {
            echo "SEND!";
            exit;
        }
    } else if (strtolower($sendit) === "no") {
        exit;
    }
} while(true);
