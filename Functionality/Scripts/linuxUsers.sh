#!/bin/bash

OUTPUT=$(sudo getent passwd | awk -F: '{ print $1}')
echo "${OUTPUT}"


