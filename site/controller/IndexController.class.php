<?php
/**
 * Site Index Controller
 */
class IndexController extends Controller {

	function __construct() {
		parent::__construct();
	}


	function index(){
		$this->setView('', 'home');
	}

}

?>