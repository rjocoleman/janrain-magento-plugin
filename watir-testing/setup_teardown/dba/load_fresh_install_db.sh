#!/bin/bash

# name of mysql program - stick it in a var so it's easy to concatenate with path
m=mysql

# reload sample Magento data
"$MGP_MYSQL_PATH$m" --user=$MGP_DB_USERNAME --password=$MGP_DB_PASSWORD $MGP_DB_NAME < ./magento_fresh_install.sql > fresh_install_result.txt

