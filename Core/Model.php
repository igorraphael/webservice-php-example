<?php
namespace Core;

class Model
{

    protected $host;
    protected $db_name;
    protected $dbuser;
    protected $user;
    protected $pass;
 


    public function __construct(){
        $this->con = $this->connectDB();
        $this->close = $this->closeConnection();
    }

    public function connectDB(){
        $host = 'localhost';
		$db_name = 'app_tarefas';
		$port = '3306';
		$db_user = 'root';
		$db_pass = '';

        try{
            $con = new \mysqli($host, $db_user, $db_pass, $db_name);
            if(!$con){
                echo "deu erro";
            }
            return $con;
        }catch (Error $e) {
            print_r("Could not connect to server: {$e->getMessage()}");
        }

    }



    public function closeConnection(){
		if (isset($con)) {
			mysqli_close($con);
		}
	}

}
