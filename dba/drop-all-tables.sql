#!/bin/bash

# hat tip: http://www.cyberciti.biz/faq/how-do-i-empty-mysql-database/

mysql --user=magentostaging --password=magentostaging -BNe "show tables" magentostaging | tr '\n' ',' | sed -e 's/,$//' | awk '{print "SET FOREIGN_KEY_CHECKS = 0;DROP TABLE IF EXISTS " $1 ";SET FOREIGN_KEY_CHECKS = 1;"}' | mysql --user=magentostaging --password=magentostaging magentostaging


# then run the install script, there's a copy currently in dan's home directory on plugins.janrain.com

# cd /home/dan/magento-1.5-data/magento-sample-data-1.2.0
# mysql --user=magentostaging --password=magentostaging magentostaging < magento_sample_data_for_1.2.0.sql > output.txt


# that reinstalls all the tables, including resetting admin to admin/123123

# to get back to set a few config things:

#- redo the indexes in the admin page (see messages at top)
#- system / configuration / web / SEO           - turn rewrite back on
#- system / configuration / web / secure        - set baseurl to http://plugins.janrain.com/staging/magento-1.5/
#- system / permissions / users                 - change admin password (staging123)


