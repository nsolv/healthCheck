#!/bin/sh

PATH=/etc:/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin

TEMP="$(vcgencmd measure_temp | egrep -o '[0-9]*\.[0-9]*')"

#echo $TEMP

DB=/mnt/ssd/scripts/temperature/data.db

# Create table temperature if it does not exist
echo "CREATE TABLE IF NOT EXISTS temperature (id INTEGER PRIMARY KEY AUTOINCREMENT, ts datetime default CURRENT_TIMESTAMP, value float not null);" | sqlite3 $DB

# Insert value
echo "INSERT INTO temperature (value) VALUES ('$TEMP')" | sqlite3 $DB