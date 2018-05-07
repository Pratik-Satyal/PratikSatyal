<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Referal extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
		    $this->load->helper('my_form');
            $this->load->library('form_validation');
        $this->load->model(array('referal_m','hrm/department_m'));
		    $this->load->library('session');
    }

    public function index(){
      //$test = $this->referal_m->individual_referal(); 

         $result = $this->referal_m->getEmpTotalCount();
         //echo '<pre>';print_r($result);exit;
         $this->template
              ->title('Referal Dashboard')
              ->append_js('jquery.dataTables.min.js')
             ->append_js('dataTables.bootstrap.js')
             ->append_css('dataTables.bootstrap.css')
             ->append_css('select2.css')
            ->append_js('select2.js')
            ->append_js('bootbox.min.js')
             ->append_js('module::script_department_employee.js')
              ->set('result',$result)
              ->build ('referal_dashboard.php');   
    
}
public function ajax(){
    $action = uri_assoc('action',3);
    //$token = uri_assoc('token',5);
    //print_r($token);exit;

    try{
      if(!$this->input->is_ajax_request()){
        throw new Exception('Invalid Request Made');
        exit();
      }else{
        switch ($action){
          case 'referal_list':
            $this->_prepreferal_list();
          break;
           case 'emp_list':
            $this->_prepemp_list();
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
    public function add_referal(){

    $this->template
         ->title('Add Referal')
         ->build ('add_referal.php');   
    }

    public function _prepreferal_list(){

        $_offset         = (int) $this->input->post('iDisplayStart');
        $_limit          = (int) $this->input->post('iDisplayLength');
        $_sort_field     = (int) $this->input->post('iSortCol_0');
        $_sort_direction = $this->input->post('sSortDir_0');
        $_search_string  = $this->input->post('sSearch');
        $department = $this->input->post('department');
        $branch = $this->input->post('branch');
        $user = $this->input->post('username');


      $result = $this->referal_m->get_customer_list(array(
          '_offset'        => $_offset,
          '_limit'         => $_limit,
          '_sort_field'    => $_sort_field,
          '_sort_direction'=> $_sort_direction,
          '_search_string' => $_search_string,
          'department'     => $department,
           'branch'        => $branch,
           'username'          => $user, 
         
      ));
      echo json_encode($result);
}
    
    public function customer_list_table(){
        $department_dropdown = $this->referal_m->get_department_dropdown();
        $department_dropdown = array('-1'=>'ALL')+$department_dropdown;
        $branch_dropdown = $this->referal_m->get_branch_dropdown();
        $branch_dropdown = array('-1'=>'ALL')+$branch_dropdown;
        $username = $this->session->userdata('username');
        $userid = $this->session->userdata('emp_id');
        $id = array($userid=>$username, '-1'=>'ALL');
        $this->template
             ->title('Referal List') 
             ->append_js('jquery.dataTables.min.js')
             ->append_js('dataTables.bootstrap.js')
             ->append_css('dataTables.bootstrap.css')
             ->append_js('module::script_referal_list.js')
             ->set('id',$id)
             ->set('branch',$branch_dropdown)
             ->set('department',$department_dropdown)
             ->build('referal_list.php');   
    }

    public function my_referal(){

        $username = $this->session->userdata('username');
        $userid = $this->session->userdata('emp_id');
        $id = array($userid=>$username);
        $this->template
             ->title('My Referal')
             ->append_js('jquery.dataTables.min.js')
             ->append_js('dataTables.bootstrap.js')
             ->append_css('dataTables.bootstrap.css')
             ->append_js('module::script_referal_list.js')
             ->set('id',$id)
             ->build('my_referal.php');   
    }
    public function _prepemp_list(){
      $branch = $this->input->post('branch');
      //print_r($branch);exit;
      //print_r($token);exit;
      $result = $this->referal_m->getEmpListCount();
    //echo '<pre>';print_r($result);exit;

       $this->template
             ->title('Department Employee List')
             ->set_layout('modal')
             ->set('result',$result)
             ->set('branch',$branch)
             ->append_js('module::script_department_employee.js')
             ->build('name_employee_referal.php');   
    
    }
}?>    
