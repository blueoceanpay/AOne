## A One system 添加 BlueCoean 支付方式

***
A One System 可能会不定期更新，在更新之后，第三方添加的支付方式可能会失效，变得不可用。在系统更新之后，再参考以下步骤，恢复代码即可。

以下涉及到修改的文件，系统更新若无修改，可直接替换，操作前注意做好备份。
***

### 后台：

1. 新增
<br />
`/weixinpl/Base/pay_set/blueoceanpay_set.php` 　      支付方式配置表单文件。配置合适的 head 值（顺序排列），不能与其它支付方式有冲突，此为 `Tab` 菜单切换之用。
`/weixinpl/Base/pay_set/save_blueoceanpay_set.php`　处理保存支付配置信息到数据库。
`/weixinpl/Base/common/images/pay_set/blueoceanpay_128.png`　支付方式默认图标。

2. 修改
<br />
`/weixinpl/Base/pay_set/pay_type_config.php`　　 添加支付方式类型配置
`/weixinpl/Base/pay_set/pay_config.class.php`　　 添加从数据库获取支付配置方法。
`/weixinpl/Base/pay_set/pay_head.php`　                添加支付配置菜链接（ tab 选项卡）
`/weixin/plat/app/Tpl/IndexV2/managerV2.html`    　修改菜单为，默认首选打开支付方式（可选）

### 前台：

1. 新增
<br/>
`/weixinpl/mshop/blueoceanpay/blueoceanpay.php`    调起支付，完成支付动作。
`/weixinpl/mshop/blueoceanpay/blueoceanpay_notify.php`   支付成功通知，修改订单状态为已支付。

2. 修改
<br />
`/weixinpl/mshop/choose_paytype.php`     修改 `StartPay`  js 方法，添加相关支付方式分支选择。


完成支付方式添加！

***

### 其它：

* 打开或关闭 `phpmyadmin` 访问数据库

	修改配置文件

	`/opt/lampp/etc/extra/httpd-xampp.conf`　

	<br/>
	重启 httpd

	`/opt/lampp/bin/apachectl restart`


* 更改发送通知邮件地址

	订单通知邮件发送，配置文件。修改配置后，需手动删除缓存文件。
	
	`vim weixin/plat/app/Conf/config.php`
	
	
	缓存文件，需手动删除
	
	`rm -rf weixin/plat/app/Runtime/～runtime.php`



