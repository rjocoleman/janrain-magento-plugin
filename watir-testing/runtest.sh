#!/bin/bash

## BE SURE TO EXPORT VARS (see README) before running this script


# clear firefox cookies


# [ -e /var/www/test.log ] && rm -f /var/www/test.log

# /var/www/clearcookies.sh

#kludge to attempt to work around problem where watir can't attach to firefox
#on the first load after a reboot -- start firefox, then kill it, prior to
#starting the watir script -- hopefully this will help get around the timing
#issue during the first load of firefox after bootup

# firefox & sleep 5; killall -9 firefox-bin

# /var/www/rpx_apitest.watir

# ./rpx_social_widget_test.watir staging | tee social_widget_test.output

# /var/www/check_social_output.sh staging



