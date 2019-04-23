<?php
namespace Controllers;


class BlockController {

	public function index () {
        $return = '{return:"EndPoint not found or not existing.", qnt:"0"}';
        return json_encode($return);
    }
}