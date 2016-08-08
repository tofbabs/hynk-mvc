<?php
/**
 * 404 Controller
 */
class CategoryController extends Controller {
	
	function __construct() {
		parent::__construct();

	}
    
    function index(){
        $this->add();
    }

    function edit($cat_id){
        $this->setVariable('isEdit', TRUE);

        $c = Category::getOne(array('category_id' => $cat_id));

        $this->setVariable('cat', $c);
        $this->setView('','add-cat');
    }

    function add(){

        $this->setView('', 'add-cat'); 
        $this->setVariable('isEdit', FALSE);

        $c = Category::getAll();

        $flotpie_data = array();

        foreach ($c as $key => $cat) {
            # code...
            $arrdata = array();
            $arrdata['label'] = $cat->getCatName();
            $arrdata['data'] = Blacklist::getDistinctCount(array('category' => $cat->getId()));
            // print_r($arrdata);
            $flotpie_data[] = $arrdata;
        }

        // print_r($flotpie_data);

        $this->setVariable('pie_data',$flotpie_data);

        /* 
            If Post Button is clicked 
        */
        if(isset($_POST['addNewCatBtn'])) {

            // Validate POST INPUT
            if(isset($_POST['category_name'])) {

                // Initialize POST variables
                $cat_name = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);
                $cat_desc = filter_var($_POST['category_desc'], FILTER_SANITIZE_STRING);

                // Check if cat exist
                $c = Category::getOne(array('category_name' => $cat_name));

                if($c->getId() == NULL || isset($_POST['category_id'])) {

                    $cat = new Category();

                    if (isset($_POST['category_id']))
                        $cat->setId($_POST['category_id']);

                    // Create or Update Company Details
                    $cat->setCatName($cat_name);
                    $cat->setCatDesc($cat_desc);
                    $cat->save();

                    $this->notifyBar('success','Category has been updated');

                }
                else{

                    $this->notifyBar('error','Category Exist');
                    Utils::printOut("Category Exist" . $cat_name);
                    exit();
                }


            }

            else{
                $this->notifyBar('error', 'Kindly Complete Required Fields');
            }

        }

    }
   
}

?>