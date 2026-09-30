#!/bin/bash

FROM_DATE="$1"
TO_DATE="$2"
LAST_TRY_MV="$3"
LAST_TRY_LV="$4"
THREADS=4
CLOSE_PENDING=0

catcat > config0.ini <<EOF
fromDate=$FROM_DATE
toDate=$TO_DATE
lastTryMv=$LAST_TRY_MV
lastTryLv=$LAST_TRY_LV
threads=$THREADS
closePending=$CLOSE_PENDING
EOF

echo "Fichier config.ini généré avec succès."