<?php
namespace App\Core\Abstract;
use App\Core\DataBase;
use App\Entities\User;
use App\Core\App;

abstract class AbstractRepository
{
    protected  $db;
    abstract public  function selectAll() ;
   
    abstract public function update() ;
    abstract public function delete();
    abstract public function selectById($id);
    
    public function __construct()
    {
        // $this->db = DataBase::getInstance()->connect();
        $this->db = App::getDependencie('DataBase')->connect();
    }
 
}