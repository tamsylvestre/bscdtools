drop table if exists batch_execution;
CREATE TABLE batch_execution (
    batch_id     VARCHAR2(64) PRIMARY KEY,
    batch        VARCHAR2(32),
    startAt      DATE,
    endAt        DATE,
    beginWith    NUMBER,
    endWith      NUMBER,
    return_code  NUMBER,
    status       VARCHAR2(20),
    duration     NUMBER
);

CREATE TABLE batch_list (
    batch_name   VARCHAR2(50) PRIMARY KEY,
    sql_count    CLOB NOT NULL
);


INSERT INTO batch_execution(batch_id,batch,startAt,beginWith,status) 
SELECT 'ID', 'CALC_CSMO', SYSDATE, t.c, 'RUNNING' FROM (     
SELECT
    COUNT(*) c
FROM itifact
WHERE ind_tratado = 2
  AND ind_embalsado = 2
  AND f_actual > SYSDATE - 30
) t

UPDATE batch_execution SET endAt = SYSDATE, endWith = ( $COUNT_QUERY ), return_code = 'code', status = 'END', duration = ROUND((SYSDATE-startAt)*24*60*60) WHERE batch_id='ID'


INSERT INTO batch_list VALUES (
'lecc510',
'SELECT COUNT(*) c FROM ciclos_itin WHERE est_ciclo_itin=''IR009'''
);

INSERT INTO batch_list VALUES (
'lecc600',
'SELECT COUNT(*) c FROM itiner_aus WHERE EST_LECT=''EL003'''
);

INSERT INTO batch_list VALUES (
'lecc540',
'SELECT COUNT(*) c FROM ciclos_itin WHERE est_ciclo_itin=''IR005'''
);

INSERT INTO batch_list VALUES (
'calc_csmo',
'SELECT COUNT(*) c FROM itifact WHERE ind_tratado=2 AND ind_embalsado=2 AND f_actual>SYSDATE-30'
);

INSERT INTO batch_list VALUES (
'estimation',
'SELECT COUNT(*) c FROM sum_estimar WHERE ind_tratado=2 AND ind_embalsado=2 AND f_actual>SYSDATE-30'
);

INSERT INTO batch_list VALUES (
'facc000',
'SELECT COUNT(*) c FROM serv_facturar WHERE ind_fact=2 AND ind_embalsado=2 AND f_actual>SYSDATE-30'
);

INSERT INTO batch_list VALUES (
'cb_split',
'SELECT COUNT(*) c FROM recibos_dispatch WHERE f_actual>SYSDATE-30 AND est_act=''ER010'''
);

INSERT INTO batch_list VALUES (
'cb_conv',
'SELECT COUNT(*) c FROM recibos_dispatch WHERE f_actual>SYSDATE-30 AND est_act=''ER015'''
);

INSERT INTO batch_list VALUES (
'cb_stprod',
'SELECT COUNT(*) c FROM imagenes_dispatch WHERE f_actual>SYSDATE-30 AND est_imagen=''PS001'''
);

INSERT INTO batch_list VALUES (
'cb_stext',
'SELECT COUNT(*) c FROM imagenes_dispatch WHERE f_actual>SYSDATE-30 AND est_imagen=''PS002'''
);



DROP IF EXIST copy_mms_config
CREATE TABLE copy_mms_config (
    cycle   INTEGER,
    migration    INTEGER
);

DROP IF EXIST copy_mms_report
CREATE TABLE copy_mms_report (
    cycle   INTEGER,
    migration    INTEGER,
    client  VARCHAR2(4),
    compteur_avant_migration INTEGER,
    compteur_apres_migration INTEGER,
    itineraire_avant_migration INTEGER,
    itineraire_apres_migration INTEGER,

    PRIMARY KEY(cycle,client,migration)
);

DROP IF EXIST copy_mms_fermeture_manuel
CREATE TABLE copy_mms_fermeture_manuel (
    cycle   INTEGER,
    migration    INTEGER,
    client  VARCHAR2(4),
    compteur_avant_migration INTEGER,
    compteur_apres_migration INTEGER,

    PRIMARY KEY(cycle,client,migration)
);