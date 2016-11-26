<?php
/**
 * Base Controller class
 */
class Controller {

    protected $template;
    protected $flash;

    function __construct() {

        $this->template = new Template();
        $this->flash = array();

    }

    public function getPageTitle(){
        // echo get_called_class();
        return get_called_class();
    }

    function index(){
        error_log("Controller[".get_called_class()."] index method is not defined");
    }

    protected function setView($folder,$file){
        $this->template->set($folder,$file);
        if (isset($_SESSION['user_role']) && $this->checkPermission($_SESSION['user_role']) == FALSE) {
            $this->template->set('','404');
        }
    }

    protected function ignoreSetView(){

        $this->template->norender();
    }

    protected function setVariable($key,$value){
        $this->template->setVariable($key,$value);
    }

    protected function is_session_started(){
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    function notifyBar($type, $msg){
        // $info = '';
        switch ($type) {
            case 'success':
                # code...
                $this->flash[] = '<div class="alert alert-success alert-dismissable">
                         <button type="button" class="close" data-dismiss="alert">×</button>
                          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                          <strong>Success: </strong>'. $msg .'</div>';

                break;
            case 'error':
                  # code...
                $this->flash[] = '<div class="alert alert-danger">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <strong>Error: </strong>'. $msg .'</div>';
                  break;  
            case 'info':
                  # code...
                $this->flash[] = '<div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                          <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>
                          <strong>Info: </strong>'. $msg .'</div>';
                  break;  

            case 'warning':
                  # code...
                $this->flash[] = '<div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <strong>Warning: </strong>'. $msg .'</div>';
                  break;

            default:
                # code...
                break;
        }
        // $this->flash[] = $info;
        // array_push($this->flash, $info);

    }
    
    function __destruct(){
        // Redeclare Info Variable
        $this->setVariable('flash', $this->flash);

        $this->template->render();
    }
}

?>