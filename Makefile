#!make

DRUSH=$(CURDIR)/vendor/bin/drush -r $(CURDIR)/web

build: composer init-theme build-theme deploy

sync: composer init-theme deploy

init: composer init-theme

composer:
	composer install --prefer-dist --no-progress --optimize-autoloader

init-theme:
	npm install
	cd web/modules/custom/ui_icons_lucide && npm install

build-theme:
	npm run build

dev-theme:
	npm run dev

storybook:
	$(DRUSH) storybook:generate-all-stories

config-export:
	$(DRUSH) config-export -y

deploy:
	$(DRUSH) deploy -y

install-coding-standards:
	vendor/bin/phpcs --config-set installed_paths vendor/acquia/coding-standards/src/Standards,vendor/drupal/coder/coder_sniffer,vendor/phpcompatibility/php-compatibility,vendor/slevomat/coding-standard

lint:
	make lint-be
	# make lint-fe
	make lint-tests

lint-be:
	composer validate --strict
	vendor/bin/phpcs
	vendor/bin/phpstan

lint-be-fix:
	vendor/bin/phpcbf

lint-fe:
	vendor/bin/twig-cs-fixer lint

lint-tests:
	vendor/bin/gherkinlint lint tests/behat/features

test:
	make test-unit
	make test-kernel
	make test-functional
	make test-bdd

test-unit:
	vendor/bin/phpunit --testsuite=unit

test-kernel:
	vendor/bin/phpunit --testsuite=kernel

test-functional:
	vendor/bin/phpunit --testsuite=functional

test-bdd:
	$(DRUSH) en -y dblog
	BEHAT_SCREENSHOT_PURGE=1 php -d memory_limit=-1 vendor/bin/behat
	$(DRUSH) pmu -y dblog

courses-import:
	$(DRUSH) mim --update --sync --continue-on-failure keh_course_course

courses-rollback: courses-reset
	$(DRUSH) mr keh_course_course

courses-reset:
	$(DRUSH) mrs keh_course_course
