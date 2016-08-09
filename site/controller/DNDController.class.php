<?php

/**
 * Site Index Controller
 */

class DNDController extends ListController {

	protected $list_type;

	function __construct($_list_type='dnd') {
		parent::__construct($_list_type);
	}
   
}

?>