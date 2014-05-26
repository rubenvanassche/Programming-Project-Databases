#!/bin/sh
# Setup website and configure cronjobs
# Don't sudo this script.

#########################
##### SETUP DATABASE ####
#########################

# Configure app/config/database.php
echo "### SETTING UP DATABASE ###"
read -p "Database username: " username
read -p "Database password: " password

sed -i.bak 's/\x27username\x27  => \x27root\x27,/\x27username\x27  => \x27'$username'\x27,/g' '../app/config/database.php'
sed -i.bak 's/\x27password\x27  => \x27root\x27,/\x27password\x27  => \x27'$password'\x27,/g' '../app/config/database.php'

# run php artisan *COMMAND* (Command that executes the queries) // What function can I call in the command?
# Create database schema + add data

#########################
##### ADD CRONJOBS ######
#########################
echo "### ADDING CRONJOBS ###"
PHPPATH=$(which php)
cd ../
artisanLocation=`pwd`/artisan
#Remind users daily (at 20:00) to bet on upcoming matches in the next 2 days.
line="0 20 * * * $PHPPATH $artisanLocation remindUsers 2"
(crontab -u $USER -l; echo "$line" ) | crontab -u $USER -

#Remind users weekly to bet on upcoming matches in the upcoming week.
#This is more like a weekly overview.
line="0 20 * * 1 $PHPPATH $artisanLocation remindUsers 7"
(crontab -u $USER -l; echo "$line" ) | crontab -u $USER -

#Add cronjob for database updates (which also processes bets).
line="0 */2 * * * $PHPPATH $artisanLocation updateDB"
(crontab -u $USER -l; echo "$line" ) | crontab -u $USER -

echo "### INSTALLATION COMPLETE ###"
exit
