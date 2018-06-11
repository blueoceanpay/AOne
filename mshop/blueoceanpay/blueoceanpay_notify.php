<?php
require_once '../../config.php';

$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
require_once LocalBaseURL . 'public_method/handle_order_function.php';
require_once LocalBaseURL . 'public_method/order_operation.php';

$out_trade_no   = $_POST['out_trade_no'];
$industry_type  = 'shop';
$out_trade_no   = $_POST['out_trade_no'];
$transaction_id = $_POST['transaction_id'];
$paytype        = "blueoceanpay";
$real_pay_price = $_POST['total_fee'] / 100;

try {
    $order_ope   = new order_operation();
    $customer_id = $order_ope->find_customer_id_from_log($out_trade_no);
    $result      = handle_order_function($customer_id, $industry_type, $out_trade_no, $transaction_id, $paytype, '', '', $real_pay_price);
    ob_end_clean();
    echo "SUCCESS";
} catch (\Exception $e) {
    file_put_contents('./exception.txt', $e->getMessage());
}

mysql_close($link);
