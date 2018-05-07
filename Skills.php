<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skills extends Public_Controller{
    public function __construct(){

        parent::__construct();
        $this->load->helper('uri');
		    $this->load->helper('my_form');
        $this->load->model('trainings_m');
		    $this->load->library('session');
         $this->load->model('trainers_m');

    
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

        case 'delete_training_skill':
         $this->_prep_delete_training_skill();
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
        //$trainingtype    = $this->trainings_m->get_training_type_name();
        //$skills = $this->trainers_m->get_skills();
        //print_r($skills);exit;
        //print_r($trainingtype);exit;
      $params=array(
        '_limit'          => $_limit,
        '_offset'         => $_offset,
        '_sort_field'     => $_sort_field,
        '_search_string'  => $_search_string,
        '_sort_direction' => $_sort_direction,
        //'training_type'   => $trainingtype,
        //'skills'          => $skills,

      );
 //print_r($params);exit;    
      $result = $this->trainings_m->get_skills($params);
 //print_r($result);exit;
      echo json_encode($result);
    }
    else{
    $this->template
         ->append_js('module::script_training_skills.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->build('skills');
  }
}

public function _prep_skills(){

       $result = $this->trainings_m->set_training_skills();
     //print_r($result);exit;
    if($result){
        echo json_encode(array('msg'=>'add training level successful', 'status'=>200));
      }else{
        echo json_encode(array('msg'=>'cannot add level this time', 'status'=>300));
      }

}

public function _prep_delete_training_skill(){
   $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
    $result = $this->hrdb->where('id',$row_id)
                            ->delete('training_skills');
        
    if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
    }else{
      echo json_encode(array('status' =>300, 'msg' => 'failure'));
    }


  }

}
 ?>