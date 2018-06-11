<?php
require_once '../../config.php';
require_once '../../customer_id_decrypt.php'; //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
require_once '../../back_init.php';
require_once '../../common/common_ext.php';
require_once 'upload_icon.php';
$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database');
_mysql_query("SET NAMES UTF8");

$blueoceanpay_id = i2post("blueoceanpay_id", -1); //商城id
$version         = i2post("version", 0); //版本信息
$appid           = i2post("appid"); //APPID
$appsecret       = i2post("appsecret"); //APPSecret
$paysignkey      = i2post("paysignkey");
$partnerid       = i2post("partnerid");
$partnerkey      = i2post("partnerkey");
$sub_mch_id      = i2post("sub_mch_id");
$fee_type        = i2post("fee_type");
$title           = i2post("title", "");
$px              = i2post("px");
$icon            = i2post("icon");
$description     = i2post("description", "");
$attach          = i2post("attach");
$pay_type        = "blueoceanpay";

session_start();
$appsecretorgin  = $_SESSION['wxappsecret'];
$paysignkeyorgin = $_SESSION['wxpaysignkey'];
if (strpos($appsecret, "*") !== false) {
    $appsecret = $appsecretorgin;
}
if (strpos($paysignkey, "*") !== false) {
    $paysignkey = $paysignkeyorgin;
}

if ($_FILES["Filedata"]["error"] > 0) {
//    echo "Error:".$_FILES["Filedata"]["error"];
    //    exit;
} else {

    $tmp_name  = $_FILES["Filedata"]["tmp_name"];
    $file_name = $_FILES["Filedata"]["name"];
    $file_type = $_FILES["Filedata"]["type"];
    $file_size = $_FILES["Filedata"]["size"];

    if ((($file_type == "image/gif") || ($file_type == "image/jpeg") || ($file_type == "image/pjpeg") || ($file_type == "image/png")) && ($file_size < 50000)) {
        $upload_icon = new upload_icon();
        $icon        = $upload_icon->upload_icon($customer_id, $pay_type, $icon, $tmp_name, $file_name, $cust_oem_id);

    } else {
        echo "请检查上传图标的格式和大小是否符合要求";
        var_dump($tmp_name, $file_name, $file_type, $file_size);
        exit;
    }

}

$uptypes            = array('﻿application/octet-stream', '﻿application/octet-stream');
$max_file_size      = 1000000; //上传文件大小限制, 单位BYTE
$path_parts         = pathinfo($_SERVER['PHP_SELF']); //取得当前路径
$destination_folder = "../../" . Base_Upload . "Base/pay_set"; //上传文件路径

$destination_cert = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!is_uploaded_file($_FILES["apiclient_cert_path"]["tmp_name"]))
    //是否存在文件
    {
        $destination_cert = $_POST["apiclient_cert_path_v"];
    } else {
        $file = $_FILES["apiclient_cert_path"];
        if ($max_file_size < $file["size"])
        //检查文件大小
        {
            echo "<font color='red'>文件太大！</font>";
            exit;
        }
        $filetype = $file["type"];
        if ($filetype != "﻿application/octet-stream") {
            //echo "<font color='red'>不能上传此类型文件！</font>";
            // exit;
        }

        if (!file_exists($destination_folder)) {
            mkdir($destination_folder, 0777, true);
        }

        $destination_folder = $destination_folder . "/";

        if (!file_exists($destination_folder)) {
            mkdir($destination_folder, 0777, true);
        }

        $filename = $file["tmp_name"];
        $pinfo    = pathinfo($file["name"]);
        $ftype    = $pinfo["extension"];

        if ($ftype != "pem") {
            echo "<font color='red'>不能上传此类型文件！</font>";
            exit;
        }
        $destination_cert = $destination_folder . time() . "." . $ftype;
        $overwrite        = true;
        if (file_exists($destination_cert) && $overwrite != true) {
            echo "<font color='red'>同名文件已经存在了！</a>";
            exit;
        }
        if (!_move_uploaded_file($filename, $destination_cert)) {
            echo "<font color='red'>移动文件出错！</a>";
            exit;
        }

        $destination_cert = str_replace("../", "", $destination_cert);
        $destination_cert = "/weixinpl/" . $destination_cert;
    }
}

