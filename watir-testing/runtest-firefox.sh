#!/bin/bash


######################################
## BE SURE TO EXPORT VARS (see README)
## before running this script


###################
# clear screen
clear


###################
# opts parsing code taken from example at: http://www.linux.com/archive/feed/118031

# whether to completely reinstall Magento before running the tests
reload_db=

# same, but quit right after reload
reload_db_and_quit=

while getopts 'rR' OPTION
do
  case $OPTION in
  r)	reload_db=1
        ;;
  R)	reload_db=1
        reload_db_and_quit=1
        ;;
  ?)	printf "Usage: %s: [-r] \n" $(basename $0) >&2
        exit 2
        ;;
  esac
done
shift $((OPTIND - 1))


###################
# database reload
# -r will reload, then run tests.
# -R will reload, then quit.

if [ "$reload_db" ]
then

    printf "Magento db being reloaded from snapshot...\n"

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

    printf "Magento db reloaded.\n"

    if [ "$reload_db_and_quit" ]
    then
        printf "Quitting script after db reload.\n"
        exit 0
    fi

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




