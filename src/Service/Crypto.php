<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class Crypto
{

    private $cipher = "AES-128-CBC";
    private $passphrase;
    private $ivlen;
    private $logger;

    public function __construct(LoggerInterface $logger, string $passphrase)
    {
        $this->ivlen = openssl_cipher_iv_length($this->cipher);
        $this->logger = $logger;
        $this->passphrase = $passphrase;
    }

    public function encode(string $plaintext): ?string
    {
        $this->logger->info("Start encode message");
        $this->logger->info("Passphrase used: {passphrase}", ['passphrase' => $this->passphrase]);
        $iv = openssl_random_pseudo_bytes($this->ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $this->cipher, $this->passphrase, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->passphrase, true);

        $this->logger->info("Encoding finished and cipher returned");
        return base64_encode( $iv.$hmac.$ciphertext_raw );
    }

    public function decode(string $ciphertext): ?string
    {
        $decode = base64_decode($ciphertext);
        $iv = substr($decode, 0, $this->ivlen);
        $hmac = substr($decode, $this->ivlen, 32);
        $ciphertext_raw = substr($decode, $this->ivlen+32);

        $plaintext = openssl_decrypt($ciphertext_raw, $this->cipher, $this->passphrase, OPENSSL_RAW_DATA, $iv);

        $signature = hash_hmac('sha256', $ciphertext_raw, $this->passphrase, true);
        if( hash_equals($hmac, $signature) ) {
            return $plaintext;
        }

        return null;
    }
}
