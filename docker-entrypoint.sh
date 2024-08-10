#!/bin/sh
set -e

php /var/www/html/init_db.php

apache2-foreground