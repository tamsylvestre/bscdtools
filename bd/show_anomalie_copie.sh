#!/bin/bash

DB_CONN="CMS_RFC/CMS_2016_RFC@//cmsprodpr:1521/cmsprod.global.aes.com"

sqlplus -s "$DB_CONN" <<EOF
SET HEADING OFF
SET FEEDBACK OFF
SET PAGESIZE 0
SET TRIMSPOOL ON
SET LINESIZE 1000

SELECT *
FROM CMS_RFC.anomalie_mt_copie
ORDER BY upload_date DESC;

EXIT;
EOF