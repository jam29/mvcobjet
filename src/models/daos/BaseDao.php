<?php
//
// DAO : data access object 
// le DAO est un design pattern (patron de conception)
// 
namespace mvcobjet\Models\Daos;

use PDO;

class BaseDao
{

    protected $db;

    public function __construct()
    {
       // $env = parse_ini_file(__DIR__ . '/../../../env');
        $this->db = new PDO("mysql://host=localhost;dbname=cinesite;charset=utf8", 'root' , '');
    }
}
