#!/bin/ksh

. /home/profadm/default.sh
. ~/bin/sel_env.sh 1

BIN_DIR=/home/op_ascms/cmsprod/tbatch/bin

cd "$BIN_DIR" || exit 1

echo
echo "===================================================="
echo -e "\n\tRunning LECC0300 for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo "===================================================="

# ------------------------------------------------------
# Lancement de LECC0300 en arrière-plan
# ------------------------------------------------------
"$BIN_DIR/LECC0300" &

PID=$!

echo "PID de LECC0300 : $PID"

# ------------------------------------------------------
# Heartbeat toutes les 60 secondes
# ------------------------------------------------------
while kill -0 "$PID" 2>/dev/null
do
    sleep 60

    if kill -0 "$PID" 2>/dev/null
    then
        echo "[HEARTBEAT] LECC0300 toujours en cours - $(date '+%Y-%m-%d %H:%M:%S')"
    fi
done

# ------------------------------------------------------
# Attendre la fin réelle et récupérer le code retour
# ------------------------------------------------------
wait "$PID"
RET=$?

echo "===================================================="
echo -e "\tEnd of LECC0300 for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')"
echo "Code retour : $RET"
echo "===================================================="

exit $RET