#!/bin/ksh

. /home/profadm/default.sh
. ~/bin/sel_env.sh 1

BIN_DIR=/home/op_ascms/cmsprod/tbatch/bin
PROD_DIR=/home/op_ascms/cmsprod/tbatch/cms_mra/prod


echo -e "\n\tRunning LECC0300 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
$BIN_DIR/LECC0300
echo -e "\tEnd of LECC0300 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"

cd "$PROD_DIR" || exit 1
ID=$(uuidgen | tr -d '-')
./insert.sh START "$ID" "lecc510"
echo -e "\n\tRunning LECC0510 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$BIN_DIR" || exit 1
control -pLECC0510 -n10 -s10000 -m32768
RET=$?
echo -e "\tEnd of LECC0510 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$PROD_DIR" || exit 1
./insert.sh END "$ID" "lecc510" "$RET"

ID=$(uuidgen | tr -d '-')
./insert.sh START "$ID" "lecc600"
echo -e "\n\tRunning LECC0600 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$BIN_DIR" || exit 1
control -pLECC0600 -n10 -s10000 -m32768
RET=$?
echo -e "\tEnd of LECC0600 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$PROD_DIR" || exit 1
./insert.sh END "$ID" "lecc600" "$RET"

ID=$(uuidgen | tr -d '-')
./insert.sh START "$ID" "lecc540"
echo -e "\n\tRunning LECC0540 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$BIN_DIR" || exit 1
control -pLECC0540 -n10 -s10000 -m32768
RET=$?
echo -e "\tEnd of LECC0540 for \""`encrypt -d -i FECHAB`"\"\t\tTime is :: `date +%Y-%m-%d' '%H':'%M':'%S`\n"
cd "$PROD_DIR" || exit 1
./insert.sh END "$ID" "lecc540" "$RET"

exit $RET