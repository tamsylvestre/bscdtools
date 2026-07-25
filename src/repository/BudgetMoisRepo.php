<?php

    require_once('src/lib/database.php');
    require_once("src/model/budgetmois.php");

    class BudgetMoisRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM budget_mensuel"
            );


            $statement->execute();
            
            $budgets = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $budget = new BudgetMois();
                $budget->indicateur =$row['indicateur'];
                $budget->mois =$row['mois'];
                $budget->budget =$row['budget'];
                $budget->realise =$row['realise'];
                $budget->budgetYTD =$row['budgetYTD'];
                $budget->realiseYTD =$row['realiseYTD'];
                $budget->commentaire =$row['commentaire'];

                $budgets[]= $budget;
            }
            
            return $budgets;

        }

        public function getByService($idservice):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM budget_mensuel WHERE indicateur IN ( SELECT idindicateur FROM indicateur WHERE service = :idservice )"
            );

            $statement->bindParam(':idservice', $idservice);

            $statement->execute();
            
            $budgets = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $budget = new BudgetMois();
                $budget->indicateur =$row['indicateur'];
                $budget->mois =$row['mois'];
                $budget->budget =$row['budget'];
                $budget->realise =$row['realise'];
                $budget->budgetYTD =$row['budgetYTD'];
                $budget->realiseYTD =$row['realiseYTD'];
                $budget->commentaire =$row['commentaire'];

                $budgets[]= $budget;
            }
            
            return $budgets;

        }

        public function getByDomaine($iddomaine):array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM budget_mensuel WHERE indicateur IN ( SELECT idindicateur FROM domaine WHERE domaine = :iddomaine )"
            );

            $statement->bindParam(':iddomaine', $iddomaine);
            
            $statement->execute();
            
            $budgets = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $budget = new BudgetMois();
                $budget->indicateur =$row['indicateur'];
                $budget->mois =$row['mois'];
                $budget->budget =$row['budget'];
                $budget->realise =$row['realise'];
                $budget->budgetYTD =$row['budgetYTD'];
                $budget->realiseYTD =$row['realiseYTD'];
                $budget->commentaire =$row['commentaire'];

                $budgets[]= $budget;
            }
            
            return $budgets;

        }

        // public function getBudgetMois($mois):array
        // {
        //     $statement = $this->dbconnect->getConection()->prepare(
        //         "SELECT * FROM budget_mensuel WHERE mois = :mois"
        //     );

        //     $statement->bindParam(':mois', $mois);

        //     $statement->execute();
            
        //     $budgets = [];

        //     while($row = $statement->fetch(PDO::FETCH_ASSOC))
        //     {        
        //         $budget = new BudgetMois();
        //         $budget->indicateur =$row['indicateur'];
        //         $budget->mois =$row['mois'];
        //         $budget->budget =$row['budget'];
        //         $budget->realise =$row['realise'];
        //         $budget->budgetYTD =$row['budgetYTD'];
        //         $budget->realiseYTD =$row['realiseYTD'];

        //         $budgets[]= $budget;
        //     }
            
        //     return $budgets;

        // }
        
        public function save($budget)
        {
            try{
            $statement = $this->dbconnect->getConection()->prepare(
                "INSERT INTO budget_mensuel(indicateur,mois,budget,realise,budgetYTD,realiseYTD,commentaire) VALUES(:indicateur,:mois,:budget,:realise,:budgetYTD,:realiseYTD,:commentaire)"
            );

            $statement->bindParam(':indicateur', $budget->indicateur);
            $statement->bindParam(':mois', $budget->mois);
            $statement->bindParam(':budget', $budget->budget);
            $statement->bindParam(':realise', $budget->realise);
            $statement->bindParam(':budgetYTD', $budget->budgetYTD);
            $statement->bindParam(':realiseYTD', $budget->realiseYTD);
            $statement->bindParam(':commentaire', $budget->commentaire);

            $statement->execute();
            
            return $budget;
        }
        catch(Exception $e)
        {
            print( $e->getMessage() );
        }

        }

        public function update($budget)
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "UPDATE budget_mensuel SET budget = :budget ,realise = :realise,budgetYTD = :budgetYTD ,realiseYTD = :realiseYTD, commentaire = :commentaire WHERE indicateur =:indicateur AND mois =:mois"
            );

            $statement->bindParam(':indicateur', $budget->indicateur);
            $statement->bindParam(':mois', $budget->mois);
            $statement->bindParam(':budget', $budget->budget);
            $statement->bindParam(':realise', $budget->realise);
            $statement->bindParam(':budgetYTD', $budget->budgetYTD);
            $statement->bindParam(':realiseYTD', $budget->realiseYTD);
            $statement->bindParam(':commentaire', $budget->commentaire);

            $statement->execute();
            
            return $budget;

        }

        public function delete($budget)
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "DELETE FROM budget_annee WHERE indicateur =:indicateur AND mois =:mois"
            );

            $statement->bindParam(':indicateur', $budget->indicateur);
            $statement->bindParam(':mois', $budget->mois);

            $statement->execute();
            
            return $budget;

        }
        
    }