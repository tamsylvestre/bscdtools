<?php

    require_once('src/lib/database.php');
    require_once("src/model/indicateur.php");

    class IndicateurRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM indicateur order by ordre"
            );


            $statement->execute();
            
            $unites = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $unite = new Indicateur();
                $unite->idindicateur =$row['idindicateur'];
                $unite->description =$row['description'];
                $unite->unite =$row['unite'];
                $unite->service =$row['service'];
                $unite->domaine =$row['domaine'];
                $unite->responsable =$row['responsable'];
                $unite->typeEcart =$row['typeEcart'];

                $unites[]= $unite;
            }
            
            return $unites;

        }

        public function getByService($idservice):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM indicateur WHERE service = :idservice"
            );

            $statement->bindParam(':idservice', $idservice);

            $statement->execute();
            
            $unites = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $unite = new Indicateur();
                $unite->idindicateur =$row['idindicateur'];
                $unite->description =$row['description'];
                $unite->unite =$row['unite'];
                $unite->service =$row['service'];
                $unite->domaine =$row['domaine'];
                $unite->responsable =$row['responsable'];
                $unite->typeEcart =$row['typeEcart'];

                $unites[]= $unite;
            }
            
            return $unites;

        }

        public function getByDomaine($iddomaine):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM indicateur WHERE domaine = :iddomaine"
            );

            $statement->bindParam(':iddomaine', $iddomaine);

            $statement->execute();
            
            $unites = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $unite = new Indicateur();
                $unite->idindicateur =$row['idindicateur'];
                $unite->description =$row['description'];
                $unite->unite =$row['unite'];
                $unite->service =$row['service'];
                $unite->domaine =$row['domaine'];
                $unite->responsable =$row['responsable'];
                $unite->typeEcart =$row['typeEcart'];

                $unites[]= $unite;
            }
            
            return $unites;

        }

        public function getByResponsable($userid):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM indicateur WHERE responsable = :userid"
            );

            $statement->bindParam(':userid', $userid);

            $statement->execute();
            
            $unites = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $unite = new Indicateur();
                $unite->idindicateur =$row['idindicateur'];
                $unite->description =$row['description'];
                $unite->unite =$row['unite'];
                $unite->service =$row['service'];
                $unite->domaine =$row['domaine'];
                $unite->responsable =$row['responsable'];
                $unite->typeEcart =$row['typeEcart'];

                $unites[]= $unite;
            }
            
            return $unites;

        }

    }