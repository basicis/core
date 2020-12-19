#!/bin/bash
touch bin/basicis.db &&
composer doctrine orm:schema-tool:create &&
echo APP_ENV=dev > .env &&
echo DB_DRIVER=pdo_sqlite > .env &&
echo DB_PATH=bin/basicis.db > .env &&
composer test
rm bin/basicis.db