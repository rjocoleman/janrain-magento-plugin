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

# whether to rebuild the db before running the tests
rebuilddb=

while getopts 'r' OPTION
do
  case $OPTION in
  r)	rebuilddb=1
        ;;
  ?)	printf "Usage: %s: [-r] \n" $(basename $0) >&2
        exit 2
        ;;
  esac
done
shift $((OPTIND - 1))

if [ "$rebuilddb" ]
then

    printf "Option -r specified; database will be rebuilt before tests are run.\n"

    ##########################
    ## rebuild entire database

    cd setup_teardown
    cd dba

    ./drop_magento_db.sh


    cd ../..

fi



# todo remove me
exit







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

if [ "$rebuilddb" ]
then
    ruby tests/main.rb rebuilddb
else
    ruby tests/main.rb
fi





