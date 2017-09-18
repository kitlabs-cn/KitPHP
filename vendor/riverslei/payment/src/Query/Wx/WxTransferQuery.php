<?php
namespace Payment\Query\Wx;

use Payment\Common\PayException;
use Payment\Common\Weixin\Data\Query\TransferQueryData;
use Payment\Common\Weixin\WxBaseStrategy;
use Payment\Config;
use Payment\Utils\DataParser;

/**
 * Class WxTransferQuery
 * @package Payment\Query
 * anthor helei
 */
class WxTransferQuery extends WxBaseStrategy
{
    protected $reqUrl = 'https://api.mch.weixin.qq.com/{debug}/mmpaymkttransfers/gettransferinfo';

    public function getBuildDataClass()
    {
        return TransferQueryData::class;
    }

    /**
     * 处理通知的返回数据
     * @param array $data
     * @return mixed
     * @author helei
     */
    protected function retData(array $data)
    {
        if ($this->config->returnRaw) {
            $data['channel'] = Config::WX_TRANSFER;
            return $data;
        }

        // 请求失败，可能是网络
        if ($data['return_code'] != 'SUCCESS') {
            return $retData = [
                'is_success'    => 'F',
                'error' => $data['return_msg'],
                'channel' => Config::WX_TRANSFER,
            ];
        }

        // 业务失败
        if ($data['result_code'] != 'SUCCESS') {
            return $retData = [
                'is_success'    => 'F',
                'error' => $data['err_code_des'],
                'channel' => Config::WX_TRANSFER,
            ];
        }

        // 正确
        return $this->createBackData($data);
    }

    /**
     * 返回数据给客户端
     * @param array $data
     * @return array
     * @author helei
     */
    protected function createBackData(array $data)
    {
        // 将金额处理为元
        $amount = bcdiv($data['payment_amount'], 100, 2);

        $retData = [
            'is_success'    => 'T',
            'response'  => [
                'trans_no'   => $data['partner_trade_no'],// 商户单号
                'transaction_id'  => $data['detail_id'],// 付款单号
                'status'  => strtolower($data['status']),// 转账状态
                'reason'    => $data['reason'],// 失败原因
                'openid'   => $data['openid'],
                'payee_name'   => $data['transfer_name'],// 收款用户姓名
                'amount'   => $amount,
                'pay_date'   => $data['transfer_time'],
                'desc'   => $data['desc'],// 付款描述
                'channel' => Config::WX_TRANSFER,
            ],
        ];

        return $retData;
    }

    /**
     * @param array $data
     * @author helei
     * @throws PayException
     * @return array|string
     */
    public function handle(array $data)
    {
        $buildClass = $this->getBuildDataClass();

        try {
            $this->reqData = new $buildClass($this->config, $data);
        } catch (PayException $e) {
            throw $e;
        }

        $this->reqData->setSign();

        $xml = DataParser::toXml($this->reqData->getData());
        $ret = $this->sendReq($xml);

        return $this->retData($ret);
    }
}
