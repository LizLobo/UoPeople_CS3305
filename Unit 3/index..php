<?php
//Question 1 begins here
//Section covering part a.
/**
 * Calculates the total price including tax
 *
 * @param float $price The unit price of the item
 * @param int $quantity The quantity of items to purchase
 * @return float The total cost with 10% tax applied
 * 
 * This uses a simple arithmetic formula to calculate total cost and apply tax.
 * The approach aligns with standard PHP arithmetic operations (PHP Documentation, n.d.).
 */
function calculateTotal($price, $quantity) {
    return $price * $quantity * 1.1; // Adding 10% tax
}

//Section covering part b.
/**
 * Formats a product name by applying multiple transformations.
 *
 * This function takes a product name string and:
 * - Removes leading and trailing whitespace
 * - Limits the name to a maximum of 50 characters
 * - Removes all special characters, keeping only alphanumeric characters and spaces
 * - Converts the string to lowercase and capitalizes the first letter of each word
 *
 * @param string $name The product name to be formatted
 * @return string The formatted product name with proper capitalization and cleaned content
 *
 * @example
 * $formatted = formatProductName("  HELLO world! @#$ ");
 * // Returns: "Hello World"
 * 
 * These techniques are based on common PHP string handling practices
 * (PHP Documentation, n.d.; Bro Code, 2024c).
 */
function formatProductName($name) {
    $name = trim($name); // Remove leading and trailing whitespace
    $name = substr($name, 0, 50); // Limit to 50 characters
    $name = preg_replace('/[^A-Za-z0-9 ]+/', '', $name); // Remove special characters from name (This is part of question 3)
    return ucwords(strtolower($name)); // Capitalize the first letter of each word
}

//Section covering part c.
// Function to calculate the discounted price based on the original price and discount percentage
/**
 * Calculates the discounted price based on the original price and discount percentage.
 *
 * @param float $price The original price of the item.
 * @param float $discountPercent The discount percentage (e.g., 10 for 10%).
 * @return float The discounted price.
 * 
 * Uses a percentage-based reduction formula, which is a standard approach
 * when working with numeric values in PHP (PHP Documentation, n.d.).
 */
function calculateDiscount($price, $discountPercent){
    return $price * (1 - $discountPercent / 100);
}



//Question 2 begins here
//Section covering part a.
// Associative arrays are useful for structured data like products with multiple attributes
// (Bro Code, 2024b; PHP Documentation, n.d.).
//I've added special characters to the product names to demonstrate the cleaning function in question 3, and also added descriptions to make it more realistic and to have more data to work with for question 3.
$products = [
    [
        'name' => 'iPhone 14!',
        'price' => 799,
        'category' => 'Electronics',
        'description' => 'Apple smartphone with A15 Bionic chip and 6.1-inch display'
    ],
    [
        'name' => 'MacBook Air & Pro',
        'price' => 1099,
        'category' => 'Electronics',
        'description' => 'Lightweight laptop with M1 chip and Retina display'
    ],
    [
        'name' => 'iPad Pro-12.9',
        'price' => 799,
        'category' => 'Electronics',
        'description' => 'Powerful tablet with Apple Pencil support and Liquid Retina display'
    ],
    [
        'name' => 'Apple Watch Series 8@',
        'price' => 399,
        'category' => 'Electronics',
        'description' => 'Smartwatch with health tracking and always-on Retina display'
    ],
    [
        'name' => 'AirPods Pro#2',
        'price' => 249,
        'category' => 'Electronics',
        'description' => 'Wireless earbuds with active noise cancellation and spatial audio'
    ]
];

//print original list of products
echo "Original Product List:\n";
foreach ($products as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . ", Description: " . $product['description'] . "\n";
}

// Function to remove duplicate products based on product names
/**
 * Removes duplicate products from an array based on product names.
 *
 * This function iterates through the provided array of products and ensures
 * that only unique products (based on their 'name' key) are retained. It uses
 * an associative array to track seen names for efficiency (PHP Documentation, n.d.; Bro Code, 2024a).
 *
 * @param array $products An array of associative arrays, each representing a product with at least a 'name' key.
 * @return array An array containing only unique products, preserving the first occurrence of each name.
 */
