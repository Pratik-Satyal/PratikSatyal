<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings_dashboard extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
    $this->load->helper('my_form');
        $this->load->model('trainings_m');
        $this->load->model('trainers_m');
    $this->load->library('session');
    
    }
    public function ajax(){
    $token = uri_assoc('token',5);
    $action = uri_assoc('action',4);
    try{
      if(!$this->input->is_ajax_request()){
        throw new Exception('Invalid Request Made');
        exit();
      }else{
        switch ($action){

    ###########Global Training Settings/Training Levels##########     
          case 'training_level':
            $this->_prep_training_level();
            break;

          case 'add_training_level':
            $this->_prep_add_training_level();
            break;
          
          case 'edit_training_level':
            $this->_prep_edit_training_level();
            break; 
          
          case 'delete_training_level':
            $this->_prep_delete_training_level();
            break;

    ###########Global Training Settings/Training Grades##########       
          case 'add_training_grade':
            $this->_prep_add_training_grade();
            break;
          
          case 'training_grade':
            $this->_prep_training_grade();
            break; 
          
          case 'submit_grade':
            $this->_prep_submit_training_grade();
            break;
          
          case 'edit_grade':
            $this->_prep_edit_training_grade();
            break;
          
          case 'edit_grade_wages':
            $this->_prep_edit_training_wages();
            break;
          
          case 'delete_training_grade':
            $this->_prep_delete_training_grade();
            break; 

    ###########Performance Settings/Training Grades##########     
          
          case 'performance_field':
            $this->_prep_performance_field();
            break;

          case 'add_training_field':
            $this->_prep_add_training_field();
            break; 
 
          case 'edit_field':
            $this->_prep_edit_performance_field();
            break;
          
          case 'edit_skill':
            $this->_prep_edit_performance_skill();
            break;  
          
          case 'delete_training_field':
            $this->_prep_delete_training_field();
            break;  
    
    ###########Training Budget##########          
          
          case 'budget_headiing':
            $this->_prep_budget_heading();
            break;

          case 'add_budget':
            $this->_prep_add_training_budget();
            break; 

          case 'delete_budget_record':
            $this->_prep_delete_budget_record();
            break; 

    ###########Training Venue##########          
          
          case 'venue':
            $this->_prep_training_venue();
            break; 

          case 'delete_training_venue':
            $this->_prep_delete_training_venue();
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

###########Settings Dashboard########## 
  public function training_settings(){
    $skills = $this->trainers_m->get_skills();
    $skill_grade = $this->trainings_m->get_skill_grade();
    $this->template
         ->append_js('module::script_training_setting.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->set('skill_grade', $skill_grade)
         ->set('skills', $skills)
         ->build('training_setting');
}

public function global_training_setting(){
  
  $skills = $this->trainers_m->get_skills();
  $skill_grade = $this->trainings_m->get_skill_grade();
  $this->template
       ->append_js('module::script_training_setting.js')
       ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
       ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
       ->append_css('module::training.css')
       ->set('skill_grade', $skill_grade)
       ->set('skills', $skills)
       ->build('setting/global_performance_budget_tab'); 
}


###########Global Training Settings/Training Levels########## 
 public function _prep_training_level(){

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
      
      $result = $this->trainings_m->gettraining_level($params);
      echo json_encode($result);
  }
  
  public function _prep_add_training_level(){
     $result = $this->trainings_m->set_training_level();
    if($result){
        echo json_encode(array('msg'=>'add training level successful', 'status'=>200));
      }else{
        echo json_encode(array('msg'=>'cannot add level this time', 'status'=>300));
      }

  }

  public function _prep_delete_training_level(){
    $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
    $result = $this->hrdb->where('id',$row_id)
                            ->delete('training_level');
        
    if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
    }else{
      echo json_encode(array('status' =>300, 'msg' => 'failure'));
    }

  }

  ###########Global Training Settings/Training Grade########## 

  public function _prep_training_grade(){

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
      
      $result = $this->trainings_m->getList_grade($params);
      echo json_encode($result);
    }

  public function _prep_add_training_grade(){
    //print_r("expression");exit;
    $this->template
          ->set_layout('modal')
          ->append_css('bootstrap-editable.css')
          ->append_js('bootstrap-editable.min.js')      
          ->append_js('bootbox.min.js')
          ->append_css('select2.css')
          ->append_js('select2.js')
          ->append_js('jquery.validate.min.js')
          ->append_js('module::script_training_setting.js')
          ->build('setting/grade_bootbox');
  }



  

  public function _prep_edit_training_grade(){
    $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'trainer_grade' =>  $this->input->post('value'),
    );
       $result = $this->trainings_m->submit_grade($params);
      if($result){
        echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }
  }

  public function _prep_edit_training_wages(){
    $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'daily_wage'  => $this->input->post('value'),
    );
       $result = $this->trainings_m->submit_grade($params);
      if($result){
       echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }
  }

  public function _prep_submit_training_grade(){
    //print_r("expression");exit;
    $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'trainer_grade' =>  $this->input->post('grade'),
                     'daily_wage'  => $this->input->post('wage'),
                     'description' =>$this->input->post ('description') 
    );
    //print_r($params);exit;
       $result = $this->trainings_m->submit_grade($params);
      if($result){
          //header('location:'.base_url()."trainings/training_settings");
                    echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }
  }


 public function _prep_delete_training_grade(){
   $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
    $result = $this->hrdb->where('id',$row_id)
                            ->delete('trainer_grades');
        
    if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
    }else{
      echo json_encode(array('status' =>300, 'msg' => 'failure'));
    }


  }

   #########Performance##############

  public function _prep_performance_field(){

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
        '_skills'         =>$this->trainers_m->get_skills()

      );
      
      $result = $this->trainings_m->performancesetting_list($params);
