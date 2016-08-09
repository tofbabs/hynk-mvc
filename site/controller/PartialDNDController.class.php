<?php

/**
 * Site Index Controller
 */

class PartialDNDController extends ListController {

	protected $list_type;

	function __construct($_list_type='partialdnd') {
		parent::__construct($_list_type);
	}
   
}

?>