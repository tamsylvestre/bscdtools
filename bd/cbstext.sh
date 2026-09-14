#!/bin/ksh

. /home/profadm/default.sh
. ~/bin/sel_env.sh 1

BIN_DIR=/home/op_ascms/cmsprod/tbatch/bin
PROD_DIR=/home/op_ascms/cmsprod/tbatch/cms_mra/prod

ID=$(uuidgen | tr -d '-')
BATCH=cb_stext

cd "$PROD_DIR" || exit 1

./insert.sh START "$ID" "$BATCH"

START_TIME=$(date +%s)

cd "$BIN_DIR" || exit 1

echo
echo "===================================================="
echo -e "\n\tRunning $BATCH for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo "===================================================="


# ------------------------------------------------------
# Fonction qui exécute les 4 control
# ------------------------------------------------------
run_controls()
{
    RET_GLOBAL=0

    echo
    echo "========== CONTROL 1 : cb_stExt =========="
    ./control -pcb_stExt -n15 -s32000 -m65536 --p -b1 --c -gn -o1
    RET1=$?
    echo "[CONTROL] cb_stExt terminé - Code retour : $RET1"

    if [ "$RET1" -ne 0 ]; then
        RET_GLOBAL=1
    fi


    echo
    echo "========== CONTROL 2 : cb_stExt_grouped -bs =========="
    ./control -pcb_stExt_grouped -n7 -s32000 -m65536 --p -b1 --c -b1 -bs
    RET2=$?
    echo "[CONTROL] cb_stExt_grouped -bs terminé - Code retour : $RET2"

    if [ "$RET2" -ne 0 ]; then
        RET_GLOBAL=1
    fi


    echo
    echo "========== CONTROL 3 : cb_stExt_grouped -bg =========="
    ./control -pcb_stExt_grouped -n7 -s32000 -m65536 --p -b1 --c -b1 -bg
    RET3=$?
    echo "[CONTROL] cb_stExt_grouped -bg terminé - Code retour : $RET3"

    if [ "$RET3" -ne 0 ]; then
        RET_GLOBAL=1
    fi


    echo
    echo "========== CONTROL 4 : cb_stExt_mv =========="
    ./control -pcb_stExt_mv -n1 -s32000 -m65536 --p -b1 --c -gk -o1
    RET4=$?
    echo "[CONTROL] cb_stExt_mv terminé - Code retour : $RET4"

    if [ "$RET4" -ne 0 ]; then
        RET_GLOBAL=1
    fi


    echo
    echo "===================================================="
    echo "Résultats des controls :"
    echo "  cb_stExt             : $RET1"
    echo "  cb_stExt_grouped -bs : $RET2"
    echo "  cb_stExt_grouped -bg : $RET3"
    echo "  cb_stExt_mv          : $RET4"
    echo "Code retour global     : $RET_GLOBAL"
    echo "===================================================="

    return $RET_GLOBAL
}


# ------------------------------------------------------
# Lancement des 4 controls en arrière-plan
# ------------------------------------------------------
run_controls &

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


# ------------------------------------------------------
# Fin du batch
# ------------------------------------------------------
END_TIME=$(date +%s)

echo "===================================================="
echo -e "\tEnd of $BATCH for \"$(encrypt -d -i FECHAB)\"\t\tTime is :: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo "Code retour : $RET"
echo "Durée shell : $((END_TIME-START_TIME)) s"
echo "===================================================="


cd "$PROD_DIR" || exit 1

./insert.sh END "$ID" "$BATCH" "$RET"

exit $RET