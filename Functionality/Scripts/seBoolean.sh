#!/bin/bash

OUTPUT=$(sudo semanage boolean -l)
echo "${OUTPUT}"


