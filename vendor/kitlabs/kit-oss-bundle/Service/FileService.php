<?php
namespace Kit\Bundle\OssBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService extends ClientService
{
    public function upload($file, $bucket, $object = null, $dir = null)
    {
        try {
            if($file instanceof UploadedFile){
                if(is_null($object)) $object = $this->generateName($file);
                $file = $file->getPathname();
            }else{
                if(file_exists($file)){
                    if(is_null($object)) $object = basename($file);
                }else{
                    return [
                        'code' => 3,
                        'msg' => 'file not exists',
                        'data' => []
                    ];
                }
            }
            if(!empty($dir)) $object = trim($dir, '/') . '/' . $object;
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
    
    private function generateName($file)
    {
        return time().'_'.uniqid().'.'.$file->guessExtension();
    }
}