<?php 
if($shop_level == 1){ ?>
	<!-- /weixinpl/config.php定义了shop_level 商城等级 1：默认高级微商城 2：精简微商城  -->
	
	<div class="WSY_column_header">
		<div class="WSY_columnnav">
			<a href="base_set.php?customer_id=<?php echo $customer_id_en; ?>">基础设置</a>
			<a href="weixinpay_set.php?customer_id=<?php echo $customer_id_en; ?>">微信支付</a>
			<a href="alipay_set.php?customer_id=<?php echo $customer_id_en; ?>">支付宝</a>
			<a href="jdpay_set.php?customer_id=<?php echo $customer_id_en; ?>">京东支付</a>
			<a href="yeepay_set.php?customer_id=<?php echo $customer_id_en; ?>">易宝支付</a>
			<a href="paypal_set.php?customer_id=<?php echo $customer_id_en; ?>">PayPal支付</a>
			<a href="xingyebankpay_set.php?customer_id=<?php echo $customer_id_en; ?>">兴业银行支付</a>
			<a href="vlifepay_set.php?customer_id=<?php echo $customer_id_en; ?>">V咖支付</a>        
			<a href="cardpay_set.php?customer_id=<?php echo $customer_id_en; ?>">会员卡余额支付</a>
			<a href="moneybag_set.php?customer_id=<?php echo $customer_id_en; ?>">零钱支付</a>
			<a href="anotherpay_set.php?customer_id=<?php echo $customer_id_en; ?>">找人代付</a>
			<a href="nopay_set.php?customer_id=<?php echo $customer_id_en; ?>">提单不支付</a>
			<a href="hxpay_set.php?customer_id=<?php echo $customer_id_en; ?>">环迅支付</a>
			<a href="wftpay_set.php?customer_id=<?php echo $customer_id_en; ?>">威富通支付</a>
			<a href="healthpay_set.php?customer_id=<?php echo $customer_id_en; ?>">健康钱包</a>
			<a href="blueoceanpay_set.php?customer_id=<?php echo $customer_id_en; ?>">蓝海支付</a>
		</div>
	</div>
	<script>
	var head = <?php echo $head + 1; ?>;
	$(".WSY_columnnav").find("a").eq(head).addClass('white1');
	</script>
	
<?php }else if($shop_level == 2){ ?>
	<!-- /weixinpl/config.php定义了shop_level 商城等级 1：默认高级微商城 2：精简微商城  -->
	
	<div class="WSY_column_header">
		<div class="WSY_columnnav">
			<a href="weixinpay_set.php?customer_id=<?php echo $customer_id_en; ?>">微信支付</a>
		</div>
	</div>
	<script>
	var head = <?php echo $head; ?>;
	$(".WSY_columnnav").find("a").eq(head).addClass('white1');
	</script>
	
<?php } ?>