function removeDuplicateProducts(array $products): array {
    $seen = []; // Initialize an array to track product names that have already been encountered
    $uniqueProducts = []; // Initialize an array to store the unique products
    
    // Loop through each product in the input array
    foreach ($products as $product) {
        // Check if the product's name has not been seen before
        if (!in_array($product['name'], $seen)) {
            $seen[] = $product['name']; // Add the name to the seen array to mark it as encountered
            $uniqueProducts[] = $product; // Add the product to the unique products array
        }
        // If the name is already in seen, skip this product (duplicate)
    }
    
    return $uniqueProducts; // Return the array containing only unique products
}

// Function to sort products by price in ascending order (lowest to highest)
/**
 * Sorts an array of products by their price in ascending order (lowest to highest).
 *
 * This function uses the usort function with a spaceship operator to compare
 * the 'price' values of each product, ensuring the array is sorted from the
 * cheapest to the most expensive item (PHP Documentation, n.d.).
 *
 * @param array $products An array of associative arrays, each containing at least a 'price' key with a numeric value.
 * @return array The sorted array of products.
 */
function sortProductsByPrice(array $products) {
    usort($products, function ($a, $b) {
        return $a['price'] <=> $b['price'];
    });
    return $products;
}

$products = sortProductsByPrice(removeDuplicateProducts($products));

//print sorted list of products
echo "Sorted Product List:\n";
foreach ($products as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . ", Description: " . $product['description'] . "\n";
}


// Section covering part b.
// Apply 10% discount to products in the "Electronics" category
// Iterate through each product in the $products array using a reference (&$product)
// to allow direct modification of the original array elements
foreach ($products as &$product) {
    // Check if the current product's category is 'Electronics'
    if ($product['category'] === 'Electronics') {
        // Apply a 10% discount to the product price using the calculateDiscount function
        // and update the product's price with the discounted value
        $product['price'] = calculateDiscount($product['price'], 10);
    }
}

// Print the updated product list with the discounted prices for products in the "Electronics" category
echo "Updated Product List:\n";
foreach ($products as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . ", Description: " . $product['description'] . "\n";
}

// Section covering part c.
// Define supplier inventories
$supplier1 = [
    [
        'name' => 'iPhone 14',
        'price' => 799,
        'category' => 'Electronics',
        'description' => 'Apple smartphone with A15 Bionic chip and 6.1-inch display'
    ],
    [
        'name' => 'MacBook Air',
        'price' => 1099,
        'category' => 'Electronics',
        'description' => 'Lightweight laptop with M1 chip and Retina display'
    ],
    [
        'name' => 'Samsung Galaxy S23',
        'price' => 699,
        'category' => 'Electronics',
        'description' => 'Android flagship phone with high-resolution camera and dynamic AMOLED screen'
    ]
];

$supplier2 = [
    [
        'name' => 'iPad Pro',
        'price' => 799,
        'category' => 'Electronics',
        'description' => 'Powerful tablet with Apple Pencil support and Liquid Retina display'
    ],
    [
        'name' => 'Apple Watch Series 8',
        'price' => 399,
        'category' => 'Electronics',
        'description' => 'Smartwatch with health tracking and always-on Retina display'
    ],
    [
        'name' => 'AirPods Pro',
        'price' => 249,
        'category' => 'Electronics',
        'description' => 'Wireless earbuds with active noise cancellation and spatial audio'
    ],
    [
        'name' => 'iPhone 14',
        'price' => 799,
        'category' => 'Electronics',
        'description' => 'Apple smartphone with A15 Bionic chip and 6.1-inch display' // Duplicate
    ]
];

// Merge the two supplier arrays
$mergedProducts = array_merge($supplier1, $supplier2);

