<?php
/**
 * Created by PhpStorm.
 * User: zhaojing
 * Date: 17/2/9
 * Time: 上午10:49
 */
include_once "pay_type_config.php";
class pay_config
{

    private $pay_types;

    public function __construct()
    {
        $pay_type_config = new pay_type_config();
        $this->pay_types = $pay_type_config->pay_types;
    }

    // 获取蓝海支付配置信息
    public function get_blueoceanpay_config($customer_id)
    {

        $pay_type = "blueoceanpay";
        $query    = "select
                        id,
                        appid,
                        appsecret,
                        apiclient_cert_path,
                        apiclient_key_path,
                        paysignkey,
                        partnerid,
                        version,
                        partnerkey,
                        title,
                        px,
                        icon,
                        description,
                        sub_mch_id,
                        fee_type,
                        attach
                    from
                        pay_config
                    where
                        customer_id='" . $customer_id . "'
                    and
                        pay_type='" . $pay_type . "'
                    and
                        isvalid=true limit 1";

        $result = _mysql_query($query) or die('Query failed: ' . mysql_error());
        $sqlre  = array(
            'blueoceanpay_id'     => -1, //支付信息ID
            'appid'               => "",
            'appsecret'           => "",
            'paysignkey'          => "",
            'partnerid'           => "",
            'partnerkey'          => "",
            'version'             => 1,
            'apiclient_cert_path' => "",
            'apiclient_key_path'  => "",
            'fee_type'            => "",
            'sub_mch_id'          => "",
            'attach'              => "",
            'title'               => $this->pay_types["blueoceanpay"]["show_name"], //显示名字
            'px'                  => "", //显示顺序
            'icon'                => $this->pay_types["blueoceanpay"]["icon"], //默认图标
            'description'         => "", //描述
        );

        while ($row = mysql_fetch_object($result)) {
            $sqlre['blueoceanpay_id']     = $row->id;
            $sqlre['appid']               = $row->appid;
            $sqlre['appsecret']           = $row->appsecret;
            $sqlre['paysignkey']          = $row->paysignkey;
            $sqlre['partnerid']           = $row->partnerid;
            $sqlre['partnerkey']          = $row->partnerkey;
            $sqlre['version']             = $row->version;
            $sqlre['apiclient_cert_path'] = $row->apiclient_cert_path;
            $sqlre['apiclient_key_path']  = $row->apiclient_key_path;
            $sqlre['fee_type']            = $row->fee_type;
            $sqlre['sub_mch_id']          = $row->sub_mch_id;
            $sqlre['attach']              = $row->attach;
            $sqlre['px']                  = $row->px;
            $sqlre['description']         = $row->description;
            $sqlre['title']               = $row->title;

            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;
    }

    /**查询微信支付的配置
     * @param $customer_id
     * @return array
     */
    public function get_weixinpay_config($customer_id)
    {

        $pay_type = "weipay";
        $query    = "select id,appid,appsecret,apiclient_cert_path,apiclient_key_path,paysignkey,partnerid,version,partnerkey,title,px,icon,description,sub_mch_id,fee_type,attach  from pay_config where customer_id='" . $customer_id . "'and pay_type='" . $pay_type . "' and isvalid=true limit 1";
//echo $query;
        $result = _mysql_query($query) or die('Query failed: ' . mysql_error());
        $sqlre  = array(
            'weixinpay_id'        => -1, //微信支付信息ID
            'appid'               => "",
            'appsecret'           => "",
            'paysignkey'          => "",
            'partnerid'           => "",
            'partnerkey'          => "",
            'version'             => 1, //接口版本
            'apiclient_cert_path' => "", //退款和红包证书id
            'apiclient_key_path'  => "", //退款和红包证书key
            'fee_type'            => "", //货币种类(境外服务商)
            'sub_mch_id'          => "", //子商户号(境外服务商)
            'attach'              => "", //门店授权码(境外服务商)

            'title'               => $this->pay_types["weipay"]["show_name"], //显示名字
            'px'                  => "", //显示顺序
            'icon'                => $this->pay_types["weipay"]["icon"], //默认图标
            'description'         => "", //描述
        );

        while ($row = mysql_fetch_object($result)) {
            $sqlre['weixinpay_id']        = $row->id;
            $sqlre['appid']               = $row->appid;
            $sqlre['appsecret']           = $row->appsecret;
            $sqlre['paysignkey']          = $row->paysignkey;
            $sqlre['partnerid']           = $row->partnerid;
            $sqlre['partnerkey']          = $row->partnerkey;
            $sqlre['version']             = $row->version;
            $sqlre['apiclient_cert_path'] = $row->apiclient_cert_path;
            $sqlre['apiclient_key_path']  = $row->apiclient_key_path;
            $sqlre['fee_type']            = $row->fee_type;
            $sqlre['sub_mch_id']          = $row->sub_mch_id;
            $sqlre['attach']              = $row->attach;
            $sqlre['px']                  = $row->px;
            $sqlre['description']         = $row->description;
            //  if($row->title != null){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;
    }

    /**
     * 获取支付宝相关配置
     * @param $customer_id
     */
    public function get_alipay_config($customer_id)
    {
        $pay_type = "alipay";
        $query    = "SELECT id,appid,appsecret,paysignkey,title,px,icon,description,public_key,private_key,alipay_appid From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'alipay_id'    => -1,
            'account'      => '', //支付宝账号
            'pid'          => '', //支付宝PID
            'akey'         => '', //支付宝KEY
            'title'        => $this->pay_types["alipay"]["show_name"], //显示名字
            'px'           => "", //显示顺序
            'icon'         => $this->pay_types["alipay"]["icon"], //默认图标
            'description'  => "", //描述
            'public_key'   => '', //RSA2公钥
            'private_key'  => '', //RSA2私钥
            'alipay_appid' => '', //支付宝应用ID
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['alipay_id']    = $row->id;
            $sqlre['account']      = $row->appid;
            $sqlre['pid']          = $row->appsecret;
            $sqlre['akey']         = $row->paysignkey;
            $sqlre['px']           = $row->px;
            $sqlre['description']  = $row->description;
            $sqlre['public_key']   = $row->public_key;
            $sqlre['private_key']  = $row->private_key;
            $sqlre['alipay_appid'] = $row->alipay_appid;
            // if($row->title != null){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }

            break;
        }
        return $sqlre;
    }

    /**
     * 获取京东支付配置
     * @param $customer_id
     * @return array
     */
    public function get_jdpay_config($customer_id)
    {
        $pay_type = "jdpay";
        $query    = "SELECT id,appid,appsecret,title,px,icon,description,apiclient_cert_path,apiclient_key_path From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'jdpay_id'             => '', //在表中的id
            'jdpay_customernumber' => '', //商户号
            'jdpay_secret'         => '', //密钥
            'private_pem'          => '', //私钥证书
            'public_pem'           => '', //公钥证书
            'title'                => $this->pay_types["jdpay"]["show_name"], //显示名字
            'px'                   => "", //显示顺序
            'icon'                 => $this->pay_types["jdpay"]["icon"], //默认图标
            'description'          => "", //描述

        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['jdpay_id']             = $row->id;
            $sqlre['jdpay_customernumber'] = $row->appid;
            $sqlre['jdpay_secret']         = $row->appsecret;
            $sqlre['private_pem']          = $row->apiclient_cert_path;
            $sqlre['public_pem']           = $row->apiclient_key_path;
            $sqlre['px']                   = $row->px;
            $sqlre['description']          = $row->description;

            //if($row->title != null){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }

            break;
        }

        return $sqlre;
    }

