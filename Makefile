unit-test:
	./vendor/bin/phpunit -v
.PHONY: unit-test

psalm:
	./vendor/bin/psalm
.PHONY: psalm