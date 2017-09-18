<?php
namespace Kit\Bundle\OssBundle\Service;

class ImageService extends ClientService
{
    public function upload($bucket, $object, $file)
    {
        try {
            $result = $this->getClient()->uploadFile($bucket, $object, $file);
            if(isset($result['oss-request-url']) && !empty($result['oss-request-url'])){
                return [
                    'code' => 1,
                    'msg' => 'success',
                    'data' => [
                        'url' => $result['oss-request-url']
                    ]
                ];
            }else{
               return [
                   'code' => 2,
                   'msg' => 'faild',
                   'data' => $result
               ];              
            }
        }catch (\Exception $e){
            return [
                'code' => 0,
                'msg' => 'exception',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ];
        }
    }
}