    /**
     * 获取易宝支付的配置
     * @param $customer_id
     * @return array
     */
    public function get_yepay_config($customer_id)
    {
        $pay_type = "yeepay";
        $query    = "SELECT id,appid,appsecret,paysignkey,partnerkey,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'yeepay_id'             => '', //在表中的id
            'yeepay_customernumber' => '', //商户编号
            'yeepay_secret'         => '', //商户公钥
            'paysignkey'            => '', //商户私钥
            'partnerkey'            => '', //易宝公钥
            'title'                 => $this->pay_types["yeepay"]["show_name"], //显示名字
            'px'                    => "", //显示顺序
            'icon'                  => $this->pay_types["yeepay"]["icon"], //默认图标
            'description'           => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['yeepay_id']             = $row->id;
            $sqlre['yeepay_customernumber'] = $row->appid;
            $sqlre['yeepay_secret']         = $row->appsecret;
            $sqlre['paysignkey']            = $row->paysignkey;
            $sqlre['partnerkey']            = $row->partnerkey;
            $sqlre['px']                    = $row->px;
            $sqlre['description']           = $row->description;
            // if($row->title != null){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;

    }

    /**
     * 获PayPal的配置
     * @param $customer_id
     * @return array
     */
    public function get_paypal_config($customer_id)
    {
        $pay_type = "paypal";
        $query    = "SELECT id,appid,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'paypal_id'   => '', //在表中的id
            'paypal_mail' => '', //paypal 账户
            'title'       => $this->pay_types["paypal"]["show_name"], //显示名字
            'px'          => "", //显示顺序
            'icon'        => $this->pay_types["paypal"]["icon"], //默认图标
            'description' => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['paypal_id']   = $row->id;
            $sqlre['paypal_mail'] = $row->appid;
            $sqlre['px']          = $row->px;
            $sqlre['description'] = $row->description;

            //if ($row->title){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;

    }

