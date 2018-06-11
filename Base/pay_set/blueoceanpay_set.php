<?php
header("Content-type: text/html; charset=utf-8");
require_once '../../config.php';
require_once '../../customer_id_decrypt.php'; //导入文件,获取customer_id_en[加密的customer_id]以及customer_id[已解密]
require_once '../../back_init.php';
$link = mysql_connect(DB_HOST, DB_USER, DB_PWD);
mysql_select_db(DB_NAME) or die('Could not select database11');
_mysql_query("SET NAMES UTF8");
require_once '../../proxy_info.php';
require_once '../../common/common_ext.php';
require_once 'pay_config.class.php';
$new_baseurl = $http_host;
$head        = 14; // 选项卡切换，样式。

$INDEX      = i2get("INDEX", 0);
$pay_config = new pay_config();
$sqlre      = $pay_config->get_blueoceanpay_config($customer_id);
session_start();
$_SESSION['wxappsecret']  = $sqlre['appsecret'];
$_SESSION['wxpaysignkey'] = $sqlre['paysignkey'];

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../common/css_V6.0/content.css">
<link rel="stylesheet" type="text/css" href="../../common/css_V6.0/content<?php echo $theme; ?>.css">
<link rel="stylesheet" type="text/css" href="../common/css/pay_set/weixin_set.css">
<script type="text/javascript" src="../../common/js/jquery-2.1.0.min.js"></script>


<title>蓝海支付</title>

<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<style>
.WSY_commonbox02{border:solid 1px #ccc;}
</style>
</head>
<body>
	<!--内容框架开始-->
	<div class="WSY_content">

		<!--列表内容大框开始-->
		<div class="WSY_columnbox">
			<!--列表头部切换开始-->
			<?php include "pay_head.php";?>
			<!--列表头部切换结束-->

        <!--支付设置代码开始-->
			<div class="WSY_data">
                <!--列表按钮开始-->
                <div class="WSY_list">
                    <li class="WSY_left"><a>蓝海支付设置</a></li>
                </div>
                <!--列表按钮结束-->
				<form action="save_blueoceanpay_set.php?customer_id=<?php echo $customer_id_en; ?>" enctype="multipart/form-data" method="post" id="upform" name="upform">
				<input type=hidden name="blueoceanpay_id" id="weixinpay_id" value="<?php echo $sqlre['blueoceanpay_id']; ?>" />


					<div class="WSY_commonbox01">
						<li>
							<span>APPID：</span>
							<input class="text_input" type="text" name="appid" value="<?php echo $sqlre['appid']; ?>">
						</li>
						<li>
							<span>AppSecret：</span>
							<input class="text_input" id="appsecret" type="text" name="appsecret" value="<?php if (!empty($sqlre['appsecret'])) {echo substr_replace($sqlre['appsecret'], "*********************", 2, 20);}?>">
						</li>
						<li>
							<span>Store ID：</span>
							<input  class="text_input" type="text" name="sub_mch_id" value="<?php echo $sqlre['sub_mch_id']; ?>">
							<a class="WSY_red">(关联门店 ID，没有门店可不填写)</a>
						</li>
                        <li>
                            <span>显示名称(Title)：</span>
                            <input  class="text_input" type="text" name="title" value="<?php echo $sqlre['title']; ?>" maxlength="12" placeholder="字数不多于12个字">
                        </li>
                        <li>
                            <span>显示顺序(PaiXu)：</span>
                            <input  class="text_input" type="text" placeholder="在前端选择支付方式时的显示顺序" name="px" value="<?php echo $sqlre['px']; ?> ">
                        </li>
						<li>
							<span>标价币种(FeeType)：</span>
							<input  class="text_input" type="text" name="fee_type" value="<?php echo $sqlre['fee_type']; ?>">
							<a class="WSY_red">(非境外服务商请勿填写)</a>
						</li>
                        <li>
                            <span>默认图标(Icon)：</span>
                            <img id="def_icon" src="<?php if ($sqlre['icon'] != "") {echo $sqlre['icon'];} else {echo "请选择文件...";}?>" style="width: 42px;height: 42px"/>
                            <div class="uploader white" id="WSY_commondiv">
                                <input type="text" class="filename"  value="<?php if ($sqlre['icon'] != "") {echo $sqlre['icon'];} else {echo "请选择文件...";}?>" readonly style="width: 120px;height: 30px;"/>
                                <input type="button" name="file" class="button" value="上传..." style="width: 60px;height: 30px"/>
                                <input type="file" class="fra_image_select" name="Filedata" onchange="fileSelect_banner(this)" style="width: 150px;"/>
                                <input type=hidden name="icon" value="<?php echo $sqlre['icon']; ?>" />
                            </div>
                            <a class="WSY_red WSY_photo_tips" style="font-size: 14px;margin-left:154px;">建议上传尺寸：42px*42px；图片格式：JPG、PNG；图片大小：5M以内</a>
                        </li>
                        <li>
                            <span>描述(Description)：</span>
                            <input class="text_input" type="text" name="description" id="description" value="<?php $sqlre['description'];?>" maxlength="20" placeholder="字数不多于20个字">
                        </li>

                    </div>

					<div  class="WSY_commonbox02" id="div_refund">

						<div class="WSY_common02">
							<a>退款需要以下证书</a><!--每个设置项标题-->
						</div>
						<ul class="WSY_commonbox">
							<li>apiclient_cert.pem</li>
							<!--上传文件代码开始-->
								<div class="uploader white" id="WSY_commondiv">
									<input type="text" class="filename"  value="<?php if ($sqlre['apiclient_cert_path'] != "") {echo $sqlre['apiclient_cert_path'];} else {echo "请选择文件...";}?>" readonly/>
									<input type="button" name="file" class="button" value="上传..."/>
									<input type="file" name="apiclient_cert_path" size="30"/>
									<input type=hidden name="apiclient_cert_path_v" value="<?php echo $sqlre['apiclient_cert_path']; ?>" />
								</div>
								<!--上传文件代码结束-->
							<span><?php echo $sqlre['apiclient_cert_path']; ?></span>
						</ul>
						<ul class="WSY_commonbox">
							<li>apiclient_key.pem</li>
							<!--上传文件代码开始-->
								<div class="uploader white" id="WSY_commondiv">
									<input type="text" class="filename"  value="<?php if ($sqlre['apiclient_key_path'] != "") {echo $sqlre['apiclient_key_path'];} else {echo "请选择文件...";}?>" readonly/>
									<input type="button" name="file" class="button" value="上传..."/>
									<input type="file" name="apiclient_key_path" size="30"/>
									<input type=hidden name="apiclient_key_path_v" value="<?php echo $sqlre['apiclient_key_path']; ?>" />
								</div>
							<span><?php echo $sqlre['apiclient_key_path']; ?></span>
						</ul>
					</div>
				</form>
                <div class="WSY_text_input" id="WSY_text_input"><button onclick="submitV(this);" class="WSY_button">提交</button><br class="WSY_clearfloat"></div>
			</div>
        <!--微信支付设置代码结束-->
		</div>
	</div>
<script type="text/javascript" src="../../common/js_V6.0/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../common/js_V6.0/content.js"></script>
<script type="text/javascript" src="../common/js/pay_set/weixin_set.js"></script>
<script type="text/javascript" src="../common/js/pay_set/uploadImg.js"></script>
<script>
selPayType(<?php echo $sqlre['version']; ?>);
document.getElementById('description').value = '<?php echo $sqlre['description'] ?>';//显示描述的内容

</script>
</body>
</html>
