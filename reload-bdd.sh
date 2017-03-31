#!/bin/bash
php app/console propel:build
php app/console propel:sql:insert --force

mysql -u root -p politizr_demo -h localhost < ./app/propel/migrations/import.sql

php app/console propel:fixtures:load
php app/console faker:populate
