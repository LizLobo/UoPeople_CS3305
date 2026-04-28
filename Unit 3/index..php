<?php
//Question 1 begins here
function calculateTotal($price, $quantity) {
    return $price * $quantity * 1.1; // Adding 10% tax
}

function formatProductName($name) {
    $name = trim($name); // Remove leading and trailing whitespace
    $name = substr($name, 0, 50); // Limit to 50 characters
    return ucwords(strtolower($name)); // Capitalize the first letter of each word
}

// Function to calculate the discounted price based on the original price and discount percentage
function CalculateDiscount($price, $discountPercent){
    return $price * (1 - $discountPercent / 100);
}

//Question 2 begins here
// Array of products with their names and prices and include category
$products = [
    ['name' => 'iPhone 14', 'price' => 799, 'category' => 'Electronics'],
    ['name' => 'MacBook Air', 'price' => 1099, 'category' => 'Electronics'],
    ['name' => 'iPad Pro', 'price' => 799, 'category' => 'Electronics'],
    ['name' => 'Apple Watch Series 8', 'price' => 399, 'category' => 'Electronics'],
    ['name' => 'AirPods Pro', 'price' => 249, 'category' => 'Electronics']
];

// Function to remove duplicate products based on product names
function removeDuplicateProducts(array $products): array {
    $seen = []; // Array to track seen product names
    $uniqueProducts = []; // Array to store unique products
    
    foreach ($products as $product) {
        if (!in_array($product['name'], $seen)) {
            $seen[] = $product['name']; // Add name to seen array
            $uniqueProducts[] = $product; // Keep the product
        }
    }
    
    return $uniqueProducts; // Return the array with duplicates removed
}

// Function to sort products by price in ascending order (lowest to highest)
function sortProductsByPrice(array $products) {
    return sort($products);
}


// Apply 10% discount to products in the "Electronics" category
foreach ($products as &$product) {
    if ($product['category'] === 'Electronics') {
        $product['price'] = CalculateDiscount($product['price'], 10);
    }
}

// Print the updated product list
echo "Updated Product List:\n";
foreach ($products as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . "\n";
}

// Define supplier inventories
$supplier1 = [
    ['name' => 'iPhone 14', 'price' => 799, 'category' => 'Electronics'],
    ['name' => 'MacBook Air', 'price' => 1099, 'category' => 'Electronics'],
    ['name' => 'Samsung Galaxy S23', 'price' => 699, 'category' => 'Electronics']
];

$supplier2 = [
    ['name' => 'iPad Pro', 'price' => 799, 'category' => 'Electronics'],
    ['name' => 'Apple Watch Series 8', 'price' => 399, 'category' => 'Electronics'],
    ['name' => 'AirPods Pro', 'price' => 249, 'category' => 'Electronics'],
    ['name' => 'iPhone 14', 'price' => 799, 'category' => 'Electronics'] // Duplicate
];

// Merge the two supplier arrays
$mergedProducts = array_merge($supplier1, $supplier2);

// Remove duplicates based on product name
$uniqueProducts = removeDuplicateProducts($mergedProducts);

// Print the combined inventory
echo "Combined Inventory:\n";
foreach ($uniqueProducts as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . "\n";
}

//Question 3 begins here


