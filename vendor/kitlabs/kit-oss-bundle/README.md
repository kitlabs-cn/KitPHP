# KitOssBundle
Aliyun OSS Bundle for Symfony3

## Installation
 
### Step 1: Download the Bundle
---------------------------
 
Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:
 
```console
$ composer require kitlabs/kit-oss-bundle "~0.1"
```
 
This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.
 
### Step 2: Enable the Bundle
---------------------------
 
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:
 
```php
<?php
// app/AppKernel.php
 
// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
 
            new Kit\Bundle\OssBundle\KitOssBundle(),
        );
 
        // ...
    }
 
    // ...
}
```
## Usage
```php

/**
 *
 * @var $ossService \Kit\Bundle\OssBundle\Service\ossClientService
 */
$ossService = $this->get('kit_oss.oss_client_service');
$ossClient = $ossService->getClient($accessKeyId, $accessKeySecret, $endpoint);
$bucketListInfo = $ossClient->listBuckets();
$bucketList = $bucketListInfo->getBucketList();
foreach($bucketList as $bucket) {
    dump($bucket->getLocation() . "\t" . $bucket->getName() . "\t" . $bucket->getCreatedate() . "\n");
}
```