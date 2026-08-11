<?php
    require_once('src/model/user.php');
    require_once('src/model/role.php');
    require_once('src/model/user_role.php');

    class C_Access
    {
        private $dbconnect;

        public function __construct()
        {
            $this->dbconnect = new DbConnect();
        }

        function default()
        {
            // $user = new User();
            // $user->cn = $_POST['userid'];
            // $user->username = $_POST['userid'];
            // $_SESSION['user'] = $user;
            // $_SESSION['roles'] = ["ADMIN"];
            // header("Location: dashboard");

            if(isset($_POST['userid'])&&isset($_POST['password']))
            {
                $userid = $_POST['userid'];
                $password = $_POST['password'];

                $tab = explode("@",$userid);
                $userid = trim($tab[0]);

                $this->CheckADUser($userid, $password);

            }

        }

        function logout()
        {
            session_destroy();
            require("template/connexion.php");
        }

        private function CheckADUser($userid, $password)
        {
            try {
                // Connexion au serveur
                $server = "ldap://10.250.90.8"; //"camlight.cm"; //"10.250.90.207";
                $connexion_serveur = ldap_connect($server) or die("Impossible de se connecter.");

                // Information de connexion
                $UserId = $userid;
                $pwd = $password;

                if ($connexion_serveur) {
                    ldap_set_option($connexion_serveur, LDAP_OPT_PROTOCOL_VERSION, 3);
                    ldap_set_option($connexion_serveur, LDAP_OPT_REFERRALS, 0);

                    $userDn = $UserId. "@camlight.cm";
                    $userPw = $pwd;

                    $result = @ldap_bind($connexion_serveur, $userDn, $userPw);
                    // var_dump($UserId);

                    // Connexion identifiée au serveur			               
                    if (!$result) {
                        ldap_close($connexion_serveur);
                        $error = 'Nom utilisateur ou mot de passe incorrect';
                        require("template/connexion.php");
                    } else {
                        //Récupération des informations personnel de l'utilisateur
                        //Definition du compte AD à chercher
                        $dn = "OU=Eneo People,OU=People,OU=Cameroon,Dc=camlight,DC=cm";  //nom du domaine de recherche
                        $filter = "(&(objectCategory=person)(objectclass=user)(sAMAccountName=$UserId))";
                        $attr = array("mail", "samaccountname", "cn", "description", "memberof"); //attributs à récuperer

                        $results = ldap_search($connexion_serveur, $dn, $filter, $attr);
                        $entries = ldap_get_entries($connexion_serveur, $results);

                        if ($entries["count"] == 0) {
                            $error = 'Compte invalide';
                            require("template/connexion.php");
                        } else {
                            // var_dump($entries);
                            $user = new User();
                            $user->cn = $entries[0]['samaccountname'][0];
                            $user->username = $entries[0]['cn'][0];

                            $_SESSION['user'] = $user;
                            $this->getUserRole($user->cn);

                            // $title = "Dashboard";
                            // $breadcumb = "Dashboard";
                            // require("template/dashboard.php");
                            header("Location: dashboard");
                        }

                    }
                } else {
                    $error = 'Erreur de connexion au serveur';
                    require("template/error.php");
                }

            } catch (Exception $e) {
                $error = "ERROR : ".$e->getMessage();
                require("template/error.php");
            }

        }

        private function getUserRole($cn)
        {
            $roles = UserRole::UserRoles($cn);
            $_SESSION['roles'] = $roles;

        }

        
    }