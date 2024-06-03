#!/bin/bash

if [ $1 = --non-exact ]; then
    non_exact_flag=true
fi

if [ "$non_exact_flag" = true ]; then
    read line
    find . -name \*.po -exec fgrep -l "$line" "{}" ";"
else
    find . -name \*.po -exec fgrep -l "\"$1\"" "{}" ";"
fi
