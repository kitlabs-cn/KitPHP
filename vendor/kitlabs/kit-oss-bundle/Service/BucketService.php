<?php
namespace Kit\Bundle\OssBundle\Service;

use OSS\OssClient;

class BucketService extends  ClientService
{
    public function create($bucket)
    {
        $this->getClient()->createBucket($bucket);
        return true;
    }
    
    public function checkExist($bucket)
    {
        try {
            return $this->getClient()->doesBucketExist($bucket);
        }catch (\Exception $e){
            return false;
        }
    }
    
    public function list()
    {
        try {
            return $this->getClient()->listBuckets();
        }catch (\Exception $e){
            return false;
        }
    }
}