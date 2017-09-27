<?php
namespace KitBaseBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Container;

class FileUploader
{
    private $targetDir;
    private $container;

    public function __construct($targetDir,Container $container)
    {
        $this->targetDir = $targetDir;
        $this->container = $container;
    }

    public function upload(UploadedFile $file, $subDir = '')
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $subDir = empty($subDir) ? '' : '/'. $subDir;
        try {
            $file->move($this->targetDir . $subDir, $fileName);
            $file->getPath();
        }catch (\Exception $e){
            return [
                'code' => 0,
                'data' => $e->getCode() . $e->getMessage()
            ];
        }

        return [
            'code' => 1,
            'data' => 'uploads' .$subDir . '/' .$fileName
        ];
    }
    
    public function uploadOss(UploadedFile $file, $bucket)
    {
        $filename = $this->generateName($file);
        /**
         *
         * @var \Kit\Bundle\OssBundle\Service\ImageService $imageService
         */
        $imageService = $this->container->get('kit_oss.image_service');
        return $imageService->upload($bucket, $filename, $file->getPathname());
    }
    
    private function generateName($file)
    {
        return 'images/' .time().'_'.uniqid().'.'.$file->guessExtension();
    }
}