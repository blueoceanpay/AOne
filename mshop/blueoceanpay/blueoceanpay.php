<?php
header("Content-type: text/html; charset=utf-8");
require "../../config.php";

//调试模式:开启
define('DEBUG_MODE', true);
ini_set('display_errors', 1);
error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

$order_id = -1;
if (!empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
}

if (!empty($_GET["industry_type"])) {
    $industry_type = $_GET["industry_type"];
    if ($industry_type == "cashier_o2o") {
        $cash_o2o_type = $_GET["cash_o2o_type"];
    }
    if ($industry_type == "orderingretail") {
        if (!empty($_GET["opt"])) {
            $opt = $_GET["opt"]; //是否是转上级操作
        } else {
            $opt = "stock";
        }
    }

    if ($industry_type == "cityarea") {
        $is_merge  = $_GET["is_merge"];
        $city_type = $_GET["city_type"];
    }
}

$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
require_once LocalBaseURL . "public_method/handle_order_function.php";
require_once LocalBaseURL . 'common/common_from.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/wsy_pay/sdk/IndustryOpeInstance.php';

// 获取支付方式配置信息
$query = "SELECT
            appid,
            appsecret,
            sub_mch_id AS store_id
        FROM
            pay_config
        WHERE
            pay_type = 'blueoceanpay'
        AND
            isvalid = 1
        AND
            customer_id = $customer_id
        LIMIT 1 ";

$result = _mysql_query($query) or die('Query failed5182: ' . mysql_error());
$appid  = $appsecret  = $store_id  = '';
while ($row = mysql_fetch_object($result)) {
    $appid     = $row->appid;
    $appsecret = $row->appsecret;
    $store_id  = $row->store_id;
    break;
}

// 获取 openid.
$openid = "";
if (!isset($_GET['response'])) {
    $original   = urlencode($protocol_http_host . $_SERVER['REQUEST_URI']);
    $openid_url = "http://auth.hk.blueoceanpay.com/wechat/user/getOpenId?merchant=$appid&original=$original";
    header("location: $openid_url");
    exit;
} else {
    $response = json_decode($_GET['response'])->data;
    $openid   = $response->openid;
}

$extra = array();
if ($industry_type == "orderingretail") {
    $extra['opt'] = $opt;
}
if ($industry_type == "cityarea") {
    $extra['is_merge'] = $is_merge;
}

//查询订单数据
$data = query_order($customer_id, $order_id, $industry_type, "", "weipay", $extra);

//订单已支付
if ($data['paystatus'] == 10001) {
    die();
}

/****************************** 开始支付 ******************************/
// 支付接口地址
$url        = 'http://api.hk.blueoceanpay.com/payment/pay';
$notify_url = $protocol_http_host . "/weixinpl/mshop/blueoceanpay/blueoceanpay_notify.php?customer_id=" . $customer_id;
// 支付订单数据
$requestData = [
    'openid'       => $openid,
    'appid'        => $appid,
    'payment'      => 'wechat.jsapi',
    'body'         => $data['pnamearr'], //商品名称
    'out_trade_no' => $data['order_id'],
    'total_fee'    => $data['totalprice'] * 100,
    'notify_url'   => $notify_url,
];

if ($store_id) {
    $requestData['store_id'] = $store_id;
}

$requestData['sign'] = generateSign($requestData, $appsecret);
$result              = httpPost($url, json_encode($requestData));
$returnData          = json_decode($result, true);

if ($returnData['code'] == 200) {
    $jsApiParameters = $returnData['data']['jsapi'];
} else {
    if ($returnData['data'] != '') {
        echo $returnData['message'] . ': ' . $returnData['data'];
    } else {
        echo $returnData['message'];
    }
    exit;
}

// 获取支付跳转地址
$return_page = '/weixinpl/mshop/orderlist_detail.php?customer_id=' . $customer_id . '&batchcode=' . $order_id;

/**
 * 以post方式提交请求
 * @param string $url
 * @param array|string $data
 * @return bool|mixed
 */
function httpPost($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    if (is_array($data)) {
        foreach ($data as &$value) {
            if (is_string($value) && stripos($value, '@') === 0 && class_exists('CURLFile', false)) {
                $value = new CURLFile(realpath(trim($value, '@')));
            }
        }
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $data = curl_exec($ch);
    curl_close($ch);
    if ($data) {
        return $data;
    }
    return false;
}

/**
 * 数组数据签名
 * @param array $data 参数
 * @param string $key 密钥
 * @return string 签名
 */
function generateSign($data, $key)
{
    $ignoreKeys = ['sign', 'key'];
    ksort($data);
    $signString = '';
    foreach ($data as $k => $v) {
        if (in_array($k, $ignoreKeys)) {
            unset($data[$k]);
            continue;
        }
        $signString .= "{$k}={$v}&";
    }
    $signString .= "key={$key}";
    return strtoupper(md5($signString));
}

mysql_close($link);

?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>蓝海支付</title>
<script type="text/javascript">
var customer_id = '<?php echo $customer_id; ?>';
var customer_id_en = "<?php echo $customer_id_en; ?>";
var return_page = "<?php echo $return_page; ?>";

//调用微信JS api 支付
function jsApiCall()
{
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        <?php echo $jsApiParameters; ?>,
        function(res){
            var msg = res.err_msg;
            var p_stu = false;
            var url = "";
           if(msg=="get_brand_wcpay_request:ok"){
               p_stu = true;
               document.location="<?php echo $protocol_http_host; ?>"+return_page;
           }else{
              win_alert('支付失败！');
           }
        }
    );
}

function callpay()
{
    if (typeof WeixinJSBridge == "undefined"){
        alert(555);
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall();
    }
}
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
   callpay();
})

</script>

<?php
$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
require_once LocalBaseURL . 'common/common_from.php';
require_once LocalBaseURL . 'common/share.php';
?>

</head>
<body>
</body>
</html>

