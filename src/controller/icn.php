<?php

    require_once("src/lib/utils.php");

    require_once("src/repository/IcnRepo.php");

    class C_Icn
    {
        private $repo;

        public function __construct()
        {
            CheckUserConnect();
            $this->repo = new IcnRepository(new DbConnect());
            
        }

        function users()
        {
            $request = "
                    SELECT
                        u.unit,
                        u.name,
                        u.email,
                        u.`status`,
                        u.roles,    
                        DATE(u.createdAt)  createdAt,
                        DATE(t.last_login_at) last_login_at
                    FROM v_users u
                    LEFT JOIN (
                        SELECT a.userid, MAX(a.created_at) AS last_login_at
                        FROM audits a
                        WHERE a.endpoint = '/login'
                        GROUP BY a.userid
                    ) t ON t.userid = u.id
                    ORDER BY t.last_login_at DESC;
                ";
            $users = $this->repo->getAll($request);

            require("template/icn_users.php");
        }

        function aci_brute()
        {
            $acis = [];
            $periode = "";

            if(isset($_REQUEST['periode']))
            {
                $tab = explode('|',$_REQUEST['periode']);
                $debut = $tab[0];
                $fin = $tab[1];
                $periode = "ACI Créé du ".$debut.' Au '.$fin;
                $request = 
                "
                    SELECT 
                        t.reference, t.name, t.region, t.unit, t.status, 
                        t.reasonForRefusal, t.bank, t.branch, t.town, 
                        t.amount, t.paymentDate, t.paymentMode, 
                        t.createdAt, t.updatedAt
                    FROM v_transactions t
                    WHERE t.createdAt BETWEEN '$debut 00:00:00' AND '$fin 23:59:59'
                    ORDER BY t.updatedAt DESC            
                ";

                $acis =  $this->repo->getAll($request);
            }

            require("template/aci_brute.php");
        }

        
        function Unapplied_aci()
        {
            $fichiers = [];
            $output = "";
            $periode = "";

            if (!empty($_REQUEST['periode']))
            {
                $tab = explode('|',$_REQUEST['periode']);
                $debut = $tab[0];
                $fin = $tab[1];
                $periode = "ACI Créé Du ".$debut." Au ".$fin." non appliqué dans CMS";
                // var_dump($_POST);

                $folder = "./template/exports/aci/unapplied/*";

                // Récupère tous les fichiers correspondant au pattern
                $files = glob($folder); 

                foreach($files as $file){
                    if(is_file($file)) {
                        unlink($file); // Supprime le fichier
                    }
                }

                $this->repo->unapplied($debut,$fin);

                $folder = "./template/exports/aci/unapplied/*";

                // Récupère tous les fichiers correspondant au pattern
                $fichiers = glob($folder);
            }

            require("template/aci/unapplied_aci.php");
        }

        function cancel_aci()
        {
            $aci = [];
            $aci_details = [];
            $error = "";
            $visible = "invisible";

            if(isset($_REQUEST['reference']))
            {
                if(isset($_REQUEST['motif']))
                {
                    $error = "ACI ".$_REQUEST['reference']." annulé!!!";
                    $request = "UPDATE transactions SET statusId=5 , reasonForRefusal='".$_REQUEST['motif']."' WHERE reference IN ('".$_REQUEST['reference']."')";
                    
                    $request = "DELETE FROM transaction_details WHERE transactionId IN (SELECT id FROM transactions WHERE REFERENCE IN ('".$_REQUEST['reference']."'))";
                }

                $request = 
                "
                    SELECT 
                        t.reference, t.name, t.region, t.unit, t.status, 
                        t.reasonForRefusal, t.bank, t.branch, t.town, 
                        t.amount, t.paymentDate, t.paymentMode, 
                        t.createdAt, t.updatedAt
                    FROM v_transactions t
                    WHERE t.reference = '".$_REQUEST['reference']."'           
                ";

                $aci =  $this->repo->getOne($request);

                $request = 
                "
                SELECT * FROM transaction_details WHERE transactionId IN (SELECT id FROM transactions WHERE REFERENCE IN ('".$_REQUEST['reference']."'))
                ";
                $aci_details =  $this->repo->getAll($request);

                if(sizeof($aci)<=0){
                        $error = "ACI INEXISTANT";
                }
                else
                {
                    if( $aci['status'] != 'treated' )
                        $visible = "";
                }
            }

            require("template/aci/cancel.php");
        }

    }