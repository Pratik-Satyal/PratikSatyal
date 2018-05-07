<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trainers extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
		    $this->load->helper('my_form');
        $this->load->model('trainers_m');
		    $this->load->library('session');
        $this->load->library('form_validation');

      $this->validation_rules_basic=array(
      // Basic Information
      'first_name'  => array(
        'field'   => 'first_name',
        'label'   => 'First Name',
        'rules'   => 'xss_clean|required',
        ),
      'middle_name' => array(
        'field'   => 'middle_name',
        'label'   => '',
        'rules'   =>'xss_clean'
        ),
      'last_name'   => array(
        'field'   => 'last_name',
        'label'   => 'Last Name',
        'rules'   => 'xss_clean|required',
        ),
      'gender'    => array(
        'field'   => 'gender',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'dob'     => array(
        'field'   => 'dob',
        'label'   => '',
        'rules'   => 'xss_clean|required',
        ),
      'email'     => array(
        'field'   => 'email',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'mstat'     => array(
        'field'   => 'mstat',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'nation'    => array(
        'field'   => 'nation',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'ctz_no'    => array(
        'field'   => 'ctz_no',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'pcell_no'  => array(
        'field'   => 'pcell_no',
        'label'   => 'Cell No.',
        'rules'   => 'xss_clean|required',
        ),
      'taddress'    => array(
        'field'   => 'taddress',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
      'paddress'    => array(
        'field'   => 'paddress',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
       'skill_grade'    => array(
        'field'   => 'skill_grade',
        'label'   => '',
        'rules'   => 'xss_clean',
        ),
    );
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
          case 'trainers':
              $this->_prep_trainers();
              break; 
          case 'trainerslist':
              $this->_prep_trainerslist();
              break;
          case 'employeetrainerslist':
              $this->_prep_employeetrainerslist();
              break;
          case 'deletetrainerslist':
              $this->_prep_deletetrainerslist();
              break;
          case 'addemptrainerslist':
              $this->_prep_addemptrainerslist();
              break;
          case 'emptraineradd_skills':
              $this->_prep_emptraineradd_skills();
              break;
          case 'trainername':
              $this->_prep_trainername();
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
          $this->template
               ->append_js('module::script_trainers.js')
               ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
               ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
               ->append_css('module::training.css')
               ->build('Trainers/trainers');
     }


     
     public function _prep_trainers(){
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
            $result = $this->trainers_m->selected_List_trainers($params);
          echo json_encode($result);
      }


     public function add_trainer(){
          $skill_grade = $this->trainers_m->get_skill_grade();
          //print_r($skill_grade);exit;
          $skills = $this->trainers_m->get_skills();
          $gender = array('male'=>'male', 'female'=>'female');
          $marriage = array('unmarried'=>'unmarried', 'married'=>'married');

          $this->template
               ->append_js('module::script_trainers.js')
               ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
               ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
               ->append_css('module::training.css')
               ->set('skills', $skills)
               ->set('skill_grade', $skill_grade)
               ->set('gender', $gender)
               ->set('marriage', $marriage)
               ->build('Trainers/external_trainer_form');
     }


       public function _prep_trainerslist(){
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
              '_skills'         =>$this->trainers_m->get_skills(),
              // '_trainer_grade'  =>$this->trainers_m->get_trainer_grade(),


            );
           // print_r($params);exit;
            $result = $this->trainers_m->trainer_list_employee($params);
          echo json_encode($result);
       }

       
       public function _prep_emptraineradd_skills(){ 
        $params = array(
                  'row_id'=>$this->input->post('pk'),
                  'skills'=>$this->input->post('value'),
                  );            
         $result = $this->trainers_m->set_training_skills($params);
         if($result){
            echo json_encode(array('msg'=>'add training level successful', 'status'=>200));
          }else{
            echo json_encode(array('msg'=>'cannot add level this time', 'status'=>300));
          }
       }


       public function _prep_trainername(){
        //print_r($this->input->post('value'));exit;
         $params = array (
                     'row_id' =>$this->input->post('pk'),
                     'trn_name'=>$this->input->post('value'),

    );
        $result = $this->trainers_m->set_training_skills($params);
         if($result){
            echo json_encode(array('msg'=>'add training level successful', 'status'=>200));
          }else{
            echo json_encode(array('msg'=>'cannot add level this time', 'status'=>300));
          }
        }
       

       public function get_edit_skills_list(){
       
        $skills =  $this->trainers_m->get_skills();
        echo json_encode($skills);
      }

      public function get_edit_name_list(){
         $name = $this->trainers_m->get_trainee_name();
        // print_r($name);exit;
        echo json_encode($name);
      }


       public function _prep_employeetrainerslist(){

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
            $result = $this->trainers_m->getList_trainers($params);
          echo json_encode($result);
      }


      public function _prep_addemptrainerslist(){
         $iops_id = $this->input->post('row_id');
         $value = $this->trainers_m->get_employee_trainer($iops_id);
         $db_array = array();
         foreach ($value as $key => $data) {
          $db_array[$key] = $data;        
         }
         $trainer_id = $this->trainers_m->insert_basic_info($db_array);

         if($trainer_id){
            header('location:'.base_url()."trainings/trainers");

         //$this->session->set_flashdata('Success', "Trainer's Basic Information record has been saved Successfully!");
         }else{
           $this->session->set_flashdata('error', validation_errors());
           $redirect_url='trainings/trainers/add_trainer';
         }

      }


     public function add_extrnal_trainer(){
       $id = intval($this->input->post('id'));
       $db_array = array();
       $validation_rules = $this->validation_rules_basic;
       if(!$id){
        $this->form_validation->set_rules($this->validation_rules_basic);
         if($this->form_validation->run()){

             foreach ($this->validation_rules_basic as $key => $value) {
               $db_array[$key] = set_value($key);
             }

             $trainer_id = $this->trainers_m->insert_basic_info($db_array);

             if($trainer_id){
               $redirect_url = 'trainings/trainers';
             $this->session->set_flashdata('Success', "Trainer's Basic Information record has been saved Successfully!");
             }

         }else{
           $this->session->set_flashdata('error', validation_errors());
           $redirect_url='trainings/trainers/add_trainer';
         }

       } 
         if(isset($_POST['save'])){
        redirect($redirect_url);      
        }else{
          redirect('#');
        }

     }

    
    public function _prep_deletetrainerslist(){
         $row_id=$this->input->post('row_id');
         $result = $this->hrdb->where('id',$row_id)
                              ->delete('trainer_basic');
            
        if($result){
          echo json_encode(array('status'=>200,'msg' => 'success'));                  
        }else{
          echo json_encode(array('status' =>300, 'msg' => 'failure'));
      }

      }



   }
   ?>