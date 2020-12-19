#!/bin/bash
touch bin/basicis.db &&
composer doctrine orm:schema-tool:create &&
#echo ENV_TEST=ok > .env &&
composer test
rm bin/basicis.db