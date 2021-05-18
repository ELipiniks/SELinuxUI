#!/bin/bash

identity=$1
user=$2
sudo semanage login -a -s $identity $user


