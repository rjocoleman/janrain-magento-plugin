#!/bin/bash

######################################
## BE SURE TO EXPORT VARS (see README)
## before running this script

if [ ! -d "$MGP_WEBPUSH_HOME" ]; then
    echo "MGP_WEBPUSH_HOME does not exist, exiting."
    exit 0
fi

# copy files to our test directory
./setup_teardown/webpush.sh

# clear firefox cookies
if [ "$MGP_OS" = "OSX" ] ; then
    ./setup_teardown/clear-cookies-OSX.sh
else
    echo "MGP_OS only accepts OSX for the moment, exiting."
    exit 0
fi


cd $MGP_WEBPUSH_HOME


# [ -e $MGP_WEBPUSH_HOME/test.log ] && rm -f $MGP_WEBPUSH_HOME/test.log


#kludge to attempt to work around problem where watir can't attach to firefox
#on the first load after a reboot -- start firefox, then kill it, prior to
#starting the watir script -- hopefully this will help get around the timing
#issue during the first load of firefox after bootup
if [ "$MGP_OS" = "OSX" ] ; then
    /Applications/Firefox.app/Contents/MacOS/firefox-bin & sleep 5; killall -9 firefox-bin
else
    echo "MGP_OS only accepts OSX for the moment, exiting."
    exit 0
fi

ruby $MGP_WEBPUSH_HOME/tests/sanity/sanity1.rb

# /var/www/rpx_apitest.watir
# ./rpx_social_widget_test.watir staging | tee social_widget_test.output
# /var/www/check_social_output.sh staging



