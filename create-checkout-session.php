<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too
session_start();
$amount = $_POST['customamount'];


// require 'vendor/autoload.php';
include './stripe-php\stripe-php-master\init.php';
\Stripe\Stripe::setApiKey('sk_test_51JFfNuDPzeSt5wX6TVzie53XHBdHEnqSsevoVbmVAGm8RrId5PNZSK3TAJ07LGVb5gOLs7CZJblby2k3yQqMHAIX00lGPnAZWy');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/payment';

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'gbp',
      'unit_amount' => $amount*100,
      'product_data' => [
        'name' => 'Donatation'
       
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);



header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
