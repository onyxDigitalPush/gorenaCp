<?php

/**
 * Description of GestorPersistenciaMySQLImpl
 *
 * @author usuario1
 */
class GestorPersistenciaMySQLImpl implements GestorPersistenciaMySQL
{

    private $host;
    private $user;
    private $password;
    private $baseDeDades;
    private $connexio;

    function getHost(){return $this->host;}

    function getUser(){return $this->user;}

    function getPassword(){return $this->password;}

    function getBaseDeDades(){return $this->baseDeDades;}

    function getConnexio(){return $this->connexio;}

    function setHost($host){$this->host = $host;}

    function setUser($user){$this->user = $user;}

    function setPassword($password){$this->password = $password;}

    function setBaseDeDades($baseDeDades){$this->baseDeDades = $baseDeDades;}

    function setConnexio($connexio){$this->connexio = $connexio;}

    public function __construct()
    {
        //$host,$dbname,$user,$password 
        //"localhost","controlpres","lenovo","lenovo1"
        //        ini_set('log_errors', 1);
        //        ini_set('error_log', '_logs/errors.log');
        //        $errorPath = ini_get('error_log');



        $this->host = "localhost"; //$host;
        $this->baseDeDades = "gorena_prueba"; //$dbname;
        $this->user = "proyectos"; //$user;
        $this->password = "4lzCw66_"; //$password;//4lzCw66_

        /*
          $this->host = "localhost";//$host;
          $this->baseDeDades = "skytanking";//$dbname;
          $this->user = "adminsky";//$user;
          $this->password = "@o75jwQ5";//$password;//4lzCw66_
         */
        /*
          $this->host = $host;
          $this->baseDeDades = $dbname;
          $this->user = $user;
          $this->password = $password;
         */

        /** EDIT: optimización consultas y tiempo */
        try
        {
            $conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->baseDeDades . '', $this->user, $this->password);
            //$conn = new mysqli($this->host, $this->user, $this->password, $this->baseDeDades);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setConnexio($conn);
            //echo "Connected successfully"; 
            //return $conn;
        }
        catch (PDOException $e)
        { //(mysqli_sql_exception $e) {
            echo "La Connexió ha fallat: " . $e->getMessage();
        }
    }





    /**
     * Class destruct
     * @access public
     */
    function __destruct()
    {
        $this->connexio = null;
        /** TODO: quizás esto no está bien y sería optimo hacer un close de PDO */
    }

    public function obrirConnexio()
    {
        /** EDIT: optimización consultas y tiempo */
    }

    public function tancarConnexio()
    {
        /** EDIT: optimización consultas y tiempo */
    }

    public function executarSentencia($sql)
    {
        $this->obrirConnexio();
        $res = $this->getConnexio();

        //$res->query($sql);
        $res->exec($sql);
        $this->tancarConnexio();
    }

    public function executarSentenciaOnyx($sql)
    {
        $this->obrirConnexio();
        $res = $this->getConnexio();

        $res->query($sql);

        //print_r($res->query($sql)->fetch(PDO::FETCH_ASSOC));
        $this->tancarConnexio();
    }

    public function executarSentenciaParametrizada($sql, $values = array())
    {
        $this->obrirConnexio();
        $res = $this->getConnexio();

        $query = $res->prepare($sql);
        $result = $query->execute($values);


        //print_r($res->query($sql)->fetch(PDO::FETCH_ASSOC));
        $this->tancarConnexio();
        return $result;
    }

    public function executarConsultaParametrizada($sql, $values = array())
    {
        $this->obrirConnexio();
        $res = $this->getConnexio();

        $query = $res->prepare($sql);
        $query->execute($values);

        $result = $query->fetchAll();

        //print_r($res->query($sql)->fetch(PDO::FETCH_ASSOC));
        $this->tancarConnexio();
        return $result;
    }

    public function executarConsulta($sql)
    {
        $this->obrirConnexio();
        $res = $this->getConnexio();
        //$rs = $res->query($sql);
        $GLOBALS['DEBUG_SQL'] = false;
        if (isset($GLOBALS['DEBUG_SQL']) && $GLOBALS['DEBUG_SQL'] === true)
        {
            // MD5($sop) as array key 
            $query_md5 = md5($sql);

            // Check if the same $sop has already been executed
            if (array_key_exists($query_md5, $GLOBALS['DEBUG_SQL_QUERIES']))
            {
                // Add to the counter
                $GLOBALS['DEBUG_SQL_QUERIES'][$query_md5]['count']++;
            }
            else
            {
                // Add query to the array
                $GLOBALS['DEBUG_SQL_QUERIES'][$query_md5] = array('count' => 1, 'execution_time' => 0, 'sql' => $sql);
            }
        }
        /** Debug SQL */
        if (isset($GLOBALS['DEBUG_SQL']) && $GLOBALS['DEBUG_SQL'] === true)
        {
            $starttime = microtime(false);
        }


        $rs = $res->query($sql)->fetchAll();


        /** Debug SQL */
        if (isset($GLOBALS['DEBUG_SQL']) && $GLOBALS['DEBUG_SQL'] === true)
        {
            $endtime = microtime(false);
            $duration = $endtime - $starttime; //calculates total time taken
            $GLOBALS['DEBUG_SQL_QUERIES'][$query_md5]['times'] .= '[' . number_format($duration, 5) . ']';
            if ($duration > 0.5)
            {
                $GLOBALS['DEBUG_SQL_QUERIES'][$query_md5]['slow'] .= '[' . number_format($duration, 5) . ']';
            }
        }
        $this->tancarConnexio();
        return $rs;
    }
}
