<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config.php"; 

$response = array(); 

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $response['success'] = true;
        $response['product'] = $product;
    } else {
        http_response_code(404);
        $response['success'] = false;
        $response['error'] = "Product not found";
    }
    
    $stmt->close();
    } else {
        http_response_code(400);
        $response['success'] = false;
        $response['error'] = "Invalid request";
    }

header('Content-Type: application/json');
echo json_encode($response);

$conn->close(); 
?>
