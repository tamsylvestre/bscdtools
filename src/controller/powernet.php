<?php

    require_once("src/lib/utils.php");

    require_once("src/repository/PowernetRepo.php");

    class C_Powernet
    {
        private $repo;

        public function __construct()
        {
             CheckUserConnect();
            $this->repo = new PowernetRepository(new DbConnect());
            
        }

        function users()
        {
            $users = $this->repo->getAllUsers();

            require("template/powernet_users.php");
        }

        function saleslogs()
        {
            $ventes = [];
            $output = "";
            $periode = "";
            $partenaire = "";

            if (!empty($_REQUEST['periode']))
            {
                $tab = explode('|',$_REQUEST['periode']);
                $debut = $tab[0];
                $fin = $tab[1];
                // $partenaires = $_REQUEST['partenaire'];
                $partenaire = $_REQUEST['partenaire'];
                $periode = "Vente du partenanire : <code> $partenaire </code> Du ".$debut." Au ".$fin;
                
                $folder = "./template/exports/powernet/saleslogs/*";

                // Récupère tous les fichiers correspondant au pattern
                $files = glob($folder); 

                foreach($files as $file){
                    if(is_file($file)) {
                        unlink($file); // Supprime le fichier
                    }
                }

                // foreach ($partenaires as $partenaire) {
                //     $output = $output . $this->repo->getSalesLogs($debut,$fin,$partenaire);
                // }

                $output = $output . $this->repo->getSalesLogs($debut,$fin,$partenaire);

                $folder = "./template/exports/powernet/saleslogs/*";

                // Récupère tous les fichiers correspondant au pattern
                $ventes = glob($folder);
            }

            require("template/powernet_saleslogs.php");
        }

        function buyhisto()
        {
            $achats = [];
            $periode = "";

            if(isset($_POST['periode']))
            {
                $compteur = $_POST['compteur'];
                $tab = explode("|",$_POST['periode']);
                $statement = 
                "
                    with all_data as (
                    select '$compteur' meter_no from dual
                    )
                    SELECT
                        ot.ordersid,
                        om.meterno,
                        yh.hh contract,
                        yh.hm customer_name,
                        pos.posname pos,
                        ot.token,
                        to_char(ot.op_time,'MM') month,
                        to_char(ot.op_time,'YYYY') year,
                        ot.op_time,
                        om.ENERGY,
                        om.tenderamt,
                        om.company_tenderamt,
                        om.charge_amount,
                        om.company_charge_amount,
                        om.total_amount,
                        om.COMPANY_ACCOUNT_ID
                    FROM all_data a 
                        LEFT JOIN prepaid.order_master om on om.meterno = a.meter_no
                        LEFT JOIN prepaid.order_token  ot ON om.ordersid = ot.ordersid
                        LEFT JOIN prepaid.da_yh yh on yh.hh = om.accountno
                        left join prepaid.pos_station pos on om.posid = pos.posid
                    WHERE
                        om.order_type in ('01')
                        AND ot.op_time >= TO_DATE('$tab[0] 00:00:00', 'YYYY-MM-DD HH24:MI:SS')
                        AND ot.op_time <  TO_DATE('$tab[1] 00:00:00', 'YYYY-MM-DD HH24:MI:SS')
                        order by op_time desc
                ";
                // var_dump($statement);
                $achats = $this->repo->getWithParams($statement,[]);
                $periode = "Achat du compteur ".$compteur. " Du $tab[0] Au $tab[1]";

            }

            require("template/powernet/buyhisto.php");
        }

    }