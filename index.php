<?php

//Tested for : Migration jommla 3.4 to joomla 3.8

ini_set('memory_limit', -1);
ini_set('max_execution_time', -1);

require 'config/config.php';
require 'inc/autoload.php';
include 'inc/tables.php';

// connect to the database
Connexion::getConnection();

// Var to store tables names are empty.
$vide = "";
$etat = "";

// Add Old Prefix
array_walk($uselessTables, "addOldPrefix");

// Select all tables names
$req = " SELECT `TABLE_NAME` "
     . " FROM INFORMATION_SCHEMA.TABLES "
     . " WHERE `TABLE_SCHEMA` = '" . DATA_BASE . "' "
     . " AND `TABLE_NAME` NOT LIKE '" . $uselessTableLike . "' "
     . " AND `TABLE_NAME` NOT IN ( '" . implode('\', \'', $uselessTables) . "' )";

if (($req = Connexion::query($req)) && (Connexion::rowCount($req))) {

    while ($res = $req->fetchObject()) {

        // Storing tables names without a prefix.
        $tables[] = substr($res->TABLE_NAME, OLD_PREFIX_LENGTH);
    }
}

echo "----------------------------------------- Exported tables : " . date('Y-m-d H:i:s') . " -----------------------------------------";
echo "<br /><br />";

// Iterate tables names
foreach ($tables as $tab) {
    //$tab        =    "content";
    $table = OLD_PREFIX . $tab;
    $newTable = NEW_PREFIX . $tab;

    /*
     *  Select all the columns names.
    */
    if (in_array($tab, $tableChange)) :

        $req = " SELECT `COLUMN_NAME` "
             . " FROM INFORMATION_SCHEMA.COLUMNS"
             . " WHERE `TABLE_SCHEMA` = '" . DATA_BASE . "'"
             . " AND TABLE_NAME = '" . $table . "'";

        if (($req = Connexion::query($req)) && (Connexion::rowCount($req))) {

            while ($res = $req->fetch(PDO::FETCH_ASSOC)) {
                // Storage column name..
                $colonnes[] = $res[COLUMN_NAME];
            }
        }

        $colonnes_tab = "(`" . implode("`, `", $colonnes) . "`)";  // => (`column 1`,`column 2`,`column 3`,..., `column n`)
    endif;

    switch ($tab):
        case "menu" :
            $req = " SELECT * FROM " . $table . " WHERE client_id = 0"; /* 0 : for the site */
            break;
        default :
            $req = " SELECT * FROM " . $table;
    endswitch;

    if (($req = Connexion::query($req)) && (Connexion::rowCount($req))) {

        $fichier = DIR_SQL . SEPARATOR . $tab . EXTENSION;

        $fp = fopen($fichier, MODE);

        switch ($tab):
            case "menu" :
                fwrite($fp, " DELETE FROM " . $newTable . " WHERE client_id = 0 ;\n");
                break;
            case (preg_match('/^sv_bookpro3/', $tab) ? true : false) :
                $etat = "<b style='color: red'>Creation and</b> ";
                include 'inc/createTable.php';
                break;
            default :
                fwrite($fp, " TRUNCATE TABLE " . $newTable . ";\n");
        endswitch;

        while ($res = $req->fetch(PDO::FETCH_ASSOC)) {

            array_walk($res, "Connexion::escape");

            /*
             * Query with columns names : INSERT INTO tbl_name (col_A,col_B,col_C) VALUES (1,2,3)
            */
            if (in_array($tab, $tableChange)) {

                if ($tab == "icagenda_registration"):
                    $colonnes_tab = str_replace('custom_fields', 'params', $colonnes_tab);
                endif;

                if ($tab == "kunena_users"):
                    $colonnes_tab = str_replace('msn', 'microsoft', $colonnes_tab);
                    $colonnes_tab = str_replace('gtalk', 'google', $colonnes_tab);
                endif;

                $sqlCommand = "INSERT INTO " . $newTable . " " . $colonnes_tab . " VALUES ('" . implode("','", array_values($res)) . "');\n";
            } else {
                /*
                 * Query without columns names : INSERT INTO tbl_name VALUES (1,2,3)
                */
                $sqlCommand = "INSERT INTO " . $newTable . " VALUES ('" . implode("','", array_values($res)) . "');\n";
            }

            // Write the query in the file
            fwrite($fp, utf8_encode($sqlCommand));
        }

        fclose($fp);

        $etat .= "<b style='color: red'>Inserting</b>";
        echo "Exporting table <b> " . $table . " </b> to " . $fichier . " : " . $etat;
        $etat = "";
        echo "<br />";
    } else {
        if (preg_match('/^sv_bookpro3/', $tab)) :

            $fichier = DIR_SQL . SEPARATOR . $tab . EXTENSION;
            $fp = fopen($fichier, MODE);
            include 'inc/createTable.php';
            fclose($fp);
            $vide.= "<b style='color: red'>" . $table . " : Creation </b> <br /> ";
            continue;
        endif;

        $vide .= "<b>" . $table . "</b> <br /> ";
    }
    //break;
}
echo "<br /><br />";
echo "------------------------------------------- Tables are empty : -------------------------------------------";
echo "<br /><br /> " . $vide;