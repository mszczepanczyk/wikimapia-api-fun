#!/bin/sh

wget "http://code.jquery.com/jquery-1.4.3.js" -O "jquery-1.4.3.js"

php -r "include('db.php'); init_db();"
chmod 777 "wikimapia.sqlite"

mkdir "objects"
chmod -R 777 "objects"
chmod 777 .
