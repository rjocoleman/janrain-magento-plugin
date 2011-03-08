#!/bin/bash

# name of mysql program - stick it in a var so it's easy to concatenate with path
m=mysql

# drop all Magento tables
"$MGP_MYSQL_PATH$m" --user=$MGP_DB_USERNAME --password=$MGP_DB_PASSWORD -BNe "show tables" $MGP_DB_NAME | tr '\n' ',' | sed -e 's/,$//' | awk '{print "SET FOREIGN_KEY_CHECKS = 0;DROP TABLE IF EXISTS " $1 ";SET FOREIGN_KEY_CHECKS = 1;"}' | "$MGP_MYSQL_PATH$m" --user=$MGP_DB_USERNAME --password=$MGP_DB_PASSWORD $MGP_DB_NAME

