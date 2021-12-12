#!/bin/bash
while true
do
 nohup php /home/every/public_html/include/cron/cron.php > /dev/null 2>&1
 sleep 10
done