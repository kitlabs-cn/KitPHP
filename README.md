# KitPHP
a skeleton for symfony


## create database
	
	php bin/console doctrine:database:create
## generate tables

	php bin/console doctrine:schema:update --force
## generate admin account
	
	php bin/console kit:admin:generate --username=admin --password=123456
	// param optional, default username=admin, password=admin
	php bin/console kit:admin:generate -u admin -p 123456
