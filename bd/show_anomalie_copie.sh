#!/bin/bash

DB_CONN="CMS_RFC/CMS_2016_RFC@//cmsprodpr:1521/cmsprod.global.aes.com"

CICLO="$1"

if ! [[ "$CICLO" =~ ^[0-9]+$ ]]; then
    echo "Erreur : num_ciclo doit être un nombre."
    echo "Usage : $0 <num_ciclo>"
    exit 1
fi

sqlplus -s "$DB_CONN" <<EOF
WHENEVER SQLERROR EXIT SQL.SQLCODE
WHENEVER OSERROR EXIT FAILURE

SET HEADING ON
SET FEEDBACK OFF
SET PAGESIZE 50000
SET TRIMSPOOL ON
SET LINESIZE 1000
SET VERIFY OFF
SET ECHO OFF

SELECT
    a.num_apa,
    '' AS co_al,
    2010 AS num_mrsp,
    'non genere' AS observation
FROM CMS_RFC.anomalie_mt_copie a
WHERE NOT EXISTS (
    SELECT 1
    FROM itiner i
    WHERE i.num_apa = a.num_apa
      AND i.num_mrsp = 2010
      AND i.num_ciclo = $CICLO
) UNION ALL SELECT DISTINCT
    i.num_apa,
    i.co_al,
    i.num_mrsp,
    'genere' AS observation
FROM itiner i
WHERE i.num_mrsp = 2010
  AND i.num_ciclo = $CICLO
  AND EXISTS (
      SELECT 1
      FROM CMS_RFC.anomalie_mt_copie a
      WHERE a.num_apa = i.num_apa
  );

EXIT;
EOF

RC=$?

if [ "$RC" -ne 0 ]; then
    echo "Erreur SQLPlus : code retour $RC"
    exit "$RC"
fi