#!/bin/sh
# Setup website and configure cronjobs
# Run this script with sudo

#########################
##### SETUP DATABASE ####
#########################

# Configure app/config/database.php (Necessary? root/root could just work fine.)

# run php artisan *COMMAND* (Command that executes the queries) // What function can I call in the command?

#########################
##### ADD CRONJOBS ######
#########################
#Remind users daily (at 20:00) to bet on upcoming matches in the next 2 days.
line="0 20 * * * php artisan remindUsers 2"
(crontab -u $USER -l; echo "$line" ) | crontab -u $USER -

#Remind users weekly to bet on upcoming matches in the upcoming week.
#This is more like a weekly overview.
line="0 20 * * 1 php artisan remindUsers 7"
(crontab -u $USER -l; echo "$line" ) | crontab -u $USER -

#Add cronjob for database updates.

#Add cronjob for processing bets.



exit
