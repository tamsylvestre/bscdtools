<?php

    require_once('src/lib/database.php');

    class SmartcashRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAllUsers():array
        {
            $statement = $this->dbconnect->getSmartcashDb()->prepare(
                "
                Select x.*, l.seen AS \"Last connexion\" FROM (SELECT 
                    u.id, 
                    case WHEN u.username like '%Del%' THEN 'INACTIVE' ELSE 'ACTIVE' END AS \"STATUT\",
                    c.orga_division AS \"Region\", c.orga_division_sub AS Division, c.company_name AS Agence, u.username AS \"Login\", CONCAT(u.last_name, \" \", u.first_name) AS \"Username\", g.NAME AS \"Profil\"
                FROM sf_guard_user u
                    LEFT JOIN core_user_profile p ON p.user_id = u.id
                    LEFT JOIN sf_guard_user_group ug ON ug.user_id = u.id
                    LEFT JOIN sf_guard_group g ON g.id = ug.group_id
                    LEFT JOIN mpay_collector_company c ON c.id = p.tenant_id
                    WHERE u.id > 200) as x
                    LEFT OUTER JOIN (SELECT user_id, MAX(created_at) AS seen FROM user_login_history GROUP BY user_id) AS l ON l.user_id = x.id
                "
            );

            $statement->execute();

            $users = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $users[]= $row;
            }

            return $users;            
        }
    }