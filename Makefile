INSTALL_DIR = /usr/local/bin

all:
	rm -f build/phpdia.phar
	chmod +x vendor/bin/phar-builder
	php -d phar.readonly=0 vendor/bin/phar-builder package composer.json
	chmod +x build/phpdia.phar

test:
	@vendor/bin/phpunit src/

install:
	cp build/phpdia.phar ${INSTALL_DIR}
	echo "#!/usr/bin/env bash\nphp -d phar.readonly=0 ${INSTALL_DIR}/phpdia.phar \$$1" > ${INSTALL_DIR}/phpdia
	chmod +x ${INSTALL_DIR}/phpdia

uninstall:
	rm ${INSTALL_DIR}/phpdia
	rm ${INSTALL_DIR}/phpdia.phar