#!/bin/bash

boolean=$1
state=$2
sudo setsebool $boolean $state


