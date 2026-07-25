<?php

    require_once('src/lib/database.php');

    class Repository
    {
        private $dbconnect;

        public function __construct()
        {
            $this->dbconnect = new DbConnect();;
        }

        public function getAll($request):array
        {
            try{
            
                $statement = $this->dbconnect->getDB()->prepare($request);
                
                $statement->execute();
                
                $output = [];

                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {        
                    $output[]= $row;
                }

                return $output;                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
            }

            return [];
        }

        public function getOne($request)
        {
            try{
            
                $statement = $this->dbconnect->getDB()->prepare($request);
                    
                $statement->execute();
                
                $output = [];

                if($row = $statement->fetch(PDO::FETCH_ASSOC))
                {        
                    $output = $row;
                }

                return $output;                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
            }

        }

        public function getAllWithParams($request,$params)
        {
            try{
                $statement = $this->dbconnect->getDB()->prepare($request);

                foreach ($params as $key => $value) {
                    $statement->bindValue(':'.$key, $value);
                }

                $statement->execute();

                $output = [];

                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {        
                    $output[] = $row;
                }

                return $output;
                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
                die();
            }
        }

        public function getOneWithParams($request,$params)
        {
            try{
            
                $statement = $this->dbconnect->getDB()->prepare($request);
                
                foreach ($params as $key => $value) {
                    $statement->bindValue(':'.$key, $value);
                }
                
                $statement->execute();
                
                $output = [];

                if($row = $statement->fetch(PDO::FETCH_ASSOC))
                {        
                    $output = $row;
                }

                return $output;                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
            }

        }

        public function insert($request,$params)
        {
            try{
                $statement = $this->dbconnect->getDB()->prepare($request);

                foreach ($params as $key => $value) {
                    $statement->bindValue(':'.$key, $value);
                }

                $statement->execute();
                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
                die();
            }
        }

        public function update($request,$params)
        {
            try{
                $statement = $this->dbconnect->getDB()->prepare($request);

                foreach ($params as $key => $value) {
                    $statement->bindValue(':'.$key, $value);
                }

                $statement->execute();
                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
                die();
            }
        }

        public function delete($request,$params)
        {
            try{
                $statement = $this->dbconnect->getDB()->prepare($request);

                foreach ($params as $key => $value) {
                    $statement->bindValue(':'.$key, $value);
                }

                $statement->execute();
                
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                require("template/error.php");
                die();
            }
        }

    }