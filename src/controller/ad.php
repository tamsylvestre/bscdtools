<?php


    class C_Ad
    {

        public function __construct()
        {
           
        }

        function SearchByName($name)
        {
           // Configuration
            $ldap_host = "ldap://10.250.90.8";
            // $ldap_dn   = "OU=Users,DC=entreprise,DC=cm"; // Base de recherche
            $ldap_dn   = "OU=Cameroon,Dc=camlight,DC=cm";
            $ldap_user = "sylvestre.tam@camlight.cm";    // Compte de lecture
            $ldap_pass = "Barcelone2026";

            $search_string = $name; // La chaîne à rechercher

            // 1. CONNEXION ET OPTIONS
            $ldap_conn = ldap_connect($ldap_host) or die("Impossible de se connecter.");

            // Options indispensables pour l'AD
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

            try {
                // 2. AUTHENTIFICATION (BIND)
                if (@ldap_bind($ldap_conn, $ldap_user, $ldap_pass)) {
                    
                    // 3. FILTRE DE RECHERCHE
                    // Recherche dans le nom (cn), le login (samaccountname) ou l'email (mail)
                    $filter = "(|(cn=*$search_string*)(samaccountname=*$search_string*)(mail=*$search_string*))";
                    // $filter = "(&(objectClass=user)(objectCategory=person))";
                    
                    // Champs que l'on souhaite récupérer
                    $attributes = ["cn", "samaccountname", "mail", "telephonenumber"];

                    // 4. EXÉCUTION
                    $result = ldap_search($ldap_conn, $ldap_dn, $filter, $attributes);
                    $entries = ldap_get_entries($ldap_conn, $result);

                    // echo "Nombre d'utilisateurs trouvés : " . $entries["count"] . "<br><br>";
                    $users = [];
                    // 5. AFFICHAGE DES RÉSULTATS
                    for ($i = 0; $i < $entries["count"]; $i++) {
                        // echo "Nom : " . $entries[$i]["cn"][0] . "<br>";
                        // echo "Login : " . $entries[$i]["samaccountname"][0] . "<br>";
                        // echo "Email : " . ($entries[$i]["mail"][0] ?? "N/A") . "<br><hr>";
                        // print_r($entries[$i]);
                        // echo "<br><hr>";
                        $users[] = ["cn"=>$entries[$i]["cn"][0],"samaccountname"=>$entries[$i]["samaccountname"][0]];
                    }

                    print(json_encode($users));

                } else {
                    throw new Exception(ldap_error($ldap_conn));
                }
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            } finally {
                // 6. CLÔTURE
                ldap_unbind($ldap_conn);
            }
        }

        function default()
        {
            print 'hello';
        }
       

    }