<?php
// Include your database connection
include 'db_connect.php'; // Use the existing connection from db_connect.php

// Get the POST data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields are present
if (!isset($data['ime'], $data['prezime'], $data['adresa'], $data['grad'], $data['postanski_broj'], $data['broj_telefona'], $data['cartItems'])) {
    echo json_encode(['success' => false, 'error' => 'Nedostaju potrebni podaci']);
    exit;
}

try {
    // Begin transaction
    $conn->begin_transaction();

    // Calculate the total price of products in the cart
    $ukupnaCena = 0;
    foreach ($data['cartItems'] as $item) {
        $ukupnaCena += $item['price'] * $item['quantity'];
    }

    // Determine the shipping cost: free if total price is more than 4500 RSD
    if ($ukupnaCena > 4500) {
        $cenaDostave = 0;  // Free shipping
    } else {
        $cenaDostave = 300; // Standard shipping cost
    }

    // Insert into porudzbine table
    $stmt = $conn->prepare("INSERT INTO porudzbine (ime, prezime, adresa, grad, postanski_broj, broj_telefona, ukupna_cena, cena_dostave) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind values
    $stmt->bind_param(
        "ssssssii",
        $data['ime'],
        $data['prezime'],
        $data['adresa'],
        $data['grad'],
        $data['postanski_broj'],
        $data['broj_telefona'],
        $ukupnaCena,
        $cenaDostave
    );
    $stmt->execute();

    // Get the last inserted order ID
    $porudzbina_id = $conn->insert_id;

    // Insert each product from the cart into porudzbina_proizvodi table
    $stmt = $conn->prepare("INSERT INTO porudzbina_proizvodi (id_porudzbine, naziv_proizvoda, kolicina, cena, slika_proizvoda_url) 
                            VALUES (?, ?, ?, ?, ?)");

    foreach ($data['cartItems'] as $item) {
        $stmt->bind_param(
            "isiis",
            $porudzbina_id,
            $item['name'],
            $item['quantity'],
            $item['price'],
            $item['image']
        );
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
