<?php
    class Indicateur
    {
        public $idindicateur;
        public $description;
        public $unite;
        public $service;
        public $domaine;
        public $responsable;
        
        public $typeEcart;
        public $Unite;
        public $budgets = [];

        public function setUnite($unites)
        {
            foreach ($unites as $unite) {
                if($unite->unite == $this->idindicateur)
                    $this->unite = $unite;
            }
        }

        public function setBudgets($budgets)
        {
            foreach ($budgets as $budget) {
                if($budget->indicateur == $this->idindicateur)
                    $this->budgets[] = $budget;
            }
        }
    }