<?php
namespace Models;

use \Core\Model;

class Tarefa extends Model{

    /**
     * Return all tasks 
     */
    public function getAllTasks(){
        $array = array();
        $sql = "SELECT * FROM tarefas";
        $result = $this->con->query($sql);
        $this->close; //close connection db.
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
            $row_arr['id'] = $row['id'];
            $row_arr['nome_tarefa'] = $row['nome_tarefa'];
            $row_arr['status'] = $row['status'];
            $row_arr['data_hora'] = $row['data_hora'];
            $row_arr['importancia'] = $row['importancia'];
            $row_arr['obs'] = $row['obs'];
            array_push($array,$row_arr);
        }
        return $array;
    }

    /**
     * Function to insert new task
     */
    public function insertNewTask($nome_tarefa, $data_hora, $importancia, $obs){
        $sql = "INSERT INTO tarefas (nome_tarefa, data_hora, importancia, obs) VALUES('$nome_tarefa','$data_hora', '$importancia', '$obs')";
        $insert = $this->con->query($sql);
        $this->close; //close connection db.
        if($insert != true):
            return "Houve um problema ao adicionar nova tarefa, por favor tente mais tarde.";
        endif;
            return "Tarefa adicionada com sucesso.";
    } 
    
    /**
     * Function to update status task
     */
    public function updateStatusTask($id_tarefa, $status_att){
        $sql = "UPDATE tarefas SET status='$status_att'  WHERE id = '$id_tarefa'";
        $update = $this->con->query($sql);
        if($update === true):
            return "Status atualizado!";
        endif;
    }

    public function deleteTask($id_tarefa){
        $sql = "DELETE FROM tarefas WHERE id = '$id_tarefa'";
        $delete = $this->con->query($sql);
        if($delete === true):
            return "Tarefa deletada.";
        endif;
    }

}
    

