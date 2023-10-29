<?php
function encrypt($data)
{
    // Load .env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];

    // Generate a random IV
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));

    // Encrypt the data
    $encryptedValue = openssl_encrypt($data, $cipherMethod, $encryptionKey, 0, $iv);

    // Combine the IV and encrypted value
    $combined = $iv . $encryptedValue;

    return base64_encode($combined); // Encode the result to ensure it's safe for storage or transmission
}

function decrypt($data)
{
    // Load .env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];
    $data = base64_decode($data); // Decode the data

    // Extract the IV
    $ivLength = openssl_cipher_iv_length($cipherMethod);
    $iv = substr($data, 0, $ivLength);

    // Extract the encrypted value
    $encryptedValue = substr($data, $ivLength);

    // Decrypt the data
    $decryptedValue = openssl_decrypt($encryptedValue, $cipherMethod, $encryptionKey, 0, $iv);

    return $decryptedValue;
}
