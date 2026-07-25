<?php

    require_once('src/lib/database.php');
    require_once("src/model/mois.php");

    class MoisRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM mois ORDER BY annee DESC, number DESC"
            );


            $statement->execute();
            
            $mois = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $month = new Mois();
                $month->annee =$row['annee'];
                $month->description =$row['description'];
                $month->number =$row['number'];
                $month->idmois =$row['idmois'];
                $month->status =$row['status'];

                $mois[]= $month;
            }
            
            return $mois;

        }

        public function save($mois)
        {
            try{

                $statement = $this->dbconnect->getConection()->prepare(
                    "INSERT INTO mois(idmois,description,number,annee,status) VALUES(:idmois,:description,:number,:annee,'OUVERT')"
                );

                $statement->bindParam(':idmois', $mois->idmois);
                $statement->bindParam(':description', $mois->description);
                $statement->bindParam(':number', $mois->number);
                $statement->bindParam(':annee', $mois->annee);

                $statement->execute();
            }
            catch(Exception $e)
            {
                print($e->getMessage());
            }

            return 0;

        }

        public function update($mois)
        {
            try{

                $statement = $this->dbconnect->getConection()->prepare(
                    "UPDATE mois SET status = :status WHERE idmois = :idmois"
                );

                $statement->bindParam(':idmois', $mois->idmois);
                $statement->bindParam(':status', $mois->status);

                $statement->execute();
            }
            catch(Exception $e)
            {
                print($e->getMessage());
            }

            return 0;

        }
    }