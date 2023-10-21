<?php
class Database{
    protected $connection = null;

    /**
     * @throws Exception if the connection fails
     */
    public function __construct(){
        try {
            $this->connection = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE_NAME);
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception if operation fails
     */
    protected function insert($query, $params){
        try {
            $statement = $this->executeStatement($query,$params);
            $result = $statement->get_result()->fetch_all();
            $statement->close();
            return $result;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception if operation fails
     */
    protected function select($query, $params){
        try {
            $statement = $this->executeStatement($query,$params);
            $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
            $statement->close();
            return $result;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception if operations fails
     */
    private function executeStatement($query, $params=[]){
        try {
            $statement = $this->connection->prepare($query);
            if ($statement===false){
                throw new Exception("Unable to prepare statement");
            }
            if ($params){
                for ($i=0;$i<count($params);$i++){
                    $statement->bind_param($params[$i]);
                }
            }
            $statement->execute();
            return $statement;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}