<?php

class Connexion {

    /**
     * @var
     */
    static $cnx;

    /**
     * @var int
     */
    static $pile=0;

    // Connection to the database
    static function getConnection() {
        self::$pile++;
        if (self::$pile == 1) {
            try {
                self::$cnx = new PDO('mysql:host=' . LOCAL_HOST . ';dbname=' . DATA_BASE . '', LOGIN_NAME, PASS_WORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {
                die('Failed to connect to the database : ' . $e->getMessage());
            }
        }
    }

    /**
     * To execute queries
     *
     * @param $req
     * @return mixed
     */
    static function query($req) {
        $req = self::$cnx->query($req) or die (" Failed to execute query : ( ".self::$cnx->errno." ) ".self::$cnx->error );
        if ($req) {
                return $req;
        }
    }

    /**
     * To execute prepared queries
     *
     * @param $req
     * @param array $tab
     * @return mixed
     */
    static function queryPrepare($req, $tab = array() ){
        $var = self::$cnx->prepare($req);
        $var->execute($tab);
        return $var;
    }

    /**
     * To retrieve the number of rows by the last queries
     *
     * @param $exec
     * @return mixed
     */
    static function rowCount($exec) {
        return $exec->rowCount();
    }

    /**
     * To Protect a String for Use in an SQL Query
     *
     * @param $chaine
     */
    static function escape(&$chaine ) {
         $chaine = addcslashes( $chaine, "'" );
    }
}