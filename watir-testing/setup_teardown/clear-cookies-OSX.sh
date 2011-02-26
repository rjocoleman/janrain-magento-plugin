#!/bin/bash

# move user's Firefox cookies temporarily to home directory
mv ~/Library/Application\ Support/Firefox/Profiles/*.default/cookies.sqlit* ~

# make a safe backup of the cookies in the home dir
cp ~/cookies.sqlite ~/cookies.sqlite_BKP
cp ~/cookies.sqlite-journal ~/cookies.sqlite-journal_BKP

