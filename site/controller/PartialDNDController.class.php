<?php

/**
 * Site Index Controller
 */

class PartialdndController extends ListController {

	protected $list_type;

	function __construct($_list_type='partialdnd') {
		parent::__construct($_list_type);
	}

	function download(){
		$this->setView('','download-partial');
	}

	/**  
	 * Creates Cache File for every category
	 * @override ListController::createBlacklistFile
	 * @param NULL
	 * @return NULL
	 */ 

	function createBlacklistFile($set_id=NULL){

	    $listModel = $this->_checkList($this->list_type);
	    $c = Category::getAll();

	    foreach ($c as $key => $cat) {
	    	# code...
	    	$category = $cat->getId();

	    	$temp = '/tmp/' . $this->list_type . rand() .'.csv';
	    	$file = FILE_PATH . 'partial' . $category .'.csv';

	    	if ($listModel::writeListCategoryToFile($temp,$category) && file_exists($file)) unlink($file);

	    	@file_put_contents($file, @file_get_contents($temp));
	    	Utils::trace('Updating Cache Base ' . $file);

	    }

	    $this->notifyBar('info','Entire '.strtoupper($this->list_type).' Cache File Regenerated');
	    $this->view();
	    

	}

	function download_cat($cat_id){

		$this->setView('','plain');
		$c = Category::getOne(array('category_id' => $cat_id));
		$list = file_get_contents(FILE_PATH . 'partial' . $cat_id .'.csv');
		$filename =  'PARTIAL_' . str_replace(' ', '_' ,$c->getCatName()) . '_COMPLETE.txt';

		if (isset($list)) {
		    # code...
		    Activity::create('implement', $this->u->getName(), ' Partial DND- ' . $c->getCatName());
		    Utils::downloadFile($list,$filename);
		}

	}

}

?>