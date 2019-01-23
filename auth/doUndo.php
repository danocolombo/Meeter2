<?php
//$key previously generated safely, ie: openssl_random_pseudo_bytes
$plaintext = "test@recovery.help";
$key = "UAT";
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);
$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
echo "\n$plaintext\n";
echo "\n============================\n";
echo $ciphertext;
echo "\n============================\n";
//decrypt later....
$c = base64_decode($ciphertext);
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = substr($c, 0, $ivlen);
$hmac = substr($c, $ivlen, $sha2len=32);
$ciphertext_raw = substr($c, $ivlen+$sha2len);
$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
echo "\n$original_plaintext\n";
// if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
// {
//     echo $original_plaintext."\n";
// }

?>