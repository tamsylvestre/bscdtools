#!/bin/bash

DB_CONN="CMS_RFC/CMS_2016_RFC@//cmsprodpr:1521/cmsprod.global.aes.com"

sqlplus -s "$DB_CONN" <<EOF
SET HEADING OFF
SET FEEDBACK OFF
SET PAGESIZE 0
SET TRIMSPOOL ON
SET LINESIZE 1000

SELECT DISTINCT num_apa,co_al, num_mrsp FROM itiner WHERE num_mrsp=2010 AND num_ciclo=8  
        AND  num_apa IN (SELECT num_apa FROM CMS_RFC.anomalie_mt_copie);

EXIT;
EOF