    /**
     * 获取会员卡余额支付、零钱支付、找人代付、提单不支付配置的公用方法
     * @param $customer_id
     * @return array
     */
    public function get_commonpay_config($customer_id, $pay_type)
    {

        $query  = "SELECT id,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre  = array(
            'pay_id'      => '', //在表中的id
            'title'       => $this->pay_types[$pay_type]["show_name"], //显示名字
            'px'          => "", //显示顺序
            'icon'        => $this->pay_types[$pay_type]["icon"], //默认图标
            'description' => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['pay_id']      = $row->id;
            $sqlre['px']          = $row->px;
            $sqlre['description'] = $row->description;

            //if ($row->title != null){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;

    }

    /**
     * 获取兴业银行支付配置
     */
    public function get_xingyebankpay_config($customer_id)
    {

        $pay_type = "xingyebankpay";
        $query    = "SELECT id,appid,appsecret,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'xingye_id'      => -1,
            'xingye_account' => '', //商户号
            'xingye_secret'  => '', //商户密钥
            'title'          => $this->pay_types["xingyebankpay"]["show_name"], //显示名字
            'px'             => "", //显示顺序
            'icon'           => $this->pay_types["xingyebankpay"]["icon"], //默认图标
            'description'    => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['xingye_id']      = $row->id;
            $sqlre['xingye_account'] = $row->appid;
            $sqlre['xingye_secret']  = $row->appsecret;
            $sqlre['px']             = $row->px;
            $sqlre['description']    = $row->description;
            $sqlre['title']          = $row->title;

            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }

