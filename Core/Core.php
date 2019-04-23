<?php 
namespace Core;

class Core
{
	
	public function run(){
		$url = '/';
		
		if (isset($_GET['url'])) {
			$url .= $_GET['url'];
		}
		$params = array();
		if (!empty($url) && $url != '/') {//Se tiver algo na URL.
			$url = explode('/', $url);
			array_shift($url);	
			$currentController = $url[0].'Controller';
			array_shift($url); //Remove o proximo indice no qual será a Action.
			
			if (isset($url[0]) && !empty($url[0])) {
				//se existe action seta.
				$currentAction = $url[0];
				array_shift($url);//remove a action para sobrar apenas os parametros.
			}else{
				$currentAction = 'index';//se não existir, seta action padrão Index.
			}
			//se existir parametros na url, passa para variavel params;
			if (count($url) > 0) {
				$params = $url;
			}

		}else{
			//Se não for passado nada na URL, seta como padrão o controller home e a action index.
			$currentController = 'BlockController';
			$currentAction = 'index';
		}
		//funçao deixa a primeira letra maiuscula.
		$currentController = ucfirst($currentController);

		//prefixo do pacote para os controllers(composer).
		$prefixo = '\Controllers\\';

		//Se não existir controllador seta uma pagina 404! Pagina não encontrada.
		if (!file_exists('Controllers/'.$currentController.'.php') || !method_exists($prefixo.$currentController, $currentAction)) {
			$currentController = 'BlockController';
			$currentAction = 'index';
		}

		//Caminho da class para o composer e depois instancia a classe
		$newController = $prefixo.$currentController;

		$controller = new $newController();
		/**
		 * Função do PHP call_user_func_array, responsável por executar uma função dentro de uma classe mas não sabemos qual nome da função, sendo isso setando a função dinamicamente. 
		 * 2 Parametros.
		 * 1 @param é um array(), dentro desse array, o primeiro item é o controller, no caso a nossa class, e o segundo item é o metodo/action que será executado.
		 * 2 @param envia o array de parametros se existir, se não envia o array vazio.
		 */

		call_user_func_array(array($controller, $currentAction), $params);

		
		// echo "Controller: ".$currentController."</br>";		
		// echo "Action: ".$currentAction."</br>";		
		// echo "Params: ".print_r($params, true)."</br>";		

	}
}