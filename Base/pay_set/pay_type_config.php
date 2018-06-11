<?php
/**
 * 和支付方式相关的配置文件
 * User: zhaojing
 * Date: 17/2/8
 * Time: 下午3:26.
 */
class pay_type_config
{
    /**
     * 支付方式数组.
     */
    public $pay_types = array(
        'blueoceanpay'  => array(
            'name'            => '蓝海支付',
            'show_name'       => '蓝海支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/wechat_pay.jpg',
            'pay_url'         => array(
                'common' => '/weixinpl/mshop/blueoceanpay/blueoceanpay.php',
            ),
            'notify_url'      => array(),
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/blueoceanpay_set.php', //支付配置界面路径
            'is_public'       => true, //是否为公用支付的方式
        ),

        'card'          => array(
            'name'            => '会员卡余额支付', //支付方式名
            'show_name'       => '会员卡余额支付', //默认显示名称
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-2.png', //默认图标名
            'pay_url'         => array('key' => 'url'), //发起支付页面
            'notify_url'      => array('key' => 'url'), //回调页面路径
            'is_check'        => 1, //是否需要校验支付密码
            'is_check_config' => 0, //是否需要校验配置
            'is_public'       => true, //是否为公用支付的方式
        ),

        'moneybag'      => array(
            'name'            => '零钱支付',
            'show_name'       => '零钱支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-3.png',
            'pay_url'         => '支付页面路径',
            'notify_url'      => '回调路径',
            'is_check'        => 1,
            'is_check_config' => 0, //是否需要校验配置
            'is_public'       => true, //是否为公用支付的方式
        ),

        'anotherpay'    => array(
            'name'            => '找人代付',
            'show_name'       => '找人代付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-6.png',
            'pay_url'         => '支付页面路径',
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 0, //是否需要校验配置
            'is_public'       => true, //是否为公用支付的方式
        ),

        'nopay'         => array(
            'name'            => '提单不支付',
            'show_name'       => '提单不支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/pay_no.png',
            'pay_url'         => '支付页面路径',
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 0, //是否需要校验配置
            'is_public'       => true, //是否为公用支付的方式
        ),

        'weipay'        => array(
            'name'            => '微信支付',
            'show_name'       => '微信支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-1.png',
            'pay_url'         => array('common' => '/weixinpl/mshop/WeChatPay/weipay_new.php', 'h5' => '/weixinpl/mshop/H5Pay/jsapi.php'),
            'notify_url'      => array(),
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/weixinpay_set.php', //支付配置界面路径
            'is_public'       => true, //是否为公用支付的方式
        ),

        'alipay'        => array(
            'name'            => '支付宝支付',
            'show_name'       => '支付宝支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-4.png',
            'pay_url'         => array('h5' => '/weixinpl/mshop/alipay/alipayapi_new.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/alipay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'yeepay'        => array(
            'name'            => '易宝支付',
            'show_name'       => '易宝支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-9.png',
            'pay_url'         => array('h5' => '/weixinpl/yeepay/ydsytYeepay/sendRequest.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/yeepay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'paypal'        => array(
            'name'            => 'paypal支付',
            'show_name'       => 'paypal支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-7.png',
            'pay_url'         => array('common' => '/weixinpl/common_shop/jiushop/paypal_new.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/paypal_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'jdpay'         => array(
            'name'            => '京东支付',
            'show_name'       => '京东支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-10.png',
            'pay_url'         => array('common' => '/weixinpl/jdpay_new/action/ClientOrder_new.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/jdpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),
        'xingyebankpay' => array(
            'name'            => '兴业银行公众号支付',
            'show_name'       => '兴业银行支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/ybimg.png',
            'pay_url'         => array('common' => '/weixinpl/mshop/WeChatPay/xypay.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/xingyebankpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),
        'wftpay'        => array(
            'name'            => '威富通支付',
            'show_name'       => '威富通支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/wftpay.png',
            'pay_url'         => array('common' => '/weixinpl/wftpay_wx/weixinpay.php', 'h5' => '/weixinpl/wftpay_alipay/alipay.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/wftpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),
        'vlifepay'      => array(
            'name'            => 'V咖支付',
            'show_name'       => 'V咖支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-11.png',
            'pay_url'         => array('common' => '/weixinpl/Vlifepay/vlife_login.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/vlifepay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'IPSpay'        => array(
            'name'            => '环迅快捷支付',
            'show_name'       => '环迅快捷支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/icon-hxzf.png',
            'pay_url'         => array('common' => '/weixinpl/IPSpay/hxpay.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/hxpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'IPSweipay'     => array(
            'name'            => '环迅微信支付',
            'show_name'       => '环迅微信支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/icon-hxwxzf.png',
            'pay_url'         => array('common' => '/weixinpl/IPSpay/IPSweipay.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/hxpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'healthpay'     => array(
            'name'            => '健康钱包支付',
            'show_name'       => '健康钱包支付',
            'icon'            => '/weixinpl/Base/common/images/pay_set/np-3.png',
            'pay_url'         => array('common' => '/weixinpl/healthpay/login.php'),
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 1, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/healthpay_set.php',
            'is_public'       => true, //是否为公用支付的方式
        ),

        'virtual'       => array(
            'name'            => '虚拟库存支付',
            'show_name'       => '虚拟库存支付',
            'icon'            => '/addons/view/ordering_retail/common/images_orange/zhifu.png',
            'pay_url'         => '支付页面路径',
            'notify_url'      => '回调路径',
            'is_check'        => 0,
            'is_check_config' => 0, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/healthpay_set.php',
            'is_public'       => false,
        ),

        'account'       => array(
            'name'            => '货款支付',
            'show_name'       => '货款支付',
            'icon'            => '/addons/view/ordering_retail/common/images_orange/yue.png',
            'pay_url'         => '支付页面路径',
            'notify_url'      => '回调路径',
            'is_check'        => 1,
            'is_check_config' => 0, //是否需要校验配置
            'conf_url'        => 'Base/pay_set/healthpay_set.php',
            'is_public'       => false,
        ),
    );

    /**
     * 支付客户端.
     */
    public $pay_clients = array(
        'wx'  => '微信',
        'pc'  => 'PC',
        'h5'  => 'H5',
        'app' => 'APP',
    );

    /**
     * 客户端对应的支付方式.
     */
    public $pay_type_client = array(
        'blueoceanpay'  => array('wx', 'pc', 'h5', 'app'),
        'card'          => array('wx', 'pc', 'h5', 'app'),
        'moneybag'      => array('wx', 'pc', 'h5', 'app'),
        'anotherpay'    => array('wx', 'h5', 'app'),
        'nopay'         => array('wx', 'pc', 'h5', 'app'),
        'weipay'        => array('wx', 'pc', 'h5', 'app'),
        'alipay'        => array('pc', 'h5', 'app'),
        'yeepay'        => array('wx', 'pc', 'h5', 'app'),
        'paypal'        => array('wx', 'pc', 'h5', 'app'),
        'jdpay'         => array('wx', 'h5', 'app'),
        'xingyebankpay' => array('wx'),
        'vlifepay'      => array('wx', 'pc', 'h5', 'app'),
        'IPSpay'        => array('wx', 'pc', 'h5', 'app'),
        'wftpay'        => array('wx', 'h5', 'app'),
        'IPSweipay'     => array('wx'),
        'healthpay'     => array('wx', 'h5', 'app'),
    );

    /**
     * 每个行业可以允许开启的支付方式.
     */
    public $pay_type_industry = array(
        'shop'            => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'anotherpay',
            'nopay',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
            'IPSpay',
            'IPSweipay',
            'wftpay',
            'healthpay',
        ),

        'cashier_system'  => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'cashier_o2o'     => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'nopay',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'delicacy'        => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'ktv'             => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'hotel'           => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'line_mall'       => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
        ),
        'gift_packs'      => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
            'IPSpay',
            'IPSweipay',
            'wftpay',
        ),
        'micro_broadcast' => array(
            'blueoceanpay',
            'moneybag',
            'weipay',
        ),
        'cityarea'        => array(
            'blueoceanpay',
            'card',
            'moneybag',
            'nopay',
            'weipay',
            'alipay',
            'yeepay',
            'paypal',
            'jdpay',
            'xingyebankpay',
            'vlifepay',
            'IPSpay',
            'IPSweipay',
        ),
        'orderingretail'  => array(
            'blueoceanpay',
            'moneybag',
            'nopay',
            'weipay',
            'alipay',
        ),
        'yiren'           => array(
            'blueoceanpay',
            'moneybag',
            'weipay',
            'alipay',
        ),
        'travel_card'     => array(
            'blueoceanpay',
            'moneybag',
            'weipay',
            'alipay',
            'card',
        ),
    );
}
