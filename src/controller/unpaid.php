<?php


class C_Unpaid
{
    private $reposytories = [
        'DCUD' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUD",
        'DCUY' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUY",
        'DRC' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRC",
        'DRE' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRE",
        'DRNEA' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRNEA",
        'DRONO' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRONO",
        'DRSANO' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSANO",
        'DRSM' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSM",
        'DRSOM' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSOM",
    ];

    public function __construct()
    {
        CheckUserConnect();
    }

    function default()
    {
        require("template/unpaid.php");
    }
}
