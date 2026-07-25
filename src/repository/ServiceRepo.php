<?php

    require_once('src/lib/database.php');
    require_once("src/model/service.php");

    class ServiceRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM service"
            );


            $statement->execute();
            
            $services = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $service = new Service();
                $service->idservice =$row['idservice'];
                $service->description =$row['description'];

                $services[]= $service;
            }
            
            return $services;

        }
        
        public function getById($idservice):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM service WHERE idservice = :idservice"
            );

            $statement->bindParam(':idservice', $idservice);

            $statement->execute();
            
            $services = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $service = new Service();
                $service->idservice =$row['idservice'];
                $service->description =$row['description'];

                $services[]= $service;
            }
            
            return $services;

        }

        public function getByDomaine($iddomaine):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM service WHERE idservice IN ( SELECT service FROM indicateur WHERE domaine = :iddomaine ) "
            );

            $statement->bindParam(':iddomaine', $iddomaine);
            $statement->execute();
            
            $services = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $service = new Service();
                $service->idservice =$row['idservice'];
                $service->description =$row['description'];

                $services[]= $service;
            }
            
            return $services;

        }

        public function getByResponsable($userid):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM service WHERE idservice IN ( SELECT service FROM indicateur WHERE responsable = :responsable ) "
            );

            $statement->bindParam(':responsable', $userid);
            $statement->execute();
            
            $services = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $service = new Service();
                $service->idservice =$row['idservice'];
                $service->description =$row['description'];

                $services[]= $service;
            }
            
            return $services;

        }
    }