<?php

use phpseclib3\Net\SFTP;

require_once("src/lib/utils.php");
require_once("src/repository/SmartcashRepo.php");

class C_Smartcash
{
    private $repo;

    public function __construct()
    {
        CheckUserConnect();
        $this->repo = new SmartcashRepository(new DbConnect());
    }

    function users()
    {
        $users = $this->repo->getAllUsers();

        require("template/smartcash_users.php");
    }

    function rapporttparties()
    {
        // Augmenter le timeout à 30 ou 60 secondes
        $sftp = new SFTP('10.250.90.200', 22, 60);

        if (!$sftp->login('sdsa.user', 'Sds@eneo')) {
            exit('Connexion échouée');
        }

        // Récupération du contenu
        $contenu = $sftp->get('/u01/COMMERCIALS_APPS/Nwameh/messag.txt');

        // Affichage (Interprétation HTML automatique par le navigateur)
        echo $contenu;
    }

    private function getUsers(): array
    {
        return $this->repo->getAllUsers();
    }
}
