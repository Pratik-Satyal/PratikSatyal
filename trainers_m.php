<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trainers_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		ci()->hrdb=$this->hrdb = $this->load->database('hrdb', true);
		
	}



     public function get_skill_grade(){
        
         $skills_grade = $this->hrdb->get('skill_grades')
                               ->result();
          $skill_grade_dropdown   = array();

          foreach ($skills_grade as $skillgrade ) {
              $skill_grade_dropdown[$skillgrade->id] = $skillgrade->grade;
          }

          return $skill_grade_dropdown;
      }
    
    	public function get_skills(){
        
          $skills = $this->hrdb->get('training_skills')
                               ->result();
          $skill_dropdown   = array();

          foreach ($skills as $skill ) {
              $skill_dropdown[$skill->id] = $skill->skills;
          }

          return $skill_dropdown;
    	}

        public function get_trainee_name(){
        
          $name = $this->hrdb->get('training_basic')
                               ->result();
          return $name;
      }
  	


    public function trainer_list_employee($params){
      $skills = $params['_skills'];
      //$trainer_grade = $params['_trainer_grade'];
      $select = array(
                "concat(first_name, ' ',last_name) as trn_name",'ent_date',
                'id', 'gender', 'pcell_no', 'taddress','mstat', 'email','type','skills'
            );
        $sort = array('id', 'trn_name');
        $_field = $sort[$params['_sort_field']];
        //print_r($_field);exit;

        if ( $params['_search_string'] != "") {

            $toSearch = array(          
                'first_name', 
                'last_name'       
            );
            $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
        }

        $result = $this->hrdb->select($select)
                             ->order_by($_field, $params['_sort_direction'])
                             ->limit($params['_limit'], $params['_offset'])
                             ->get('trainer_basic')
                             ->result();
                           // print_r($result);exit;
          foreach ($result as $value) {
              if( $value->skills){
                 $value->skills=$skills[$value->skills];
              }          
         }
        $_total_records = $this->count_without_limit('hrdb');
        $log_query = $this->hrdb->last_query();
         return array(
              'aaData'        =>  $result ,
              'iTotalRecords' => count($result),
              'query'         => $log_query,
              'iTotalDisplayRecords' =>$_total_records,
            );
    }
    
	public function getList_trainers($params){
        $select = array(
                "concat(emb.first_name, ' ',emb.last_name) as emp_name",'emb.ent_date',
                'emb.id','emb.iops_id', 'emb.gender', 'emb.pcell_no', 'emb.taddress','emb.mstat', 'eor.emp_code', 'eor.iopsdep_id', 'eor.email', 'ea.group_id'
            );
        $sort = array('id', 'emp_name','emp_code','email', 'iopsdep_id','group_id');
        $_field = $sort[$params['_sort_field']];
        //print_r($_field);exit;

        if ( $params['_search_string'] != "") {

            $toSearch = array(          
                'first_name',
                'last_name',        
            );
            $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
        }

        $result = $this->hrdb->select($select)
                             ->join('employee_org eor', 'emb.id=eor.emp_id', 'left')
                             ->join('employee_assign ea', 'emb.id=ea.emp_id', 'left')
                            // ->where($where)
                             ->where('eor.emp_status!="terminated"')
                             ->order_by($_field, $params['_sort_direction'])
                             ->limit($params['_limit'], $params['_offset'])
                             ->get('employee_basic AS emb')
                             ->result();
                           // print_r($result);exit;
        
        $_total_records = $this->count_without_limit('hrdb');
        $log_query = $this->hrdb->last_query();
         return array(
              'aaData'        =>  $result ,
              'iTotalRecords' => count($result),
              'query'         => $log_query,
              'iTotalDisplayRecords' =>$_total_records,
            );
    }

    public function insert_basic_info($db_array){
      if($db_array['iops_id']){
         $level = 'Employee';
      }else{
         $level = 'External';
      }

        $tr_array = array(
              'first_name'=>$db_array['first_name'],
              'middle_name'=>$db_array['middle_name'],
              'last_name'=>$db_array['last_name'],
              'gender'=>$db_array['gender'],
              'dob'=>$db_array['dob'],
              'type'=>$level,
              'email'=>$db_array['email'],
              'mstat'=>$db_array['mstat'],
              'nation'=>$db_array['nation'],
              'ctz_no'=>$db_array['ctz_no'],
              'pcell_no'=>$db_array['pcell_no'],
              'taddress'=>$db_array['taddress'],
              'paddress'=>$db_array['paddress'],
              'ent_date' => date('Y-m-d'),
              'modified_by' => $this->session->userdata('user_id'),
              'skill_grade' => $db_array['skill_grade']
            );

    if($db_array['middle_name'] && !empty($db_array['middle_name'])){
      $first_name = $db_array['first_name'].' '.$db_array['middle_name'];
    }else{
      $first_name = $db_array['first_name'];
    }
      $result=$this->hrdb->insert('trainer_basic',$tr_array);
      if($result){
        return $result;
      }else{
        return false;
      }
    }
   
   public function get_employee_trainer($iops_id){
      $select = array(
                  'first_name', 'middle_name', 'last_name','ent_date','gender','dob','email','nation',
                  'id', 'gender', 'pcell_no', 'taddress','mstat', 'email','paddress','ctz_no','iops_id'
              );
      $result = $this->hrdb->select($select)
                           ->where('iops_id', $iops_id)
                           ->get('employee_basic')
                           ->result();
     if($result){
      foreach ($result as  $value) {
       return $value;
      }
     }else{
       return false;
     }
   }

   public function set_training_skills($params){
//print_r($params);exit;
   
    if($params['row_id'] && $params['row_id']!=null){
      $id= $params['row_id'];
            unset($params['row_id']);
      $result = $this->hrdb->where('id',$id)
                 ->update('trainer_basic',$params);
    }
    //print_r($result);exit;
    if($result){
      return $result;
    }else{
      return false;
    }
}

// public function get_trainer_grade(){

//     $trainer = $this->hrdb->get('trainer_grades')
//                              ->result();
//                               //print_r($type);exit;
//           $type_trainer_grade   = array();

//           foreach ($trainer as $trainer_training ) {
//               $type_trainer_grade[$trainer_training->id] = $trainer_training->trainer_grade;
//           }  
//          // print_r($type_dropdown);exit;

//           return $type_trainer_grade;
// }

}?>