#!/bin/bash

IFS=+;
wget -q -U Mozilla -O "$*.mp3" "http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=$*&tl=fr"
