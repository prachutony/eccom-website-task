<?php
require "includes/common.php";
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51Qd4cpQCONvr4H0ATjPhGrLcx1IchDte2ZdVTBr56dMybR9op0VAOErTzqLIQxS6ka2QEixGOTuc3yK3FDpwILXp00zEK4EHNw";

\Stripe\Stripe::setApiKey($stripe_secret_key);


$user_id = $_SESSION['user_id'];
$query = " SELECT products.price AS Price, products.id, products.name AS Name FROM users_products JOIN products ON users_products.item_id = products.id WHERE users_products.user_id='$user_id' and status='Added To Cart'";
$result = mysqli_query($con, $query);
$line_items = [];
$total_price = 0;
while ($row = mysqli_fetch_array($result)) {
    $line_item = [
        "quantity" => 1,
        "price_data" => [
            "currency" => "inr",
            "unit_amount" => $row["Price"]*100,
            "product_data" => [
                "name" => $row["Name"]
            ]
        ]
    ];
    $total_price += $row["Price"];
    array_push($line_items, $line_item);

}

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/ecommerce-task/success.php?total_price=$total_price",
    "cancel_url" => "http://localhost/ecommerce-task/cart.php",
    "locale" => "auto",
    "line_items" => $line_items
]);

http_response_code(303);
header("Location: " . $checkout_session->url);