unit-test:
	./vendor/bin/phpunit \
	  --display-incomplete --display-deprecations
.PHONY: unit-test

psalm:
	./vendor/bin/psalm
.PHONY: psalm