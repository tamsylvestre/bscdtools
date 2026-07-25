#!/bin/bash

ACTION=$1
ID=$2
BATCH=$3
RET=$4

#DB_CONN="CMS_BTCH/ABK_245@//cmsprodpr:1521/cmsprod.global.aes.com"
DB_CONN="CMS_RFC/CMS_2016_RFC@//cmsprodpr:1521/cmsprod.global.aes.com"

if [ $# -lt 3 ]; then
    echo "Usage:"
    echo "  $0 START <id> <batch>"
    echo "  $0 END   <id> <batch> <return_code>"
    exit 1
fi

##############################################################################
# Récupère la requête de comptage depuis Oracle
##############################################################################
get_count_query() {

sqlplus -s "$DB_CONN" <<EOF
SET HEADING OFF
SET FEEDBACK OFF
SET PAGESIZE 0
SET TRIMSPOOL ON
SET LINESIZE 1000

SELECT TRIM(sql_count)
FROM batch_list
WHERE batch_name = '$1';

EXIT;
EOF
}

##############################################################################

# COUNT_QUERY=$(get_count_query "$BATCH")
COUNT_QUERY=$(get_count_query "$BATCH" | tr -d '\n')
COUNT_QUERY=$(echo "$COUNT_QUERY" | sed 's/^[ \t]*//;s/[ \t]*$//')

if [ -z "$COUNT_QUERY" ]; then
    echo "Batch inconnu dans batch_list : $BATCH"
    exit 1
fi

##############################################################################

case "$ACTION" in

START)

REQ="INSERT INTO batch_execution(batch_id,batch,startAt,beginWith,status) SELECT '$ID', '$BATCH', SYSDATE, t.c, 'RUNNING' FROM ( $COUNT_QUERY ) t;"

;;

END)

if [ "$RET" = "0" ]; then
    STATUS="SUCCESS"
else
    STATUS="FAILED"
fi

REQ="UPDATE batch_execution SET endAt = SYSDATE, endWith = ( $COUNT_QUERY ), return_code = $RET, status = '$STATUS', duration = ROUND((SYSDATE-startAt)*24*60*60) WHERE batch_id='$ID';"

;;

*)

echo "Action inconnue : $ACTION"
exit 1
;;

esac

##############################################################################

sqlplus -s "$DB_CONN" <<EOF
WHENEVER SQLERROR EXIT SQL.SQLCODE

SET FEEDBACK OFF
SET HEADING OFF
SET VERIFY OFF
SET PAGESIZE 0
SET LINESIZE 1000

$REQ

COMMIT;
EXIT;
EOF

RET_SQL=$?

if [ $RET_SQL -ne 0 ]; then
    echo "Erreur Oracle : $RET_SQL"
    exit $RET_SQL
fi

exit 0