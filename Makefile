all:
	composer run-script qa-all --timeout=0

all-coverage:
	composer run-script qa-all-coverage --timeout=0

ci:
	composer run-script qa-ci --timeout=0

ci-extended:
	composer run-script qa-ci-extended --timeout=0

contrib:
	composer run-script qa-contrib --timeout=0

init:
	if [ ! -d vendor ]; then COMPOSER_ROOT_VERSION=`git describe --abbrev=0` composer install; fi;

cs:
	composer cs

cs-fix:
	composer cs-fix

unit:
	composer run-script unit --timeout=0

unit-coverage:
	composer run-script unit-coverage --timeout=0

ci-coverage: init
	composer ci-coverage
