<?php

    require_once('src/lib/database.php');
    require_once("src/model/domaine.php");

    class DomaineRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM domaine"
            );


            $statement->execute();
            
            $domaines = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $domaine = new Domaine();
                $domaine->iddomaine =$row['iddomaine'];
                $domaine->description =$row['description'];

                $domaines[]= $domaine;
            }
            
            return $domaines;

        }

        public function getById($iddomaine):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM domaine WHERE iddomaine = :iddomaine"
            );

            $statement->bindParam(':iddomaine', $iddomaine);

            $statement->execute();
            
            $domaines = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $domaine = new Domaine();
                $domaine->iddomaine =$row['iddomaine'];
                $domaine->description =$row['description'];

                $domaines[]= $domaine;
            }
            
            return $domaines;

        }

        public function getByService($idservice):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM domaine WHERE iddomaine IN ( SELECT domaine FROM indicateur WHERE service = :idservice )"
            );

            $statement->bindParam(':idservice', $idservice);

            $statement->execute();
            
            $domaines = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $domaine = new Domaine();
                $domaine->iddomaine =$row['iddomaine'];
                $domaine->description =$row['description'];

                $domaines[]= $domaine;
            }
            
            return $domaines;

        }

        public function getByResponsable($userid):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM domaine WHERE iddomaine IN ( SELECT domaine FROM indicateur WHERE responsable = :responsable )"
            );

            $statement->bindParam(':responsable', $userid);

            $statement->execute();
            
            $domaines = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $domaine = new Domaine();
                $domaine->iddomaine =$row['iddomaine'];
                $domaine->description =$row['description'];

                $domaines[]= $domaine;
            }
            
            return $domaines;

        }
    }