unit-test:
	./vendor/bin/phpunit \
	  --display-incomplete --display-deprecations
.PHONY: unit-test

psalm:
	./vendor/bin/psalm
.PHONY: psalm

cs-check:
	./vendor/bin/php-cs-fixer fix --dry-run --diff --verbose --sequential --format=txt
.PHONY: cs-check

cs-fix:
	./vendor/bin/php-cs-fixer fix --verbose --sequential --format=txt
.PHONY: cs-fix
