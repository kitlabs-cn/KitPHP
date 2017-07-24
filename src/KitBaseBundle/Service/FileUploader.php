<?php
namespace KitBaseBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $subDir = '')
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $subDir = empty($subDir) ? '' : DIRECTORY_SEPARATOR . $subDir;
        $file->move($this->targetDir . $subDir, $fileName);

        return $subDir . DIRECTORY_SEPARATOR .$fileName;
    }
}