<?php
require_once 'models/Product.php';
require_once 'models/Sales.php';

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['message' => 'Invalid data']);
    exit;
}

$orderItems = $data['orderItems'];
$paymentMethod = $data['paymentMethod'];

// Update stock and sales
foreach ($orderItems as $item) {
    $productId = $item['id'];
    $quantity = $item['quantity'];
    $price = $item['price'];

    // Reduce stock
    $product = Product::find($productId);
    if ($product) {
        $product->quantity -= $quantity;
        $product->update();
    }

    // Update sales
    Sales::addSale($productId, $quantity, $price);
}

echo json_encode(['message' => 'Order updated successfully']);
?>
