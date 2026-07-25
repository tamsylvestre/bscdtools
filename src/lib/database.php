<?php

    class DbConnect
    {
        public ?PDO $database = null;


        public function getDb(): PDO
        {
            if($this->database === null)
            {
                try{
                    $this->database = new PDO('mysql:host=127.0.0.1;dbname=extractor;charset=utf8', 'extractor', 'extractor',[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false]);
                    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->database;
                }catch(PDOException $e){
                    $error = "ERREUR DE CONNEXION".$e->getMessage();
                    require("template/error.php");
                    die();
                }
            }

            return $this->database;
        }

        public function getSmartcashDb(): PDO
        {
            if($this->database === null)
            {
                try{
                    $this->database = new PDO('mysql:host=192.167.0.9;dbname=smobilpay_core;charset=utf8', 'smart_audit', 'R@nd0m_1',[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false]);
                    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->database;
                }catch(PDOException $e){
                    $error = "ERREUR DE CONNEXION".$e->getMessage();
                    require("template/error.php");
                    die();
                }
            }

            return $this->database;
        }

        public function getICNDb(): PDO
        {
            if($this->database === null)
            {
                try{
                    $this->database = new PDO('mysql:host=10.241.132.188;dbname=icn_cashing;charset=utf8', 'icncashing', 'icnCMR_2030+',[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false]);
                    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->database;
                }catch(PDOException $e){
                    $error = "ERREUR DE CONNEXION".$e->getMessage();
                    require("template/error.php");
                    die();
                }
            }

            return $this->database;
        }

        public function getPowertnetDB()
        {
            try {
                $conn = oci_connect('PP_Query', 'PP_123Query', '//10.250.139.23:1526/VENDING_DR', 'AL32UTF8');
            
                if (!$conn) {
                    $e = oci_error();
                    throw new Exception($e['message']);
                }
            
                return $conn;

            } catch (Exception $ex) {
                $error = "Erreur : " . $ex->getMessage();
                require('template/error.php');
                die();
            }

        }

        public function getCMSDb() 
        {
            try {
                // Chaîne de connexion via service name (recommandé)
                // $conn = oci_connect('UTILISATEUR', 'MOT_DE_PASSE', '//HOST:1521/SERVICE_NAME', 'AL32UTF8');
                $conn = oci_connect('CMS_RFC', 'CMS_2016_RFC', '//10.241.151.11:1521/cmsprod.global.aes.com', 'AL32UTF8');
                // sqlplus CMSRFC/CMS_2016_RFC@//10.241.107.44:1521/cmsprod.global.aes.com
            
                if (!$conn) {
                    $e = oci_error();
                    throw new Exception($e['message']);
                }
            
                return $conn;
                
                /*$sql = "SELECT SYSDATE FROM DUAL";
                $stid = oci_parse($conn, $sql);
                oci_execute($stid);
                $row = oci_fetch_array($stid, OCI_ASSOC);
                var_dump($row);
            
                oci_free_statement($stid);
                oci_close($conn);
                echo "Connexion Oracle OK (OCI8).";*/

            } catch (Exception $ex) {
                $error = "Erreur : " . $ex->getMessage();
                require('template/error.php');
                die();
            }
        }

    }


     


 