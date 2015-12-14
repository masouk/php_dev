#!/bin/sh



#備份 sun_db
DBName=sun_new_55
BackupPath=/home/sun_db/
DBbinPath=/usr/local/bin/mysqldump

if ${DBbinPath} --opt --extended-insert=false -h 127.0.0.1 --port 3306 -uxxxxx -pxxxxxxxx ${DBName} > ${BackupPath}${DBName}"/"${DBName}`date "+%Y-%m-%d"`".sql" ;
then
    find ${BackupPath}${DBName}"/" -mtime +3 -exec rm {} \;
else
    exit
fi