// Remove duplicates based on product name
$uniqueProducts = removeDuplicateProducts($mergedProducts);

// Print the combined inventory
echo "Combined Inventory:\n";
foreach ($uniqueProducts as $product) {
    echo "Name: " . $product['name'] . ", Category: " . $product['category'] . ", Price: $" . number_format($product['price'], 2) . ", Description: " . $product['description'] . "\n";
}



//Question 3 begins here

//Section covering part a.
/**
 * Format and sanitize a product description for consistent display.
 *
 * Trims whitespace, converts underscores to spaces, limits the length
 * to 100 characters, and converts the result to lowercase.
 *
 * @param string $description The raw product description to be normalized.
 * @return string The cleaned and formatted product description.
 * 
 * Demonstrates string manipulation using trim(), preg_replace(), substr(), and strtolower()
 * (PHP Documentation, n.d.; Bro Code, 2024c).
 */
function formatProductDescription($description) {
    $description = trim($description); // Remove leading and trailing whitespace
    $description = preg_replace('/_/', ' ', $description); // Replace underscores with a single space    
    $description = substr($description, 0, 100); // Limit to 100 characters
    return strtolower($description); // Convert to lowercase
}

//format and sanitize product names and descriptions
foreach ($products as &$product) {
    $product['description'] = formatProductDescription($product['description']);
    $product['name'] = formatProductName($product['name']);
}

//Section covering part b.
//I changed the function to also accept a keyword, so that it can check for relevant keywords, since 'leather', in the assignment prompt is not part of my products.
/**
 * Analyze a description string for word count, character count, and keyword presence.
 *
 * @param string $description The text to analyze.
 * @param string $keyword The keyword to search for within the description.
 *
 * @return array{
 *     wordCount: int,
 *     characterCount: int,
 *     keywordFound: bool
 * }
 * 
 *   Uses:
 * - str_word_count() for words
 * - strlen() for characters
 * - strpos() for keyword detection
 * (PHP Documentation, n.d.)
 */
function analyzeDescription($description, $keyword) {
    $wordCount = str_word_count($description);
    $characterCount = strlen($description);
    $keywordFound = strpos(strtolower($description), strtolower($keyword)) !== false;
    if ($keywordFound) {
        echo "Keyword found\n";      
    } else {
        echo "Keyword not found\n";        
    }
        echo "Characters: $characterCount\n";
        echo "Words: $wordCount\n";
    return [
        'wordCount' => $wordCount,
        'characterCount' => $characterCount,
        'keywordFound' => $keywordFound
    ];
}

//Using analyzeDescription function with a sample description and keyword
$sampleDescription = "This is a powerful tablet with Apple Pencil support and Liquid Retina display.";
$sampleKeyword = "pencil";
analyzeDescription($sampleDescription, $sampleKeyword);


//Section covering part c.

/**
 * Format and process a customer review string.
 *
 * Trims leading and trailing whitespace, generates a short preview of the review,
 * searches for the case-insensitive keyword "excellent", and appends a thank-you
 * message to the original review text.
 *
 * @param string $review  The original customer review input.
 * @return string         The updated review with appended feedback acknowledgement.
 * 
 *  Demonstrates substring extraction, searching, and concatenation
 * (Bro Code, 2024c; PHP Documentation, n.d.).
 */

function formatCustomerReview($review)
{
    $review = trim($review);
    $preview = substr($review, 0, 20) . "...";
    echo "Preview: " . $preview . "\n";

    $position = strpos(strtolower($review), "excellent");
    if ($position !== false) {
        echo "Keyword 'excellent' found at position: " . $position . "\n";
    } else {
        echo "Keyword 'excellent' not found\n";
    }

    $updatedReview = $review . " Thank you for your feedback!";
    echo "Full Review: " . $updatedReview . "\n";

    return $updatedReview;
}

// Using formatCustomerReview function with a sample review
$sampleReview = "  This product is excellent! I really enjoyed using it.  ";
formatCustomerReview($sampleReview);


