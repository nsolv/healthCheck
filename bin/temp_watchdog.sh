#!/bin/sh

FILENAME_SCRIPT=/mnt/ssd/scripts/temperature/temp.sh

while sleep 1; do ($FILENAME_SCRIPT &) ; done