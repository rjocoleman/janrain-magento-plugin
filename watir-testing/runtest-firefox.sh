#!/bin/bash


######################################
## BE SURE TO EXPORT VARS (see README)
## before running this script

#if [ ! -d "$MGP_WEBPUSH_HOME" ]; then
#    echo "MGP_WEBPUSH_HOME does not exist, exiting."
#    exit 0
#fi
# todo add tests for required env vars



###################
# clear screen
clear


###################
# opts parsing code taken from example at: http://www.linux.com/archive/feed/118031

# whether to completely reinstall Magento before running the tests
reinstall_all=

while getopts 'r' OPTION
do
  case $OPTION in
  r)	reinstall_all=1
        ;;
  ?)	printf "Usage: %s: [-r] \n" $(basename $0) >&2
        exit 2
        ;;
  esac
done
shift $((OPTIND - 1))

if [ "$reinstall_all" ]
then

    printf "Option -r specified; Magento db will be restored from a fresh install snapshot before tests are run.\n"

    ##########################
    ## drop all database tables
    cd setup_teardown
    cd dba
    ./drop_magento_db.sh

    ## import db from snapshot
    ./load_fresh_install_db.sh

    ## back to root dir
    cd ../..

    ## delete var/ stuff
    rm -rf $MAGENTO_1d5/var/cache
    rm $MAGENTO_1d5/var/session/*

fi



#############
# clear firefox cookies
if [ "$MGP_OS" = "OSX" ] ; then
    ./setup_teardown/clear-cookies-OSX.sh
else
    echo "MGP_OS only accepts OSX for the moment, exiting."
    exit 0
fi


#############
#kludge to attempt to work around problem where watir can't attach to firefox
#on the first load after a reboot -- start firefox, then kill it, prior to
#starting the watir script -- hopefully this will help get around the timing
#issue during the first load of firefox after bootup
if [ "$MGP_OS" = "OSX" ] ; then
    /Applications/Firefox.app/Contents/MacOS/firefox-bin & sleep 3; killall -9 firefox-bin
else
    echo "MGP_OS only accepts OSX for the moment, exiting."
    exit 0
fi




###########################
##  and now the tests......

ruby tests/main.rb




