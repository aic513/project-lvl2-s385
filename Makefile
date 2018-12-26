install:
	composer install

lint-fix:
	composer run-script phpcbf -- --standard=PSR2 src bin

test:
	composer run-script phpunit tests
