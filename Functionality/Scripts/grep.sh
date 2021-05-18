#!/bin/bash

OUTPUT=$(sudo  grep "^$(/usr/gnu/bin/date -d -1hour +'%Y-%m-%d %H')" /var/log/messages | grep "SELinux is preventing")
echo "${OUTPUT}"


