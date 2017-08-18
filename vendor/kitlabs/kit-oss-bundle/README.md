# KitOssBundle
Aliyun OSS Bundle for Symfony3

## Installation
 
### Step 1: Download the Bundle
---------------------------
 
Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:
 
	
	$ composer require kitlabs/kit-oss-bundle "~0.1"

 
This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.
 
### Step 2: Enable the Bundle
---------------------------
 
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

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

### Step 3: Configuration 

	# config.yml
	kit_oss:
	    access_key_id: ************
	    access_key_secret: ************
	    endpoint: oss-cn-beijing.aliyuncs.com
## Usage
- bucket

		/**
		 * @var $bucketService \Kit\Bundle\OssBundle\Service\ossClientService
		 */
		$bucketService = $this->get('kit_oss.bucket_service');
		$bucketService->create($bucket);
		$bucketService->list();
		$bucketService->checkExist($bucket);