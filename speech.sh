#!/bin/bash
say() { local IFS=+;/usr/bin/mpg123 "http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=$*&tl=fr"; }
say $*
