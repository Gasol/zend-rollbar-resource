.PHONY: check clean coveralls prepare test vendor stan style

BUILD_DIR=$(PWD)/build
DEVTOOLS_DIR=$(PWD)/dev-tools
PHPCS_CMD=$(DEVTOOLS_DIR)/phpcs.phar
PHPSTAN_CMD=$(DEVTOOLS_DIR)/phpstan.phar
PHPCOVERALLS_CMD=$(DEVTOOLS_DIR)/php-coveralls.phar
PHP_VERNUM=$(shell php-config --vernum)

prepare:
	@mkdir -p $(DEVTOOLS_DIR) $(BUILD_DIR)/logs

dev-tools/phpstan.phar: | prepare
	curl -Lso $(PHPSTAN_CMD) https://github.com/phpstan/phpstan/releases/download/0.11.2/phpstan.phar
	chmod +x $(PHPSTAN_CMD)

dev-tools/phpcs.phar: | prepare
	curl -Lso $(PHPCS_CMD) https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
	chmod +x $(PHPCS_CMD)

dev-tools/phpcoveralls.phar: | prepare
	curl -Lso $(PHPCOVERALLS_CMD) https://github.com/php-coveralls/php-coveralls/releases/download/v2.1.0/php-coveralls.phar
	chmod +x $(PHPCOVERALLS_CMD)


stan: dev-tools/phpstan.phar vendor
ifdef DOCKER
	docker run --rm -v $$PWD:/app phpstan/phpstan analyze --no-progress --ansi -l $${PHPSTAN_LEVEL:-0} -a vendor/autoload.php src tests;
else
	@if [ "$(PHP_VERNUM)" -lt 70000 ]; then \
		echo "The PHPStan is required PHP 7.0 runtime or laters"; \
		exit 1; \
	fi
	$(PHPSTAN_CMD) analyse --no-progress --ansi -l $${PHPSTAN_LEVEL:-0} -a vendor/autoload.php src tests
endif

style: dev-tools/phpcs.phar
	$(PHPCS_CMD) --standard=PSR2 src tests

check: style stan

all: test

vendor:
	composer install

test: prepare vendor
	vendor/bin/phpunit

coveralls: dev-tools/phpcoveralls.phar
	$(PHPCOVERALLS_CMD) -v

clean:
	rm -rf $(DEVTOOLS_DIR) vendor
