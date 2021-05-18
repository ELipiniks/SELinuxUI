#!/bin/bash

mode=$1
sudo semanage login -a -s $identity $mode


