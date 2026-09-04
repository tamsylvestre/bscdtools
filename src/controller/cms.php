<?php

    use PhpOffice\PhpSpreadsheet\IOFactory;

    require_once("src/lib/utils.php");

    require_once("src/repository/CmsRepo.php");

    class C_Cms
    {
        private $repo;

        public function __construct()
        {
            $this->repo = new CmsRepository(new DbConnect());
            
        }

        function users()
        {
            $users = $this->getUsers();

            require("template/cms_users.php");
        }

        function asc()
        {       
            $asc=[];   
                if (!empty($_FILES['ref']['tmp_name']))
                {
                    $file = __DIR__ . '/uploads/ref_asc.xlsx';
                    move_uploaded_file($_FILES['ref']['tmp_name'], $file);

                    if (!is_file($file)) { die("Erreur Fichier introuvable"); }

                    $spreadsheet = IOFactory::load($file);
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray(null, true, true, true); // valeurs formatées, clés A,B,C...

                    $count = sizeof($rows);

                    $req1="";
                    for($i=2; $i<=$count; $i++)
                    {
                        $val = $sheet->getCell('A'.$i)->getValue();
                        $txt ="select ".$val." nis_rad from dual \r\n";
                        if($i<$count)
                            $txt = $txt."union \r\n";
                        $req1 = $req1.$txt;
                    }

                    $cycle = $_REQUEST['cycle'];
                    $annee = $_REQUEST['annee'];
                    
                    $req = "with all_data as (".$req1."
                        ) select distinct a.nis_rad service_no, i.cust_name, i.nom_unicom agency, ".$cycle." reading_cycle, i.regroup_id,
                                i.regroup_name, ".$annee." calendar_year, i.pk_cust_id old_account_no, i.meter_no,
                                NULL number_wires,i.pot_max_admis subscription_load, r.num_rec billing_date,to_char(r.f_fact,'YYYY-MM-DD') billing_date,
                                r.f_prev_puesta dispatch_date, r.imp_tot_rec amount_with_tax, (r.imp_tot_rec - r.imp_cta) due_amount,
                                estado(r.est_act) bill_status, substr(tipo(tip_contr),1,2) cat_cli ,
                                sum (case when c.co_concepto not like 'CT%' then c.imp_concepto else 0 end) over(partition by r.num_rec) amount_without_vat,
                        trunc ((sum (case when c.co_concepto not like 'CT%' then -c.imp_concepto else 0 end) over(partition by r.num_rec)) + r.imp_tot_rec) amount_vat,
                        tipo(r.tip_rec) bill_type
                        from all_data a
                        left join recibos r on r.nis_rad = a.nis_rad and r.tip_rec in('TR022','TR040')
                        left join cmsreport.tb_customers_infos i on i.nis_rad= a.nis_rad
                        left JOIN imp_concepto c ON r.num_rec = c.num_rec
                    ";
                    
                    $asc = $this->repo->getASC($req);
                }
                require('template/asc.php');
        }

        function annulation()
        {
            $annulations = [];
            $output = "";
            $periode = "";

            if (!empty($_REQUEST['periode']))
            {
                $tab = explode('|',$_REQUEST['periode']);
                $debut = $tab[0];
                $fin = $tab[1];
                $periode = $debut." Au ".$fin;

                $statement = "
                    select distinct
                    nis_rad contrat,
                        (r.num_rec) facture,
                        sum (case when i.co_concepto not like 'CT%' then i.imp_concepto else 0 end) over(partition by r.num_rec) montants_HT,
                        trunc ((sum (case when i.co_concepto not like 'CT%' then -i.imp_concepto else 0 end) over(partition by r.num_rec)) + r.imp_tot_rec) TVA,
                        imp_tot_rec montant_TTC,
                        f_fact date_facturation,
                        f_prev_puesta dispatch_date,
                        f_est_act date_annulation,
                        CASE WHEN cod_tar LIKE '3%' THEN 'MT' ELSE 'BT' END type_client
                    FROM recibos r
                    left JOIN imp_concepto i ON r.num_rec = i.num_rec
                    WHERE est_act IN ('ER600', 'ER630', 'ER900') AND f_fact BETWEEN DATE '".$debut."' AND DATE'".$fin."'-1/86400
                    ORDER BY r.num_rec desc
                ";

                $output = $this->repo->getAnnulations($statement);

                $folder = "./template/exports/annulations/*";

                // Récupère tous les fichiers correspondant au pattern
                $annulations = glob($folder);
            }
            require("template/annulation.php");
        }

        function aci_encaisses()
        {
            $periode = "";
            $acis = [];

            if (!empty($_REQUEST['periode']))
            {
                $tab = explode('|',$_REQUEST['periode']);
                $debut = $tab[0];
                $fin = $tab[1];

                $periode = "ACI encaissés du ".$debut." Au ".$fin;


                $statement = "
                    SELECT
                        c.*,
                        CASE WHEN e.type_operation IS NULL THEN 'AUTRES' END AS type_operation,
                        e.nom_client
                    from
                    (
                    select /*+ parallel(8) */ distinct

                                (case
                                            when regexp_like(c.datos_pago,'ACI No:[a-zA-Z0-9\.]+')
                                                        then regexp_replace(regexp_substr(c.datos_pago, '@ACI No:[a-zA-Z0-9\.]+@'),'(\.0+)|E[0-9]|[^0-9]')
                                            else
                                                        regexp_replace(regexp_substr(c.comentarios_cli,'BP[0-9\.]+@'), 'BP|(\.0+)|@')
                                end) numero_aci,

                                to_char(g.f_actual, 'dd/mm/yyyy') date_traitement,
                                num_recibos nombre_factures_traitees,
                                imp_gest_cobro montant_aci
                    from cmsadmin.gestiones_cobro g
                    join cmsadmin.cobtemp c on c.num_gest_cobro = g.num_gest_cobro and g.cod_caja = c.cod_caja
                    WHERE g.cod_caja = 5701473 AND g.f_actual >= TO_DATE('$debut', 'YYYY-MM-DD') AND g.f_actual <= TO_DATE('$fin', 'YYYY-MM-DD')
                    ) c
                    LEFT JOIN kpirhextract.elements_aci e ON e.numero_aci = c.numero_aci
                    order by c.date_traitement
                ";

                $acis = $this->repo->getAll($statement);

            }
            require("template/aci_encaisses.php");
        }

        function customer_list()
        {
            $files = [];
            $output = "";   
            
            $regions = $this->repo->getBusinessStructElement("REGION");
            $divisions = $this->repo->getBusinessStructElement("DIVISION");
            $agences = $this->repo->getBusinessStructElement("AGENCE");
            $statuts = $this->repo->getBusinessStructElement("STATUS");

            $region = "all";
            $division = "all";
            $agence = "all";
            $statut = "all";
            $abonnement = "";
            
            if(isset($_REQUEST['region']))
            {
                $region = ($_REQUEST['region'] == 'all') ? "" : $_REQUEST['region'];
                $division = ($_REQUEST['division'] == 'all') ? "" : $_REQUEST['division'];
                $agence = ($_REQUEST['agence'] == 'all') ? "" : $_REQUEST['agence'];
                $statut = ($_REQUEST['status'] == 'all') ? "" : $_REQUEST['status'];
                
                $statement = "
                        SELECT
                            REGION,
                            DIVISION,
                            AGENCE,
                            COD_UNICOM,
                            COD_CLI,
                            CONTRACT,
                            STATUS,
                            METER_NO,
                            CUST_NAME,
                            PHONE_NUMBERS,
                            E_MAIL,
                            REF_GEO,
                            DATE_AB,
                            DATE_RESILIATION,
                            VOLTAGE,
                            SEGMENT_TRESOR,
                            METER,
                            NIU_RIGHT,
                            NUI_QC,
                            LAST_VC_DATE,
                            SEGMENT_RFM_2,
                            POSTPAID_PROFILE_DATE,
                            SEGMENTATION
                        FROM CMS_RFC.TB_CUSTOMERS_LIST
                        WHERE
                        REGION LIKE '%$region%' AND
                        DIVISION LIKE '%$division%' AND 
                        AGENCE LIKE '%$agence%' AND
                        STATUS LIKE '%$statut%'
                    ";

                if(!empty($_REQUEST['abonnement'])){
                    $tab = empty($_REQUEST['abonnement']) ? ['',''] : explode('|',$_REQUEST['abonnement']);
                    $day1 = $tab[0];
                    $day2 = $tab[1];
                    $abonnement = $_REQUEST['abonnement'];

                    $statement = "
                        SELECT
                            REGION,
                            DIVISION,
                            AGENCE,
                            COD_UNICOM,
                            COD_CLI,
                            CONTRACT,
                            STATUS,
                            METER_NO,
                            CUST_NAME,
                            PHONE_NUMBERS,
                            E_MAIL,
                            REF_GEO,
                            DATE_AB,
                            DATE_RESILIATION,
                            VOLTAGE,
                            SEGMENT_TRESOR,
                            METER,
                            NIU_RIGHT,
                            NUI_QC,
                            LAST_VC_DATE,
                            SEGMENT_RFM_2,
                            POSTPAID_PROFILE_DATE,
                            SEGMENTATION
                        FROM CMS_RFC.TB_CUSTOMERS_LIST
                        WHERE
                        REGION LIKE '%$region%' AND
                        DIVISION LIKE '%$division%' AND
                        AGENCE LIKE '%$agence%' AND
                        STATUS LIKE '%$statut%' AND
                        DATE_AB >= TO_DATE('$day1', 'YYYY-MM-DD') AND
                        DATE_AB <= TO_DATE('$day2', 'YYYY-MM-DD')";
                }

                // var_dump($statement);

                $output = $this->repo->getCustomerList($statement);

                $folder = "./template/exports/customer_list/*";

                // Récupère tous les fichiers correspondant au pattern
                $files = glob($folder);
            }

            require("template/customer_list.php");
        }

        private function getUsers():array
        {
            $statement = 
            "
                        SELECT DISTINCT s.nom_area, s.nom_zona, a.cod_unicom, b.nom_unicom, u.nom_usr,
                        a.desc_usr, u.nom_perfil, p.desc_perfil,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 1, 10))
                                                                    AS second_profile,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 12, 10))
                                                                AS aux_sec_profile_1,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 23, 10))
                                                                AS aux_sec_profile_2,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 34, 10))
                                                                AS aux_sec_profile_3,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 45, 10))
                                                                AS aux_sec_profile_4,
                        (SELECT m.desc_perfil
                        FROM cmsadmin.usuario_perfil_sec t,
                                cmsadmin.perfiles m
                        WHERE t.nom_usr = u.nom_usr
                            AND m.nom_perfil = SUBSTR (t.nom_perfil_det, 56, 10))
                                                                AS aux_sec_profile_5,
                        u.f_actual AS last_modification_date,
                                                    (SELECT max(f_actual)
                        FROM icsaudit.adt_usuario u where desc_action  = 'CREATED' and nom_usr =a.nom_usr) as creation_date,
                        (SELECT max(usuario)
                        FROM icsaudit.adt_usuario u where desc_action  = 'CREATED' and nom_usr =a.nom_usr) as creation_by,
                        (SELECT max(f_actual)
                        FROM icsaudit.adt_usuario u where desc_action  = 'PASSWORD CHANGE' and nom_usr =a.nom_usr) as last_changed_password
                                FROM cmsadmin.usuario_perfil u,
                                        cmsadmin.perfiles p,
                                        cmsadmin.usuarios a,
                                        cmsadmin.unicom b,
                                        cmsadmin.business_struct s
                                WHERE u.nom_perfil = p.nom_perfil
                                    AND a.nom_usr = u.nom_usr
                                    AND b.cod_unicom = a.cod_unicom
                                    AND s.cod_unicom = b.cod_unicom
                ";

            return $this->repo->getAllUsers($statement);
        }
    }