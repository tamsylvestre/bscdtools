<?php

    use PhpOffice\PhpSpreadsheet\IOFactory;

    require_once("src/lib/utils.php");
    require_once("src/repository/AciRepo.php");

    class C_Aci
    {
        private $repo;

        public function __construct()
        {
            $this->repo = new AciRepository(new DbConnect());
            
        }

        function report()
        {
            $output = "";
            $periode = "";
            $creatednotaccounted = [];


            if (!empty($_FILES))
            {                
               $folder = "./template/exports/aci/creatednotaccounted/*";

                // Récupère tous les fichiers correspondant au pattern
                $files = glob($folder); 

                foreach($files as $file){
                    if(is_file($file)) {
                        unlink($file); // Supprime le fichier
                    }
                }

                $folder = "./template/uploads/aci/report/*";

                // Récupère tous les fichiers correspondant au pattern
                $files = glob($folder); 

                foreach($files as $file){
                    if(is_file($file)) {
                        unlink($file); // Supprime le fichier
                    }
                }

                $debut =$_POST['dateCreation'];
                
                $file = ROOT.'/template/uploads/aci/report/ref_aci.xlsx';
                move_uploaded_file($_FILES['ref']['tmp_name'], $file);

                $creatednotaccounted =  $this->repo->creatednotaccounted($file,$debut);

                $folder = "./template/exports/aci/creatednotaccounted/*";
                // Récupère tous les fichiers correspondant au pattern
                $creatednotaccounted = glob($folder);
            }

            require("template/aci/report.php");
        }

    }