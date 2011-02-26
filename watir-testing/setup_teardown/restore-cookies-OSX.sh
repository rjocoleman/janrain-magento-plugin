#!/bin/bash

# restore Firefox cookies from home directory
mv ~cookies.sqlit* ~/Library/Application\ Support/Firefox/Profiles/*.default/

# TODO uncomment if script is running safely
# delete the safe backup of the cookies in the home dir
#rm ~/cookies.sqlite_BKP
#rm ~/cookies.sqlite-journal_BKP

