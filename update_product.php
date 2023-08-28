<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "config.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST["id"];
    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $expiryDate = $_POST["expiry_date"];
    $inventory = $_POST["inventory"];

    $sql = "UPDATE products SET name=?, unit=?, price=?, expiry_date=?, inventory=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("ssdssi", $name, $unit, $price, $expiryDate, $inventory, $productId);

    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Product updated successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Failed to update product";
    }

    $stmt->close();
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request method";
}

header("Content-Type: application/json");
echo json_encode($response);
?>
