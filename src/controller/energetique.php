<?php

class C_Energetique
{

    public function __construct()
    {
        CheckUserConnect();
    }

    function default()
    {
        $title = "Dashboard";
        $breadcumb = "BATCH";
        require("template/energetique.php");
    }
}