//print_r($result);exit;
      echo json_encode($result);
    }

    public function _prep_add_training_field(){
    
     $params = array (
                    'row_id'=> $this->input->post('id'),
                    
                    'skill_id'=>$this->input->post('skills'),
                    'field'=>$this->input->post('field')
    );
    //print_r($params);exit;
       $result = $this->trainings_m->submit_training_field($params);

      if($result){
          //header('location:'.base_url()."trainings/Settings_Dashboard/training_settings");
        echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }

    }

    public function _prep_edit_performance_field(){

       $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'field' =>  $this->input->post('value'), 
                     );
       //print_r($params);exit;
       $result = $this->trainings_m->submit_training_field($params);
      if($result){
        echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }
    }

    public function _prep_edit_performance_skill(){

       $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'skill_id'=>$this->input->post('value'),

    );
       $result = $this->trainings_m->submit_training_field($params);
      if($result){
        echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }
    }

    public function _prep_delete_training_field(){
      $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
      $result = $this->hrdb->where('id',$row_id)
                           ->delete('training_evaluation_fields');
      if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
      }else{
        echo json_encode(array('status' =>300, 'msg' => 'failure'));
      }

  }

  #########Training Budget Heading##############

  public function _prep_budget_heading(){
  if ($this->input->is_ajax_request()) {
        $_limit          = (int) $this->input->post('iDisplayLength');
        $_offset         = (int) $this->input->post('iDisplayStart');
        $_sort_field     = (int) $this->input->post('iSortCol_0');
        $_sort_direction = $this->input->post('sSortDir_0');
        $_search_string  = $this->input->post('sSearch');
        #print_r($emp_dropdown);exit;

      //echo "string " .$_search_string;exit;
      $params=array(
        '_limit'          => $_limit,
        '_offset'         => $_offset,
        '_sort_field'     => $_sort_field,
        '_search_string'  => $_search_string,
        '_sort_direction' => $_sort_direction,

      );
      
      $result = $this->trainings_m->budget_heading_list($params);
      //print_r($result);exit;
       #echo "<pre>";print_r($result);echo "</pre>";exit;
      //$result= $this->pyrocache->model('doctors_m','index_doctors',array($params));
      echo json_encode($result);
    }
    else{
        $this->template
         ->append_js('module::script_training_setting.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->build('setting/training_budget_heading');
    }
  }

   public function _prep_add_training_budget(){

     $params = array (
                     'row_id'=> $this->input->post('id'),
                     'budget_heading'=>$this->input->post('budget_heading'),
                     'remarks'=>$this->input->post('remarks'),
                     'cost'=>$this->input->post('cost'),

    );
       $result = $this->trainings_m->submit_budget_field($params);
      if($result){
          //header('location:'.base_url()."trainings/Settings_Dashboard/training_settings");
        echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }

    }

    public function _prep_delete_budget_record(){
      $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
      $result = $this->hrdb->where('id',$row_id)
                           ->delete('training_budget_head');
      if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
      }else{
        echo json_encode(array('status' =>300, 'msg' => 'failure'));
      }

  }

###########Venue##########
public function _prep_training_venue(){
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
      
      $result = $this->trainings_m->gettraining_venue($params);
      echo json_encode($result);

}

public function field_enums($table = 'training_venue', $field = ''){
        $enums = array();
        if ($table == '' || $field == '') return $enums;
        preg_match_all("/'(.*?)'/", $this->hrdb->query("SHOW COLUMNS FROM {$table} LIKE '{$field}'")->row()->Type, $matches);
        foreach ($matches[1] as $key => $value) {
            $enums[$value] = $value; 
        }
        return $enums;
    }

public function training_venue(){

$type =  $this->field_enums('training_venue','type');

//$type = $this->trainings_m->get_type_venue();
//print_r($type);exit;
  $this->template
       ->append_js('module::script_training_venue.js')
       //->append_js('module::script_map.js')
       ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
       ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
       ->append_css('module::venue.css')
       ->set('type', $type)
       ->build('setting/training_venue'); 
}

public function add_venue_info(){
  $type =  $this->field_enums('training_venue','type');
  $this->template
        ->set('type', $type)
       ->build('setting/add_info_venue'); 
}

public function save_training_venue(){

   $params = array(
            'row_id'=>$this->input->post('id'),
            'latitude'=>$this->input->post('latitude'),
            'longitude'=>$this->input->post('longitude'),
            'venue_name'=>$this->input->post('venue_name'),
            'type'=>$this->input->post('type'),
            'contact_mobile'=>$this->input->post('contact_mobile'),
            'contact_person'=>$this->input->post('contact_person'),
            

   );
   //print_r($params);exit;
    //$this->db->set($params);
   $result=$this->trainings_m->save_training_venue($params); 
    if($result){
       header('location:'.base_url()."trainings/settings_dashboard/training_venue");
       echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }

}


public function _prep_delete_training_venue(){
    $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
    $result = $this->hrdb->where('id',$row_id)
                            ->delete('training_venue');
        
    if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
    }else{
      echo json_encode(array('status' =>300, 'msg' => 'failure'));
    }


}

public function venue_map(){
  $row_id=$this->input->get('row_id');
  $data=$this->trainings_m->get_lat($row_id);
  #print_r($data);
  $this->template
      ->set('data',$data)
       ->build('setting/venue_map'); 
}


}
 ?>