#!/bin/bash

# move user's Firefox cookies temporarily to home directory
if [ -e ~/Library/Application\ Support/Firefox/Profiles/*.default/cookies.sqlit* ] ; then
    mv ~/Library/Application\ Support/Firefox/Profiles/*.default/cookies.sqlit* ~
fi


# make a safe backup of the cookies in the home dir
if [ -e ~/cookies.sqlite ] ; then
    cp ~/cookies.sqlite ~/cookies.sqlite_BKP
    cp ~/cookies.sqlite-journal ~/cookies.sqlite-journal_BKP
fi


