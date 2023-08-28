<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "config.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $expiry = $_POST["expiry"];
    $inventory = $_POST["inventory"];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = basename($_FILES['image']['name']);
        $imagePath = '../product_management/uploads/' . $imageFileName;
        
        $targetDir = '../product_management/uploads/';
        $targetFile = $targetDir . $imageFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO products (name, unit, price, expiry_date, inventory, image_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsss", $name, $unit, $price, $expiry, $inventory, $imagePath);

            if ($stmt->execute()) {
                $response["status"] = "success";
                $response["message"] = "Product added successfully";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response["status"] = "error";
            $response["message"] = "Error uploading image.";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "No image uploaded or upload error.";
    }
} else {
    $response["status"] = "error";
    $response["message"] = "Invalid request method: " . $_SERVER["REQUEST_METHOD"];
}

echo json_encode($response);
?>
