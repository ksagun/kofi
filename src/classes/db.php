<?php 

class DB {
    private static $Name = DB_NAME;
    private static $Host = DB_HOST;
    private static $Username = DB_USER;
    private static $Password = DB_PASSWORD;

    private static $connection = null;

    public static function initConnection() {
          // One connection through whole application
          if(self::$connection == null) {
            try {
                self::$connection = new PDO("mysql:host=".self::$Host.";"."dbname=".self::$Name, self::$Username, self::$Password);
            }
            catch(PDOException $e) {
                die($e->getMessage());
            }
          }
        // Tell PDO to throw exceptions when errors occur
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function query($query, $bind){
        $stm = self::$connection->prepare($query);
        foreach($bind as $alias){
            if(count($bind)){
                $stm->bindParam(":".$alias['key'], $alias['value']);
            }
          
        }
        $stm->execute();

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public static function queryAll($query){
        $stm = self::$connection->query($query);
        $rows = $stm->fetchAll();
        return $rows;
    }

    public static function insertQuery($query, $bind){
        $stm = self::$connection->prepare($query);
        foreach($bind as $alias){
            if(count($bind)){
                $stm->bindParam(":".$alias['key'], $alias['value']);
            }
        }
        
        return $stm->execute();
    }
}
?>