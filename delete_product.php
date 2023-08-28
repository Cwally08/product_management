<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST["id"];

    $getImagePathQuery = "SELECT image_path FROM products WHERE id = ?";
    $getImagePathStmt = $conn->prepare($getImagePathQuery);
    $getImagePathStmt->bind_param("i", $productId);
    $getImagePathStmt->execute();
    $getImagePathStmt->bind_result($imagePath);
    $getImagePathStmt->fetch();
    $getImagePathStmt->close();

    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $response = array("success" => true, "message" => "Product and image deleted successfully");
    } else {
        $response = array("success" => false, "message" => "Error deleting product");
    }

    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>
