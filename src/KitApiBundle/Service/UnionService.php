<?php
namespace KitApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class UnionService
{
    private $em;
    
    private $container;
    
    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }
    
    /**
     * 
     */
    public function run($type, $data = [])
    {
        return $this->request($type, $data);
    }
    /**
     * get guzzle http client
     *
     * @return \GuzzleHttp\Client
     */
    private function getClient()
    {
        return $this->container->get('guzzle.client.api_pay_union');
    }
    
    /**
     * 发起请求
     */
    private function request($type, $data)
    {
        $client = $this->getClient();
        try {
            $response = $client->post( $this->getUri($type), [
                'form_params' => $this->getParams($type, $data)
            ]);
            if (200 == $response->getStatusCode()) {
                $content = (string) $response->getBody();
                $result = json_decode($content, true);
                if(isset($result['retcode']) && 'SUCCESS' == $result['retcode']){
                    return [
                        'code' => 1,
                        'msg' => 'success',
                        'data' => $result
                    ];
                }else{
                    return [
                        'code' => 0,
                        'msg' => 'fail',
                        'data' => $result
                    ];
                }
            } else {
                return [
                    'code' => 5,
                    'msg' => 'http error',
                    'data' => [
                        'exception_code' => $response->getStatusCode(),
                        'exception_msg' => 'http code',
                        'request' => '',
                        'response' => $response->getBody()->getContents()
                    ]
                ];
            }
        } catch (ClientException $e) {
            return [
                'code' => 2,
                'msg' => 'clint exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getRequest(),
                    'response' => $e->getResponse()
                ]
            ];
        } catch (RequestException $e) {
            return [
                'code' => 3,
                'msg' => 'request exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getRequest(),
                    'response' => $e->getResponse()
                ]
            ];
        } catch (\Exception $e) {
            return [
                'code' => 4,
                'msg' => 'exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getFile(),
                    'response' => $e->getLine()
                ]
            ];
        }
    }
    
    /**
     * 生成签名
     */
    private function sign($param)
    {
        $param['key'] = 'allinpay888';
        ksort($param);
        return md5(http_build_query($param));
    }
    
    private function getUri($type)
    {
        return 'https://vsp.allinpay.com/apiweb/unitorder/pay';
        return 'http://113.108.182.3:10080/apiweb/unitorder';
    }
    /**
     * 处理参数
     */
    private function getParams($type, $data)
    {
        $baseParams = [
            'cusid' => '990581007426001',
            'appid' => '00000051',
            'version' => 11
        ];
        switch ($type) {
            case 'pay':
                $params = [
                    'trxamt' => 100, // 单位分
                    'reqsn' => '1024' .time(), // 商户订单号
                    'paytype' => 'A01', // 固定值
                    'randomstr' => uniqid(), // 随机值
                    'body' => '订单标题',
                    'remark' => '备注信息',
                    'validtime' => '60', // 订单有效时间，最长60分钟
                    'notify_url' => 'www.baidu.com' //异步回调地址，对刷卡无效
                ];
                break;
        }
        $params = array_merge($baseParams, $params);
        $params['sign'] = $this->sign($params);
        return $params;
    }
}