            break;
        }
        return $sqlre;

    }

    /**
     * 获取威富通支付的配置
     * @param $customer_id
     * @return array
     */
    public function get_wftpay_config($customer_id)
    {

        $pay_type = "wftpay";
        $query    = "SELECT id,appid,appsecret,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'wft_id'      => -1,
            'wft_account' => '', //商户号
            'wft_secret'  => '', //商户密钥
            'title'       => $this->pay_types["wftpay"]["show_name"], //显示名字
            'px'          => "", //显示顺序
            'icon'        => $this->pay_types["wftpay"]["icon"], //默认图标
            'description' => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['wft_id']      = $row->id;
            $sqlre['wft_account'] = $row->appid;
            $sqlre['wft_secret']  = $row->appsecret;
            $sqlre['px']          = $row->px;
            $sqlre['description'] = $row->description;
            $sqlre['title']       = $row->title;

            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }

            break;
        }
        return $sqlre;

    }

    /**
     * 获V咖支付的配置
     * @param $customer_id
     * @return array
     */
    public function get_vlifepay_config($customer_id)
    {
        $pay_type = "vlifepay";
        $query    = "SELECT id,appid,partnerid,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'vlifepay_id'      => '', //在表中的id
            'vlifepay_account' => '', //v咖 账户
            'vlifepay_store'   => '', //v咖门店账号
            'title'            => $this->pay_types["vlifepay"]["show_name"], //显示名字
            'px'               => "", //显示顺序
            'icon'             => $this->pay_types["vlifepay"]["icon"], //默认图标
            'description'      => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['vlifepay_id']      = $row->id;
            $sqlre['vlifepay_account'] = $row->appid;
            $sqlre['vlifepay_store']   = $row->partnerid;
            $sqlre['px']               = $row->px;
            $sqlre['description']      = $row->description;

            //if ($row->title){
            $sqlre['title'] = $row->title;
            //}
            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }
            break;
        }

        return $sqlre;

    }

    /**
     * 环迅支付(包括环迅微信支付和快捷支付)的配置
     * @param $customer_id
     * @return array
     */
    public function get_hxpay_config($customer_id)
    {
        //环迅快捷支付
        $pay_type = "IPSpay";
        $query    = "SELECT id,appid,appsecret,partnerid,partnerkey,paysignkey,title,px,icon,description,gathering From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'hxpay_id'             => '', //在表中的id
            'wxpay_id'             => '', //在表中的id
            'hxpay_customernumber' => '', //商户号
            'hxpay_account'        => '', //交易账户
            'hxpay_secret'         => '', //密钥
            'hxpay_vector'         => '', //向量
            'hxpay_signsecret'     => '', //签名密钥

            'hx_title'             => $this->pay_types["IPSpay"]["show_name"], //显示名字
            'hx_px'                => "", //显示顺序
            'hx_icon'              => $this->pay_types["IPSpay"]["icon"], //默认图标
            'hx_description'       => "", //描述
            'wx_title'             => $this->pay_types["IPSweipay"]["show_name"], //显示名字
            'wx_px'                => "", //显示顺序
            'wx_icon'              => $this->pay_types["IPSweipay"]["icon"], //默认图标
            'wx_description'       => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['hxpay_id']             = $row->id;
            $sqlre['hxpay_customernumber'] = $row->appid;
            $sqlre['hxpay_account']        = $row->partnerid;
            $sqlre['hxpay_secret']         = $row->appsecret;
            $sqlre['hxpay_vector']         = $row->partnerkey;
            $sqlre['hxpay_signsecret']     = $row->paysignkey;
            $sqlre['hx_title']             = $row->title;
            $sqlre['hx_icon']              = $row->icon;
            $sqlre['hx_px']                = $row->px;
            $sqlre['hx_description']       = $row->description;
            $sqlre['gathering']            = $row->gathering;
            break;
        }

        //环迅微信支付
        $pay_type = "IPSweipay";
        $query    = "SELECT id,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        while ($row = mysql_fetch_object($result)) {
            $sqlre['wxpay_id']       = $row->id;
            $sqlre['wx_title']       = $row->title;
            $sqlre['wx_icon']        = $row->icon;
            $sqlre['wx_px']          = $row->px;
            $sqlre['wx_description'] = $row->description;
            break;
        }
        return $sqlre;
    }

    /**
     * 获取健康钱包支付配置
     */
    public function get_healthpay_config($customer_id)
    {

        $pay_type = "healthpay";
        $query    = "SELECT id,appid,appsecret,title,px,icon,description From pay_config WHERE customer_id='" . $customer_id . "' AND pay_type='" . $pay_type . "' AND isvalid=true limit 1";
        $result   = _mysql_query($query) or die('Query failed:' . mysql_error());
        $sqlre    = array(
            'health_id'      => -1,
            'health_account' => '', //商户号
            'health_secret'  => '', //商户密钥
            'title'          => $this->pay_types["healthpay"]["show_name"], //显示名字
            'px'             => "", //显示顺序
            'icon'           => $this->pay_types["healthpay"]["icon"], //默认图标
            'description'    => "", //描述
        );
        while ($row = mysql_fetch_object($result)) {
            $sqlre['health_id']      = $row->id;
            $sqlre['health_account'] = $row->appid;
            $sqlre['health_secret']  = $row->appsecret;
            $sqlre['px']             = $row->px;
            $sqlre['description']    = $row->description;
            $sqlre['title']          = $row->title;

            if ($row->icon != null) {
                $sqlre['icon'] = $row->icon;
            }

            break;
        }
        return $sqlre;
    }

    /**
     * 获取支付是否需要绑定手机
     * @param $customer_id
     * @return array
     */
    public function get_base_config($customer_id)
    {
        $query  = "SELECT IFNULL(sum(is_set_need_phone),0) as is_set_need_phone from pay_setting where isvalid=true and customer_id=" . $customer_id;
        $result = _mysql_query($query) or die('Query failed:' . mysql_error());
        while ($row = mysql_fetch_object($result)) {
            $re = $row->is_set_need_phone;
        }
        return $re;
    }
}
