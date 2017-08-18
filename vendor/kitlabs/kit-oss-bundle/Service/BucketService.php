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
    
    public function delete($bucket)
    {
        try {
            return $this->getClient()->deleteBucket($bucket);
        }catch (\Exception $e){
            return false;
        }
    }
    
    public function setAcl($bucket, $acl)
    {
        try {
            return $this->getClient()->putBucketAcl($bucket, $acl);
        }catch (\Exception $e){
            return false;
        }
    }
    
    public function getAcl($bucket)
    {
        try {
            return $this->getClient()->getBucketAcl($bucket);
        }catch (\Exception $e){
            return false;
        }
    }
    
    public function setCors()
    {
        
    }
    
    public function getCors()
    {
        
    }
    
    public function deleteCors()
    {
        
    }
    
    public function setLifecycle()
    {
        
    }
    
    public function getLifecycle()
    {
        
    }
    
    public function deleteLifecycle()
    {
        
    }
    
    public function setLogging()
    {
        
    }
    
    public function getLogging()
    {
        
    }
    
    public function deleteLogging()
    {
        
    }
    
    public function setReferer()
    {
        
    }
    
    public function getReferer()
    {
        
    }
    
    public function deleteReferer()
    {
        
    }
    public function setWebsite()
    {
        
    }
    
    public function getWebsite()
    {
        
    }
    
    public function deleteWebsite()
    {
        
    }
}