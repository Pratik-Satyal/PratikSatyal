<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Initial_file_trainings extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
		    $this->load->helper('my_form');
        $this->load->model('trainings_m');
		    $this->load->library('session');
    
    } 

  public function index(){
    $this->template
         ->append_js('jquery.ui.datepicker.js')
         ->append_css('module::training.css')
         ->build('training_dashboard');
   
  }  


  public function training_list(){
    $this->template  
         ->append_js('module::script_training.js')
         ->append_js(array('jquery.dataTables.min.js','dataTables.bootstrap.js','select2.js'))
         ->append_css(array('dataTables.bootstrap.css','jquery.dataTables.css','select2.css')) 
         ->build('training_list_table');
  }

  public function ajax(){
    $token = uri_assoc('token',5);
    $action = uri_assoc('action',3);
    try{
      if(!$this->input->is_ajax_request()){
        throw new Exception('Invalid Request Made');
        exit();
      }else{
        switch ($action){
          case 'training_list':
            $this->_prep_training_list();
          break;
         //  case 'training_level':
         //    $this->_prep_training_level();
         //    break;
         //  case 'add_training_level':
         //    $this->_prep_add_training_level();
         //    break;
         //  case 'edit_training_level':
         //    $this->_prep_edit_training_level();
         //    break; 
         //  case 'delete_training_level':
         //    $this->_prep_delete_training_level();
         //    break;
         //  case 'add_training_grade':
         //    $this->_prep_add_training_grade();
         //    break;
         //  case 'training_grade':
         //    $this->_prep_training_grade();
         //    break; 
         //  case 'submit_grade':
         //    $this->_prep_submit_training_grade();
         //    break;
         //  case 'edit_grade':
         //    $this->_prep_edit_training_grade();
         //    break;
         //  case 'edit_grade_wages':
         //    $this->_prep_edit_training_wages();
         //    break;
         //  case 'delete_training_grade':
         //    $this->_prep_delete_training_grade();
         //    break; 
         //  case 'performance_field':
         //    $this->_prep_performance_field();
         //    break; 
         // case 'budget_headiing':
         //    $this->_prep_budget_heading();
         //    break; 
          // case 'trainers':
          //   $this->_prep_trainers();
          //   break; 
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

  public function _prep_training_list(){

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
      
      $result = $this->trainings_m->getList_trainings($params);

      echo json_encode($result);
 }


  public function training_form(){
    $type = $this->trainings_m->get_type_venue();
    print_r($type);exit;
    $traininglevel = $this->trainings_m->dropdown_training_level();
    $this->template
         ->set('training_level',$traininglevel)
         ->append_css('module::training.css')
         ->set('type_dropdown',$type)
         ->build('training_form');
  }

  public function save_training_form(){
    $params = array(
            'training_name'=>$this->input->post('training_name'),
            'start_date'=>$this->input->post('start_date'),
            'end_date'=>$this->input->post('end_date'),
            'level_id'=>$this->input->post('level_id'),
            'training_duration'=>$this->input->post('training_duration'),
            'type_id'=>$this->input->post('type_id'),
            'type_id'=>$this->input->post('type_id'),
            'total_trainee'=>$this->input->post('total_trainee'),
            'description'=>$this->input->post('description'),
            'venue'=>$this->input->post('venue'),
            'month_breakdown'=>$this->input->post('month_breakdown'),
    );
  $result=$this->trainings_m->save_training_data($params);
  }

  ####################################################################Trainings setting

  // public function training_settings(){
  //   $skill_grade = $this->trainings_m->get_skill_grade();
  //   $this->template
  //        ->append_js('module::script_training_setting.js')
  //        ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
  //        ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
  //        ->append_css('module::training.css')
  //        ->set('skill_grade', $skill_grade)
  //        ->build('training_setting');
  // }

  // public function _prep_training_level(){

  //       $_limit          = (int) $this->input->post('iDisplayLength');
  //       $_offset         = (int) $this->input->post('iDisplayStart');
  //       $_sort_field     = (int) $this->input->post('iSortCol_0');
  //       $_sort_direction = $this->input->post('sSortDir_0');
  //       $_search_string  = $this->input->post('sSearch');
  //     $params=array(
  //       '_limit'          => $_limit,
  //       '_offset'         => $_offset,
  //       '_sort_field'     => $_sort_field,
  //       '_search_string'  => $_search_string,
  //       '_sort_direction' => $_sort_direction,

  //     );
      
  //     $result = $this->trainings_m->gettraining_level($params);

  //     echo json_encode($result);
  // }
  
  // public function _prep_add_training_level(){
  //    $result = $this->trainings_m->set_training_level();
  //   if($result){
  //       echo json_encode(array('msg'=>'add training level successful', 'status'=>200));
  //     }else{
  //       echo json_encode(array('msg'=>'cannot add level this time', 'status'=>300));
  //     }

  // }

  // public function _prep_delete_training_level(){
  //  $row_id=$this->input->post('row_id');
  //  //print_r($row_id);exit;
  //   $result = $this->hrdb->where('id',$row_id)
  //                           ->delete('training_level');
        
  //   if($result){
  //     echo json_encode(array('status'=>200,'msg' => 'success'));                  
  //   }else{
  //     echo json_encode(array('status' =>300, 'msg' => 'failure'));
  //   }

  // }

  // public function _prep_delete_training_grade(){
  //  $row_id=$this->input->post('row_id');
  //  //print_r($row_id);exit;
  //   $result = $this->hrdb->where('id',$row_id)
  //                           ->delete('trainer_grades');
        
  //   if($result){
  //     echo json_encode(array('status'=>200,'msg' => 'success'));                  
  //   }else{
  //     echo json_encode(array('status' =>300, 'msg' => 'failure'));
  //   }


  // }

  // public function _prep_add_training_grade(){
  //   $this->template
  //         ->set_layout('modal')
  //         ->append_css('bootstrap-editable.css')
  //         ->append_js('bootstrap-editable.min.js')      
  //         ->append_js('bootbox.min.js')
  //         ->append_css('select2.css')
  //         ->append_js('select2.js')
  //         ->append_js('jquery.validate.min.js')
  //         ->append_js('module::script_training_setting.js')
  //         ->build('setting/grade_bootbox');
  // }

  // public function _prep_submit_training_grade(){
  //   $params = array (
  //                    'row_id' =>$this->input->post('pk'),
  //                    'trainer_grade' =>  $this->input->post('grade'),
  //                    'daily_wage'  => $this->input->post('wage'),
  //                    'description' =>$this->input->post ('description') 
  //   );
  //   //print_r($params);exit;
  //      $result = $this->trainings_m->submit_grade($params);
  //     if($result){
  //         //header('location:'.base_url()."trainings/training_settings");
  //                   echo json_encode(array('msg'=>'sucess', 'status'=>200));
  //    }else{
  //       echo json_encode(array('msg'=>'Failed', 'status'=>400));
  //    }
  // }

  // public function _prep_edit_training_grade(){
  //   $params = array (
  //                    'row_id' =>$this->input->post('pk'),
  //                    'trainer_grade' =>  $this->input->post('value'),
  //   );
  //      $result = $this->trainings_m->submit_grade($params);
  //     if($result){
  //       echo json_encode(array('msg'=>'sucess', 'status'=>200));
  //    }else{
  //       echo json_encode(array('msg'=>'Failed', 'status'=>400));
  //    }
  // }

  // public function _prep_edit_training_wages(){
  //   $params = array (
  //                    'row_id' =>$this->input->post('pk'),
  //                    'daily_wage'  => $this->input->post('value'),
  //   );
  //      $result = $this->trainings_m->submit_grade($params);
  //     if($result){
  //      echo json_encode(array('msg'=>'sucess', 'status'=>200));
  //    }else{
  //       echo json_encode(array('msg'=>'Failed', 'status'=>400));
  //    }
  // }

  // public function _prep_training_grade(){

  //       $_limit          = (int) $this->input->post('iDisplayLength');
  //       $_offset         = (int) $this->input->post('iDisplayStart');
  //       $_sort_field     = (int) $this->input->post('iSortCol_0');
  //       $_sort_direction = $this->input->post('sSortDir_0');
  //       $_search_string  = $this->input->post('sSearch');
  //       #print_r($emp_dropdown);exit;

  //     //echo "string " .$_search_string;exit;
  //     $params=array(
  //       '_limit'          => $_limit,
  //       '_offset'         => $_offset,
  //       '_sort_field'     => $_sort_field,
  //       '_search_string'  => $_search_string,
  //       '_sort_direction' => $_sort_direction,

  //     );
      
  //     $result = $this->trainings_m->getList_grade($params);
  //     //print_r($result);exit;
  //      #echo "<pre>";print_r($result);echo "</pre>";exit;
  //     //$result= $this->pyrocache->model('doctors_m','index_doctors',array($params));
  //     echo json_encode($result);
  //   }

      ###########Trainers############# 

  public function trainers(){
    $this->template
         ->append_js('module::script_trainers.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->build('Trainers/trainers');
  }

public function test_next_phase(){
    //this is just a test  method testing
}
  /*public function add_trainer(){
    $skill_grade = $this->trainings_m->get_skill_grade();
    $this->template
         ->append_js('module::script_trainers.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->set('skill_grade', $skill_grade)
         ->build('Trainers/external_trainer_form');
  }
*/
//   #########performance##############

//   public function _prep_performance_field(){

//         $_limit          = (int) $this->input->post('iDisplayLength');
//         $_offset         = (int) $this->input->post('iDisplayStart');
//         $_sort_field     = (int) $this->input->post('iSortCol_0');
//         $_sort_direction = $this->input->post('sSortDir_0');
//         $_search_string  = $this->input->post('sSearch');

//       $params=array(
//         '_limit'          => $_limit,
//         '_offset'         => $_offset,
//         '_sort_field'     => $_sort_field,
//         '_search_string'  => $_search_string,
//         '_sort_direction' => $_sort_direction,

//       );
      
//       $result = $this->trainings_m->performancesetting_list($params);
// //print_r($result);exit;
//       echo json_encode($result);
//     }

//     public function add_training_field(){

//      $params = array (
//                      'row_id'=>$this->input->post('id'),
//                      'skill_id'=>$this->input->post("skills"),
//                      'field'=>$this->input->post('field')
//     );
//        $result = $this->trainings_m->submit_training_field($params);

//       if($result){
//           header('location:'.base_url()."trainings/training_settings");
//         echo json_encode(array('msg'=>'sucess', 'status'=>200));
//      }else{
//         echo json_encode(array('msg'=>'Failed', 'status'=>400));
//      }

//     }

//     #########Training Budget Heading##############

//   public function _prep_budget_heading(){
//   if ($this->input->is_ajax_request()) {
//         $_limit          = (int) $this->input->post('iDisplayLength');
//         $_offset         = (int) $this->input->post('iDisplayStart');
//         $_sort_field     = (int) $this->input->post('iSortCol_0');
//         $_sort_direction = $this->input->post('sSortDir_0');
//         $_search_string  = $this->input->post('sSearch');
//         #print_r($emp_dropdown);exit;

//       //echo "string " .$_search_string;exit;
//       $params=array(
//         '_limit'          => $_limit,
//         '_offset'         => $_offset,
//         '_sort_field'     => $_sort_field,
//         '_search_string'  => $_search_string,
//         '_sort_direction' => $_sort_direction,

//       );
      
//       $result = $this->trainings_m->budget_heading_list($params);
//       //print_r($result);exit;
//        #echo "<pre>";print_r($result);echo "</pre>";exit;
//       //$result= $this->pyrocache->model('doctors_m','index_doctors',array($params));
//       echo json_encode($result);
//     }
//     else{
//         $this->template
//          ->append_js('module::script_training_setting.js')
//          ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
//          ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
//          ->append_css('module::training.css')
//          ->build('setting/training_budget_heading');
//     }
//   }
    
}?>