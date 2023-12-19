<?php
    namespace app\core;

use Error;
use Exception;

    abstract class DbModel extends Model{
        abstract public function tableName(): string;
        abstract public function attributes(): array;

        public function save(){
            try{
                $tableName = $this->tableName();
                $attributes = $this->attributes();
                $columns = implode(",", $attributes);
                $params = array_map(fn($attr) => ":$attr", $attributes);
                $values = implode(",", $params);
                $statement = self::prepare(
                    "
                        INSERT INTO $tableName ($columns)
                        VALUES ($values); 
                    "
                );
                
                foreach($attributes as $attribute){
                    $statement->bindValue(":$attribute", $this->{$attribute});
                }
    
                $statement->execute();
                return true;
            }catch(Exception $e){
                return false;
            }
        }
        public static function prepare($sql){
            return Application::$app->db->pdo->prepare($sql);
        }
        
    }

?>