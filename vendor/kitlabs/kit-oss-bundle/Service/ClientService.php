<?php
namespace Kit\Bundle\OssBundle\Service;

use OSS\OssClient;

class ClientService
{
    private $accessKeyId;
    private $accessKeySecret;
    private $endpoint;
    
    public function __construct($accessKeyId, $accessKeySecret, $endpoint)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->endpoint = $endpoint;
    }
    /**
     * get oss client 
     * @param unknown $accessKeyId
     * @param unknown $accessKeySecret
     * @param unknown $endpoint
     * @throws Exception
     * @return \OSS\OssClient
     */
    public function getClient()
    {
        try{
            return new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        }catch (\OSS\Core\OssException $e) {
            return null;
        }catch (\Exception $e){
            return null;
        }
    }
}