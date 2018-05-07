<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Procurements extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
		$this->load->helper('my_form');
        $this->load->model('trainings_m');
		$this->load->library('session');
    
    }
public function ajax(){
    $token = uri_assoc('token',5);
    $action = uri_assoc('action',2);
    try{
      if(!$this->input->is_ajax_request()){
        throw new Exception('Invalid Request Made');
        exit();
      }else{
        switch ($action){

        case 'add_skills':
         $this->_prep_skills();
        break;

        default:
          echo 'Nothing to return';
        break;
        }
      }
      }catch ( Exception $e ) {
        echo $e->getMessage();
      exit();
    }
  }

public function index(){
  if ($this->input->is_ajax_request()) {
        $_limit          = (int) $this->input->post('iDisplayLength');
        $_offset         = (int) $this->input->post('iDisplayStart');
        $_sort_field     = (int) $this->input->post('iSortCol_0');
        $_sort_direction = $this->input->post('sSortDir_0');
        $_search_string  = $this->input->post('sSearch');
      $params=array(
        '_limit'          => $_limit,
        '_offset'         => $_offset,
        '_sort_field'     => $_sort_field,
        '_search_string'  => $_search_string,
        '_sort_direction' => $_sort_direction,

      );
      
      $result = $this->trainings_m->procurements($params);

      echo json_encode($result);
    }
    else{
    $this->template
         ->append_js('module::script_training_skills.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->build('');
  }
}

}
 ?>