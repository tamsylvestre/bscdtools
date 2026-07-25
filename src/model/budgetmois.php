<?php
    class BudgetMois
    {
        public $indicateur;
        public $mois;
        public $budget;
        public $realise;
        public $budgetYTD;
        public $realiseYTD;
        public $commentaire;

        public $Indicateur;
        public $unite;


        public function setIndicateur($indicateurs)
        {
            foreach ($indicateurs as $indicateur) {
                if($indicateur->idindicateur == $this->indicateur)
                    $this->Indicateur = $indicateur;
            }
        }

        public function setUnite($unites)
        {
            foreach ($unites as $unite) {
                if($unite->unite == $this->Indicateur->unite)
                    $this->unite = $unite;
            }
        }
    }