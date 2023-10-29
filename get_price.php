<?php

function get_price($taille, $poids)
{
    include "../db_connect.php";
    // include '../crypt.php';

    // Load .env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $API_HOST = $_ENV['API_HOST'];

    $sql = "SELECT poids, taille, prix FROM contrat WHERE prix IS NOT NULL";
    $result = mysqli_query($connection, $sql);
    $train = [];
    $price = 0;
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($train, array(floatval(decrypt($row['prix'])), floatval(decrypt($row['taille'])), floatval(decrypt($row['poids']))));
        }
    }

    if (!empty($train)) {
        $data = array(
            'taille' => floatval($taille),
            'poids' => floatval($poids),
            'data_train' => $train
        );

        $ch = curl_init($API_HOST . '/predict');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        if ($result) {
            $price = $result['price'];
        }
    }
    return $price;
}