$destination_key = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!is_uploaded_file($_FILES["apiclient_key_path"]["tmp_name"]))
    //是否存在文件
    {
        $destination_key = $_POST["apiclient_key_path_v"];
    } else {
        $file = $_FILES["apiclient_key_path"];
        if ($max_file_size < $file["size"])
        //检查文件大小
        {
            echo "<font color='red'>文件太大！</font>";
            exit;
        }
        $filetype = $file["type"];
        if ($filetype != "﻿application/octet-stream") {
            //echo "<font color='red'>不能上传此类型文件！</font>";
            // exit;
        }

        if (!file_exists($destination_folder)) {
            mkdir($destination_folder, 0777, true);
        }

        $destination_folder = $destination_folder . $customer_id . "/";

        if (!file_exists($destination_folder)) {
            mkdir($destination_folder, 0777, true);
        }

        $filename = $file["tmp_name"];
        $pinfo    = pathinfo($file["name"]);
        $ftype    = $pinfo["extension"];
        if ($ftype != "pem") {
            echo "<font color='red'>不能上传此类型文件！</font>";
            exit;
        }
        $destination_key = $destination_folder . time() . "." . $ftype;
        $overwrite       = true;
        if (file_exists($destination_key) && $overwrite != true) {
            echo "<font color='red'>同名文件已经存在了！</a>";
            exit;
        }
        if (!_move_uploaded_file($filename, $destination_key)) {
            echo "<font color='red'>移动文件出错！</a>";
            exit;
        }

        $destination_key = str_replace("../", "", $destination_key);
        $destination_key = "/weixinpl/" . $destination_key;
    }

}

if ($blueoceanpay_id > 0) {
    $sql = "update 
                pay_config 
            set 
                apiclient_cert_path='" . $destination_cert . "',
                apiclient_key_path='" . $destination_key . "',
                version=" . $version . ",
                appid='" . $appid . "',
                appsecret='" . $appsecret . "',
                paysignkey='" . $paysignkey . "',
                partnerid='" . $partnerid . "',
                partnerkey='" . $partnerkey . "',
                sub_mch_id='" . $sub_mch_id . "',
                fee_type='" . $fee_type . "',
                pay_type='" . $pay_type . "',
                title='" . $title . "',
                px='" . $px . "',
                icon='" . $icon . "',
                description='" . $description . "' ,
                attach='" . $attach . "' 
            where 
                id=" . $blueoceanpay_id;
} else {
    if ($title == "") {
        $title = "蓝海支付";
    }
    $sql = "insert into 
                pay_config(
                    version,
                    appid,
                    appsecret,
                    paysignkey,
                    partnerid,
                    partnerkey,
                    customer_id,
                    isvalid,
                    createtime,
                    apiclient_cert_path,
                    apiclient_key_path,
                    sub_mch_id,
                    fee_type,
                    pay_type,
                    title,
                    description,
                    icon,
                    px,
                    attach
                )
                values(
                    " . $version . ",
                    '" . $appid . "',
                    '" . $appsecret . "',
                    '" . $paysignkey . "',
                    '" . $partnerid . "',
                    '" . $partnerkey . "',
                    " . $customer_id . ",
                    true,
                    now(),
                    '" . $destination_cert . "',
                    '" . $destination_key . "',
                    '" . $sub_mch_id . "',
                    '" . $fee_type . "',
                    '" . $pay_type . "',
                    '" . $title . "',
                    '" . $description . "',
                    '" . $icon . "',
                    '" . $px . "',
                    '" . $attach . "'
                )";
}

$result = _mysql_query($sql) or die('Query failed: ' . mysql_error());
$error = mysql_error();
mysql_close($link);

echo "<script>location.href='blueoceanpay_set.php?customer_id=" . $customer_id_en . "';</script>"
?>
