#!/bin/sh

echo Sauvegarde des données

mpg123 /home/pi/RPi-Jukebox-RFID/shared/startupsound.mp3


if [ "$(id -nu)" != "root" ]; then
   echo Nécessite sudo
    exit 1
fi

mkdir /mnt/backup

chmod 0775 /mnt/backup

mount -t nfs 192.168.0.21:/volume1/PhonieBoxBackup /mnt/backup && rsync -avz /home/pi/RPi-Jukebox-RFID /mnt/backup

# ls -al /mnt/backup

umount /mnt/backup


mpg123 /home/pi/RPi-Jukebox-RFID/shared/shutdownsound.mp3


