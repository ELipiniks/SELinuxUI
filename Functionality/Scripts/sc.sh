#!/bin/bash

OUTPUT=$(sudo semanage login -l)
echo "${OUTPUT}"

