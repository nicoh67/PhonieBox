#!/bin/bash
ffmpeg -i "concat:startupsound.mp3|silence-0.5sec.mp3|startup.mp3" -acodec copy startupsoundIris.mp3
mpg123 startupsoundIris.mp3
