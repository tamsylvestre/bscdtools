
BIN_DIR=/opt/openlink/gencode_batch/bin_amr
. /opt/openlink/.bash_profile_bin_amr

cd $BIN_DIR

ID=$(uuidgen | tr -d '-')
BATCH=lecc0250

# ./insert.sh START "$ID" "$BATCH"

START_TIME=$(date +%s)

cd "$BIN_DIR" || exit 1

echo
echo "===================================================="
echo -e "\n\tRunning $BATCH for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo "===================================================="

# ------------------------------------------------------
# Lancement du batch en arrière-plan
# ------------------------------------------------------
$BIN_DIR/LECC0250 &
PID=$!

echo "PID du batch : $PID"

# ------------------------------------------------------
# Heartbeat toutes les 60 secondes
# ------------------------------------------------------
while kill -0 "$PID" 2>/dev/null
do
    sleep 60

    if kill -0 "$PID" 2>/dev/null
    then
        echo "[HEARTBEAT] $BATCH toujours en cours - $(date '+%Y-%m-%d %H:%M:%S')"
    fi
done

# ------------------------------------------------------
# Attendre la fin réelle du processus et récupérer
# son code retour
# ------------------------------------------------------
wait "$PID"
RET=$?

END_TIME=$(date +%s)

echo "===================================================="
echo -e "\tEnd of $BATCH for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo "Code retour : $RET"
echo "Durée shell : $((END_TIME-START_TIME)) s"
echo "===================================================="

# ./insert.sh END "$ID" "$BATCH" "$RET"

exit $RET