<?php

// Include your database connection
include 'db_connect.php'; // Use the existing connection from db_connect.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

// Get the POST data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields are present
if (!isset($data['first_name'], $data['last_name'], $data['address'], $data['city'], $data['zip_code'], $data['phone'], $data['email'], $data['cartItems'])) {
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
    $stmt = $conn->prepare("INSERT INTO porudzbine (ime, prezime, adresa, grad, postanski_broj, broj_telefona, mejl, ukupna_cena, cena_dostave) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind values
    $stmt->bind_param(
        "sssssssii",
        $data['first_name'],
        $data['last_name'],
        $data['address'],
        $data['city'],
        $data['zip_code'],
        $data['phone'],
        $data['email'],
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

    // Generate the order summary HTML for email
    $orderDetails = "<h2>Detalji porudžbine:</h2>";
    $orderDetails .= "<p>Ime: {$data['first_name']} {$data['last_name']}</p>";
    $orderDetails .= "<p>Adresa: {$data['address']}, {$data['city']}, {$data['zip_code']}</p>";
    $orderDetails .= "<p>Telefon: {$data['phone']}</p>";
    $orderDetails .= "<table border='1' cellpadding='10' cellspacing='0'>";
    $orderDetails .= "<thead><tr><th>Proizvod</th><th>Količina</th><th>Cena</th><th>Ukupno</th></tr></thead>";
    $orderDetails .= "<tbody>";

    foreach ($data['cartItems'] as $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $orderDetails .= "<tr>
                            <td>{$item['name']}</td>
                            <td>{$item['quantity']}</td>
                            <td>{$item['price']} RSD</td>
                            <td>{$itemTotal} RSD</td>
                          </tr>";
    }

    $orderDetails .= "</tbody></table>";
    $orderDetails .= "<p><strong>Ukupna cena proizvoda:</strong> {$ukupnaCena} RSD</p>";
    $orderDetails .= "<p><strong>Cena dostave:</strong> {$cenaDostave} RSD</p>";
    $orderDetails .= "<p><strong>Ukupno za naplatu:</strong> " . ($ukupnaCena + $cenaDostave) . " RSD</p>";

    // Send confirmation email
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'mail.tvojluksuz.rs';                 
        $mail->SMTPAuth = true;                               
        $mail->Username = 'prodaja@tvojluksuz.rs';       
        $mail->Password = 'i-N.F2rNE3xUrgb';                    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
        $mail->Port = 587;                                   

        //Recipients
        $mail->setFrom('prodaja@tvojluksuz.rs', 'Tvoj luksuz');
        $mail->addAddress($data['email']);  // Customer's email

        // Email content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Potvrda porudzbine';
        $mail->Body    = '<b>Hvala na porudžbini!</b><br>' . $orderDetails;
        $mail->AltBody = 'Hvala na porudžbini!';

        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Email not sent. ' . $mail->ErrorInfo]);
    }

} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}