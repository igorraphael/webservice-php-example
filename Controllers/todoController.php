<?php
namespace Controllers;

use \Models\Tarefa;

class todoController
{

    public function __construct()
    {
        $this->task = new Tarefa();
    }

    public function index()
    {
        $return = '{return:"EndPoint not found or not existing.", qnt:"0"}';
        echo $return;
    }

    /**
     * Function to return all tasks.
     */
    public function listar()
    {
        header("Access-Control-Allow-Origin: *");//CORS
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //$this->controlAccess($_SERVER);//save data request in db
            $responseRequest = $this->task->getAllTasks();
        }else{
            //$this->controlAccess($_SERVER);//Control
            $responseRequest = "Warning!!! Somente o método GET é aceito.";
        }
        header("Content-Type: application/json");
        echo json_encode($responseRequest);
    }

    /**
     * Function add new task in database.
     */
    public function add()
    {
        header("Access-Control-Allow-Origin: *");//CORS
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (array_key_exists("nome_tarefa", $_REQUEST) && array_key_exists("data_hora", $_REQUEST) && array_key_exists("importancia", $_REQUEST)) {
                $nome_tarefa = $_REQUEST['nome_tarefa'];
                $data_hora = $_REQUEST['data_hora'];
                $importancia = $_REQUEST['importancia'];
                $obs = (isset($_REQUEST['obs']) && !empty($_REQUEST['obs'])) ? $_REQUEST['obs'] : 'Nada informado.';
                $return = $this->checkPostData($nome_tarefa, $data_hora, $importancia, $obs);
                if (!$this->checkPostData($nome_tarefa, $data_hora, $importancia, $obs)) {
                    $responseRequest = "Error!!! Parametros em branco/invalidos.";
                } else {
                    $this->controlAccess($_SERVER);//Control
                    $responseRequest = $this->task->insertNewTask($nome_tarefa, $data_hora, $importancia, $obs);
                }
            } else {
                $responseRequest = "Error!!! Falta parametros, por padrão deve se informar o nome_tarefa(string), data_hora(datatime), importancia(string).";
            }
        } else {
            $responseRequest = "Warning!!! Somente o método POST é aceito.";
        }
        header("Content-Type: application/json");
        echo json_encode($responseRequest);
    }

    /**
     * Function update status the task ( 0 or 1 )
     */
    public function update_status()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            if (array_key_exists("id_tarefa", $_REQUEST) && array_key_exists("status", $_REQUEST)) {
                if (empty($_REQUEST['id_tarefa']) or empty($_REQUEST['status'])) { //Verifica se os parametros enviados estao preenchidos.
                    $responseRequest = "Error!!! Parametros em branco/invalidos.";
                } else {
                    $id = $_REQUEST['id_tarefa'];
                    $status = $_REQUEST['status'];
                    if (is_numeric($id) && is_numeric($status)) {
                        $this->controlAccess($_SERVER);//Control
                        $responseRequest = $this->task->updateStatusTask($id, $status); //recebe o retorno da funçao de atualizaçao.
                    } else {
                        $responseRequest = "Error!!! Valor do parametro não é aceito."; //$id nao e uma string numeric.
                    }
                }
            } else {
                $responseRequest = "Warning!!! Falta parametros, informar o id_tarefa(int), status(int).";
            }
        } else {
            $responseRequest = "Error!!! Este endpoint aceita apenas o method PUT.";
        }
        header("Content-Type: application/json");
        echo json_encode($responseRequest);
    }

    public function delete()
    {
        header("Access-Control-Allow-Origin: *");//CORS
        if ($_SERVER['REQUEST_METHOD'] == "DELETE" || "POST") {
            if (array_key_exists("id_tarefa", $_REQUEST)) {
                if (empty($_REQUEST['id_tarefa'])) {
                    $responseRequest = "Error!!! Parametros em branco/invalidos.";
                } else {
                    $id_tarefa = $_REQUEST['id_tarefa'];
                    if (is_numeric($id_tarefa)) {
                        $this->controlAccess($_SERVER);//Control
                        $responseRequest = $this->task->deleteTask($id_tarefa); //recebe o retorno da funçao de deletar.
                    } else {
                        $responseRequest = "Error!!! Valor do parametro não é aceito.";
                    }
                }
            } else {
                $responseRequest = "Warning!!! Falta parametros, informar o id_tarefa(int).";
            }
        } else {
            $responseRequest = "Error!!! Este endpoint aceita apenas o method DELETE.";
        }
        header("Content-Type: application/json");
        echo json_encode($responseRequest);
    }

    /**
     * Function check and valid
     * @return  [array]
     */
    private function checkPostData($nome_tarefa, $data_hora, $importancia, $obs)
    {
        $valid = 0;
        if (!isset($nome_tarefa) or empty($nome_tarefa)): //nome_tarefa vazio..
            $valid++;
        endif;
        if (!isset($data_hora) or empty($data_hora)): //data_hora vazio..
            $valid++;
        endif;
        if (!isset($importancia) or empty($importancia)): //importancia vazio..
            $valid++;
        endif;

        if ($valid === 0) {
            $dataValid = array(
                $this->validate($nome_tarefa),
                $this->validate($data_hora),
                $this->validate($importancia),
                $this->validate($obs),
            );
            return $dataValid;
        } else {
            return;
        }
    }

    /**
     * @return  [str]
     */
    public function validate($str)
    {
        return trim(addslashes($str));
    }

    /**
     * function for print with <pre>
     */
    public function dump($var){
        echo "<pre>";
            print_r($var);
        echo "</pre>";
    }

    /**
     * Function for controll ips 
     */
    public function controlAccess($arrayServer){
        if(!$arrayServer): //Apenas um debug para test.
            echo "Voce não tem permissão, debug!";
            die();
        endif;
        $remoteIp = $arrayServer['REMOTE_ADDR'];//ip remote request
        $userAgent = explode(")", $arrayServer['HTTP_USER_AGENT']);//userAgent[0] - esta o name user agent.
        $requestMethod = $arrayServer['REQUEST_METHOD'];//method (post, get, put..)
        $requestUri = $arrayServer['REQUEST_URI'];//url request
        $requestQuery = $arrayServer['QUERY_STRING'];//query request
        $requestStatus = $arrayServer['REDIRECT_STATUS'];
        $this->task->insertControlAccess($remoteIp, $userAgent[0], $requestMethod, $requestUri, $requestQuery, $requestStatus);
    }

}
