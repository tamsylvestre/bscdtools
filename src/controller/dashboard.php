<?php

    class C_Dashboard
    {
        private $dbconnect;

        public function __construct()
        {
            CheckUserConnect();
        }

        function default()
        {
            $title = "Dashboard";
            $breadcumb = "Dashboard";
            require("template/dashboard.php");
        }

    }