<?php
// Include database connection file
include('db_connect.php'); 

if (isset($_POST['submit'])) {
    // Collect product data
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $shortDescription = $_POST['shortDescription'];
    $discountedPrice = $_POST['discountedPrice'];

    // Prepare and bind the SQL statement
    $sql = $conn->prepare("INSERT INTO proizvodi (naziv, kratki_opis, cena_bez_popusta, cena_sa_popustom, opis) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sdssd", $product_name, $shortDescription, $discountedPrice, $product_price, $product_description);

    if ($sql->execute()) {
        // Get the last inserted product ID
        $product_id = $conn->insert_id;

        // Handle image uploads
        $total_images = count($_FILES['product_images']['name']);
        for ($i = 0; $i < $total_images; $i++) {
            $image_name = $_FILES['product_images']['name'][$i];
            $image_tmp_name = $_FILES['product_images']['tmp_name'][$i];
            $target_dir = "uploads/";  // Folder to store images
            $target_file = $target_dir . basename($image_name);

            // Move uploaded file to the target directory
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                // Insert image data into product_images table
                $sql_image = "INSERT INTO slike (id_proizvoda, url_slike) VALUES ('$product_id', '$target_file')";
                $conn->query($sql_image);
            }
        }

        echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
